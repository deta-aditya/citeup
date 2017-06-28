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
            'activities' => ',',
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
            'profile', 'entry', 'keys', 'alerts', 'activity', 'edits',
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

        'sortable' => [
            'held_at',
        ],

        'comparable' => [
            'description', 'held_at', 'activity_id',
        ],

        'loadable' => [
            'activity', 'edits',
        ],

    ],

    'submissions' => [

        'selectable' => [
            'description', 'picture',
        ],

        'comparable' => [
            'description', 'picture', 'entry_id',
        ],

        'loadable' => [
            'entry',
        ],

    ],

    'documents' => [

        'selectable' => [
            'file', 'type',
        ],

        'comparable' => [
            'file', 'type', 'entry_id',
        ],

        'loadable' => [
            'entry',
        ],

    ],

    'testimonials' => [

        'selectable' => [
            'content', 'rating',
        ],

        'comparable' => [
            'content', 'rating', 'entry_id',
        ],

        'loadable' => [
            'entry',
        ],

    ],

    'attempts' => [

        'selectable' => [
            'started_at', 'finished_at',
        ],

        'sortable' => [
            'started_at', 'finished_at',
        ],

        'comparable' => [
            'started_at', 'finished_at', 'entry_id',
        ],

        'loadable' => [
            'entry', 'answers',
        ],

    ],

    'questions' => [

        'selectable' => [
            'content', 'picture',
        ],

        'comparable' => [
            'content', 'picture',
        ],

        'loadable' => [
            'choices', 'answers',
        ],

    ],

    'choices' => [

        'selectable' => [
            'content', 'picture',
        ],

        'comparable' => [
            'content', 'picture', 'question_id',
        ],

        'loadable' => [
            'question', 'answers',
        ],

    ],

    'answers' => [

        'comparable' => [
            'attempt_id', 'choice_id',
        ],

        'loadable' => [
            'attempt', 'choice',
        ],

    ],

    'galleries' => [

        'selectable' => [
            'caption', 'picture',
        ],

        'comparable' => [
            'caption', 'picture',
        ],

        'loadable' => [
            'edits',
        ],

    ],

    'news' => [

        'selectable' => [
            'title', 'content', 'picture',
        ],

        'sortable' => [
            'title',
        ],

        'comparable' => [
            'title', 'content', 'picture',
        ],

        'loadable' => [
            'edits',
        ],

    ],

    'edits' => [

        'sortable' => [
            'editable_id', 'editable_type'
        ],

        'comparable' => [
            'editable_id', 'editable_type'
        ],

        'loadable' => [
            'editable', 'user',
        ],

    ],

];
