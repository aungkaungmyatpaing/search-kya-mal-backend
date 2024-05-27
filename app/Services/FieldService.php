<?php

namespace App\Services;

use App\Exceptions\ResourceForbiddenException;
use App\Models\Field;

class FieldService
{
    public function getFields($filter)
    {
        $query = Field::query()
            ->when(isset($filter['township_id']), function ($q) use ($filter) {
                $q->where('township_id', $filter['township_id']);
            })
            ->when(isset($filter['weekday_id']), function ($q) use ($filter) {
                $q->where('weekday_id', $filter['weekday_id']);
            })
            ->when(isset($filter['weekend_id']), function ($q) use ($filter) {
                $q->where('weekend_id', $filter['weekend_id']);
            })
            ->when(isset($filter['type_id']), function ($q) use ($filter) {
                $q->where('type_id', $filter['type_id']);
            })
            ->when(isset($filter['keyword']), function ($q) use ($filter) {
                $q->where(function ($q) use ($filter) {
                    $keyword = '%' . $filter['keyword'] . '%';
                    $q->whereHas('township', function ($q) use ($keyword) {
                        $q->where('name', 'like', $keyword);
                    })
                    ->orWhereHas('type', function ($q) use ($keyword) {
                        $q->where(function ($q) use ($keyword) {
                            $q->where('stadium', 'like', $keyword)
                              ->orWhere('field', 'like', $keyword);
                        });
                    })
                    ->orWhereHas('weekend', function ($q) use ($keyword) {
                        $q->where(function ($q) use ($keyword) {
                            $q->where('price', 'like', $keyword)
                              ->orWhere('hour', 'like', $keyword);
                        });
                    })
                    ->orWhereHas('weekday', function ($q) use ($keyword) {
                        $q->where(function ($q) use ($keyword) {
                            $q->where('price', 'like', $keyword)
                              ->orWhere('hour', 'like', $keyword);
                        });
                    });
                });
            })
            ->orderBy('created_at', 'desc');
            $perPage = $filter['limit'] ?? 20;
        $data = $query->paginate($perPage);

        return $data;
    }

    public function getFieldDetails($filter)
    {
        $data = Field::find($filter['id']);
        if ($data) {
            return $data;
        }else {
            throw new ResourceForbiddenException('Fetching data failed, filed not found');
        }
    }
}
