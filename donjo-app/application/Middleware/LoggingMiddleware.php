<?php
declare(strict_types=1);
namespace Donjo\Application\Middleware;
use Donjo\Application\Ports\Inbound\LoggingPortInterface;
use Donjo\Application\UseCases\InputInterface;
final class LoggingMiddleware implements MiddlewareInterface
{
    public function __construct(private LoggingPortInterface $logger) {}
    public function handle(InputInterface $input, callable $next): mixed
    {
        $start = microtime(true);
        $class = get_class($input);
        $this->logger->info("Use case started: " . $class, ["input" => get_object_vars($input)]);
        try {
            $result = $next($input);
            $duration = round((microtime(true) - $start) * 1000, 2);
            $this->logger->info("Use case completed: " . $class, ["duration_ms" => $duration]);
            return $result;
        } catch (\Throwable $e) {
            $duration = round((microtime(true) - $start) * 1000, 2);
            $this->logger->error("Use case failed: " . $class, ["error" => $e->getMessage(), "duration_ms" => $duration]);
            throw $e;
        }
    }
}
