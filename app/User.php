<?php

namespace App;

use App\Comment;
use Illuminate\Notifications\Notifiable;
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
        'name', 'email', 'password', 'type', 'avatar', 'slug'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function publications()
    {
        return $this->hasMany(Page::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    public function providers($provider = null)
    {
        if (empty($provider)) {
            return $this->hasMany(AuthProvider::class);
        } else {
            return $this->hasOne(AuthProvider::class)->where('provider', $provider);
        }
    }

    public static function findOrFailBySlug($slug)
    {
        return static::where('slug', $slug)->first();
    }

    public function createOrUpdateProvider(String $provider, $providerUser)
    {
        $authProvider = $this->providers($provider)->first();

        if (empty($authProvider)) {
            $this->providers()->create([
                'provider' => $provider,
                'provider_user_id' => $providerUser->getId(),
                'avatar' => $providerUser->getAvatar()
            ]);
        } else {
            $authProvider->avatar = $providerUser->getAvatar();
            $authProvider->save();
        }

        $this->avatar = $providerUser->getAvatar();

        return $this->save();
    }


    

    public function getUrlAttribute()
    {
        return url('/profile/' . $this->slug);
    }

    public function getAgoAttribute()
    {
        return $this->updated_at->diffForHumans();
    }
}
