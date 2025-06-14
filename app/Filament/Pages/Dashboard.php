<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\UserWidget;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\GlobalSearch\Actions\Action;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;

    
    protected function getHeaderWidgets(): array
    {
        return [
            UserWidget::class,
        ];
    }
    public function filtersForm(Form $form): Form
    {
        return $form->schema([
            Section::make('')->schema([
            TextInput::make('name'),
            DatePicker::make('start_date'),
            DatePicker::make('end_date'),
            ])->columns(3),
            
        ]);
    }
}