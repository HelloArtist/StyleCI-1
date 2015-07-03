<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Events\Analysis;

use Illuminate\Contracts\Mail\MailQueue;
use Illuminate\Mail\Message;
use McCool\LaravelAutoPresenter\Facades\AutoPresenter;
use StyleCI\StyleCI\Events\Analysis\AnalysisHasCompletedEvent;
use StyleCI\StyleCI\Repositories\UserRepository;

/**
 * This is the analysis notification handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
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
     * @var \Illuminate\Contracts\Mail\MailQueue
     */
    protected $mailer;

    /**
     * Create a new analysis notifications handler instance.
     *
     * @param \StyleCI\StyleCI\Repositories\UserRepository $userRepository
     * @param \Illuminate\Contracts\Mail\MailQueue         $mailer
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository, MailQueue $mailer)
    {
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
    }

    /**
     * Handle the analysis has completed event.
     *
     * @param \StyleCI\StyleCI\Events\Analysis\AnalysisHasCompletedEvent $event
     *
     * @return void
     */
    public function handle(AnalysisHasCompletedEvent $event)
    {
        $analysis = $event->analysis;

        if ($analysis->status < 3 || $analysis->pr) {
            return;
        }

        $repo = $analysis->repo;

        $mail = [
            'repo'    => $repo->name,
            'commit'  => $analysis->message,
            'link'    => route('analysis_path', AutoPresenter::decorate($analysis)->id),
            'subject' => '[StyleCI] Failed Analysis',
        ];

        switch ($analysis->status) {
            case 3:
            case 4:
            case 5:
                $status = 'failed';
                break;
            case 6:
                $status = 'misconfigured';
                break;
            default:
                $status = 'errored';
        }

        foreach ($this->userRepository->collaborators($repo) as $user) {
            $mail['email'] = $user->email;
            $mail['name'] = AutoPresenter::decorate($user)->first_name;
            $this->mailer->queue(["emails.{$status}-html", "emails.{$status}-text"], $mail, function (Message $message) use ($mail) {
                $message->to($mail['email'])->subject($mail['subject']);
            });
        }
    }
}