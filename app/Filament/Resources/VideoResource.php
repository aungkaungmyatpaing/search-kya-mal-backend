<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoResource\Pages;
use App\Filament\Resources\VideoResource\RelationManagers;
use App\Models\Video;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Group as FormGroup;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-play-circle';

    protected static ?string $navigationGroup = 'Videos';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FormGroup::make()->schema([
                    Toggle::make('new')
                    ->onColor('success')
                    ->offColor('danger'),
                ]),
                FormGroup::make()->schema([
                    Select::make('category_id')
                        ->relationship('category','name')
                        ->preload()
                        ->required()
                        ->searchable(),
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('youtube_link')
                        ->required()
                        ->helperText(new HtmlString('Youtube url must be the same like this <strong>https://www.youtube.com/watch?v=dXfBkY2XM_Y</strong>'))
                        ->hint('https://www.youtube.com/watch?v=*****')
                        ->columnSpanFull(),
                    SpatieMediaLibraryFileUpload::make('Thumbnail')
                        ->collection('video-thumbnail')
                        ->nullable()
                        ->columnSpanFull()
                ])->columns(2),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('Thumbnail')
                    ->collection('video-thumbnail')
                    ->defaultImageUrl(asset('assets/images/default.png'))
                    ->conversion('thumb'),
                TextColumn::make('category.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('youtube_link'),
                ToggleColumn::make('new')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideo::route('/create'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
        ];
    }
}
