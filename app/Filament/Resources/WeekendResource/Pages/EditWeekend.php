<?php

namespace App\Filament\Resources\WeekendResource\Pages;

use App\Filament\Resources\WeekendResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditWeekend extends EditRecord
{
    protected static string $resource = WeekendResource::class;

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
                        ->title('Weekend is in use')
                        ->body('This Weekend is in use by field')
                        ->send();

                    return;
                }

                Notification::make()
                    ->success()
                    ->title('Weekend deleted')
                    ->body('The Weekend data has been deleted')
                    ->send();

                $record->delete();
                redirect('/admin/weekends');

            })
        ];
    }
}
