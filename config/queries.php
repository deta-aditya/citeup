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
        
            'with' => ['entry'],

        ],

        'delimiters' => [
            'keys' => ',',
            'activities' => ',',
        ],

        'selectable' => [
            'name', 'email', 'photo', 'section', 'crew',
        ],

        'sortable' => [
            'name', 'email', 'section', 'crew',
        ],

        'comparable' => [
            'name', 'email', 'section', 'crew', 'role_id', 'entry_id',
        ],

        'loadable' => [
            'entry', 'keys', 'alerts', 'activity', 'documents', 'edits',
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
            'title', 'pivot_seen_at', 'pivot_announced_at',
        ],

        'comparable' => [
            'title', 'content',
        ],

        'loadable' => [
            'users',
        ],

    ],


    'entries' => [

        'defaults' => [
            'with' => ['users', 'activity'],
        ],

        'selectable' => [
            'name', 'agency', 'address', 'phone', 'city', 'stage', 'status',
        ],

        'sortable' => [
            'name', 'agency', 'stage', 'status',
        ],

        'comparable' => [
            'name', 'agency', 'phone', 'city', 'stage', 'status', 'activity_id', 
        ],

        'loadable' => [
            'users', 'activity', 'attempts', 'submissions', 'testimonials',
        ],

    ],

    'activities' => [

        'selectable' => [
            'name', 'description', 'short_description', 'icon', 'order', 'total_prizes', 'prize_first', 'prize_second', 'prize_third',
        ],

        'sortable' => [
            'name', 'order',
        ],

        'comparable' => [
            'name', 'description', 'short_description', 'order',
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
            'user',
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
            'edits', 'edits.user.profile',
        ],

    ],

    'sponsors' => [

        'selectable' => [
            'name', 'picture', 'type', 'url',
        ],

        'sortable' => [
            'name', 'type', 'url',
        ],

        'comparable' => [
            'name', 'picture', 'type', 'url',
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

    'contact_people' => [

        'selectable' => [
            'name', 'email', 'phone', 'line',
        ],

        'sortable' => [
            'name', 'email',
        ],

        'comparable' => [
            'name', 'email', 'phone', 'line',
        ],

        'loadable' => [
            //
        ],

    ],

    'html_contents' => [

        'selectable' => [
            'name', 'content',
        ],

        'sortable' => [
            'name',
        ],

        'comparable' => [
            'name',
        ],

        'loadable' => [
            'edits',
        ],

    ],

];
