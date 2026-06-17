<?php

namespace App\Helpers;


class ApiResponse
{
    public static function success(
        array $data = []
    )
    {
        return [
            'success' => true,
            'data' => $data
        ];
    }

    public static function error(
        string $message
    )
    {
        return [
            'success' => false,
            'message' => $message
        ];
    }
}
