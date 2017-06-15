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
            'profile', 'entry', 'keys', 'alerts', 'activity'
        ],

    ],

    'keys' => [

        'selectable' => [
            'name', 'slug',
        ],

        'sortable' => [
            'name', 'slug',
        ],

        'comparable' => [
            'name', 'slug',
        ],

        'loadable' => [
            'users',
        ],

    ],

    'alerts' => [

        'delimiters' => [
            'users' => ',',
        ],

        'selectable' => [
            'title', 'content',
        ],

        'sortable' => [
            'title'
        ],

        'comparable' => [
            'title', 'content',
        ],

        'loadable' => [
            'users',
        ],

    ],

    'activities' => [

        'selectable' => [
            'name', 'description', 'short_description', 'icon',
        ],

        'sortable' => [
            'name',
        ],

        'comparable' => [
            'name', 'description', 'short_description',
        ],

        'loadable' => [
            'entries', 'users', 'schedules', 'testimonials', 'edits',
        ],

    ],

    'schedules' => [

        'selectable' => [
            'description', 'held_at',
        ],

        'comparable' => [
            'description', 'held_at',
        ],

        'loadable' => [
            'activity',
        ],

    ],

];
