<?php

namespace App\Providers;

use App\Domain\OrgMng\Org\Org;
use App\Domain\OrgMng\Org\OrgRepository;
use App\Persistence\OrgMng\OrgRepositoryDoctrine;
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
        $this->app->bind(OrgRepository::class, function ($app) {
            return new OrgRepositoryDoctrine($app['em'], $app['em']->getClassMetaData(Org::class));
        });
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
