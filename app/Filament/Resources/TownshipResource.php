<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TownshipResource\Pages;
use App\Filament\Resources\TownshipResource\RelationManagers;
use App\Models\Township;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TownshipResource extends Resource
{
    protected static ?string $model = Township::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationGroup = 'Locations';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('region_id')
                    ->relationship('region','name')
                    ->required(),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('region.name'),
                TextColumn::make('name')
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
            'index' => Pages\ListTownships::route('/'),
            'create' => Pages\CreateTownship::route('/create'),
            'edit' => Pages\EditTownship::route('/{record}/edit'),
        ];
    }
}
