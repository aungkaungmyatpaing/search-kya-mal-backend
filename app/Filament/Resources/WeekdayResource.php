<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WeekdayResource\Pages;
use App\Filament\Resources\WeekdayResource\RelationManagers;
use App\Models\Weekday;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WeekdayResource extends Resource
{
    protected static ?string $model = Weekday::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationGroup = 'Prices';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('hour')
                    ->numeric()
                    ->suffix('hr')
                    ->required(),
                TextInput::make('price')
                    ->numeric()
                    ->suffix('ks')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('hour')
                    ->suffix(' hr'),
                TextColumn::make('price')
                    ->suffix(' ks')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
                    })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWeekdays::route('/'),
            'create' => Pages\CreateWeekday::route('/create'),
            'edit' => Pages\EditWeekday::route('/{record}/edit'),
        ];
    }
}
