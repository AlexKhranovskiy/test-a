<?php

namespace App\Http\Controllers;

use App\Services\PositionService;
use Illuminate\Http\JsonResponse;

class PositionController extends Controller
{
    /** Calls service's method and gets all positions.
     * @param PositionService $positionService
     * @return JsonResponse
     */
    public function getAll(PositionService $positionService): JsonResponse
    {
        return $positionService->getAll();
    }
}
