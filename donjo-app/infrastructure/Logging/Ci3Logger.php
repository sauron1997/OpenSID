<?php
declare(strict_types=1);
namespace Donjo\Infrastructure\Logging;
use Donjo\Application\Ports\Inbound\LoggingPortInterface;
final class Ci3Logger implements LoggingPortInterface
{
    public function info(string $message, array $context = []): void
    {
        log_message('info', $this->formatMessage($message, $context));
    }
    public function warning(string $message, array $context = []): void
    {
        log_message('debug', $this->formatMessage($message, $context));
    }
    public function error(string $message, array $context = []): void
    {
        log_message('error', $this->formatMessage($message, $context));
    }
    private function formatMessage(string $message, array $context): string
    {
        if (empty($context)) return $message;
        return $message . ' ' . json_encode($context);
    }
}
