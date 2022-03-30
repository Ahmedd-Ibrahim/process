<?php

if (!function_exists('responseJson')) {
    function responseJson($data = [], $status = 200, $headers = [], $options = 0)
    {
        $message = ['message' => 'success'];

        return response()->json(array_merge($message, $data), $status, $headers, $options);
    }
}

if (!function_exists('failedResponseJson')) {
    function failedResponseJson($data = [], $status = 422, $headers = [], $options = 0)
    {
        $message = ['message' => 'failed'];

        return response()->json(array_merge($message, $data), $status, $headers, $options);
    }
}
