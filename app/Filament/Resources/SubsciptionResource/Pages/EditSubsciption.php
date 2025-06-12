<?php

namespace App\Filament\Resources\SubsciptionResource\Pages;

use App\Filament\Resources\SubsciptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubsciption extends EditRecord
{
    protected static string $resource = SubsciptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
