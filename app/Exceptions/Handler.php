<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Cachet HQ <support@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Exceptions;

use GrahamCampbell\Exceptions\ExceptionHandler;

/**
 * This is the exception hander class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        'Symfony\Component\HttpKernel\Exception\NotFoundHttpException',
    ];
}
