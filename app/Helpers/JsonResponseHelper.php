<?php

namespace App\Helpers;

use App\Enums\JsonResponseEnum;

// Funciones para devolver respuestas JSON

class JsonResponseHelper
{
    // Funcion para devolver respuesta success
    public static function success($message = "Successful Operation", $data = null)
    {
        if ($data === null) {
            $json = ['type' => JsonResponseEnum::SUCCESS, 'message' => $message];
        } else {
            $json = ['type' => JsonResponseEnum::SUCCESS, 'message' => $message, 'data' => $data];
        }
        return response($json, 200);
    }

    // Funcion para devolver respuesta error
    public static function error($message = 'Internal Server Error', $hint = null)
    {
        if (env('APP_ENV') == 'local') {
            $json = ['type' => JsonResponseEnum::ERROR, 'message' => $message, 'hint' => $hint];
        } else {
            $json = ['type' => JsonResponseEnum::ERROR, 'message' => 'Internal Server Error'];
        }
        return response($json, 500);
    }

    // Funcion para devolver respuesta not found
    public static function notFound($message = 'Not Found')
    {
        return response(
            ['type' => JsonResponseEnum::NOT_FOUND, 'message' => $message],
            404
        );
    }

    // Funcion para devolver respuesta forbidden
    public static function forbidden($message = 'Not Found')
    {
        return response(
            ['type' => JsonResponseEnum::FORBIDDEN, 'message' => $message],
            403
        );
    }

    // Funcion para devolver respuesta unauthorized
    public static function unauthorized($message = 'Unauthorized')
    {
        return response(
            ['type' => JsonResponseEnum::UNAUTHORIZED, 'message' => $message],
            401
        );
    }

    // Funcion para devolver respuesta de un recurso creado en la Base de datos
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
