<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetFieldDetailRequest;
use App\Http\Requests\GetFieldRequest;
use App\Http\Resources\FieldResource;
use App\Services\FieldService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    use ApiResponse;
    private FieldService $fieldService;

    public function __construct(FieldService $fieldService)
    {
        $this->fieldService = $fieldService;
    }

    public function getFields(GetFieldRequest $request)
    {
        $data = $this->fieldService->getFields($request->validated());
        return $this->success("Get Fields successfully", FieldResource::collection($data));
    }

    public function getFieldDetails(GetFieldDetailRequest $request)
    {
        $data = $this->fieldService->getFieldDetails($request->validated());
        return $this->success("Get Field successfully", new FieldResource($data));
    }
}
