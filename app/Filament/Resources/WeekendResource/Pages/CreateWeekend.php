<?php

namespace App\Filament\Resources\WeekendResource\Pages;

use App\Filament\Resources\WeekendResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWeekend extends CreateRecord
{
    protected static string $resource = WeekendResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
