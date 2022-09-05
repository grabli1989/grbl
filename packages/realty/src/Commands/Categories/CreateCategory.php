<?php

namespace Realty\Commands\Categories;

class CreateCategory
{
    private array $name;

    private int $mediaId;

    private int $position;

    /**
     * @param  array  $name
     * @param  int  $mediaId
     * @param  int  $position
     */
    public function __construct(array $name, int $mediaId, int $position)
    {
        $this->name = $name;
        $this->mediaId = $mediaId;
        $this->position = $position;
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
