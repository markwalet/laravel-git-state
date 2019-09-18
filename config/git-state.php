<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Git State configuration
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the git drivers below you wish
    | to use as your default driver. The value must reflect a
    | key in the drivers array below.
    |
    */

    'default' => env('GIT_STATE_DRIVER', 'exec'),

    /*
    |--------------------------------------------------------------------------
    | Driver configurations
    |--------------------------------------------------------------------------
    |
    | This is an example list of configurations that are used for the git drivers.
    | The given configuration options should be fine for most projects. But
    | feel free to change them however you like.
    |
    | Supported drivers are: 'exec', 'file', 'fake'.
    |
    */

    'drivers' => [
        'exec' => [
            'driver' => 'exec',
            'path' => base_path('.git'),
        ],

        'file' => [
            'driver' => 'file',
            'path' => base_path('.git'),
        ],
    ],
];
