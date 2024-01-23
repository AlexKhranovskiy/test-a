<?php

namespace App\Services;

use App\Models\Position;
use App\Traits\ResponseTrait;

class PositionService
{
    use ResponseTrait;

    public function getAll()
    {
        $positions = Position::all(['id', 'name']);

        return $this->responseWithSuccess([
            'positions' => $positions->toArray()
        ]);
    }
}
