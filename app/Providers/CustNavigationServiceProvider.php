<?php

namespace App\Providers;

use App\Filament\Pages\Profile;
use App\Filament\Resources\ProjectsResource;
use App\Filament\Resources\RunResource;
use App\Filament\Resources\UserResource;
use BezhanSalleh\FilamentShield\Resources\RoleResource;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\UserMenuItem;
use Filament\Pages\Dashboard;
use Illuminate\Support\ServiceProvider;
use ShuvroRoy\FilamentSpatieLaravelBackup\Pages\Backups;
use ShuvroRoy\FilamentSpatieLaravelHealth\Pages\HealthCheckResults;

class CustNavigationServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        Filament::serving(function () {
            Filament::registerUserMenuItems([
                UserMenuItem::make()
                    ->label('My Account')
                    ->icon('heroicon-o-user-circle')
                    ->url(\RyanChandler\FilamentProfile\Pages\Profile::getUrl()),
            ]);
        });

        Filament::navigation(function (NavigationBuilder $builder): NavigationBuilder {
            return $builder->items([
                ...Dashboard::getNavigationItems(),
                ...ProjectsResource::getNavigationItems(),
                ...RunResource::getNavigationItems(),
            ])->groups([
                NavigationGroup::make('Settings & Configuration')
                    ->items([
                        ...UserResource::getNavigationItems(),
                        ...Backups::getNavigationItems(),
                        ...HealthCheckResults::getNavigationItems(),
                    ]),
                NavigationGroup::make('Roles & Permissions')
                    ->items([
                        ...RoleResource::getNavigationItems(),
                    ]),
            ]);
        });

    }
}
