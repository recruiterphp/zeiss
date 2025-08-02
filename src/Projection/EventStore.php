<?php

declare(strict_types=1);

namespace Zeiss\Projection;

interface EventStore
{
    public const DEFAULT_OFFSET = 0;

    /**
     * Gets the current event offset.
     */
    public function offset(): int;

    /**
     * Fetches the next event after a given offset.
     */
    public function fetchOneOfAfter(array $types, int $fromOffset, int $limit = 100000): NextEvent;
}
