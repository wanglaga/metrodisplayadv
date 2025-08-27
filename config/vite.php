<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Development Server
    |--------------------------------------------------------------------------
    |
    | The host and port configuration for the Vite development server.
    |
    */

    'dev_server' => [
        'url' => env('VITE_DEV_SERVER_URL', 'http://localhost:5173'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Build Path
    |--------------------------------------------------------------------------
    |
    | Path ke manifest.json hasil build Vite.
    | Sesuaikan dengan struktur hosting kamu.
    |
    */

    'build_path' => public_path('build'),

    /*
    |--------------------------------------------------------------------------
    | Entry Points
    |--------------------------------------------------------------------------
    |
    | Daftar file utama yang akan dimuat oleh Vite.
    |
    */

    'entrypoints' => [
        'resources/css/app.css',
        'resources/js/app.js',
    ],

    

];
