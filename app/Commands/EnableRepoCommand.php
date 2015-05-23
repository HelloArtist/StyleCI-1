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

namespace StyleCI\StyleCI\Commands;

use StyleCI\StyleCI\Models\User;

/**
 * This is the enable repo command class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class EnableRepoCommand
{
    /**
     * The repository id.
     *
     * @var int
     */
    protected $id;

    /**
     * The repository name.
     *
     * @var string
     */
    protected $name;

    /**
     * The associated user.
     *
     * @var \StyleCI\StyleCI\Models\User
     */
    protected $user;

    /**
     * Create a new enable repo command instance.
     *
     * @param int                          $id
     * @param string                       $name
     * @param \StyleCI\StyleCI\Models\User $user
     *
     * @return void
     */
    public function __construct($id, $name, User $user)
    {
        $this->id = $id;
        $this->name = $name;
        $this->user = $user;
    }

    /**
     * Get the repository id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the repository name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the associated user.
     *
     * @return \StyleCI\StyleCI\Models\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
