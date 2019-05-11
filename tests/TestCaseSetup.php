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


    protected function a_page_can_be_created_by($user)
    {
        $page = factory(Page::class)->make();
        $content = '<p>Some random <b>HTML</b> Texts with non-alpha characters such as ` and "</p>';

        $this->actingAs($user)
            ->post(route('pages.store'), [
                'title' => $page->title,
                'summary' => $page->summary,
                'body' => $content
            ]);

        $this->assertDatabaseHas('pages', [
            'title' => $page->title,
            'summary' => $page->summary,
            'user_id' => $user->id
        ]);

        $this->assertDatabaseHas('page_contents', [
            'body' => $content
        ]);
    }


    protected function a_page_can_not_be_created_by($user)
    {
        $page = factory(Page::class)->make();
        $content = '<p>Some random <b>HTML</b> Texts with non-alpha characters such as ` and "</p>';

        $this->actingAs($user)
            ->post(route('pages.store'), [
                'title' => $page->title,
                'summary' => $page->summary,
                'body' => $content
            ])
            ->assertForbidden();

        // dump($response);
        //->assertRedirect('/abc');
    }
}
