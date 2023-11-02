<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    public function videos() {
        return $this->hasMany(Video::class, 'channel_id');
    }

    public function user() {
        return $this->hasOne(User::class);
    }

    public function subscribers() {
        return $this->belongsToMany(User::class, 'subscribers', 'channel_id', 'user_id'); 
    }
}
