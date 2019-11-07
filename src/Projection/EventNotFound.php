<?php

namespace Zeiss\Projection;

class EventNotFound implements NextEvent
{
    /** @var int */
    private $offset;

    public function __construct(int $offset)
    {
        $this->offset = $offset;
    }

    public function offset(): int
    {
        return $this->offset;
    }
}
