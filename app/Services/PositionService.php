<?php

namespace App\Services;

use App\Models\Position;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class PositionService
{
    use ResponseTrait;

    /** Gets all positions.
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $positions = Position::all(['id', 'name']);
        if(sizeof($positions) === 0){
            return $this->responseWithError("Positions not found", 422);
        } else {
            return $this->responseWithSuccess([
                'positions' => $positions->toArray()
            ]);
        }
    }
}
