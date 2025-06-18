<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Category;
use App\Models\Service;
use App\Models\ServiceProvider;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('provider_id')
                    ->label('Service Provider')
                    ->relationship('serviceProvider', 'type')
                    ->required(),
                    Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable(),

                    TextInput::make('title')->required(),
                    TextInput::make('description')->required(),
                    TextInput::make('price')->numeric()->required(),
                    FileUpload::make('image')->image()->directory('uploads'),



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('provider.type')->label('Service Provider'),
                TextColumn::make('category.name')->label('Category'),
                TextColumn::make('title')->label('Title')->searchable()->sortable(),
                TextColumn::make('description')->label('Description'),
                TextColumn::make('price')->label('Price')->sortable()->money('USD'),
                ImageColumn::make('image')->label('Image')->disk('public')->circular(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
