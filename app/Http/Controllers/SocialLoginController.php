<?php

namespace App\Http\Controllers;

use Exception;
use Socialite;
use App\User;
use Illuminate\Support\Facades\Auth;

class SocialLoginController extends Controller
{
    protected $providers = ['facebook', 'google'];

    public function provider($provider)
    {
        if (!in_array($provider, $this->providers)) {
            return abort(404, 'Provider not supported');
        }

        $driver = $this->makeDriver($provider);

        return $driver->redirect();
    }

    public function callback(String $provider)
    {
        if (!in_array($provider, $this->providers)) {
            return abort(404, 'Provider not supported');
        }

        $authenticatedUser = $this->getAuthenticatedUser($provider);
        $this->abortIfInfoMissing($authenticatedUser);
        $existingUser = $this->authenticatedUserExisting($authenticatedUser);

        if ($existingUser) {
            $existingUser->createOrUpdateProvider($provider, $authenticatedUser);
            Auth::login($existingUser, true);
        } else {
            $user = $this->createUserWithProvider($provider, $authenticatedUser);
            Auth::login($user, true);
        }
        // return 'done';
        return redirect()->intended();
    }

    private function createUserWithProvider($provider, $authenticatedUser)
    {
        $user = new User([
            'name' => $authenticatedUser->getName(),
            'email' => $authenticatedUser->getEmail(),
            'type' => 'general',
            'avatar' => $authenticatedUser->getAvatar(),
            'slug' => uniqid(mt_rand(0, 9999), true),
            'email_verified_at' => \Carbon\Carbon::now()
        ]);

        $user->save();

        $user->providers()->create([
            'provider_user_id' => $authenticatedUser->getId(),
            'provider' => $provider,
            'avatar' => $authenticatedUser->getAvatar()
        ]);

        return $user;
    }

    private function getAuthenticatedUser($provider)
    {
        try {
            $driver = $this->makeDriver($provider);

            return $driver->user();
        } catch (Exception $e) {
            return abort(400, 'Unable to authenticate user');
        }
    }

    private function authenticatedUserExisting($authenticatedUser)
    {
        return User::where('email', $authenticatedUser->getEmail())->first();
    }

    /**
     * Checks the authenticated user returned from the
     * social provider to make sure all the mandatory
     * information are present
     *
     * @param  object $authenticatedUser
     * @return void
     */
    private function abortIfInfoMissing($authenticatedUser)
    {
        if (empty($authenticatedUser->getEmail())
            || empty($authenticatedUser->getName())
            || empty($authenticatedUser->getAvatar())) {
            abort(406, 'Must provide name, email and profile picture');
        }
    }

    private function makeDriver($provider)
    {
        $func = 'make' . ucfirst($provider) . 'Driver';

        return $this->$func();
    }

    private function makeFacebookDriver()
    {
        $config['client_id'] = param('login_facebook_client_id');
        $config['client_secret'] = param('login_facebook_client_secret');
        $config['redirect'] = url('/social/login/facebook/callback');

        return  Socialite::buildProvider(\Laravel\Socialite\Two\FacebookProvider::class, $config);
    }

    private function makeGoogleDriver()
    {
        $config['client_id'] = param('login_google_client_id');
        $config['client_secret'] = param('login_google_client_secret');
        $config['redirect'] = url('/social/login/google/callback');

        return  Socialite::buildProvider(\Laravel\Socialite\Two\GoogleProvider::class, $config);
    }
}
