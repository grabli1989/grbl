<?php

namespace Realty\Commands\Categories;

class UpdateCategory
{
    private array $name;

    private int $mediaId;

    private int $position;

    private int $id;

    /**
     * @param  int  $id
     * @param  array  $name
     * @param  int  $mediaId
     * @param  int  $position
     */
    public function __construct(int $id, array $name, int $mediaId, int $position)
    {
        $this->name = $name;
        $this->mediaId = $mediaId;
        $this->position = $position;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getName(): array
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getMediaId(): int
    {
        return $this->mediaId;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }
}
