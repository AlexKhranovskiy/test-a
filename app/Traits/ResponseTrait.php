<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    public function responseWithSuccess()
    {
        return response()->json();
    }
    public function responseWithError(string $message, int $code, ?array $data = null)
    {
        $result = [
            'success' => false,
            'message' => $message
        ];

        if(!is_null($data)){
            $result[] = $data;
        }

        return response()->json($result, $code);
    }

    public function validationErrorResponse(
        Validator $validator, string $message = 'Validation failed', int $code = 422)
    : JsonResponse
    {
        $result = [
            'success' => false,
            'message' => $message,
            'fails' => $validator->errors()
        ];
        return response()->json($result, $code);
    }
}
