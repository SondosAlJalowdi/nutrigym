<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubsciptionResource\Pages;
use App\Filament\Resources\SubsciptionResource\RelationManagers;
use App\Models\Subscription;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\DatePicker;

class SubsciptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->required(),

                Select::make('service_id')
                    ->label('Service')
                    ->relationship('serviceProvider', 'type')
                    ->required(),

                ToggleButtons::make('status')
                    ->options([
                        'active' => 'Active',
                        'pending' => 'Pending',
                        'expired' => 'Expired',
                    ])
                    ->colors([
                        'active' => 'success',
                        'pending' => 'warning',
                        'expired' => 'danger',
                    ])
                    ->default('active')
                    ->required(),

                DatePicker::make('start_date')
                    ->label('Start Date')
                    ->minDate(now()),

                DatePicker::make('end_date')
                    ->label('End Date')
                    ->minDate(now()),
                    

                Textarea::make('details')
                    ->label('Details'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('serviceProvider.type')
                    ->label('Service Provider')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('End Date')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('details')
                    ->label('Details'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSubsciptions::route('/'),
            'create' => Pages\CreateSubsciption::route('/create'),
            'edit' => Pages\EditSubsciption::route('/{record}/edit'),
        ];
    }
}
