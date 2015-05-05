<?php  namespace Kivi\Repositories;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Binding the CategoryRepository
        $this->app->bind(
            'Kivi\Repositories\CategoryRepository',
            'Kivi\Repositories\EloquentCategoryRepository'
        );
    }
}