<?php

namespace App\Providers;

use App\Http\Interfaces\ContractInterface;
use App\Http\Repositories\ContractRepository;
use Illuminate\Support\ServiceProvider;

class ContractServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ContractInterface::class,
            ContractRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
