<?php

namespace Tests\Feature;

use Laravel\Socialite\Facades\Socialite;
// use Laravel\Socialite\Contracts\Factory as Socialite;
use Tests\TestCaseSetup;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Queue;
use Laravel\Socialite\Two\GoogleProvider;
use Laravel\Socialite\Two\User as SocialUser;

/**
 * This tests various controller end points pertaining to User controller
 * 
 * 
 */
class UserTest extends TestCaseSetup
{

    protected $users;


    /**
     * Mock the Socialite Factory, so we can hijack the OAuth Request.
     * @param  string  $email
     * @param  string  $token
     * @param  int $id
     * @return void
     */
    public function mockSocialiteFacade($email = 'foo@gmail.com', $token = 'foo', $id = 10)
    {
        $socialiteUser = $this->createMock(SocialUser::class);
        $socialiteUser->token = $token;
        $socialiteUser->id = $id;
        $socialiteUser->email = $email;

        $provider = $this->createMock(GoogleProvider::class);
        $provider->expects($this->any())
            ->method('user')
            ->willReturn($socialiteUser);

        $stub = $this->createMock(Socialite::class);
        $stub->expects($this->any())
            // ->method('driver')
            // ->with('google')
            ->willReturn($provider);

        // Replace Socialite Instance with our mock
        $this->app->instance(Socialite::class, $stub);
    }


    public function test_social_login_via_gmail_redirects_to_gmail()
    {
        $response = $this->call('GET', '/social/login/google');

        $this->assertContains('google.com/o/oauth2/auth', $response->getTargetUrl());
    }


    // public function test_social_login_process_google_callback_and_creates_new_user()
    // {
        
    //     // Mock the Facade and return a User Object with the email 'foo@bar.com'
    //     // $this->mockSocialiteFacade('foo@gmail.com');
        
    //     Queue::fake();

    //     $this->get('/social/login/google/callback')->assertRedirect();
    //         // ->seePageIs('/home');

    //     // $this->assertDatabaseHas('users', [
    //     //     'email' => 'foo@gmail.com',
    //     // ]);
    // }


    public function test_a_user_can_be_created_from_frontend ()
    {
        // if I post info to /register
        $user = [
            "name" => str_random(20),
            "email" => str_random(10) . '@gmail.com',
            "password" => 'abcdef123456',
            "password_confirmation" => 'abcdef123456'
        ];


        // fake the queue and make sure the queue is empty
        Queue::fake();
        Queue::assertNothingPushed();

        // post new user data for user creation
        $this->post('/register', $user);

        // make sure the user is created in the database
        $this->assertDatabaseHas('users', [
            "email" => $user['email']
        ]);

        // and a new email job is pushed to the queue
        Queue::assertPushed(SendEmailJob::class);
    }



    public function test_user_login_page_is_accessible ()
    {
        $this->get('/login')->assertOk();
    }

    public function test_login_page_shows_relevant_login_option_for_native_login()
    {
        $this->disableLoginExcept(['login_native_active']);

        $this->get('/login')
            ->assertSee('E-Mail Address')
            ->assertSee('Password');
    }


    public function test_login_page_shows_relevant_login_option_for_google_login()
    {
        $this->disableLoginExcept(['login_google_active']);

        $this->get('/login')
            ->assertSee('Login Via Google');
    }


    public function test_login_page_shows_relevant_login_option_for_facebook_login()
    {
        $this->disableLoginExcept(['login_facebook_active']);

        $this->get('/login')
            ->assertSee('Login Via Facebook');
    }


    public function test_login_page_shows_relevant_login_options_for_all_logins()
    {
        $this->disableLoginExcept(['login_facebook_active', 'login_google_active', 'login_native_active']);

        $this->get('/login')
            ->assertSee('E-Mail Address')
            ->assertSee('Password')
            ->assertSee('Login Via Google')
            ->assertSee('Login Via Facebook');
    }


    public function test_register_page_is_accessible_when_native_login_enabled()
    {
        $this->disableLoginExcept(['login_native_active']);

        $this->get('/register')
            ->assertSee('Create Account');
    }


    public function test_register_page_is_NOT_accessible_when_native_login_disabled()
    {
        $this->disableLoginExcept(['login_google_active', 'login_facebook_active']);

        $this->get('/register')
            ->assertForbidden();
    }


    

    //---------------------------------------- HELPER FUNCTIONS ----------------------------------------

    private function disableLoginExcept(array $types = [])
    {
        param('login_native_active', 'no');
        param('login_google_active', 'no');
        param('login_facebook_active', 'no');
        
        foreach($types as $type)
        {
            param($type, 'yes');
        }
    }
}
