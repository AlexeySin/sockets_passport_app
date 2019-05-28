<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Message extends Model
{
    protected $fillable = ['content'];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
