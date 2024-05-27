<?php

namespace App\Filament\Resources\RegionResource\Pages;

use App\Filament\Resources\RegionResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditRegion extends EditRecord
{
    protected static string $resource = RegionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->action(function ($data, $record){
                if ($record->townships()->count() > 0) {
                    Notification::make()
                        ->danger()
                        ->title('Region is in use')
                        ->body('This Region is in use by township')
                        ->send();

                    return;
                }

                Notification::make()
                    ->success()
                    ->title('Region deleted')
                    ->body('The Region data has been deleted')
                    ->send();

                $record->delete();
                redirect('/admin/regions');

            })
        ];
    }
}
