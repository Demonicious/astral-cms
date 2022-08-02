<?php

namespace App\Filament\Widgets;

use App\Models\Page;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getCards(): array {
        return [
            // Card::make('Pages', Page::count())->description('Amount of Pages'),
            Card::make('Users', User::count())->description('Amount of Unique Users'),
        ];
    }
}
