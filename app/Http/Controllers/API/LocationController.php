<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetTownshipRequest;
use App\Http\Resources\RegionResource;
use App\Http\Resources\TownshipResource;
use App\Services\LocationService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    use ApiResponse;
    private LocationService $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }
    public function getRegions()
    {
        $data = $this->locationService->getRegions();
        return $this->success("Get Regions successfully", RegionResource::collection($data));

    }

    public function getTownships(GetTownshipRequest $request)
    {
        $data = $this->locationService->getTownships($request->validated());
        return $this->success("Get Townships successfully", TownshipResource::collection($data));
    }
}
