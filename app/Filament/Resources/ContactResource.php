<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    protected static ?string $navigationGroup = 'Accounts';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('phone_1')
                    ->tel()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->rule(function () {
                        return function ($attribute, $value, $fail) {
                            if ((str_starts_with($value, '095') || str_starts_with($value, '093')) && strlen($value) !== 9) {
                                $fail($attribute . ' must be 9 characters long if it starts with "095" or "093".');
                            } elseif (!str_starts_with($value, '095')  && !str_starts_with($value, '093') && strlen($value) !== 11) {
                                $fail($attribute . ' must be 11 characters long if it does not start with "095" or "093".');
                            }
                        };
                    }),
                    TextInput::make('phone_2')
                        ->tel()
                        ->nullable()
                        ->unique(ignoreRecord: true)
                        ->rule(function () {
                            return function ($attribute, $value, $fail) {
                                if ((str_starts_with($value, '095') || str_starts_with($value, '093')) && strlen($value) !== 9) {
                                    $fail($attribute . ' must be 9 characters long if it starts with "095" or "093".');
                                } elseif (!str_starts_with($value, '095')  && !str_starts_with($value, '093') && strlen($value) !== 11) {
                                    $fail($attribute . ' must be 11 characters long if it does not start with "095" or "093".');
                                }
                            };
                        }),
                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255),
                    TextInput::make('address')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('facebook_link')
                        ->nullable()
                        ->columnSpanFull(),
                    TextInput::make('messenger_link')
                        ->nullable()
                        ->columnSpanFull(),
                    TextInput::make('viber_link')
                        ->nullable()
                        ->columnSpanFull()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('phone_1')
                    ->label('Phone 1'),
                TextColumn::make('phone_2')
                    ->label('Phone 2'),
                TextColumn::make('email'),
                TextColumn::make('address'),
                TextColumn::make('facebook_link'),
                TextColumn::make('messenger_link'),
                TextColumn::make('viber_link')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        $count = Contact::count();
        if ($count >= 1) {
            return false;
        }
       return true;
    }
}
