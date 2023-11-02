<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentOrReplyLike extends Model
{
    use HasFactory;

    protected $table = 'comments_and_replies_likes';
    
    protected $fillable = [
        'video_id',
        'comment_id',
        'reply_id',
        'user_id'
    ];
}
