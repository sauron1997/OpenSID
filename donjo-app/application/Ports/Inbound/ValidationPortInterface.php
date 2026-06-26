<?php

declare(strict_types=1);

namespace Donjo\Application\Ports\Inbound;

use Donjo\Application\DTOs\ValidationResult;

/**
 * Validation Service contract.
 * Defines the inbound port for data validation operations.
 */
interface ValidationPortInterface
{
    /**
     * Validate a set of data against the given rules.
     *
     * @param array<string, mixed> $data
     * @param array<string, string> $rules
     * @return ValidationResult
     */
    public function validate(array $data, array $rules): ValidationResult;

    /**
     * Validate an entity object.
     *
     * @param object $entity
     * @return ValidationResult
     */
    public function validateEntity(object $entity): ValidationResult;

    /**
     * Add a validation error to the internal error bag.
     *
     * @param string $field
     * @param string $message
     * @return void
     */
    public function addError(string $field, string $message): void;

    /**
     * Check whether the error bag has any errors.
     *
     * @return bool
     */
    public function hasErrors(): bool;

    /**
     * Retrieve all stored validation errors.
     *
     * @return array<string, string[]>
     */
    public function getErrors(): array;
}
