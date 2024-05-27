<?php

namespace App\Services;

use App\Models\Type;
use App\Models\Weekday;
use App\Models\Weekend;

class TypeService
{
    public function getTypes()
    {
        $data = Type::all();

        return $data;
    }

    public function getWeekdays()
    {
        $data = Weekday::all();

        return $data;
    }

    public function getWeekends()
    {
        $data = Weekend::all();

        return $data;
    }
}
