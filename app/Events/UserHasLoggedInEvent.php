<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Graham Campbell <graham@cachethq.io>
 * (c) Joseph Cohen <joseph.cohen@dinkbit.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Events;

use Illuminate\Queue\SerializesModels;
use StyleCI\StyleCI\Models\User;

/**
 * This is the user has logged in event class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class UserHasLoggedInEvent
{
    use SerializesModels;

    /**
     * The user that has logged in.
     *
     * @var \StyleCI\StyleCI\Models\User
     */
    protected $user;

    /**
     * Create a new user has logged in event instance.
     *
     * @param \StyleCI\StyleCI\Models\User $user
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the user that has logged in.
     *
     * @return \StyleCI\StyleCI\Models\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
