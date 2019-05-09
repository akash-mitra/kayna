<?php

namespace Tests\Feature;

use App\Page;
use App\PageContent;
use Tests\TestCaseSetup;

class PageTest extends TestCaseSetup
{

    public function test_a_page_can_be_created_by_admin()
    {
        $this->test_a_page_can_be_created_by ($this->user_admin);
    }

    
}
