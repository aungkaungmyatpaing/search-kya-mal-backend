<?php

namespace App\Services;

use App\Models\Region;
use App\Models\Township;

class LocationService
{
    public function getRegions()
    {
        $data = Region::all();

        return $data;
    }

    public function getTownships($filter)
    {
        $query = Township::query()
            ->when(isset($filter['region_id']), function ($q) use ($filter){
                $q->where('region_id', $filter['region_id']);
            })
            ->orderBy('created_at', 'desc');
        $perPage = $filter['limit'] ?? 20;
        $data = $query->paginate($perPage);

        return $data;
    }
}
