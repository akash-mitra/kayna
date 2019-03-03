<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuthProvider extends Model
{
    protected $fillable = ['provider', 'provider_user_id', 'avatar'];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
