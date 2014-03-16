<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Reptile Responses
    |--------------------------------------------------------------------------
    |
    | These are a list of responses with associated code and HTTP status code.
    |
    | This is in a configuration file so that you can alter to match your
    | own preferences. Be aware, that changing this file will change all future
    | responses, so version your API.
    |
    */
    'none' => array(
        'code' => 0,
        'http' => 200
    ),
    'unexpected' => array(
        'code' => 1,
        'http' => 500
    ),
    'unknown' => array(
        'code' => 2,
        'http' => 405
    ),
    'api' => array(
        'code' => 3,
        'http' => 403
    ),
    'signature' => array(
        'code' => 4,
        'http' => 401
    ),
    'permission' => array(
        'code' => 5,
        'http' => 403
    ),
    'incomplete' => array(
        'code' => 6,
        'http' => 400
    ),
    'argument' => array(
        'code' => 7,
        'http' => 400
    ),
    'token' => array(
        'code' => 8,
        'http' => 401
    ),
    'method' => array(
        'code' => 9,
        'http' => 405
    ),
    'validation' => array(
        'code' => 10,
        'http' => 400
    ),
    'unavailable' => array(
        'code' => 11,
        'http' => 503
    ),
    'notfound'		=> array(
        'code'	=> 12,
        'http'	=> 404
    )
);