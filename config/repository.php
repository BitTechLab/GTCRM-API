<?php

return [

    'defaults' => [
        // 'offset' => env('DEFAULT_QUERY_OFFSET', 0),
        'limit' => env('DEFAULT_QUERY_LIMIT', 20),
        // 'sort' => env('DEFAULT_QUERY_SORT', 'id'),
        // 'direction' => env('DEFAULT_QUERY_DIRECTION', 'asc'),
    ],

    'load_param' => env('LOAD_PARAM', 'load'),

];
