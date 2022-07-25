<?php

use App\Extensions\DefaultTheme;

use App\Extensions\DawnElements;

return [
    'admin-path' => env('ASTRALCMS_ADMIN_PATH', 'admin'),

    'theme' => DefaultTheme\Theme::class,

    'extensions' => [
        DawnElements\Extension::class
    ]
];