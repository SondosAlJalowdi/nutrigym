<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use App\Models\ServiceProvider;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Product Name')->required(),
                TextInput::make('description')->label('Description')->nullable(),
                TextInput::make('price')->label('Price')->required()->numeric()->minValue(0),
                TextInput::make('stock')->label('Stock')->required()->numeric()->minValue(0),
                FileUpload::make('image')
                    ->label('Product Image')
                    ->image()
                    ->directory('uploads'),
                    Select::make('provider_id')
                    ->label('Service Provider')
                    ->relationship('serviceProvider', 'type'),
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('provider.type')->label('Service Provider'),
                TextColumn::make('name')->label('Product Name')->searchable()->sortable(),
                TextColumn::make('description')->label('Description'),
                TextColumn::make('price')->label('Price')->money('USD'),
                TextColumn::make('stock')->label('Stock'),
                ImageColumn::make('image')->label('Product Image')->disk('public'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
