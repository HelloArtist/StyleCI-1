<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Cachet HQ <support@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Commands;

use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Queue\SerializesModels;
use StyleCI\StyleCI\Events\AnalysisWasQueuedEvent;
use StyleCI\StyleCI\Models\Commit;

/**
 * This is the analyse commit command.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class AnalyseCommitCommand implements ShouldBeQueued
{
    use SerializesModels;

    /**
     * The commit to analyse.
     *
     * @var \StyleCI\StyleCI\Models\Commit
     */
    public $commit;

    /**
     * Create a new analyse commit command instance.
     *
     * @param \StyleCI\StyleCI\Models\Commit $commit
     *
     * @return void
     */
    public function __construct(Commit $commit)
    {
        $this->commit = $commit;

        event(new AnalysisWasQueuedEvent($commit));
    }
}
