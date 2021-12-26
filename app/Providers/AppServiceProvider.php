<?php

namespace App\Providers;

use App\Components\DataTable;
use App\Components\DatatableOptions;
use App\Components\IDataTable;
use App\Contracts\IFormProcessor;
use App\Contracts\IFormRequest;
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
            return new DataTable(
                new DatatableOptions($app->request->get('options', []))
            );
        });

        $this->app->bind(IFormProcessor::class, function ($app) {
            // 如果不是使用request方式進入網頁，則回傳空的FormApiProcessor
//                if (is_null(request()->route())) {
//                    return $app->make('App\Processor\FormApiProcessor');
//                }

            $action = request()->route()->getAction();
            $namespace = $action['namespace'] . '\\';

            $apiVersion = strtoupper(explode('/', $action['prefix'])[1]);

            /**
             * 0 => "Modules"
             * 1 => "BASE"
             * 2 => "A01"
             * 3 => "Http"
             * 4 => "Controllers"
             * 5 => "Web"
             * 6 => "A01110Controller@index"
             */
            $controller = explode('\\', $action['controller']);
            $MenuName = explode('Controller', $controller[4]);

//          $ProcessorName = "Modules\\$schoolNo\Http\Processor\Api\\$controller[5]\\$MenuName[0]Processor";
            $ProcessorName = "App\Http\Processors\\{$controller[3]}\\{$MenuName[0]}Processor";

//             dd($ProcessorName);
//             dd(class_exists($ProcessorName));
            if (class_exists($ProcessorName)) {
                $instance = $app->make($ProcessorName);
                // $instance->bootService();
                return $instance;
            } else {
                throw new \Exception('須先建立對應的Processor!');
            }

            // todo not exists
        });

        $this->app->bind(IFormRequest::class, function ($app) {
            // 如果不是使用request方式進入網頁，則回傳空的FormRequestService
            if (is_null(request()->route())) {
            }

            $action    = request()->route()->getAction();
            $namespace = $action['namespace'] . '\\';

            /**
             * 0 => "Modules"
             * 1 => "BASE"
             * 2 => "Http"
             * 3 => "Controllers"
             * 4 => "Api"
             * 5 => "A01"
             * 6 => "A01110Controller@store"
             */
            $controller = explode('\\', $action['controller']);
//             dd($controller);
            $MenuName        = explode('Controller', $controller[4]);
//            $FormRequestName = "Modules\\$schoolNo\Http\Requests\\$controller[5]\\$MenuName[0]Request";
            $FormRequestName = "App\Http\Requests\\{$controller[3]}\\{$MenuName[0]}Request";
//            dd($FormRequestName);
//             dd(class_exists($FormRequestName));
            if (class_exists($FormRequestName)) {
                return $app->make($FormRequestName);
            }
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
