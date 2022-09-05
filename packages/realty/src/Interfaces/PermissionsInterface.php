<?php

namespace Realty\Interfaces;

interface PermissionsInterface
{
    public const PERMISSIONS = [
        'APPROVAL_AD' => 'approval_ad',
        'REJECT_AD' => 'reject_ad',
        'DELETE_AD' => 'delete_ad',
        'UPDATE_AD' => 'update_ad',
        'DISABLE_AD' => 'disable_ad',
        'ADS_ALL' => 'ads_all',

        'CREATE_CATEGORY' => 'create_category',
        'UPDATE_CATEGORY' => 'update_category',
        'REMOVE_CATEGORY' => 'remove_category',

        'DROP_SETTING' => 'drop_setting',
        'PUT_SETTING' => 'put_setting',
        'ASSIGN_SETTING' => 'assign_setting',

        'CREATE_ROLE' => 'create_role',
        'UPDATE_ROLE' => 'update_role',
        'REMOVE_ROLE' => 'remove_role',
        'ASSIGN_ROLE' => 'assign_role',

        'CREATE_USER' => 'create_user',
        'UPDATE_USER' => 'update_user',
        'REMOVE_USER' => 'remove_user',
        'USERS_ALL' => 'users_all',

        'CREATE_PERMISSION' => 'create_permission',
        'UPDATE_PERMISSION' => 'update_permission',
        'REMOVE_PERMISSION' => 'remove_permission',
        'ASSIGN_PERMISSION' => 'assign_permission',

        'PRIVATE_PERSON' => 'private_person',
        'REAL_ESTATE_AGENCY' => 'real_estate_agency',
        'SELF_EMPLOYED' => 'self_employed',
        'REALTOR' => 'realtor',

        'CREATE_PROPERTY' => 'create_property',
        'UPDATE_PROPERTY' => 'create_property',
        'DROP_PROPERTY' => 'drop_property',

        'CREATE_QUESTION' => 'create_question',
        'UPDATE_QUESTION' => 'create_question',
        'DROP_QUESTION' => 'drop_question',

        'CREATE_SET' => 'create_set',
        'UPDATE_SET' => 'create_set',
        'DROP_SET' => 'drop_set',
    ];

    public const USER_PERMISSIONS = [
        self::PERMISSIONS['PRIVATE_PERSON'],
        self::PERMISSIONS['REAL_ESTATE_AGENCY'],
        self::PERMISSIONS['SELF_EMPLOYED'],
        self::PERMISSIONS['REALTOR'],
    ];
}
