<?php

namespace App\Traits;


use http\Env\Response;

trait jsonResponseTrait
{
    public function successRequest($message = null, $status = 200, $data = null)
    {

        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data
        ];
        return Response()->json($response, $status);
    }

    public function failedRequest($message = null, $status = 400, $errors = null)
    {
        $response = [
            'success' => false,
            'message' => $message ?: 'an error has occured',
            'errors' => $errors
        ];
        return Response()->json($response, $status);
    }

}
