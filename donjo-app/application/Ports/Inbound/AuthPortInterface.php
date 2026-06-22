<?php

declare(strict_types=1);

namespace Donjo\Application\Ports\Inbound;

/**
 * Inbound port for authorization and authentication operations.
 *
 * Provides methods to check permissions and retrieve user data from the
 * application layer. Implementations are provided by the infrastructure layer.
 */
interface AuthPortInterface
{
    /**
     * Check if a user has permission to perform an action on a resource.
     *
     * @param mixed $userId The user identifier.
     * @param string $resource The resource to check.
     * @param string $action The action to check.
     * @return bool True if permitted.
     */
    public function checkPermission($userId, string $resource, string $action): bool;

    /**
     * Retrieve user information by user identifier.
     *
     * @param mixed $userId The user identifier.
     * @return array|null User data or null if not found.
     */
    public function getUser($userId): ?array;
}