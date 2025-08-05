<?php

namespace App\Http\Helpers;

class ApiResponseHelper
{
    public static function validationError($message, $status = '0')
    {
        return [
            'status'    => $status,
            'statusCode' => 411,
            'message'   => "Validation Error",
            'errors'    => $message
        ];
    }

    public static function accessDenied($message, $status = '0')
    {
        return [
            'status'    => $status,
            'statusCode' => 403,
            'message'   => $message
        ];
    }

    public static function unauthorized($message, $status = '0')
    {
        return [
            'status'    => $status,
            'statusCode' => 401,
            'message'   => $message
        ];
    }

    public static function forbidden($message, $status = '0')
    {
        return [
            'status'    => $status,
            'statusCode' => 403,
            'message'   => $message
        ];
    }

    public static function getData($data, $message = 'Data Found!!!', $status = '1')
    {
        return [
            'status'    => $status,
            'statusCode' => 200,
            'message'   => $message,
            'response'  => $data
        ];
    }

    public static function notFound($message = 'No Data Available!!!', $status = '0')
    {
        return [
            'status'    => $status,
            'statusCode' => 404,
            'message'   => $message
        ];
    }

    public static function create($data, $message, $status = '1')
    {
        return [
            'status'    => $status,
            'statusCode' => 201,
            'message'   => $message,
            'response'      => $data
        ];
    }

    public static function updateError($message, $status = '0')
    {
        return [
            'status'    => $status,
            'message'   => $message,
            'statusCode' => 401,
        ];
    }

    public static function successMessage($message, $status = '1')
    {
        return [
            "status" => $status,
            'statusCode' => 200,
            'message' => $message
        ];
    }

    public static function errorMessage($message, $status = '0')
    {
        return [
            "status" => $status,
            'statusCode' => 403,
            'message' => $message
        ];
    }

    public static function badRequest($message, $status = '0')
    {
        return [
            'status'    => $status,
            'statusCode' => 400,
            'message'   => $message
        ];
    }
}
