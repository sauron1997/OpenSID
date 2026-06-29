<?php

declare(strict_types=1);

namespace Donjo\Application\DTOs;

/**
 * Immutable validation result DTO.
 * Returned by validation operations instead of booleans or exceptions.
 */
final class ValidationResult
{
    /** @var bool */
    private $valid;

    /** @var array<string, string[]> */
    private $errors;

    /**
     * @param bool $valid
     * @param array<string, string[]> $errors
     */
    private function __construct(bool $valid, array $errors = [])
    {
        $this->valid  = $valid;
        $this->errors = $errors;
    }

    /**
     * Create a successful validation result.
     *
     * @return self
     */
    public static function success(): self
    {
        return new self(true, []);
    }

    /**
     * Create a failed validation result with the given errors.
     *
     * @param array<string, string[]> $errors
     * @return self
     */
    public static function failure(array $errors): self
    {
        return new self(false, $errors);
    }

    /**
     * Whether the validation passed without errors.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->valid;
    }

    /**
     * Retrieve all validation errors grouped by field.
     *
     * @return array<string, string[]>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Add a validation error, returning a NEW immutable instance.
     *
     * @param string $field
     * @param string $message
     * @return self
     */
    public function addError(string $field, string $message): self
    {
        $newErrors = $this->errors;
        $newErrors[$field][] = $message;

        return new self(false, $newErrors);
    }

    /**
     * Convert the result to an associative array.
     *
     * @return array{valid: bool, errors: array<string, string[]>}
     */
    public function toArray(): array
    {
        return [
            'valid'  => $this->valid,
            'errors' => $this->errors,
        ];
    }
}
