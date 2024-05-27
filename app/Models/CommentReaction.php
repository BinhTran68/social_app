<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentReaction extends Model
{
    use HasFactory;
    const UPDATED_AT = null;

    protected $fillable = [
        'comment_id',
        'user_id',
        'type'
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
