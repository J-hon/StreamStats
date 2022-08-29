<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{

    protected function responseJson($status = true, $responseCode = 200, $message = "", $data = []): JsonResponse
    {
        return response()->json([
            'status'  => $status,
            'message' => $message,
            'data'    => $data
        ], $responseCode);
    }

}
