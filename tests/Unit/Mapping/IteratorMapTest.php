<?php

declare(strict_types=1);

namespace Zeiss\Tests\Unit\Mapping;

use Generator;
use PHPUnit\Framework\TestCase;
use Zeiss\Mapping\IteratorMap;

class IteratorMapTest extends TestCase
{
    public function testArray(): void
    {
        $iterator = new IteratorMap([1, 2, 5]);
        $iterator->addMap(fn (int $x) => $x + 1);

        $actual = iterator_to_array($iterator);

        $this->assertSame([2, 3, 6], $actual);
    }

    public function testIterator(): void
    {
        $iterator = new IteratorMap($this->iterator());

        $iterator->addMap(fn (int $x) => $x + 1);

        $actual = iterator_to_array($iterator);

        $this->assertSame([2, 8, 43], $actual);
    }

    private function iterator(): Generator
    {
        yield 1;
        yield 7;
        yield 42;
    }
}
