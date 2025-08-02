<?php

declare(strict_types=1);

namespace Zeiss\Projection;

interface Command
{
    public function execute(): void;
}
