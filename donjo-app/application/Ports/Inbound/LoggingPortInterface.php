<?php

declare(strict_types=1);

namespace Donjo\Application\Ports\Inbound;

/**
 * Inbound port for logging operations.
 *
 * Provides standardized logging methods to the application layer.
 * Implementations are provided by the infrastructure layer.
 */
interface LoggingPortInterface
{
    /**
     * Log an informational message.
     *
     * @param string $message The log message.
     * @param array $context Additional context data.
     */
    public function info(string $message, array $context = []): void;

    /**
     * Log a warning message.
     *
     * @param string $message The log message.
     * @param array $context Additional context data.
     */
    public function warning(string $message, array $context = []): void;

    /**
     * Log an error message.
     *
     * @param string $message The log message.
     * @param array $context Additional context data.
     */
    public function error(string $message, array $context = []): void;
}