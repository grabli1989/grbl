<?php

namespace Realty\Interfaces;

interface CategoriesNamesInterface
{
    public const TYPES = [
        'long' => [
            'width' => 540,
            'height' => 200,
        ],
        'short' => [
            'width' => 255,
            'height' => 200,
        ],
    ];

    public const CATEGORIES = [
        [
            'name' => [
                'ukraine' => 'Продаж будинків',
                'english' => 'Houses for sale',
                'russian' => 'Продажа домов',
            ],
            'type' => 'short',
            'previewPath' => '/images/categories/0001.jpg',
        ],
        [
            'name' => [
                'ukraine' => 'Оренда будинків',
                'english' => 'House rentals',
                'russian' => 'Аренда домов',
            ],
            'type' => 'short',
            'previewPath' => '/images/categories/0002.jpg',
        ],
        [
            'name' => [
                'ukraine' => 'Новобудови',
                'english' => 'New buildings',
                'russian' => 'Новостройки',
            ],
            'type' => 'long',
            'previewPath' => '/images/categories/0003.jpg',
        ],
        [
            'name' => [
                'ukraine' => 'Нерухомість в іпотеку',
                'english' => 'Mortgage real estate',
                'russian' => 'Недвижимость в ипотеку',
            ],
            'type' => 'long',
            'previewPath' => '/images/categories/0004.jpg',
        ],
        [
            'name' => [
                'ukraine' => 'Оренда квартир',
                'english' => 'Apartments for rent',
                'russian' => 'Аренда квартир',
            ],
            'type' => 'short',
            'previewPath' => '/images/categories/0005.jpg',
        ],
        [
            'name' => [
                'ukraine' => 'Продаж квартир',
                'english' => 'Sale of apartments',
                'russian' => 'Продажа квартир',
            ],
            'type' => 'short',
            'previewPath' => '/images/categories/0006.jpg',
        ],
    ];
}
