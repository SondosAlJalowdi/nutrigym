<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('email')->email()->required(),
                TextInput::make('password')->password(),
                TextInput::make('phone')->tel()->placeholder('07xxxxxxxx'),
                FileUpload::make('image')->image()->directory('uploads'),
                TextInput::make('age'),
                Select::make('gender')->options([
                    'male'=>'Male',
                    'female'=>'Female',
            ]),
                TextInput::make('height'),
                TextInput::make('weight'),
                Select::make('location')->options([
                    'city1' => 'Irbid',
                    'city2' => 'Ajloun',
                    'city3' => 'Jerash',
                    'city4' => 'Mafraq',
                    'city5' => 'Balqa',
                    'city6' => 'Amman',
                    'city7' => 'Zarqa',
                    'city8' => 'Madaba',
                    'city9' => 'Karak',
                    'city10' => 'Tafilah',
                    'city11' => 'Ma\an',
                    'city12' => 'Aqaba',
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable()->sortable(),
                TextColumn::make('phone')->searchable(),
                ImageColumn::make('image')->disk('public')->disk('public'),
                TextColumn::make('age')->sortable(),
            ])
            ->filters([
                Filter::make('city')
                    ->form([
                        Select::make('location')
                            ->options([
                                'city1' => 'Irbid',
                                'city2' => 'Ajloun',
                                'city3' => 'Jerash',
                                'city4' => 'Mafraq',
                                'city5' => 'Balqa',
                                'city6' => 'Amman',
                                'city7' => 'Zarqa',
                                'city8' => 'Madaba',
                                'city9' => 'Karak',
                                'city10' => 'Tafilah',
                                'city11' => 'Ma\an',
                                'city12' => 'Aqaba',
                            ])
                            ->label('City')
                            ->searchable(),
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
