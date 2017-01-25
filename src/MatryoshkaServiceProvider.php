<?php

namespace Dakine\Matryoshka;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class MatryoshkaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Blade::directive('cache', function($expression) {

            Log::debug('Expression: '.$expression);

            return "<?php if (! app('Dakine\Matryoshka\BladeDirective')->setUp({$expression})) { ?>";
        });

        Blade::directive('endcache', function () {
            return "<?php } echo app('Dakine\Matryoshka\BladeDirective')->tearDown() ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(BladeDirective::class, function() {

            return new BladeDirective(
                new RussianCaching(app('cache.store'))
            );
        });
    }
}
