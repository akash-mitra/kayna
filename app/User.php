<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $appends = ['url', 'created_ago', 'updated_ago'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type', 'avatar', 'slug', 'bio'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * This method overwrites create() method in model. This is done
     * to ensure that if certain user attributes are not supplied,
     * then those attributes can be enriched at this level. As an
     * example, when RegisterController calls User::create()
     * method, it only supplies 'name', 'email' and 
     * 'password'. However, other information such 
     * as slug and types can be enriched here.
     */
    protected function create( array $attributes = []) {
        if(! array_key_exists('slug', $attributes)) {
            $attributes['slug'] = uniqid(mt_rand(0, 9999), true);
        }
        if (! array_key_exists('type', $attributes)) {
            $attributes['type'] = 'general';
        }
        return parent::create($attributes);
    }


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

    public function getUpdatedAgoAttribute()
    {
        return $this->updated_at->diffForHumans();
    }

    public function getCreatedAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function isRequestingHerSelf()
    {
        return auth()->user()->id === $this->id;
    }

    public static function props()
    {
        return [
            ['name' => 'name', 'description' => 'Name of the user', 'visibility' => true],
            ['name' => 'email', 'description' => 'Email ID of the user', 'visibility' => false],
            ['name' => 'url', 'description' => 'Link to the public profile of the user', 'visibility' => true],
            ['name' => 'avatar', 'description' => 'Profile Image of the user', 'visibility' => true]
        ];
    }
}
