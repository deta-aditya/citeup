<?php

return [
    
    'alien' => 'The requested field contains unwanted value(s) or has an invalid format.',
    'sort' => 'The direction value should be either "asc" or "desc".',
    'criteria' => [
        'is' => 'The value on "is" command should be either "null" or "notnull".',
        'date' => 'The value on "date" command should be a valid date with "year-month-date" format.',
        'month' => 'The value on "month" command should be between 1 and 12.',
        'day' => 'The value on "day" command should be between 1 and 31.',
        'column' => 'The first subvalue on "column" command should be either one of these: (<, <=, =, >=, >, <>).',
    ],

    'ids' => 'The following field contains invalid ID(s).',
    'slugs' => 'The following keys contain invalid slugs(s).',
];