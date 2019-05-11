<?php

namespace Tests\Feature;

use App\Page;
use App\PageContent;
use Tests\TestCaseSetup;

class PageTest extends TestCaseSetup
{

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
}
