<?php
declare(strict_types=1);
namespace Donjo\Domain\Services;
final class DomainEventDispatcher
{
    private array $listeners = [];
    public function addListener(string $eventName, callable $listener): void
    {
        $this->listeners[$eventName][] = $listener;
    }
    public function dispatch(string $eventName, object $event): void
    {
        if (!isset($this->listeners[$eventName])) return;
        foreach ($this->listeners[$eventName] as $listener) {
            $listener($event);
        }
    }
    public function removeListener(string $eventName, callable $listener): void
    {
        if (!isset($this->listeners[$eventName])) return;
        $this->listeners[$eventName] = array_filter(
            $this->listeners[$eventName],
            fn($l) => $l !== $listener
        );
    }
}