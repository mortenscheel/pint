<?php

namespace App\Providers;

use App\Contracts\PathsRepository;
use App\Project;
use App\Repositories\ConfigurationJsonRepository;
use App\Repositories\GitPathsRepository;
use App\Repositories\NativeConfigurationRepository;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Input\InputInterface;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ConfigurationJsonRepository::class, function () {
            $input = resolve(InputInterface::class);

            return new ConfigurationJsonRepository(
                $input->getOption('config') ?: Project::path().'/pint.json',
                $input->getOption('preset'),
            );
        });

        $this->app->singleton(PathsRepository::class, function () {
            return new GitPathsRepository(
                Project::path(),
            );
        });

        $this->app->singleton(NativeConfigurationRepository::class, function () {
            $input = resolve(InputInterface::class);

            return new NativeConfigurationRepository($input->getOption('config') ?: Project::path().'/.php-cs-fixer.dist.php');
        });
    }
}
