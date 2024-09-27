<?php
namespace App\Domain\Farm\Providers;

use App\Domain\Farm\Services\Statistic;
use Illuminate\Support\ServiceProvider;

class StatisticServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Statistic::class, Statistic::class);
        parent::register();
    }
}
