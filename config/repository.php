<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Default Cache Store
    |--------------------------------------------------------------------------
    |
    | This option controls the default cache store that will be used by the
    | framework. This connection is utilized if another isn't explicitly
    | specified when running a cache operation inside the application.
    |
    */

    'defaults' => [
        'offset' => env('DEFAULT_QUERY_OFFSET', 0),
        'limit' => env('DEFAULT_QUERY_LIMIT', 20),
        'order_by' => env('DEFAULT_QUERY_ORDER_BY', 'id'),
        'order_direction' => env('DEFAULT_QUERY_ORDER_DIRECTION', 'asc'),
    ],

    'load_param' => env('LOAD_PARAM', 'load'),

];
