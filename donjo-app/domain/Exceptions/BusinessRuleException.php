<?php

declare(strict_types=1);

namespace Donjo\Domain\Exceptions;

use Throwable;

/**
 * Raised when an action violates a domain business rule
 * (e.g. duplicate registration, insufficient balance).
 */
class BusinessRuleException extends AppException
{
    /**
     * @param string         $message  Human-readable error message.
     * @param int            $code     Internal exception code.
     * @param Throwable|null $previous Previous throwable for chaining.
     * @param array          $details  Extra context for the violated rule.
     */
    public function __construct(
        string $message = 'Business rule violation',
        int $code = 0,
        ?Throwable $previous = null,
        array $details = []
    ) {
        parent::__construct($message, $code, $previous, 422, $details);
    }
}
