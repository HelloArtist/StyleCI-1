<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Models;

use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;
use StyleCI\StyleCI\Presenters\RepoPresenter;

/**
 * This is the repo model class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class Repo extends Model implements HasPresenter
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * A list of methods protected from mass assignment.
     *
     * @var string[]
     */
    protected $guarded = ['_token', '_method'];

    /**
     * Get the analyses relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function analyses()
    {
        return $this->hasMany(Analysis::class);
    }

    /**
     * Get the user relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the last analysis of the default branch.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function last_analysis()
    {
        return $this->hasOne(Analysis::class)->where('branch', $this->default_branch)->latest();
    }

    /**
     * Get the presenter class.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return RepoPresenter::class;
    }
}
