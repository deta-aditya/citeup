<?php

return [

    'base' => [
    
        'defaults' => [
            'select' => [],
            'sort' => ['id' => 'asc'],
            'criteria' => [],
            'skip' => 0,
            'take' => 25,
            'random' => false,
            'with' => [],
            'clean' => false,
        ],

        'delimiters' => [
            'select' => ',',
            
            'sort' => [
                'per_field' => ',',
                'per_value' => ':',
            ],
            
            'criteria' => [
                'per_field' => ',',
                'per_value' => ':',
                'per_subvalue' => ';',
            ],

            'with' => ',',
        ],

        'selectable' => ['id', 'created_at', 'updated_at'],
        'sortable' => ['id', 'created_at', 'updated_at'],
        'comparable' => ['id', 'created_at', 'updated_at'],
        'loadable' => [],
        
    ],

    'users' => [

        'defaults' => [
        
            'with' => ['profile', 'entry'],

        ],

        'delimiters' => [
            'keys' => ',',
        ],

        'selectable' => [
            'email',
        ],

        'sortable' => [
            'email',
        ],

        'comparable' => [
            'email', 'role_id',
        ],

        'loadable' => [
            'profile', 'entry',
        ],

    ],

];
