<?php

namespace App\Models;

use BeyondCode\Comments\Comment as BaseComment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Comment extends BaseComment
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'user_id',
        'parent_id',
        'is_approved',
        'is_internal',
    ];

    /**
     * Return all comments for this model.
     *
     * @return MorphMany
     */
    public function replies()
    {
        return $this->morphMany(config('comments.comment_class'), 'commentable');
    }
}
