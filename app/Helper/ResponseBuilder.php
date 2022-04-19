<?php

namespace App\Helper;


class ResponseBuilder
{
    public static function apiResponse($status = true, $message = '', $data = null, $errors = null, $code = 200)
    {
        return response()->json([
            'success' => $status,
            'data' => $data,
            'message' => $message,
            'errors' => $errors,
            'code' => $code
        ], $code)
            ->setCharset('utf-8')
            ->header('Content-Type', 'application/json')
            ->setEncodingOptions(JSON_UNESCAPED_UNICODE);

    }
}
