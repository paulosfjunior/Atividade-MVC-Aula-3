<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Pet extends Model
{
    use Notifiable;

    protected $fillable = [
        'name', 'description', 'age', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
