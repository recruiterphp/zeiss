<?php

namespace Zeiss\MongoDB;

use DateTimeImmutable;
use MongoDB\BSON\UTCDateTime;
use MongoDB\Collection;
use Zeiss\Projection\Event;
use Zeiss\Projection\EventNotFound;
use Zeiss\Projection\EventStore as EventStoreInterface;
use Zeiss\Projection\NextEvent;

class EventStore implements EventStoreInterface
{
    /** @var Collection */
    private $events;

    private const DATES = [
        'receivedAt',
        'emittedAt',
    ];

    public function __construct(Collection $events)
    {
        $this->events = $events;
    }

    /**
     * @return Event | EventNotFound
     */
    public function fetchOneOfAfter(array $types, int $fromOffset, int $limit = 100000): NextEvent
    {
        $toOffset = min($this->offset(), $fromOffset + $limit);
        $document = $this->events->findOne(
            ['offset' => ['$gt' => $fromOffset, '$lte' => $toOffset],
                'type' => ['$in' => $types], ],
            ['sort' => ['offset' => 1]]
        );
        if (!$document || !is_array($document)) {
            return new EventNotFound($toOffset);
        }

        return new Event($this->boxDates($document));
    }

    public function offset(): int
    {
        $document = $this->events->findOne(['_id' => '__offset__']);
        if (!$document) {
            return self::DEFAULT_OFFSET;
        }
        assert(is_array($document));

        return (int) $document['__committed_offset__'];
    }

    private function boxDates(array $document): array
    {
        foreach (self::DATES as $key) {
            $value = $document[$key] ?? null;
            if ($value instanceof UTCDateTime) {
                $document[$key] = DateTimeImmutable::createFromMutable($value->toDateTime());
            }
        }

        return $document;
    }
}
