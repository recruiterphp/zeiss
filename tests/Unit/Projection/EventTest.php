<?php

declare(strict_types=1);

namespace Zeiss\Tests\Unit\Projection;

use PHPUnit\Framework\TestCase;
use Zeiss\Projection\Event;

class EventTest extends TestCase
{
    public function testReceivedAt(): void
    {
        $date = new \DateTimeImmutable('2019-01-01T12:34:56.789012Z');

        $event = new Event([
            'receivedAt' => $date,
        ]);

        $this->assertSame($date, $event->receivedAt());
    }

    public function testEmittedAt(): void
    {
        $date = new \DateTimeImmutable('2019-01-01T12:34:56.789012Z');

        $event = new Event([
            'emittedAt' => $date,
        ]);

        $this->assertSame($date, $event->emittedAt());
    }
}
