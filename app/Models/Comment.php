<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['id','post_id', 'comment', 'user_id', 'parent_id'];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post():BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function reactions():HasMany
    {
        return $this->hasMany(CommentReaction::class);
    }

    public function countReactions():int
    {
        return $this->reactions()->count();
    }

    public function hasReactionFromUser($userId)
    {
        return $this->reactions()->where('user_id', $userId)->exists();
    }

    public function subComments(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function countSubComments():int
    {
        return $this->subComments()->count();
    }

    public function latest3SubComments(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')->latest()->limit(3);
    }



}
