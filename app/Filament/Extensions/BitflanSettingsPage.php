<?php

namespace App\Filament\Extensions;

use App\Bitflan;
use Filament\Pages\SettingsPage;

class BitflanSettingsPage extends SettingsPage {
    public function save(): void
    {
        if( ! Bitflan::DEMO_MODE ) {
            parent::save();
        } else 
            $this->notify('success', 'This feature is disabled in Demo Mode.');
    }
}