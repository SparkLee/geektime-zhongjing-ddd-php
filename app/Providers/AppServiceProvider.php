<?php

namespace App\Providers;

use App\Domain\OrgMng\Org\Org;
use App\Domain\OrgMng\Org\OrgRepository;
use App\Domain\TenantMng\Tenant;
use App\Domain\TenantMng\TenantRepository;
use App\Persistence\OrgMng\OrgRepositoryDoctrine;
use App\Persistence\TenantMng\TenantRepositoryDoctrine;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(OrgRepository::class, function ($app) {
            return new OrgRepositoryDoctrine($app['em'], $app['em']->getClassMetaData(Org::class));
        });
        $this->app->bind(TenantRepository::class, function ($app) {
            return new TenantRepositoryDoctrine($app['em'], $app['em']->getClassMetaData(Tenant::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
