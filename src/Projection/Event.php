<?php

declare(strict_types=1);

namespace Zeiss\Projection;

class Event implements NextEvent
{
    /**
     * @param array<mixed> $event
     */
    public function __construct(private array $event)
    {
    }

    public function type(): string
    {
        return $this->event['type'];
    }

    public function fromPayload(string $key, $default = null)
    {
        return $this->event['payload'][$key] ?? $default;
    }

    public function fromCorrelationIds(string $key)
    {
        return $this->event['correlationIds'][$key] ?? null;
    }

    public function emittedAt(): \DateTimeImmutable
    {
        return $this->event['emittedAt'];
    }

    public function receivedAt(): \DateTimeImmutable
    {
        return $this->event['receivedAt'];
    }

    public function offset(): int
    {
        return $this->event['offset'];
    }
}
