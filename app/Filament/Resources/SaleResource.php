<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Models\Sale;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->disabled()
                    ->numeric(),

                Forms\Components\TextInput::make('ip')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('product')
                    ->numeric()
                    ->required(),

                Forms\Components\Textarea::make('user_agent')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Select::make('is_bot')
                    ->options([
                        0 => 'Not bot',
                        1 => 'Bot',
                    ])
                    ->required(),

                Forms\Components\DateTimePicker::make('created_at')
                    ->disabled(),

                Forms\Components\DateTimePicker::make('updated_at')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),

                Tables\Columns\TextColumn::make('ip')
                    ->searchable(),

                Tables\Columns\TextColumn::make('product')
                    ->sortable(),

                Tables\Columns\TextColumn::make('is_bot')
                    ->formatStateUsing(fn ($state): string => $state ? 'Bot' : 'Not bot')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user_agent')
                    ->limit(50),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
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
            'index'  => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit'   => Pages\EditSale::route('/{record}/edit'),
        ];
    }
}
