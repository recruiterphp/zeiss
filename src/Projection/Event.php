<?php

namespace Zeiss\Projection;

use DateTimeImmutable;

class Event implements NextEvent
{
    /** @var array */
    private $event;

    public function __construct(array $event)
    {
        $this->event = $event;
    }

    public function type(): string
    {
        return $this->event['type'];
    }

    public function fromPayload($key, $default = null)
    {
        return $this->event['payload'][$key] ?? $default;
    }

    public function fromCorrelationIds($key)
    {
        return $this->event['correlationIds'][$key] ?? null;
    }

    public function emittedAt(): DateTimeImmutable
    {
        return $this->event['emittedAt'];
    }

    public function receivedAt(): DateTimeImmutable
    {
        return $this->event['receivedAt'];
    }

    public function offset(): int
    {
        return $this->event['offset'];
    }
}
