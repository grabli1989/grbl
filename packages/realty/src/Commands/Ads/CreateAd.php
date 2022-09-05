<?php

namespace Realty\Commands\Ads;

use User\Models\User;

class CreateAd
{
    private array $caption;

    private array $description;

    private array $city;

    private array $images;

    private string $coordinates;

    private int $categoryId;

    private float $price;

    private User $user;

    private array $properties;

    /**
     * @param  array  $caption
     * @param  array  $description
     * @param  array  $city
     * @param  array  $images
     * @param  string  $coordinates
     * @param  int  $categoryId
     * @param  float  $price
     * @param  User  $user
     * @param  array  $properties
     */
    public function __construct(
        array $caption,
        array $description,
        array $city,
        array $images,
        string $coordinates,
        int $categoryId,
        float $price,
        User $user,
        array $properties,
    ) {
        $this->caption = $caption;
        $this->description = $description;
        $this->city = $city;
        $this->images = $images;
        $this->coordinates = $coordinates;
        $this->categoryId = $categoryId;
        $this->price = $price;
        $this->user = $user;
        $this->properties = $properties;
    }

    /**
     * @return array
     */
    public function getCaption(): array
    {
        return $this->caption;
    }

    /**
     * @return array
     */
    public function getDescription(): array
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public function getCity(): array
    {
        return $this->city;
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @return string
     */
    public function getCoordinates(): string
    {
        return $this->coordinates;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
    }
}
