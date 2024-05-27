<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TypeResource;
use App\Http\Resources\WeekdayResource;
use App\Http\Resources\WeekendResource;
use App\Services\TypeService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    use ApiResponse;

    private TypeService $typeService;

    public function __construct(TypeService $typeService)
    {
        $this->typeService = $typeService;
    }

    public function getTypes()
    {
        $data = $this->typeService->getTypes();
        return $this->success("Get Types successfully", TypeResource::collection($data));
    }

    public function getWeekdays()
    {
        $data = $this->typeService->getWeekdays();
        return $this->success("Get Weekdays successfully", WeekdayResource::collection($data));
    }

    public function getWeekends()
    {
        $data = $this->typeService->getWeekends();
        return $this->success("Get Weekends successfully", WeekendResource::collection($data));
    }
}
