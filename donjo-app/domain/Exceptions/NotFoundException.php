<?php

declare(strict_types=1);

namespace Donjo\Domain\Exceptions;

use Throwable;

/**
 * Raised when a requested resource cannot be located.
 */
class NotFoundException extends AppException
{
    /**
     * @param string         $message  Human-readable error message.
     * @param int            $code     Internal exception code.
     * @param Throwable|null $previous Previous throwable for chaining.
     */
    public function __construct(
        string $message = 'Resource not found',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous, 404);
    }
}
