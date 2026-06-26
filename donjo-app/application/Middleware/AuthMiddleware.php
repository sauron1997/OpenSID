<?php
declare(strict_types=1);
namespace Donjo\Application\Middleware;
use Donjo\Application\Ports\Inbound\AuthPortInterface;
use Donjo\Application\UseCases\InputInterface;
use Donjo\Domain\Exceptions\UnauthorizedException;
final class AuthMiddleware implements MiddlewareInterface
{
    public function __construct(private AuthPortInterface $auth) {}
    public function handle(InputInterface $input, callable $next): mixed
    {
        $userId = $input->userId ?? null;
        $resource = $input->resource ?? null;
        $action = $input->action ?? 'read';
        if ($userId && $resource && !$this->auth->checkPermission($userId, $resource, $action)) {
            throw new UnauthorizedException('Akses ditolak');
        }
        return $next($input);
    }
}
