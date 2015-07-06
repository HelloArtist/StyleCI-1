<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Providers;

use Illuminate\Support\ServiceProvider;
use StyleCI\StyleCI\Repositories\RepoRepository;
use StyleCI\StyleCI\Repositories\UserRepository;

/**
 * This is the repository service provider class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepoRepository();
        $this->registerUserRepository();
    }

    /**
     * Register the repo repository.
     *
     * @return void
     */
    protected function registerRepoRepository()
    {
        $this->app->singleton('styleci.reporepository', function ($app) {
            $repos = $app['styleci.repos'];

            return new RepoRepository($repos);
        });

        $this->app->alias('styleci.reporepository', RepoRepository::class);
    }

    /**
     * Register the user repository.
     *
     * @return void
     */
    protected function registerUserRepository()
    {
        $this->app->singleton('styleci.userrepository', function ($app) {
            $collaborators = $app['styleci.collaborators'];

            return new UserRepository($collaborators);
        });

        $this->app->alias('styleci.userrepository', UserRepository::class);
    }
}
