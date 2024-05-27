<?php

namespace App\Filament\Resources\TypeResource\Pages;

use App\Filament\Resources\TypeResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditType extends EditRecord
{
    protected static string $resource = TypeResource::class;

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
                            ->title('Type is in use')
                            ->body('This Type is in use by field')
                            ->send();

                        return;
                    }

                    Notification::make()
                        ->success()
                        ->title('Type deleted')
                        ->body('The Type data has been deleted')
                        ->send();

                    $record->delete();
                    redirect('/admin/types');

                })
        ];
    }
}
