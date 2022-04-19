<?php

namespace App\Helper;

use Illuminate\Http\Response;

class ResponseBuilder
{
    public static function success($status = true, $message = '', $data = null, $errors = null, $code = 200)
    {
        return Response::json([
            'success' => $status,
            'data' => $data,
            'message' => $message,
            'errors' => $errors,
            'code' => $code
        ])
            ->setCharset('utf-8')
            ->header('Content-Type', 'application/json')
            ->setEncodingOptions(JSON_UNESCAPED_UNICODE);

    }
}
