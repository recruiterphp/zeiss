<?php

namespace Zeiss\Projection;

use MongoDB\Collection;

class Registry
{
    private const DEFAULT_OFFSET = -1;

    /**
     * @var Collection
     */
    private $registry;

    /**
     * @var int[]
     */
    private $offsets = [];

    /**
     * Registry constructor.
     */
    public function __construct(Collection $registry)
    {
        $this->registry = $registry;
    }

    public function initialize(string $projectionName): int
    {
        $this->initializeIndexes();

        $entry = $this->registry->findOne(['name' => $projectionName]);
        if (!$entry) {
            $entry = [
                'name' => $projectionName,
                'offset' => $this->offset($projectionName),
            ];
            $result = $this->registry->insertOne($entry);
            assert(1 === $result->getInsertedCount());
            $entry['_id'] = $result->getInsertedId();
        }
        assert(is_array($entry));

        return $this->offsets[$projectionName] = $entry['offset'];
    }

    public function update(string $projectionName, int $offset): void
    {
        $this->offsets[$projectionName] = $offset;
        $this->registry->updateOne(
            ['name' => $projectionName],
            ['$set' => ['offset' => $this->offsets[$projectionName]]]
        );
    }

    public function offset(string $projectionName)
    {
        return $this->offsets[$projectionName] ?? self::DEFAULT_OFFSET;
    }

    private function initializeIndexes(): void
    {
        $this->registry->createIndex(
            [
                'name' => 1,
            ],
            [
                'background' => true,
                'unique' => true,
                'name' => 'name_1',
            ]
        );
    }
}
