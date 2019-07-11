<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCaseSetup;

/**
 * This tests various controller end points pertaining to User controller
 * 
 * 
 */
class UserTest extends TestCaseSetup
{

    protected $users;


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
        $this->disableLoginExcept();

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
