<?php

namespace Tests\Feature;

use App\Page;
use App\PageContent;
use Tests\TestCaseSetup;

/**
 * This tests various controller end points pertaining to Page controller
 * 
 * PageController@index - tests available
 * PageController@store - tests available
 * PageController@update - tests available
 * 
 */
class PageTest extends TestCaseSetup
{

    protected $pages;


    /**
     *-----------------------------------------------------------
     * Create some initial pages in the database 
     *-----------------------------------------------------------
     */
    protected function setUp(): void
    {
        parent::setUp();

        // a page without any content
        $this->pages[] = factory(Page::class)->create();

        // 2 pages with contents (status draft and live)
        $this->pages[] = tap(factory(Page::class)->create(['status' => 'Live']))->each(function ($page) {
            $page->content()->save(factory(PageContent::class)->make());
        });

        $this->pages[] = tap(factory(Page::class)->create(['status' => 'Draft']))->each(function ($page) {
            $page->content()->save(factory(PageContent::class)->make());
        });
    }


    /**
     *-----------------------------------------------------------
     * Tests related to PageController@index
     *-----------------------------------------------------------*/
    public function test_index_pages_retrieves_all_pages_with_relation()
    {
        $data = $this->getView('pages.index', $this->user_admin);
        $pages = $data['pages']->toArray();

        // check all the pages are returned
        $this->assertCount(count($this->pages), $pages);

        // get one of the pages
        $page = $pages[0];

        $this->assertArrayHasKey('author', $page);
        $this->assertArrayHasKey('comments', $page);
        $this->assertArrayHasKey('category', $page);
    }



    /**
     *-----------------------------------------------------------
     * Tests related to PageController@store
     *-----------------------------------------------------------*/
    public function test_a_page_can_be_created_by_admin()
    {
        $this->a_page_can_be_created_by($this->user_admin);
    }

    public function test_a_page_can_be_created_by_author()
    {
        $this->a_page_can_be_created_by($this->user_author);
    }

    public function test_a_page_can_not_be_created_by_general()
    {
        $this->a_page_can_not_be_created_by($this->user_general);
    }


    /**
     *-----------------------------------------------------------
     * Tests related to PageController@update
     *-----------------------------------------------------------*/

    public function test_a_page_can_be_updated_by_admin()
    {
        $this->a_page_can_be_updated_by($this->pages[0], $this->user_admin);
    }

    public function test_a_page_can_be_updated_by_author()
    {
        $this->a_page_can_be_updated_by($this->pages[1], $this->user_author);
    }

    public function test_a_page_can_not_be_updated_by_general()
    {
        $this->a_page_can_not_be_updated_by($this->pages[2], $this->user_general);
    }



    /**
     *-----------------------------------------------------------
     * Utility methods
     *-----------------------------------------------------------*/
    protected function a_page_can_be_created_by($user)
    {
        $page = factory(Page::class)->make();
        $content = factory(PageContent::class)->make();

        $this->actingAs($user)
            ->post(route('pages.store'), [
                'title' => $page->title,
                'summary' => $page->summary,
                'body' => $content->body
            ]);

        $this->assertDatabaseHas('pages', [
            'title' => $page->title,
            'summary' => $page->summary,
            'user_id' => $user->id
        ]);

        $this->assertDatabaseHas('page_contents', [
            'body' => $content->body
        ]);
    }


    protected function a_page_can_not_be_created_by($user)
    {
        $page = factory(Page::class)->make();
        $content = factory(PageContent::class)->make();

        $this->actingAs($user)
            ->post(route('pages.store'), [
                'title' => $page->title,
                'summary' => $page->summary,
                'body' => $content->body
            ])
            ->assertForbidden();
    }


    protected function a_page_can_be_updated_by($page, $user)
    {
        $newPage = factory(Page::class)->make([
            'category_id' => rand(0, 100000),
            'status' => 'Draft'
        ]);
        $newPageContent = factory(PageContent::class)->make();

        $this->actingAs($user)
            ->patch(route('pages.update', $page->id), [
                'id' => $page->id,

                'category_id' => $newPage->category_id,
                'title' => $newPage->title,
                'summary' => $newPage->summary,
                'metakey' => $newPage->metakey,
                'metadesc' => $newPage->metadesc,
                'media_url' => $newPage->media_url,
                'status' => $newPage->status,
                'body' => $newPageContent->body
            ]);


        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'category_id' => $newPage->category_id,
            'title' => $newPage->title,
            'summary' => $newPage->summary,
            'metakey' => $newPage->metakey,
            'metadesc' => $newPage->metadesc,
            'media_url' => $newPage->media_url,
            'status' => $newPage->status,
        ]);

        $this->assertDatabaseHas('page_contents', [
            'page_id' => $page->id,
            'body' => $newPageContent->body
        ]);
    }


    protected function a_page_can_not_be_updated_by($page, $user)
    {
        $this->actingAs($user)
            ->patch(route('pages.update', $page->id), [
                'id' => $page->id,
                'title' => 'some new information'
            ])
            ->assertForbidden();
    }
}
