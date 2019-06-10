<?php

namespace Tests\Feature;

use App\Page;
use App\Category;
use Tests\TestCaseSetup;

/**
 * This tests various controller end points pertaining to category controller
 * 
 */
class CategoryTest extends TestCaseSetup
{

        protected $pCatNoChild, $pCatWithChild, $midCat, $leafCat, $pageInLeafCat;


        /**
         *-----------------------------------------------------------
        * Create some initial categories in the database 
        *-----------------------------------------------------------
        */
        protected function setUp(): void
        {
                parent::setUp();

                // create 2 parent level categories
                $this->pCatNoChild = factory(Category::class)->create();
                $this->pCatWithChild = factory(Category::class)->create();

                // create 1 mid level category
                $this->midCat = factory(Category::class)->create(['parent_id' => $this->pCatWithChild->id]);

                // create 1 leaf level category
                $this->leafCat = factory(Category::class)->create(['parent_id' => $this->midCat->id]);

                // create a new page under this category
                $this->pageInLeafCat = factory(Page::class)->create([
                        'category_id' => $this->leafCat->id
                ]);

        }



        /**
         *-----------------------------------------------------------
        * Tests related to categoryController@index
        *-----------------------------------------------------------
        */
        public function test_admin_can_retrieve_categories()
        {
                return $this->categories_retrieved_by($this->user_admin, true);
        }

        public function test_author_can_retrieve_categories()
        {
                return $this->categories_retrieved_by($this->user_author, true);
        }

        public function test_general_user_can_not_retrieve_categories()
        {
                return $this->categories_retrieved_by($this->user_general, false);
        }

        /**
         *-----------------------------------------------------------
        * Tests related to categoryController@create
        *-----------------------------------------------------------
        */

        public function test_admin_can_view_category_create_page()
        {
                return $this->category_create_page_access_by($this->user_admin, true);
        }

        public function test_author_can_not_view_category_create_page()
        {
                return $this->category_create_page_access_by($this->user_author, false);
        }

        public function test_general_user_can_not_view_category_create_page()
        {
                return $this->category_create_page_access_by($this->user_general, false);
        }

        /**
        *-----------------------------------------------------------
        * Utility methods
        *-----------------------------------------------------------*/
        protected function categories_retrieved_by ($user, $status = true)
        {
                if ($status) {
                        return $this
                                ->actingAs($user)
                                ->get(route('categories.index'))
                                ->assertOk()
                                ->assertSee($this->pCatNoChild->name)
                                ->assertSee($this->pCatWithChild->name)
                                ->assertSee($this->midCat->name)
                                ->assertSee($this->leafCat->name)
                                ->assertSee($this->leafCat->pages[0]->name);
                } else {
                        return $this
                                ->actingAs($user)
                                ->get(route('categories.index'))
                                ->assertForbidden();
                }
        }

        protected function category_create_page_access_by ($user, $status = true)
        {
                if ($status) {
                        return $this
                                ->actingAs($user)
                                ->get(route('categories.create'))
                                ->assertOk()
                                ->assertViewHas('category')
                                ->assertViewHas('categories');
                } else {
                        return $this
                                ->actingAs($user)
                                ->get(route('categories.create'))
                                ->assertForbidden();
                }
        }
    }



    /**
     *-----------------------------------------------------------
     * Tests related to categoryController@store
     *-----------------------------------------------------------*/
//     public function test_a_category_can_be_created_by_admin()
//     {
//         $this->a_category_can_be_created_by($this->user_admin);
//     }

//     public function test_a_category_can_be_created_by_author()
//     {
//         $this->a_category_can_be_created_by($this->user_author);
//     }

//     public function test_a_category_can_not_be_created_by_general()
//     {
//         $this->a_category_can_not_be_created_by($this->user_general);
//     }


    /**
     *-----------------------------------------------------------
     * Tests related to categoryController@update
     *-----------------------------------------------------------*/

//     public function test_a_category_can_be_updated_by_admin()
//     {
//         $this->a_category_can_be_updated_by($this->categories[0], $this->user_admin);
//     }

//     public function test_a_category_can_be_updated_by_author()
//     {
//         $this->a_category_can_be_updated_by($this->categories[1], $this->user_author);
//     }

//     public function test_a_category_can_not_be_updated_by_general()
//     {
//         $this->a_category_can_not_be_updated_by($this->categories[2], $this->user_general);
//     }



    
//     protected function a_category_can_be_created_by($user)
//     {
//         $category = factory(Category::class)->make();
//         $content = factory(categoryContent::class)->make();

//         $this->actingAs($user)
//             ->post(route('categories.store'), [
//                 'title' => $category->title,
//                 'summary' => $category->summary,
//                 'body' => $content->body
//             ]);

//         $this->assertDatabaseHas('categories', [
//             'title' => $category->title,
//             'summary' => $category->summary,
//             'user_id' => $user->id
//         ]);

//         $this->assertDatabaseHas('category_contents', [
//             'body' => $content->body
//         ]);
//     }


//     protected function a_category_can_not_be_created_by($user)
//     {
//         $category = factory(Category::class)->make();
//         $content = factory(categoryContent::class)->make();

//         $this->actingAs($user)
//             ->post(route('categories.store'), [
//                 'title' => $category->title,
//                 'summary' => $category->summary,
//                 'body' => $content->body
//             ])
//             ->assertForbidden();
//     }


//     protected function a_category_can_be_updated_by($category, $user)
//     {
//         $newcategory = factory(Category::class)->make([
//             'category_id' => rand(0, 100000),
//             'status' => 'Draft'
//         ]);
//         $newcategoryContent = factory(categoryContent::class)->make();

//         $this->actingAs($user)
//             ->patch(route('categories.update', $category->id), [
//                 'id' => $category->id,

//                 'category_id' => $newcategory->category_id,
//                 'title' => $newcategory->title,
//                 'summary' => $newcategory->summary,
//                 'metakey' => $newcategory->metakey,
//                 'metadesc' => $newcategory->metadesc,
//                 'media_url' => $newcategory->media_url,
//                 'status' => $newcategory->status,
//                 'body' => $newcategoryContent->body
//             ]);


//         $this->assertDatabaseHas('categories', [
//             'id' => $category->id,
//             'category_id' => $newcategory->category_id,
//             'title' => $newcategory->title,
//             'summary' => $newcategory->summary,
//             'metakey' => $newcategory->metakey,
//             'metadesc' => $newcategory->metadesc,
//             'media_url' => $newcategory->media_url,
//             'status' => $newcategory->status,
//         ]);

//         $this->assertDatabaseHas('category_contents', [
//             'category_id' => $category->id,
//             'body' => $newcategoryContent->body
//         ]);
//     }


//     protected function a_category_can_not_be_updated_by($category, $user)
//     {
//         $this->actingAs($user)
//             ->patch(route('categories.update', $category->id), [
//                 'id' => $category->id,
//                 'title' => 'some new information'
//             ])
//             ->assertForbidden();
//     }
// }
