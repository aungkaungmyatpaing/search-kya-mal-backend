<?php

namespace App\Filament\Resources\TownshipResource\Pages;

use App\Filament\Resources\TownshipResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditTownship extends EditRecord
{
    protected static string $resource = TownshipResource::class;

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
                        ->title('Township is in use')
                        ->body('This Township is in use by field')
                        ->send();

                    return;
                }

                Notification::make()
                    ->success()
                    ->title('Township deleted')
                    ->body('The Township data has been deleted')
                    ->send();

                $record->delete();
                redirect('admin/townships');
            })
        ];
    }
}
