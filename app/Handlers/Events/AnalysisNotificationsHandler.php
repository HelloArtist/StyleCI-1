<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Cachet HQ <support@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Events;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Mail\Message;
use StyleCI\StyleCI\Events\AnalysisHasCompletedEvent;
use StyleCI\StyleCI\Models\Commit;
use StyleCI\StyleCI\Repositories\UserRepository;

/**
 * This is the analysis notification handler class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class AnalysisNotificationsHandler
{
    /**
     * The user repository instance.
     *
     * @var \StyleCI\StyleCI\Repositories\UserRepository
     */
    protected $userRepository;

    /**
     * The mailer instance.
     *
     * @var \Illuminate\Contracts\Mail\Mailer
     */
    protected $mailer;

    /**
     * Create a new analysis notifications handler instance.
     *
     * @param \StyleCI\StyleCI\Repositories\UserRepository $userRepository
     * @param \Illuminate\Contracts\Mail\Mailer            $mailer
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository, Mailer $mailer)
    {
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
    }

    /**
     * Handle the analysis has completed event.
     *
     * @param \StyleCI\StyleCI\Events\AnalysisHasCompletedEvent $event
     *
     * @return void
     */
    public function handle(AnalysisHasCompletedEvent $event)
    {
        $commit = $event->commit;

        // if the analysis didn't fail, then we don't need to notify anyone
        if ($commit->status < 2) {
            return;
        }

        // don't send out notifications for analyses of forks
        if ($commit->fork_id) {
            return;
        }

        $this->sendMessages($commit);
    }

    /**
     * Send out messages to the relevant users.
     *
     * We're emailing all repo collaborators that have accounts on StyleCI.
     *
     * @todo Allow users to set their notification preferences, and support
     * notifying users though other mediums than just email.
     *
     * @param \StyleCI\StyleCI\Models\Commit $commit
     *
     * @return void
     */
    protected function sendMessages(Commit $commit)
    {
        $mail = [
            'repo'    => $commit->name(),
            'commit'  => $commit->message,
            'link'    => route('commit_path', $commit->id),
            'subject' => '[StyleCI] Failed Analysis',
        ];

        if ($commit->status === 3) {
            $status = 'errored';
        } elseif ($commit->status === 4) {
            $status = 'misconfigured';
        } else {
            $status = 'failed';
        }

        foreach ($this->userRepository->collaborators($commit) as $user) {
            $mail['email'] = $user->email;
            $mail['name'] = explode(' ', $user->name)[0];
            $this->mailer->send(["emails.{$status}-html", "emails.{$status}-text"], $mail, function (Message $message) use ($mail) {
                $message->to($mail['email'])->subject($mail['subject']);
            });
        }
    }
}
