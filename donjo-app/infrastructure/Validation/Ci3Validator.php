<?php

declare(strict_types=1);

namespace Donjo\Infrastructure\Validation;

use Donjo\Application\DTOs\ValidationResult;
use Donjo\Application\Ports\Inbound\ValidationPortInterface;

/**
 * CI3 Form Validation adapter.
 * Bridges CodeIgniter 3 form_validation library to the clean architecture ValidationPortInterface.
 */
final class Ci3Validator implements ValidationPortInterface
{
    /** @var \CI_Form_validation|null */
    private $formValidation;

    /** @var array<string, string[]> */
    private $errorBag = [];

    /**
     * @param \CI_Form_validation|null $formValidation
     */
    public function __construct($formValidation = null)
    {
        $this->formValidation = $formValidation;
    }

    /**
     * @inheritDoc
     */
    public function validate(array $data, array $rules): ValidationResult
    {
        $fv = $this->getFormValidation();

        $fv->set_data($data);

        foreach ($rules as $field => $rule) {
            $fv->set_rules($field, $field, $rule);
        }

        if ($fv->run() === false) {
            $ciErrors = $fv->error_array();
            $errors = [];
            foreach ($ciErrors as $field => $message) {
                $errors[$field][] = $message;
            }
            return ValidationResult::failure($errors);
        }

        return ValidationResult::success();
    }

    /**
     * @inheritDoc
     */
    public function validateEntity(object $entity): ValidationResult
    {
        if (method_exists($entity, 'toArray')) {
            $data = $entity->toArray();
        } else {
            $data = get_object_vars($entity);
        }

        $errors = [];
        foreach ($data as $key => $value) {
            if ($value === null || $value === '') {
                $errors[$key][] = ucfirst($key) . ' is required.';
            }
        }

        if (empty($errors)) {
            return ValidationResult::success();
        }

        return ValidationResult::failure($errors);
    }

    /**
     * @inheritDoc
     */
    public function addError(string $field, string $message): void
    {
        $this->errorBag[$field][] = $message;
    }

    /**
     * @inheritDoc
     */
    public function hasErrors(): bool
    {
        return !empty($this->errorBag);
    }

    /**
     * @inheritDoc
     */
    public function getErrors(): array
    {
        return $this->errorBag;
    }

    /**
     * Lazily resolve the CI_Form_validation instance from the CI super-object.
     *
     * @return \CI_Form_validation
     */
    private function getFormValidation(): object
    {
        if ($this->formValidation === null) {
            $this->formValidation = &get_instance()->form_validation;
        }

        return $this->formValidation;
    }
}
