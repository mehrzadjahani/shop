<?php


namespace App\Helper;


class ResponseJson
{


    const SUCCESSFUL = 'operation successfully done';

    const FAILURE = 'operation failed';

    public static function success( $message = self::SUCCESSFUL , $data =[])
    {
        return response()->json([
                'status' => 200,
                'message' => $message,
                'data' => $data
            ]
            , 200);
    }

    public static function failure($message = self::FAILURE,$data = [])
    {
        return response()->json([
                'status' => 400,
                'message' => $message,
                'data' => $data
            ]
            , 400);
    }
}
