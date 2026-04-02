<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Models\Sale;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components as FormComponents;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            FormComponents\TextInput::make('id')
                ->disabled()
                ->numeric(),

            FormComponents\TextInput::make('ip')
                ->required()
                ->maxLength(255),

            FormComponents\TextInput::make('product')
                ->numeric()
                ->required(),

            FormComponents\Textarea::make('user_agent')
                ->required()
                ->columnSpanFull(),

            FormComponents\Select::make('is_bot')
                ->options([
                    0 => 'Not bot',
                    1 => 'Bot',
                ])
                ->required(),

            FormComponents\DateTimePicker::make('created_at')
                ->disabled(),

            FormComponents\DateTimePicker::make('updated_at')
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
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
