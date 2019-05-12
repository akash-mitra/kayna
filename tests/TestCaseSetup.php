<?php

namespace Tests;

use App\User;
use App\Page;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class TestCaseSetup extends TestCase
{
    use RefreshDatabase;

    protected $user_general;
    protected $user_author;
    protected $user_admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user_admin = factory(User::class)->create(['type' => 'admin']);
        $this->user_author = factory(User::class)->create(['type' => 'author']);
        $this->user_general = factory(User::class)->create(['type' => 'general']);
    }


    protected function getView($route, $user)
    {
        $response = $this->actingAs($user)->get(route($route));
        $content = $response->getOriginalContent();
        $data =  $content->getData();
        return $data;
    }
}
