<?php

namespace App\Filament\Extensions;

use App\Bitflan;
use Filament\Resources\Pages\EditRecord;

class BitflanEditRecord extends EditRecord
{
    public function save(bool $shouldRedirect = true): void
    {
        if( ! Bitflan::DEMO_MODE ) {
            parent::save($shouldRedirect);
        } else
            $this->notify('success', 'This feature is disabled in Demo Mode.');
    }

    public function delete(): void
    {
        if( ! Bitflan::DEMO_MODE ) {
            parent::delete();
        } else
            $this->notify('success', 'This feature is disabled in Demo Mode.');
    }
}
