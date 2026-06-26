<?php
declare(strict_types=1);
namespace Donjo\Application\Middleware;
use Donjo\Application\UseCases\InputInterface;
interface MiddlewareInterface
{
    public function handle(InputInterface $input, callable $next): mixed;
}
