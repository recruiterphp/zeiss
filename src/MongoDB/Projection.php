<?php

namespace Zeiss\MongoDB;

use MongoDB\Database;
use Zeiss\MongoDB\Command\Skip;
use Zeiss\MongoDB\Command\UpdateRecord;
use Zeiss\Projection\Command;
use Zeiss\Projection\Event;
use Zeiss\Projection\EventStore;
use Zeiss\Projection\Projection as ProjectionInterface;

abstract class Projection implements ProjectionInterface
{
    /** @var EventStore */
    protected $eventStore;

    /** @var Database */
    protected $projectionDatabase;

    /**
     * Projection constructor.
     */
    public function __construct(EventStore $eventStore, Database $projectionDatabase)
    {
        $this->eventStore = $eventStore;
        $this->projectionDatabase = $projectionDatabase;
    }

    protected function skip(): Command
    {
        return new Skip();
    }

    // TODO: $this->hold($event, $id);
    // TODO: $this->release($id);
    // TODO: $this->updateRecord($record);
    // TODO: $this->deleteRecord($record);
    // TODO: $this->compose($this->updateRecord($a), $this->updateRecord($b));
    protected function updateRecord(Record $record, Event $event): Command
    {
        return new UpdateRecord($this->projectionDatabase, $record, $event->offset());
    }
}
