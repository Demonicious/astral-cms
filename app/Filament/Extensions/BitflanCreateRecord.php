<?php

namespace App\Filament\Extensions;

use App\Bitflan;
use Filament\Resources\Pages\CreateRecord;

class BitflanCreateRecord extends CreateRecord
{
    public function create(bool $another = false): void
    {
        if( ! Bitflan::DEMO_MODE )
            parent::create($another);
        else
            $this->notify('success', 'This feature is disabled in Demo Mode.');
    }

    public function createAndCreateAnother(): void
    {
        if( ! Bitflan::DEMO_MODE )
            parent::createAndCreateAnother();
        else
            $this->notify('success', 'This feature is disabled in Demo Mode.');
    }
}
