<?php

namespace App\Helpers;

use App\Enums\JsonResponseEnum;

class JsonResponseHelper
{
    public static function success($message = "Successful Operation", $data = null)
    {
        if ($data === null) {
            $json = ['type' => JsonResponseEnum::SUCCESS, 'message' => $message, 'data' => $data];
        } else {
            $json = ['type' => JsonResponseEnum::SUCCESS, 'message' => $message];
        }
        return response($json, 200);
    }

    public static function error($message = 'Internal Server Error', $hint = null)
    {
        if (env('APP_ENV') == 'local') {
            $json = ['type' => JsonResponseEnum::ERROR, 'message' => $message, 'hint' => $hint];
        } else {
            $json = ['type' => JsonResponseEnum::ERROR, 'message' => 'Internal Server Error'];
        }

        return response($json, 500);

    }

    public static function notFound($message = 'Not Found')
    {
        return response(
            ['type' => JsonResponseEnum::NOT_FOUND, 'message' => $message],
            404
        );

    }
}
