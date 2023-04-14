<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Iotronlab\FilamentMultiGuard\ContextServiceProvider;

class ContractorPanelServiceProvider extends ContextServiceProvider
{
    public static string $name = 'contractor-panel';

    // protected function componentRoutes(): callable
    // {
    //     return function () {
    //         Route::name('pages.')->group(function (): void {
    //             foreach (Filament::getPages() as $page) {
    //                 Route::group([], $page::getRoutes());
    //             }
    //         });

    //         Route::name('resources.')->group(function (): void {
    //             foreach (Filament::getResources() as $resource) {
    //                 Route::group([], $resource::getRoutes());
    //             }
    //         });
    //     };
    // }
}
