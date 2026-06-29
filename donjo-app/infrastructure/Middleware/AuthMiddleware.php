<?php

declare(strict_types=1);

namespace Donjo\Infrastructure\Middleware;

use Donjo\Application\Ports\Inbound\AuthPortInterface;

/**
 * AuthMiddleware — thin auth gate for clean controllers.
 *
 * Delegates permission check to AuthPortInterface so the
 * concrete auth strategy (CI3 session, JWT, etc.) is swappable.
 */
final class AuthMiddleware
{
    public function __construct(
        private AuthPortInterface $auth,
    ) {
    }

    /**
     * Return true if $userId has read access to $resource.
     */
    public function canRead($userId, string $resource): bool
    {
        if (empty($userId)) {
            return false;
        }

        return $this->auth->checkPermission($userId, $resource, 'read');
    }
}
