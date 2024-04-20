<?php

namespace App\Enums;
// Enumerador de tipos de respuesta
enum JsonResponseEnum {
    const SUCCESS = 'success';
    const ERROR = 'error';
    const NOT_FOUND = 'not_found';
    const FORBIDDEN = 'forbidden';
    const UNAUTHORIZED = 'unauthorized';
}

