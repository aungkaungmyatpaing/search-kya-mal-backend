<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FieldResource\Pages;
use App\Filament\Resources\FieldResource\RelationManagers;
use App\Models\Field;
use App\Models\Region;
use App\Models\Township;
use App\Models\Type;
use App\Models\Weekday;
use App\Models\Weekend;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FieldResource extends Resource
{
    protected static ?string $model = Field::class;

    protected static ?string $navigationIcon = 'heroicon-o-lifebuoy';

    protected static ?string $navigationGroup = 'Fields';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('weekday_id')
                    ->relationship('weekday', 'hour')
                    ->getOptionLabelFromRecordUsing(fn (Weekday $record): string => "{$record->hour}hr - {$record->price}ks")
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('weekend_id')
                    ->relationship('weekend', 'hour')
                    ->getOptionLabelFromRecordUsing(fn (Weekend $record): string => "{$record->hour}hr - {$record->price}ks")
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('region_id')
                    ->label('Region')
                    ->options(Region::all()->pluck('name', 'id')->toArray())
                    ->reactive()
                    ->required()
                    ->afterStateUpdated(fn (callable $set) => $set('township_id', null)),
                Select::make('township_id')
                    ->label('Township')
                    ->options(function (callable $get) {
                        $regionId = $get('region_id');
                        if ($regionId) {
                            return Township::where('region_id', $regionId)->pluck('name', 'id')->toArray();
                        }
                        return [];
                    })
                    ->required(),
                Select::make('type_id')
                    ->relationship('type', 'stadium')
                    ->getOptionLabelFromRecordUsing(fn (Type $record): string => "{$record->stadium} | {$record->field}")
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('field_size')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('40m x 20m'),
                TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('facilities')
                    ->required(),
                Textarea::make('description')
                    ->nullable()
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('Images')
                    ->collection('field-img')
                    ->multiple()
                    ->reorderable()
                    ->conversion('thumb')
                    ->nullable()
                    ->columnSpanFull(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Location & Contact')
                    ->schema([
                        TextEntry::make('region.name')->label('Region'),
                        TextEntry::make('township.name')->label('Township'),
                        TextEntry::make('phone')->label('Phone NO')->color('success'),
                ])->columns(3),
                Section::make('Field Info')
                    ->schema([
                        TextEntry::make('type_id')
                            ->label('Type')
                            ->formatStateUsing(function ($state, $record) {
                                return $record->type ? "{$record->type->stadium} | {$record->type->field}" : '';
                            })
                            ->badge(),
                        TextEntry::make('weekday_id')
                            ->label('Weekday Time & Price')
                            ->formatStateUsing(function ($state, $record) {
                                return $record->weekday ? "{$record->weekday->hour}hr - {$record->weekday->price}ks" : '';
                            })
                            ->badge(),
                        TextEntry::make('weekend_id')
                            ->label('Weekend Time & Price')
                            ->formatStateUsing(function ($state, $record) {
                                return $record->weekend ? "{$record->weekend->hour}hr - {$record->weekend->price}ks" : '';
                            })
                            ->badge(),
                        TextEntry::make('field_size'),
                ])->columns(4),
                Section::make('Facilities & Description')
                    ->schema([
                        TextEntry::make('facilities'),
                        TextEntry::make('description'),
                ])->columns(1),
                Section::make('Images')
                    ->schema([
                        SpatieMediaLibraryImageEntry::make('slip')
                            ->collection('field-img')
                            ->width('100%')
                            ->height('auto')
                ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // SpatieMediaLibraryImageColumn::make('Image')
                //     ->collection('field-img')
                //     ->defaultImageUrl(asset('assets/images/default.png'))
                //     ->conversion('thumb'),
                TextColumn::make('region.name'),
                TextColumn::make('township.name'),
                TextColumn::make('field_size'),
                TextColumn::make('phone')
                    ->color('success'),
                TextColumn::make('type_id')
                    ->label('Type')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->type ? "{$record->type->stadium} | {$record->type->field}" : '';
                    })
                    ->badge()
                    ->alignCenter(),
                TextColumn::make('weekday_id')
                    ->label('Weekday Time & Price')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->weekday ? "{$record->weekday->hour}hr | {$record->weekday->price}ks" : '';
                    })
                    ->badge()
                    ->alignCenter(),
                TextColumn::make('weekend_id')
                    ->label('Weekend Time & Price')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->weekend ? "{$record->weekend->hour}hr | {$record->weekend->price}ks" : '';
                    })
                    ->badge()
                    ->alignCenter(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListFields::route('/'),
            'create' => Pages\CreateField::route('/create'),
            'edit' => Pages\EditField::route('/{record}/edit'),
            'view' => Pages\ViewField::route('/{record}'),
        ];
    }
}
