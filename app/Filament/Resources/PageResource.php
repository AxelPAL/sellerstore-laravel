<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Page;
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

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            FormComponents\TextInput::make('title')
                ->required()
                ->maxLength(255),
            FormComponents\TextInput::make('slug')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),
            FormComponents\TextInput::make('author_id')
                ->numeric()
                ->required()
                ->default(fn () => auth()->id()),
            FormComponents\Textarea::make('excerpt')
                ->columnSpanFull(),
            FormComponents\RichEditor::make('body')
                ->columnSpanFull(),
            FormComponents\TextInput::make('image')
                ->maxLength(255),
            FormComponents\Textarea::make('meta_description')
                ->columnSpanFull(),
            FormComponents\Textarea::make('meta_keywords')
                ->columnSpanFull(),
            FormComponents\Select::make('status')
                ->options([
                    'ACTIVE'   => 'Active',
                    'INACTIVE' => 'Inactive',
                    'PENDING'  => 'Pending',
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->searchable(),
                Tables\Columns\TextColumn::make('status')->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->filters([
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit'   => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
