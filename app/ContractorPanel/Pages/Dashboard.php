<?php

namespace App\ContractorPanel\Pages;

use Filament\Pages\Dashboard as PagesDashboard;
use Iotronlab\FilamentMultiGuard\Concerns\ContextualPage;
use Filament\Pages\Page;

class Dashboard extends PagesDashboard
{
    use ContextualPage;
}
