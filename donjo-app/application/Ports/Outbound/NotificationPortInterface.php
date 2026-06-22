<?php

declare(strict_types=1);

namespace Donjo\Application\Ports\Outbound;

/**
 * Outbound port for sending notifications.
 *
 * Defines the contract for delivering notifications to users or groups.
 * Implementations are provided by the infrastructure layer.
 */
interface NotificationPortInterface
{
    /**
     * Send a notification to a specific user.
     *
     * @param mixed $userId The user identifier.
     * @param string $message The notification message.
     */
    public function notify($userId, string $message): void;

    /**
     * Send a notification to a group of users.
     *
     * @param string $group The group identifier.
     * @param string $message The notification message.
     */
    public function notifyGroup(string $group, string $message): void;
}