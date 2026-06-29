<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases;

/**
 * Marker interface for the result of a use case.
 *
 * Implementations are immutable DTO wrappers that canonically represent
 * the outcome of an application service. They are returned to the caller
 * (controller, command handler, etc.) and are read-only after creation.
 */
interface OutputInterface
{
}