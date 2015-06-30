<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Commands;

/**
 * This is the analyse commit command.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalyseCommitCommand
{
    /**
     * The repo to analyse.
     *
     * @var int
     */
    public $repo;

    /**
     * The branch to analyse.
     *
     * @var string
     */
    public $branch;

    /**
     * The commit to analyse.
     *
     * @var string
     */
    public $commit;

    /**
     * The commit message.
     *
     * @var string
     */
    public $message;

    /**
     * Create a new analyse commit command instance.
     *
     * @param int    $repo
     * @param string $branch
     * @param string $commit
     * @param string $message
     *
     * @return void
     */
    public function __construct($repo, $branch, $commit, $message)
    {
        $this->repo = $repo;
        $this->branch = $branch;
        $this->commit = $commit;
        $this->message = $message;
    }
}
