<?php

defined('PARAM_CORS') or define('PARAM_CORS', 'cors');

return [
    PARAM_CORS => [
        'Origin' => ['*'],
        'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS', 'HEAD', 'PATCH'],
        'Access-Control-Request-Headers' => ['*'],
        'Access-Control-Allow-Credentials' => true,
        'Access-Control-Max-Age' => 86400,
        'Access-Control-Expose-Headers' => [
            'X-Pagination-Current-Page',
            'X-Pagination-Page-Count',
            'X-Pagination-Per-Page',
            'X-Pagination-Total-Count'
        ],
    ],
];
