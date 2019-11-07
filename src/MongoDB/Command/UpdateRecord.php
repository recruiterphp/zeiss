<?php

namespace Zeiss\MongoDB\Command;

use MongoDB\Database;
use Zeiss\MongoDB\Record;
use Zeiss\Projection\Command;

class UpdateRecord implements Command
{
    /*** @var Database */
    private $database;

    /** @var Record */
    private $record;

    /** @var int */
    private $offset;

    public function __construct(Database $database, Record $record, int $offset)
    {
        $this->database = $database;
        $this->record = $record;
        $this->offset = $offset;
    }

    public function execute(): void
    {
        $document = $this->record->export();
        $document['_offset'] = $this->offset;
        $document['_offsets'] = $document['_offsets'] ?? [];
        $document['_offsets'][] = $this->offset;

        $collection = $this->database->selectCollection($this->record->collection());
        $collection->updateOne(
            ['_id' => $this->record->id()],
            ['$set' => $document],
            ['upsert' => true]
        );
    }
}
