<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Cachet HQ <support@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Events;

use Illuminate\Queue\SerializesModels;
use StyleCI\StyleCI\Models\Commit;

/**
 * This is the analysis was queued event class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class AnalysisWasQueuedEvent
{
    use SerializesModels;

    /**
     * The commit that will be analysed.
     *
     * @var \StyleCI\StyleCI\Models\Commit
     */
    protected $commit;

    /**
     * Create a new analysis was queued event instance.
     *
     * @param \StyleCI\StyleCI\Models\Commit $commit
     *
     * @return void
     */
    public function __construct(Commit $commit)
    {
        $this->commit = $commit;
    }

    /**
     * Get the commit that will be analysed.
     *
     * @return \StyleCI\StyleCI\Models\Commit
     */
    public function getCommit()
    {
        return $this->commit;
    }
}
