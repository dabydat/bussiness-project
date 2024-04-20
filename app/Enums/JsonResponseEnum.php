<?php

namespace App\Enums;

enum JsonResponseEnum {
    const SUCCESS = 'success';
    const ERROR = 'error';
    const NOT_FOUND = 'not_found';
    const FORBIDDEN = 'forbidden';
    const UNAUTHORIZED = 'unauthorized';
}

