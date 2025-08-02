<?php

declare(strict_types=1);

namespace Zeiss\Projection;

class EventNotFound implements NextEvent
{
    public function __construct(private readonly int $offset)
    {
    }

    public function offset(): int
    {
        return $this->offset;
    }
}
