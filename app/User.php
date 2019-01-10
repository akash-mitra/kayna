<?php

namespace App;
use App\Page;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $appends = ['url', 'ago'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    

    public function publications ()
    {
        return $this->hasMany(Page::class);
    }


    public function getUrlAttribute()
    {
        return url('/admin/users/' . $this->id);
    }

    public function getAgoAttribute()
    {
        return $this->updated_at->diffForHumans();
    }
}
