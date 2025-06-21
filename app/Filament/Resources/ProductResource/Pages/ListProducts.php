<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Filament\Widgets\LatestProducts;
use App\Models\Product;
use App\Models\Subscription;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Widgets\Widget;

class ListProducts extends ListRecords
{
    
    protected static string $resource = ProductResource::class;
    protected int | string | array $columnSpan = 4;
    protected static ?string $title = 'Products';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            LatestProducts::class,
        ];
    }
}
