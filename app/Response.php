<?php

namespace App;

class Response
{

    /**
     * Give a success response.
     *
     * @param  $payload
     * @param  int $code
     */
    public static function success($payload, $code = 200)
    {
        http_response_code($code);

        header('Content-Type: application/json');

        print_r($payload);
    }

}