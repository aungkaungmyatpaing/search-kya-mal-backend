<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Http\Requests\GetCategoryRequest;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\CategoryResource;
use App\Services\NewService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class NewController extends Controller
{
    use ApiResponse;

    private NewService $newService;

    public function __construct(NewService $newService)
    {
        $this->newService = $newService;
    }

    public function getCategories(GetCategoryRequest $request)
    {
        $data = $this->newService->getCategories($request->validated());
        return $this->success("Get Categories successfully", CategoryResource::collection($data));
    }

    public function getArticles(ArticleRequest $request)
    {
        $data = $this->newService->getArticles($request->validated());
        return $this->success("Get Articles successfully", ArticleResource::collection($data));
    }
}
