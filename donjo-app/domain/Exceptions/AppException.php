<?php

declare(strict_types=1);

namespace Donjo\Domain\Exceptions;

use Exception;
use Throwable;

/**
 * Base application exception.
 *
 * Carries an HTTP-style status code and arbitrary details so callers can
 * map domain errors to API responses without coupling to framework code.
 */
class AppException extends Exception
{
    /**
     * @var int HTTP-style status code used by presentation layers.
     */
    protected $statusCode;

    /**
     * @var array<string, mixed> Additional structured context.
     */
    protected $details;

    /**
     * @param string         $message    Human-readable error message.
     * @param int            $code       Internal exception code.
     * @param Throwable|null $previous   Previous throwable for chaining.
     * @param int            $statusCode HTTP-style status code (default 500).
     * @param array          $details    Extra context (e.g. field names, ids).
     */
    public function __construct(
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null,
        int $statusCode = 500,
        array $details = []
    ) {
        parent::__construct($message, $code, $previous);

        $this->statusCode = $statusCode;
        $this->details    = $details;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return array<string, mixed>
     */
    public function getDetails(): array
    {
        return $this->details;
    }

    /**
     * @return array{message: string, code: int, statusCode: int, details: array<string, mixed>}
     */
    public function toArray(): array
    {
        return [
            'message'    => $this->getMessage(),
            'code'       => $this->getCode(),
            'statusCode' => $this->statusCode,
            'details'    => $this->details,
        ];
    }
}
