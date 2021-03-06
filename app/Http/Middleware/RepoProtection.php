<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use StyleCI\StyleCI\GitHub\Repos;
use StyleCI\StyleCI\Models\Repo;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * This is the repo protection middleware class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RepoProtection
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($repo = $request->route('repo')) {
            $this->protect($repo, $request->isMethodSafe());
        } elseif ($analysis = $request->route('analysis')) {
            $this->protect($analysis->repo, $request->isMethodSafe());
        }

        return $next($request);
    }

    /**
     * Apply the necessary protected to the given repo.
     *
     * @param \StyleCI\StyleCI\Models\Repo $repo
     * @param bool                         $read
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return mixed
     */
    protected function protect(Repo $repo, $read)
    {
        // if the operation is read only, no checks needed
        if ($read) {
            return;
        }

        if (Auth::guest()) {
            throw new HttpException(401);
        }

        if (!array_get(app(Repos::class)->get(Auth::user()), $repo->id)) {
            throw new HttpException(403);
        }
    }
}
