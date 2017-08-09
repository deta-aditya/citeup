<?php

use App\Modules\Electrons\Stages\StageService;

return [
    
    // The current version of the web.
    'version' => 'v0.9.0 (Beta)',

    // The landing page configuration
    'landing' => [

        // The countdown in the landing page.
        'countdown' => [
            'active' => true,
            'off' => '2017-08-21 12:00:00',
            'text' => 'Pendaftaran akan dibuka dalam:',
        ],

        // Show/hide sections of the landing page.
        'show' => [
            'welcometron' => true,
            'activities' => true,
            'testimonials' => false,
            'prizes' => true,
            'map' => true,
            'faqs' => true,
            'news' => true,
            'galleries' => false,
            'contact' => true,
            'sponsors' => true,
        ],

    ],

    // The address of the event.
    'address' => [

        // Location on map.
        'location' => [
            'lat' => -6.2284204553772,
            'lng' => 106.78988412023,
        ],

    ],

    // Contact informations.
    'contact' => [

        'email' => '',
        'facebook' => '',
        'twitter' => '',
        'instagram' => '',
        'line' => '',
    
        // The contact person information    
        'person' => [
            [
                'name' => 'Adam Marsono Putra',
                'phone' => '082133022618',
                'email' => 'a.putra@universitaspertamina.ac.id',
                'line' => 'damanotra',
            ],
            [
                'name' => 'Aries Dwi Prasetiyo',
                'phone' => '081230102023',
                'email' => 'ariesdwiprasetiyo4@gmail.com',
                'line' => 'aries0',
            ],
        ],
    ],

    // The application's current stage.
    'stage' => function () { return StageService::current(); },

];
