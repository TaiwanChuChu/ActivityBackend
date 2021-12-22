<?php

namespace App\Providers;

use App\Components\DataTable;
use App\Components\IDataTable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(IDataTable::class, function ($app) {
            return new DataTable();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//         \DB::listen(function($query) {
////             return response()->json(['query' => $query], 200);
//             Log::channel('system.debug')->debug('SQL: ' . $query->sql);
//             Log::channel('system.debug')->debug('Bindings: ' . json_encode($query->bindings));
//             Log::channel('system.debug')->debug('-----------------------------------------------');
//         });
    }
}
