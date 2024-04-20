<?php

namespace App\Helpers;

use App\Enums\JsonResponseEnum;

class JsonResponseHelper
{
    public static function success($message = "Successful Operation", $data = null)
    {
        if ($data === null) {
            $json = ['type' => JsonResponseEnum::SUCCESS, 'message' => $message];
        } else {
            $json = ['type' => JsonResponseEnum::SUCCESS, 'message' => $message, 'data' => $data];
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

    public static function forbidden($message = 'Not Found')
    {
        return response(
            ['type' => JsonResponseEnum::FORBIDDEN, 'message' => $message],
            403
        );
    }

    public static function unauthorized($message = 'Unauthorized')
    {
        return response(
            ['type' => JsonResponseEnum::UNAUTHORIZED, 'message' => $message],
            401
        );
    }

    public static function resourceCreated($message = "Successful Operation", $data = null)
    {
        if ($data === null) {
            $json = ['type' => JsonResponseEnum::SUCCESS, 'message' => $message];
        } else {
            $json = ['type' => JsonResponseEnum::SUCCESS, 'message' => $message, 'data' => $data];
        }
        return response($json, 201);
    }
}
