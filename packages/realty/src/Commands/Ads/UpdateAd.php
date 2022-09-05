<?php

namespace Realty\Commands\Ads;

use Realty\Models\Ad;
use User\Models\User;

class UpdateAd
{
    private array $caption;

    private array $description;

    private array $city;

    private array $images;

    private string $coordinates;

    private int $categoryId;

    private float $price;

    private User $user;

    private Ad $ad;

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
     * @param  Ad  $ad
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
        Ad $ad,
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
        $this->ad = $ad;
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
     * @return Ad
     */
    public function getAd(): Ad
    {
        return $this->ad;
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
    }
}
