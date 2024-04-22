<?php

declare(strict_types=1);

namespace Tests\Unit\Fakes;

use Override;
use Psr\Log\LoggerInterface;

class FakeLog implements LoggerInterface
{
    /** @var array<string, array<array<string, mixed>>> */
    private array $log = [
        'emergency' => [],
        'alert' => [],
        'critical' => [],
        'error' => [],
        'warning' => [],
        'notice' => [],
        'info' => [],
        'debug' => [],
        'log' => [],
    ];

    public function flush(string $level): void
    {
        $this->log[$level] = [];
    }

    /**
     * @return array<array<string, mixed>>
     */
    public function get(string $level): array
    {
        return $this->log[$level];
    }

    /**
     * @param string $message
     */
    #[Override]
    public function emergency($message, array $context = []): void
    {
        $this->log('emergency', $message, $context);
    }

    /**
     * @param string $message
     */
    #[Override]
    public function alert($message, array $context = []): void
    {
        $this->log('alert', $message, $context);
    }

    /**
     * @param string $message
     */
    #[Override]
    public function critical($message, array $context = []): void
    {
        $this->log('critical', $message, $context);
    }

    /**
     * @param string $message
     */
    #[Override]
    public function error($message, array $context = []): void
    {
        $this->log('error', $message, $context);
    }

    /**
     * @param string $message
     */
    #[Override]
    public function warning($message, array $context = []): void
    {
        $this->log('warning', $message, $context);
    }

    /**
     * @param string $message
     */
    #[Override]
    public function notice($message, array $context = []): void
    {
        $this->log('notice', $message, $context);
    }

    /**
     * @param string $message
     */
    #[Override]
    public function info($message, array $context = []): void
    {
        $this->log('info', $message, $context);
    }

    /**
     * @param string $message
     */
    #[Override]
    public function debug($message, array $context = []): void
    {
        $this->log('debug', $message, $context);
    }

    /**
     * @param string $level
     * @param string $message
     */
    #[Override]
    public function log($level, $message, array $context = []): void
    {
        $this->log[$level][] = [
            'message' => $message,
            'context' => $context,
        ];
    }

    public static function channel(string $level): self
    {
        return new self();
    }

    public static function getLogger(): self
    {
        return new self();
    }
}
