<?php

namespace Realty\Interfaces;

interface RolesInterface
{
    public const ROLES = [
        'SUPER_ADMIN' => 'super-admin',
        'ADMIN' => 'admin',
        'MODERATOR' => 'moderator',
        'PRIVATE_PERSON' => 'private_person',
        'REAL_ESTATE_AGENCY' => 'real_estate_agency',
        'SELF_EMPLOYED' => 'self_employed',
        'REALTOR' => 'realtor',
    ];

    public const USER_ROLES = [
        self::ROLES['PRIVATE_PERSON'],
        self::ROLES['REAL_ESTATE_AGENCY'],
        self::ROLES['SELF_EMPLOYED'],
        self::ROLES['REALTOR'],
    ];

    public const ROLES_PERMISSIONS = [
        self::ROLES['SUPER_ADMIN'] => [],
        self::ROLES['ADMIN'] => [
            PermissionsInterface::PERMISSIONS['APPROVAL_AD'],
            PermissionsInterface::PERMISSIONS['REJECT_AD'],
            PermissionsInterface::PERMISSIONS['DELETE_AD'],
            PermissionsInterface::PERMISSIONS['DISABLE_AD'],
            PermissionsInterface::PERMISSIONS['UPDATE_AD'],
            PermissionsInterface::PERMISSIONS['ADS_ALL'],
            PermissionsInterface::PERMISSIONS['CREATE_CATEGORY'],
            PermissionsInterface::PERMISSIONS['UPDATE_CATEGORY'],
            PermissionsInterface::PERMISSIONS['REMOVE_CATEGORY'],
            PermissionsInterface::PERMISSIONS['PUT_SETTING'],
            PermissionsInterface::PERMISSIONS['DROP_SETTING'],
            PermissionsInterface::PERMISSIONS['CREATE_PERMISSION'],
            PermissionsInterface::PERMISSIONS['UPDATE_PERMISSION'],
            PermissionsInterface::PERMISSIONS['REMOVE_PERMISSION'],
            PermissionsInterface::PERMISSIONS['ASSIGN_PERMISSION'],
            PermissionsInterface::PERMISSIONS['CREATE_ROLE'],
            PermissionsInterface::PERMISSIONS['UPDATE_ROLE'],
            PermissionsInterface::PERMISSIONS['REMOVE_ROLE'],
            PermissionsInterface::PERMISSIONS['ASSIGN_ROLE'],
            PermissionsInterface::PERMISSIONS['CREATE_USER'],
            PermissionsInterface::PERMISSIONS['UPDATE_USER'],
            PermissionsInterface::PERMISSIONS['REMOVE_USER'],
            PermissionsInterface::PERMISSIONS['USERS_ALL'],
            PermissionsInterface::PERMISSIONS['CREATE_PROPERTY'],
            PermissionsInterface::PERMISSIONS['UPDATE_PROPERTY'],
            PermissionsInterface::PERMISSIONS['DROP_PROPERTY'],
            PermissionsInterface::PERMISSIONS['CREATE_QUESTION'],
            PermissionsInterface::PERMISSIONS['UPDATE_QUESTION'],
            PermissionsInterface::PERMISSIONS['DROP_QUESTION'],
            PermissionsInterface::PERMISSIONS['CREATE_SET'],
            PermissionsInterface::PERMISSIONS['UPDATE_SET'],
            PermissionsInterface::PERMISSIONS['DROP_SET'],
        ],
        self::ROLES['MODERATOR'] => [
            PermissionsInterface::PERMISSIONS['APPROVAL_AD'],
            PermissionsInterface::PERMISSIONS['REJECT_AD'],
            PermissionsInterface::PERMISSIONS['DELETE_AD'],
            PermissionsInterface::PERMISSIONS['DISABLE_AD'],
            PermissionsInterface::PERMISSIONS['UPDATE_AD'],
            PermissionsInterface::PERMISSIONS['CREATE_CATEGORY'],
            PermissionsInterface::PERMISSIONS['UPDATE_CATEGORY'],
            PermissionsInterface::PERMISSIONS['REMOVE_CATEGORY'],
            PermissionsInterface::PERMISSIONS['PUT_SETTING'],
            PermissionsInterface::PERMISSIONS['DROP_SETTING'],
            PermissionsInterface::PERMISSIONS['CREATE_PROPERTY'],
            PermissionsInterface::PERMISSIONS['UPDATE_PROPERTY'],
            PermissionsInterface::PERMISSIONS['DROP_PROPERTY'],
            PermissionsInterface::PERMISSIONS['CREATE_QUESTION'],
            PermissionsInterface::PERMISSIONS['UPDATE_QUESTION'],
            PermissionsInterface::PERMISSIONS['DROP_QUESTION'],
            PermissionsInterface::PERMISSIONS['CREATE_SET'],
            PermissionsInterface::PERMISSIONS['UPDATE_SET'],
            PermissionsInterface::PERMISSIONS['DROP_SET'],
        ],
        self::ROLES['PRIVATE_PERSON'] => [
            PermissionsInterface::PERMISSIONS['PRIVATE_PERSON'],
        ],
        self::ROLES['REAL_ESTATE_AGENCY'] => [
            PermissionsInterface::PERMISSIONS['REAL_ESTATE_AGENCY'],
        ],
        self::ROLES['SELF_EMPLOYED'] => [
            PermissionsInterface::PERMISSIONS['SELF_EMPLOYED'],
        ],
        self::ROLES['REALTOR'] => [
            PermissionsInterface::PERMISSIONS['REALTOR'],
        ],
    ];
}
