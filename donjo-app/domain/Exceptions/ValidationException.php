<?php

declare(strict_types=1);

namespace Donjo\Domain\Exceptions;

use Throwable;

/**
 * Raised when input fails domain validation rules.
 *
 * Carries field-level errors so presentation layers can render them
 * next to the offending inputs.
 */
class ValidationException extends AppException
{
    /**
     * @param string               $message     Human-readable error message.
     * @param array<string, mixed> $fieldErrors Map of field name to error message or list of messages.
     * @param int                  $code        Internal exception code.
     * @param Throwable|null       $previous    Previous throwable for chaining.
     */
    public function __construct(
        string $message = 'Validation failed',
        array $fieldErrors = [],
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous, 422, ['fieldErrors' => $fieldErrors]);
    }

    /**
     * @return array<string, mixed>
     */
    public function getFieldErrors(): array
    {
        return $this->details['fieldErrors'] ?? [];
    }
}
