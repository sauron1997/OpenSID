<?php
declare(strict_types=1);
namespace Donjo\Infrastructure\Cache;
use Donjo\Application\Ports\Outbound\CachePortInterface;
final class FileCache implements CachePortInterface
{
    private string $cachePath;
    public function __construct(?string $cachePath = null)
    {
        $this->cachePath = $cachePath ?? (defined("APPPATH") ? APPPATH . "cache/" : sys_get_temp_dir() . "/opensid_cache/");
        if (!is_dir($this->cachePath)) {
            mkdir($this->cachePath, 0755, true);
        }
    }
    public function get(string $key, mixed $default = null): mixed
    {
        $file = $this->getFilePath($key);
        if (!file_exists($file)) return $default;
        $data = unserialize(file_get_contents($file));
        if ($data["expires_at"] !== null && time() > $data["expires_at"]) {
            $this->delete($key);
            return $default;
        }
        return $data["value"];
    }
    public function set(string $key, mixed $value, ?int $ttl = null): void
    {
        $file = $this->getFilePath($key);
        $data = ["value" => $value, "expires_at" => $ttl ? time() + $ttl : null];
        file_put_contents($file, serialize($data));
    }
    public function has(string $key): bool
    {
        return $this->get($key, null) !== null;
    }
    public function delete(string $key): void
    {
        $file = $this->getFilePath($key);
        if (file_exists($file)) unlink($file);
    }
    public function remember(string $key, callable $callback, ?int $ttl = null): mixed
    {
        if ($this->has($key)) return $this->get($key);
        $value = $callback();
        $this->set($key, $value, $ttl);
        return $value;
    }
    private function getFilePath(string $key): string
    {
        return $this->cachePath . md5($key) . ".cache";
    }
}