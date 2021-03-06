<?php

namespace Zeiss\Projection;

class Runner
{
    /**
     * @var Projection
     */
    private $projection;

    /**
     * @var Registry
     */
    private $registry;

    /**
     * Runner constructor.
     */
    public function __construct(Projection $projection, Registry $registry)
    {
        $this->projection = $projection;
        $this->registry = $registry;
    }

    public function initialize(): void
    {
        $this->registry->initialize($this->projection::name());
        $this->projection->initialize();
    }

    /**
     * @return bool true on success, false otherwise (e.g. nothing to do)
     */
    public function execute(): bool
    {
        $event = $this->projection->fetchNextEvent($this->registry->offset($this->projection::name()));

        if ($event instanceof Event) {
            $found = true;
            $records = $this->projection->fetch($event);

            if (0 === count($records)) {
                $records = $this->projection->defaultRecords($event);
            }
            foreach ($records as $record) {
                $command = $this->projection->process($record, $event);
                $command->execute();
            }
        } else {
            $found = false;
        }

        $this->registry->update($this->projection::name(), $event->offset());

        return $found;
    }
}
