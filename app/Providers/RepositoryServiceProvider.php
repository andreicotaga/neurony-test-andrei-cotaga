<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/20/2019
 * Time: 12:53 AM
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Contracts\SearchableContract',
            'App\Repositories\ElasticSearchPostSearchRepository');
    }
}