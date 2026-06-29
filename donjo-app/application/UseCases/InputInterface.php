<?php

declare(strict_types=1);

namespace Donjo\Application\UseCases;

/**
 * Marker interface for validated input data passed to a use case.
 *
 * Implementors are immutable DTO classes that carry the required
 * parameters for executing a specific application service. They are
 * validated at creation time and read only by the corresponding
 * UseCaseInterface.
 */
interface InputInterface
{
}