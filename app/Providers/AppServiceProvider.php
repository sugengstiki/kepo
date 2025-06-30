<?php

namespace App\Providers;

use Filament\Facades\Filament;
// use Filament\Forms\Components\View;
use Filament\Support\Facades\FilamentView;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Model::unguard();

        FilamentView::registerRenderHook(
            'panels::auth.login.form.after',
            fn(): View => view('filament.login_extra')
        );

        // Filament::serving(function () {
        //     Filament::registerNavigationGroups([
        //         'Master Data',
        //         'Mahasiswa',
        //         'Validasi',
        //         'Laporan',
        //     ]);
        // });
    }
}
