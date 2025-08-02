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
    /**
     * Projection constructor.
     */
    public function __construct(protected EventStore $eventStore, protected Database $projectionDatabase)
    {
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
