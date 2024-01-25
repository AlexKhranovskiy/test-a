<?php

namespace App\Services;

use App\Models\Position;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class PositionService
{
    use ResponseTrait;

    public function getAll(): JsonResponse
    {
        $positions = Position::all(['id', 'name']);

        return $this->responseWithSuccess([
            'positions' => $positions->toArray()
        ]);
    }
}
