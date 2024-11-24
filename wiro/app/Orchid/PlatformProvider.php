<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;
use App\Models\Borrowers;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        return [
            Menu::make('Get Started')
                ->icon('bs.book')
                ->title('Loan Management')
                ->route(config('platform.index')),

            Menu::make(__('Borrowers'))
                ->icon('bs.people')
                ->route('platform.borrowers'),

            Menu::make(__('Loan Plans'))
                ->icon('bs.card-list')
                ->route('platform.loan.plans'),

            Menu::make(__('Loan Types'))
                ->icon('bs.card-list')
                ->route('platform.loan.types'),

            Menu::make(__('Loans'))
                ->icon('bs.card-list')
                ->route('platform.loans'),

            Menu::make(__('Payments'))
                ->icon('bs.card-list')
                ->route('platform.payments'),

            Menu::make(__('Users'))
                ->icon('bs.people')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access Controls')),

            Menu::make(__('Roles'))
                ->icon('bs.shield')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles')
                ->divider(),

        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }

    //Register the search functionality
    /**
     * @return Searchable|string[]
     */
    public function registerSearchModels(): array
    {
        return [
            Borrowers::class,
        ];
    }
}
