<?php

namespace App\Http\Controllers;

use App\Services\PositionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function getAll(PositionService $positionService): JsonResponse
    {
        return $positionService->getAll();
    }
}
