<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use phpDocumentor\Reflection\Types\Boolean;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'body'];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function group() : BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function attachments() : HasMany
    {
        return $this->hasMany(PostAttachment::class);
    }


    protected static function boot()
    {
        parent::boot();
        static::deleting(function($post) {
            $attachments = $post->attachments()->get();
            foreach ($attachments as $attachment) {
                $attachment->delete();
            }
        });
    }



    public function reactions():HasMany
    {
        return $this->hasMany(PostReaction::class);
    }

    public function comments():HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function hasReactionFromUser($userId)
    {
        return $this->reactions()->where('user_id', $userId)->exists();
    }

    public function countReactions(): int
    {
        return $this->reactions()->count();
    }

    public function countComments(): int
    {
        return $this->comments()->count();
    }

    public function latest5Comment()
    {
        return $this->hasMany(Comment::class)->latest()->whereNull('parent_id')->limit(5)->get();
    }


}
