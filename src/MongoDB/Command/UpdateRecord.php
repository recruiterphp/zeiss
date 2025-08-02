<?php

declare(strict_types=1);

namespace Zeiss\MongoDB\Command;

use MongoDB\Database;
use Zeiss\MongoDB\Record;
use Zeiss\Projection\Command;

class UpdateRecord implements Command
{
    public function __construct(private readonly Database $database, private readonly Record $record, private readonly int $offset)
    {
    }

    public function execute(): void
    {
        $document = $this->record->export();
        $document['_offset'] = $this->offset;
        $document['_offsets'] ??= [];
        $document['_offsets'][] = $this->offset;

        $collection = $this->database->selectCollection($this->record->collection());
        $collection->updateOne(
            ['_id' => $this->record->id()],
            ['$set' => $document],
            ['upsert' => true],
        );
    }
}
