<?php
declare(strict_types=1);
namespace Donjo\Application\Ports\Outbound;
interface CachePortInterface
{
    public function get(string $key, mixed $default = null): mixed;
    public function set(string $key, mixed $value, ?int $ttl = null): void;
    public function has(string $key): bool;
    public function delete(string $key): void;
    public function remember(string $key, callable $callback, ?int $ttl = null): mixed;
}