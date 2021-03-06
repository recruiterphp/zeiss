<?php

declare(strict_types=1);

namespace Zeiss\Mapping;

use ArrayIterator;
use IteratorIterator;
use Traversable;

class IteratorMap extends IteratorIterator
{
    /**
     * @var callable[]
     */
    private array $maps = [];

    public function __construct(iterable $iterator)
    {
        // if it's not a traversable it must be an array
        if (!$iterator instanceof Traversable) {
            $iterator = new ArrayIterator($iterator);
        }

        parent::__construct($iterator);
    }

    /**
     * Adds a mapping step.
     *
     * @return $this
     */
    public function addMap(callable $map): self
    {
        $this->maps[] = $map;

        return $this;
    }

    public function current()
    {
        return array_reduce(
            $this->maps,
            fn ($item, callable $function) => call_user_func($function, $item),
            parent::current()
        );
    }
}
