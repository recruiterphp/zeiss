<?php

declare(strict_types=1);

namespace Zeiss\Projection;

interface Record
{
    /**
     * @return $this
     */
    public function set(string $key, mixed $value): self;

    public function get(string $key): mixed;
}
