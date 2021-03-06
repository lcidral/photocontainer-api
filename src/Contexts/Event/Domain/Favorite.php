<?php

namespace PhotoContainer\PhotoContainer\Contexts\Event\Domain;

use PhotoContainer\PhotoContainer\Infrastructure\Entity;

class Favorite implements Entity
{
    private $id;
    private $publisher;
    private $event_id;

    /**
     * Favorite constructor.
     * @param int|null $id
     * @param Publisher $publisher
     * @param int $event_id
     */
    public function __construct(?int $id, Publisher $publisher, int $event_id)
    {
        $this->changeEventId($event_id);
        $this->changeId($id);
        $this->changePublisher($publisher);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function changeId(?int $id)
    {
        $this->id = $id;
    }

    /**
     * @return Publisher
     */
    public function getPublisher(): Publisher
    {
        return $this->publisher;
    }

    /**
     * @param Publisher $publisher
     */
    public function changePublisher(Publisher $publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * @return int|null
     */
    public function getEventId(): int
    {
        return $this->event_id;
    }

    /**
     * @param int|null $event_id
     */
    public function changeEventId(int $event_id)
    {
        $this->event_id = $event_id;
    }

}