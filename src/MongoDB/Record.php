<?php

namespace Zeiss\MongoDB;

use MongoDB\BSON\ObjectId;
use Zeiss\Projection\Record as RecordInterface;

class Record implements RecordInterface
{
    /**
     * @var array
     */
    private $record;

    /**
     * @var string
     */
    private $collection;

    public function __construct(array $record, string $collection)
    {
        $this->record = $record;
        $this->collection = $collection;
        $this->ensureId();
    }

    public function id(): ObjectId
    {
        return $this->record['_id'];
    }

    public function get(string $key)
    {
        return $this->record[$key];
    }

    public function set(string $key, $value): RecordInterface
    {
        $this->record[$key] = $value;

        return $this;
    }

    public function collection(): string
    {
        return $this->collection;
    }

    public function export()
    {
        return $this->record;
    }

    private function ensureId()
    {
        if (!isset($this->record['_id'])) {
            $this->record['_id'] = new ObjectId();
        }
    }
}
