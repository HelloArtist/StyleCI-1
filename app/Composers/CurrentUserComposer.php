<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Cachet HQ <support@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Composers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\View\View;
use McCool\LaravelAutoPresenter\PresenterDecorator;

/**
 * This is the current user composer class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class CurrentUserComposer
{
    /**
     * The authentication guard instance.
     *
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * The presenter instance.
     *
     * @var \McCool\LaravelAutoPresenter\PresenterDecorator
     */
    protected $presenter;

    /**
     * Create a new current user composer instance.
     *
     * @param \Illuminate\Contracts\Auth\Guard                $auth
     * @param \McCool\LaravelAutoPresenter\PresenterDecorator $presenter
     *
     * @return void
     */
    public function __construct(Guard $auth, PresenterDecorator $presenter)
    {
        $this->auth = $auth;
        $this->presenter = $presenter;
    }

    /**
     * Bind data to the view.
     *
     * @param \Illuminate\Contracts\View\View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('currentUser', $this->presenter->decorate($this->auth->user()));
    }
}
