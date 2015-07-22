<?php

namespace Depotwarehouse\LadderTracker\Database;

use Carbon\Carbon;
use Depotwarehouse\LadderTracker\Database\Contracts\Projector;
use Depotwarehouse\LadderTracker\Events\SerializableEvent;
use Illuminate\Database\ConnectionInterface;
use League\Event\AbstractListener;
use League\Event\EventInterface;
use League\Event\ListenerInterface;

class EventRecorder extends AbstractListener
{

    const EVENT_TABLE_NAME = "laddertracker_events";

    protected $eventTable;
    protected $database;
    protected $eventProjectors;

    public function __construct(ConnectionInterface $database, array $eventProjectors = [])
    {
        $this->database = $database;
        $this->eventTable = $database->table(self::EVENT_TABLE_NAME);
        $this->eventProjectors = $eventProjectors;
    }

    /**
     * Handle an event.
     *
     * @param EventInterface $event
     *
     * @return void
     */
    public function handle(EventInterface $event)
    {
        if (!$event instanceof SerializableEvent) {
            throw new \InvalidArgumentException("Events to be recorded must implement the SerializeableEvent Interface");
        }

        $this->recordThat($event);

        $this->projectEvent($event);
    }


    public function recordThat(SerializableEvent $event)
    {
        $now = Carbon::now()->toDateTimeString();

        $this->eventTable->insert([
            'eventName' => $event->getName(),
            'eventPayload' => $event->getSerialzedPayload(),
            'timestamp' => $now
        ]);

    }

    private function projectEvent(SerializableEvent $event)
    {
        if (array_key_exists($event->getName(), $this->eventProjectors)) {
            foreach ($this->eventProjectors[$event->getName()] as $projectorClass) {
                /** @var Projector $projector */
                $projector = new $projectorClass($this->database);

                $projector->project($event);
            }
        }
    }
}
