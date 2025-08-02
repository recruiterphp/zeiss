<?php

namespace Zeiss\MongoDB;

use MongoDB\BSON\ObjectId;
use Zeiss\Projection\Record as RecordInterface;

class Record implements RecordInterface
{
    /**
     * @param array<mixed> $record
     */
    public function __construct(private array $record, private readonly string $collection)
    {
        $this->ensureId();
    }

    public function id(): ObjectId
    {
        return $this->record['_id'];
    }

    public function get(string $key): mixed
    {
        return $this->record[$key];
    }

    /**
     * @return $this
     */
    public function set(string $key, mixed $value): self
    {
        $this->record[$key] = $value;

        return $this;
    }

    public function collection(): string
    {
        return $this->collection;
    }

    /**
     * @return array<mixed>
     */
    public function export(): array
    {
        return $this->record;
    }

    private function ensureId(): void
    {
        if (!isset($this->record['_id'])) {
            $this->record['_id'] = new ObjectId();
        }
    }
}
