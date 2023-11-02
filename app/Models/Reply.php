<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $table = 'replies';
    protected $fillable = [
        'video_id',
        'comment_id',
        'user_id',
        'channel_id',
        'reply_content'
    ];

    public function channel() {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    public function likes() {
        return $this->hasMany(CommentOrReplyLike::class, 'reply_id');
    }

    public function dislikes() {
        return $this->hasMany(CommentOrReplyDislike::class, 'reply_id');
    }
}
