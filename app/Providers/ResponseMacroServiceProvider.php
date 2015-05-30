<?php  namespace App\Providers;

use Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider{

    public function boot()
    {
        Response::macro('jsend', function($status, $data = null, $message = null, $code = null) {
            switch($status) {
                case 'success':
                case 'fail':
                    $content = [
                        'status' => $status,
                        'data'   => $data
                    ];
                    break;
                default:
                    $content = [
                        'status' => 'error',
                        'message' => $message
                    ];
                    if($data !== null) {
                        $content['data'] = $data;
                    }
                    if($code !== null) {
                        $content['code'] = $code;
                    }
                    break;
            }
            $response = Response::make($content);
            $response->header('Content-Type', 'application/json');
            return $response;
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