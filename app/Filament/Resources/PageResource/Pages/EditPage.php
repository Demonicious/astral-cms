<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getActions(): array
    {
        $resource = static::getResource();

        return array_merge(
            [
                ButtonAction::make('edit')->color('primary')->icon('heroicon-o-pencil')->url(route('page-builder-edit', [ 'page' => $this->record ]))
            ],
            (($resource::hasPage('view') && $resource::canView($this->record)) ? [$this->getViewAction()] : []),
            ($resource::canDelete($this->record) ? [$this->getDeleteAction()] : []),
        );
    }
}
