<?php

namespace Zeiss\Projection;

interface Record
{
    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function set(string $key, $value): self;

    /**
     * @return mixed
     */
    public function get(string $key);
}
