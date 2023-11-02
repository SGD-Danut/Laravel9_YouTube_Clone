<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    protected $table = 'users_notifications';
    
    protected $fillable = [
        'user_id',
        'channel_id',
        'video_id'
    ];

    public function channel() {
        return $this->belongsTo(Channel::class);
    }

    public function video() {
        return $this->belongsTo(Video::class);
    }
}
