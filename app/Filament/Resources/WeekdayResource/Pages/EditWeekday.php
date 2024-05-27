<?php

namespace App\Filament\Resources\WeekdayResource\Pages;

use App\Filament\Resources\WeekdayResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditWeekday extends EditRecord
{
    protected static string $resource = WeekdayResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->action(function ($data, $record){
                if ($record->fields()->count() > 0) {
                    Notification::make()
                        ->danger()
                        ->title('Weekday is in use')
                        ->body('This Weekday is in use by field')
                        ->send();

                    return;
                }

                Notification::make()
                    ->success()
                    ->title('Weekday deleted')
                    ->body('The Weekday data has been deleted')
                    ->send();

                $record->delete();
                redirect('/admin/weekdays');

            })
        ];
    }
}
