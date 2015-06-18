<?php  namespace App\Providers;

use Kivi\Services\Response\Jsend;
use Response;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\ResponseFactory;

class ResponseMacroServiceProvider extends ServiceProvider {

    public function boot(ResponseFactory $factory)
    {
        $factory->macro('jsend', function(Jsend $jsend) use ($factory) {
            return $factory->make($jsend->content(), $jsend->statusCode())
                        ->header('Content-Type', 'application/json');
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // TODO: Implement register() method.
    }
}