<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Category;

class NewService
{
    public function getCategories($filter)
    {
        $query = Category::with(['videos' => function ($q) use ($filter) {
            if (isset($filter['new'])) {
                $q->where('new', $filter['new']);
            }
        }])
        ->when(isset($filter['id']), function ($q) use ($filter) {
            $q->where('id', $filter['id']);
        })
        ->orderBy('created_at', 'desc');

        $perPage = $filter['limit'] ?? 20;
        $data = $query->paginate($perPage);

        return $data;
    }

    public function getArticles($filter)
    {
        $query = Article::query()
            ->when(isset($filter['id']), function ($q) use ($filter) {
                $q->where('id', $filter['id']);
            })
            ->when(isset($filter['top']), function ($q) use ($filter) {
                $q->where('top', $filter['top']);
            })
            ->when(isset($filter['latest']), function ($q) use ($filter) {
                $q->where('latest', $filter['latest']);
            })
            ->orderBy('created_at', 'desc');

        $perPage = $filter['limit'] ?? 20;
        $data = $query->paginate($perPage);

        return $data;
    }
}
