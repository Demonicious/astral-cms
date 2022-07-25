<?php

namespace App\Filament\Resources;

use App\Filament\Extensions\Reorderable;
use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Models\Page;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\ButtonAction;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationGroup = 'Content';
    protected static ?string $navigationIcon  = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        $form = $form->schema([
            Forms\Components\Grid::make()->schema([
                Forms\Components\TextInput::make('name')->helperText('Not Displayed to the User.')->required()->columnSpan(2),
                Forms\Components\TextInput::make('title')->helperText('Displayed as the Browser Title')->required()->columnSpan(1),
                Forms\Components\TextInput::make('route')->helperText('Path to Access this Page.')->required()->unique('pages', 'route')->columnSpan(1),
                Forms\Components\Select::make('layout')->options([
                    'default' => 'Default'
                ])->default('default')->columnSpan(2)->disabled()
            ])
        ]);

        return $form;
    }

    public static function table(Table $table): Table
    {
        $table = $table->columns([
            Tables\Columns\TextColumn::make('title')->searchable(),
            Tables\Columns\TextColumn::make('route')->searchable(),
        ]);

        $table->actions([
            ButtonAction::make('Page Builder')->icon('heroicon-o-pencil')->color('primary')->url(fn(Page $record): string => route('page-builder-edit', [ 'page' => $record ]), true),
            ...$table->getActions()
        ]);

        return $table;
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit')
        ];
    }
}
