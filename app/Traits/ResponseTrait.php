<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    /** Handles success response.
     * @param array $data
     * @return JsonResponse
     */
    public function responseWithSuccess(array $data): JsonResponse
    {
        $result = [
            'success' => true,
        ];

        return response()->json(array_merge($result, $data));
    }

    /** Handles error response.
     * @param string $message
     * @param int $code
     * @param array|null $data
     * @return JsonResponse
     */
    public function responseWithError(string $message, int $code, ?array $data = null): JsonResponse
    {
        $result = [
            'success' => false,
            'message' => $message
        ];

        if (!is_null($data)) {
            $result = array_merge($result, $data);
        }

        return response()->json($result, $code);
    }

    /** Handles response for validation.
     * @param Validator $validator
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function validationErrorResponse(
        Validator $validator, string $message = 'Validation failed', int $code = 422): JsonResponse
    {
        $result = [
            'success' => false,
            'message' => $message,
            'fails' => $validator->errors()
        ];
        return response()->json($result, $code);
    }
}
