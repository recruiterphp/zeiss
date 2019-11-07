<?php

namespace Zeiss\Projection;

interface Projection
{
    /**
     * Gets the name of the projection.
     */
    public static function name(): string;

    /**
     * Initialize the projection (e.g. build indexes).
     */
    public function initialize(): void;

    public function fetchNextEvent(int $offset): NextEvent;

    public function process(Record $record, Event $event): Command;

    /**
     * Fetches zero or more records from the existing projection given an event.
     *
     * @return Record[]
     */
    public function fetch(Event $event): array;

    /**
     * Returns one or more default records for a given Event.
     *
     * @return Record[]
     */
    public function defaultRecords(Event $event): array;
}
