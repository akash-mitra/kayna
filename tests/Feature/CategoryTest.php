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


        /*
        *-----------------------------------------------------------
        * Create some initial categories data in the database 
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



        /*
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



        /*
        * ------------------------------------------------------------
        * Tests for CategoryController@get
        * ------------------------------------------------------------
        */
        public function test_anyone_can_view_pages_inside_category()
        {
               return $this->get(route('categories.get', $this->leafCat->id))
                        ->assertOk()
                        ->assertSee($this->pageInLeafCat->title);
        }
        


        /*
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


        /*
        *-----------------------------------------------------------
        * Tests related to categoryController@edit
        *-----------------------------------------------------------
        */
        public function test_admin_can_view_category_edit_page()
        {
                return $this->category_edit_page_access_by($this->user_admin, true);
        }

        public function test_author_can_not_view_category_edit_page()
        {
                return $this->category_edit_page_access_by($this->user_author, false);
        }

        public function test_general_user_can_not_view_category_edit_page()
        {
                return $this->category_edit_page_access_by($this->user_general, false);
        }


        /*
        *-----------------------------------------------------------
        * Tests related to categoryController@store
        *-----------------------------------------------------------
        */
        public function test_admin_can_store_new_category()
        {
                return $this->category_can_be_stored_by($this->user_admin, true);
        }

        public function test_author_can_not_store_new_category()
        {
                return $this->category_can_be_stored_by($this->user_author, false);
        }

        public function test_general_user_can_not_store_new_category()
        {
                return $this->category_can_be_stored_by($this->user_general, false);
        }



        /*
        *-----------------------------------------------------------
        * Tests related to categoryController@update
        *-----------------------------------------------------------
        */
        public function test_admin_can_update_existing_category()
        {
                return $this->category_can_be_updated_by($this->user_admin, true);
        }

        public function test_author_can_not_update_existing_category()
        {
                return $this->category_can_be_updated_by($this->user_author, false);
        }

        public function test_general_user_can_not_update_existing_category()
        {
                return $this->category_can_be_updated_by($this->user_general, false);
        }



        /*
        *-----------------------------------------------------------
        * Tests related to categoryController@destroy
        *-----------------------------------------------------------
        */
        public function test_admin_can_delete_existing_category()
        {
                $this->category_with_no_child_can_be_deleted_by($this->user_admin, true);
                $this->category_with_child_can_not_be_deleted_by($this->user_admin);
        }

        public function test_author_can_not_delete_existing_category()
        {
                return $this->category_with_no_child_can_be_deleted_by($this->user_author, false);
        }

        public function test_general_user_can_not_delete_existing_category()
        {
                return $this->category_with_no_child_can_be_deleted_by($this->user_general, false);
        }
        

        /*
        * ------------------------------------------------------------
        * Tests for Validation checks
        * ------------------------------------------------------------
        */
        public function test_category_can_not_be_created_with_empty_name()
        {
               $category = [
                        "name" => '',
                        "description" => "Category description",
                        "parent_id" => null
                ];

                $this->actingAs($this->user_admin)
                        ->post(route('categories.store'), $category)
                        ->assertSessionHasErrors('name');
        }


        public function test_category_can_not_be_updated_with_empty_name()
        {
                $this->actingAs($this->user_admin)
                        ->patch(route('categories.update', $this->midCat->id), [
                                'name' => ''
                        ])->assertSessionHasErrors('name');
        }

        public function test_category_can_not_be_updated_with_parent_id_equal_to_self()
        {
                $this->actingAs($this->user_admin)
                        ->patch(route('categories.update', $this->midCat->id), [
                                'parent_id' => $this->midCat->id
                        ])->assertSessionHasErrors('parent_id');
        }
        

        /*
        *-----------------------------------------------------------
        * Utility methods
        *-----------------------------------------------------------*/
        protected function categories_retrieved_by ($user, $positiveTest = true)
        {
                if ($positiveTest) {
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

        protected function category_create_page_access_by ($user, $positiveTest = true)
        {
                if ($positiveTest) {
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

        protected function category_edit_page_access_by ($user, $positiveTest = true)
        {
                if ($positiveTest) {
                        return $this
                                ->actingAs($user)
                                ->get(route('categories.edit', $this->midCat->id))
                                ->assertOk()
                                ->assertViewHas('category')
                                ->assertViewHas('categories');
                } else {
                        return $this
                                ->actingAs($user)
                                ->get(route('categories.edit', $this->midCat->id))
                                ->assertForbidden();
                }
        }


        protected function category_can_be_stored_by ($user, $positiveTest = true)
        {
                $category = [
                        "name" => mt_rand(10000, 99999),
                        "description" => "Category description",
                        "parent_id" => null
                ];

                if ($positiveTest) {
                        $this->actingAs($user)
                                ->post(route('categories.store'), $category)
                                ->assertRedirect();

                        $this->assertDatabaseHas('categories', [
                                'name' => $category['name']
                        ]);
                                
                } else {
                        $this->actingAs($user)
                                ->post(route('categories.store'), $category);
                                
                        $this->assertDatabaseMissing('categories', [
                                'name' => $category['name']
                        ]);
                }
        }



        protected function category_can_be_updated_by ($user, $positiveTest = true)
        {
                $newName = mt_rand(10000, 99999);

                if ($positiveTest) {
                        $this->actingAs($user)
                                ->patch(route('categories.update', $this->midCat->id), [
                                        "name" => $newName
                                ]);

                        $this->assertDatabaseHas('categories', [
                                'id' => $this->midCat->id,
                                'name' => $newName
                        ]);
                                
                } else {
                        $this->actingAs($user)
                                ->patch(route('categories.update', $this->midCat->id), [
                                        "name" => $newName
                                ]);
                                
                        $this->assertDatabaseMissing('categories', [
                                'id' => $this->midCat->id,
                                'name' => $newName
                        ]);
                }
        }


        protected function category_with_no_child_can_be_deleted_by ($user, $positiveTest = true)
        {
                $this->category_can_be_deleted_by($user, $this->leafCat, $positiveTest);
        }


        protected function category_with_child_can_not_be_deleted_by ($user)
        {
                $this->category_can_be_deleted_by($user, $this->pCatWithChild, false);
        }


        protected function category_can_be_deleted_by ($user, $category, $positiveTest = true)
        {
                if ($positiveTest) {
                        $this->actingAs($user)->delete(route('categories.destroy', $category->id));

                        $this->assertDatabaseMissing('categories', [
                                'id' => $category->id,
                        ]);
                                
                } else {
                        $this->actingAs($user)->delete(route('categories.destroy', $category->id));
                                
                        $this->assertDatabaseHas('categories', [
                                'id' => $category->id,
                        ]);
                }
        }
}
