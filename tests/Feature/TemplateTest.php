<?php

namespace Tests\Feature;

use DB;
use App\Template;
use Tests\TestCaseSetup;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/**
 * Tests for Template
 * 
 */
class TemplateTest extends TestCaseSetup
{
    //---------------------------------------------------------------------------------------------------------
    // TemplateController@index
    public function test_admin_can_index_for_all_templates()
    {
        $t = $this->createFakeTemplate(Str::random());
    
        $this->actingAs($this->user_admin)
                    ->get(route('templates.index'))
                    ->assertOk()
                    ->assertViewHas('templates')
                   ->assertSee($t->description);

        $this->deleteFakeTemplatesDirectory([
            $t->name
        ]); 
    }


    // TemplateController@create
    public function test_admin_can_open_create_page ()
    {
        return $this->ActingAs($this->user_admin)->get(route('templates.create'))->assertOk();
    }


    // TemplateController@store
    public function test_admin_can_save_a_valid_template ()
    {
        $template = [
            "name" => "My-N3w_awesome_Template",
            "description" => "A template for testing"
        ];

        $this->ActingAs($this->user_admin)
            ->post(route('templates.store', $template))
            ->assertRedirect();    
            
        $this->assertDatabaseHas('templates', [
            'name' => $template['name']
        ]);

        $this->deleteFakeTemplatesDirectory ([$template['name']]);
    }


    // TemplateController@edit
    public function test_admin_can_view_the_edit_screen ()
    {
        $fakeTemplate = $this->createFakeTemplate('editScreenCheckTemplate', ['home.blade.php', 'main123.js']);

        $this->ActingAs($this->user_admin)
            ->get(route('templates.edit', $fakeTemplate->id))

            // check that the same template is loaded
            ->assertSee($fakeTemplate->name)
            ->assertSee($fakeTemplate->description)

            // check the files of the templates are also shown
            ->assertSee('main123.js')
            ;
        
        $this->deleteFakeTemplatesDirectory ([$fakeTemplate->name]);
    }


    //TemplateFileController@form
    public function test_admin_can_view_standard_files_in_template ()
    {
        $contentSignature = Str::random(20);

        $fakeTemplate = $this->createFakeTemplate('random1', ['category.blade.php', 'home.blade.php', 'page.blade.php', 'profile.blade.php'], $contentSignature);

        $this->actingAs($this->user_admin)
            ->get(route('templates.file', [$fakeTemplate->id, 'home']))
            ->assertSee($contentSignature);

        $this->actingAs($this->user_admin)
        ->get(route('templates.file', [$fakeTemplate->id, 'page']))
        ->assertSee($contentSignature);

        $this->actingAs($this->user_admin)
        ->get(route('templates.file', [$fakeTemplate->id, 'category']))
        ->assertSee($contentSignature);

        $this->actingAs($this->user_admin)
        ->get(route('templates.file', [$fakeTemplate->id, 'profile']))
        ->assertSee($contentSignature);
        
        $this->deleteFakeTemplatesDirectory ([$fakeTemplate->name]);
    }


    public function test_admin_can_view_non_standard_files_in_template ()
    {
        $contentSignature = Str::random(20);

        $fakeTemplate = $this->createFakeTemplate('random2', ['home.blade.php', 'application.css'], $contentSignature);

        $url = route('templates.file', [$fakeTemplate->id, 'other']) . '?filename=' . 'application.css';

        $this->actingAs($this->user_admin)
            ->get($url)
            ->assertSee($contentSignature);

        $this->deleteFakeTemplatesDirectory ([$fakeTemplate->name]);
    }

    //TemplateFileController@save
    public function test_admin_can_save_a_non_standard_template_file ()
    {
        $contentSignature = Str::random(20);

        $fakeTemplate = $this->createFakeTemplate('random3', ['home.blade.php', 'application.css']);

        $this->actingAs($this->user_admin)
            ->post(route('templates.file.save', [$fakeTemplate->id, 'other']), [
                'data' => $contentSignature,
                'filename' => 'abcd.js'
            ]);

        // check the file exists in the directory
        Storage::disk('local')->assertExists('templates/'. $fakeTemplate->name .'/abcd.js');

        // read the file and check the contents are as expected
        $this->assertEquals($contentSignature, Storage::disk('local')->get('templates/'. $fakeTemplate->name .'/abcd.js'));

        $this->deleteFakeTemplatesDirectory ([$fakeTemplate->name]);

    }

    public function test_admin_can_save_a_standard_template_file ()
    {
        $fakeTemplate = $this->createFakeTemplate(Str::random(10));
        $homeData = Str::random(20);
        $pageData = Str::random(20);
        $categoryData = Str::random(20);
        $profileData = Str::random(20);

        
        // home template
        $this->actingAs($this->user_admin)
            ->post(route('templates.file.save', [$fakeTemplate->id, 'home']), [
                'data' => $homeData
            ]);

        // category template
        $this->actingAs($this->user_admin)
            ->post(route('templates.file.save', [$fakeTemplate->id, 'category']), [
                'data' => $categoryData
            ]);

        // profile template
        $this->actingAs($this->user_admin)
            ->post(route('templates.file.save', [$fakeTemplate->id, 'profile']), [
                'data' => $profileData
            ]);

        // page template
        $this->actingAs($this->user_admin)
            ->post(route('templates.file.save', [$fakeTemplate->id, 'page']), [
                'data' => $pageData
            ]);

        // check the file exists in the directory
        Storage::disk('local')->assertExists('templates/'. $fakeTemplate->name .'/home.blade.php');
        Storage::disk('local')->assertExists('templates/'. $fakeTemplate->name .'/category.blade.php');
        Storage::disk('local')->assertExists('templates/'. $fakeTemplate->name .'/profile.blade.php');
        Storage::disk('local')->assertExists('templates/'. $fakeTemplate->name .'/page.blade.php');

        // read the file and check the contents are as expected
        $this->assertEquals($homeData, Storage::disk('local')->get('templates/'. $fakeTemplate->name .'/home.blade.php'));
        $this->assertEquals($categoryData, Storage::disk('local')->get('templates/'. $fakeTemplate->name .'/category.blade.php'));
        $this->assertEquals($profileData, Storage::disk('local')->get('templates/'. $fakeTemplate->name .'/profile.blade.php'));
        $this->assertEquals($pageData, Storage::disk('local')->get('templates/'. $fakeTemplate->name .'/page.blade.php'));

        $this->deleteFakeTemplatesDirectory ([$fakeTemplate->name]);
    }


    // TemplateController@setDefault
    public function test_admin_can_set_another_template_as_default ()
    {
        $cssFileName = Str::random(10) . '.css';
        $contentSignature = Str::random(25);

        /**
         * Since I have not used a fake disk, changing the active template
         * will also replace the real active template with fake template.
         * Therefore, I will find the real active template and backup
         * the template files first so that I can restore them later
         */
        $this->backupRealTemplateFiles();

        // dd($currentActiveTemplate);

        $fakeTemplate = $this->createFakeTemplate(Str::random(10), ['home.blade.php', $cssFileName], $contentSignature);

        $this->actingAs($this->user_admin)
            ->post(route('templates.setDefault'), [
                'template_id' => $fakeTemplate->id
            ]);

        // check in the database that only this template is active
        $activeTemplate = Template::where('active', 'Y')->first();
        $this->assertEquals($fakeTemplate->id, $activeTemplate->id);

        // check that all the files of the new default template has 
        // been moved to correct directories (standard files in   
        // resources/views and static files in public directory)
        Storage::disk('resources')->assertExists('views/home.blade.php');
        $this->assertEquals($contentSignature, Storage::disk('local')->get('templates/'. $fakeTemplate->name .'/home.blade.php'));
        Storage::disk('public')->assertExists($cssFileName);

        // cleanup
        $this->deleteFakeTemplatesDirectory ([$fakeTemplate->name]);
        // non-standard files need to be explicitely deleted 
        // as that will be in the public directory
        Storage::disk('public')->delete($cssFileName);
        
        // restore the original
        $this->restoreRealTemplateFiles();
    }



    // TemplateController@destroy
    //TODO
    
    



    //---------------------------------------------------------------------------------------------------------
    
    public function deleteFakeTemplatesDirectory(array $templates) : void
    {
        foreach($templates as $templateName) 
        {
            $template = 'templates/' . $templateName;
            // var_dump ($template);
            Storage::disk('local')->deleteDirectory($template);
        }
    }


    private function createFakeTemplate($name, $fileNames = [], $contentSignature = null)
    {
        // create template table entry
        DB::table('templates')->insert([
            'name' => $name, 
            'description' => Str::random(50),
            'active' => 'N',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // create template directory
        Storage::disk('local')->makeDirectory('templates/' . $name);

        // add some template files to the template
        foreach($fileNames as $fileName) {
            $this->addFileToTemplate($name, $fileName, $contentSignature);
        }
        
        // retrieve the just created light template
        return Template::where('name', $name)->first();
    }




    private function addFileToTemplate ($templateName, $fileName, $content = null)
    {
        if ($content === null) $content = 'TEST content for ' . $fileName . ' under template ' . $templateName . ' >> ' . Str::random(100) . ' << ';

        Storage::disk('local')->put('templates/'. $templateName .'/' . $fileName, $content);
    }
        

    private function backupRealTemplateFiles()
    {
        Storage::disk('resources')->rename('views/home.blade.php', 'views/home.blade.php.backup');
        Storage::disk('resources')->rename('views/page.blade.php', 'views/page.blade.php.backup');
        Storage::disk('resources')->rename('views/category.blade.php', 'views/category.blade.php.backup');
        Storage::disk('resources')->rename('views/profile.blade.php', 'views/profile.blade.php.backup');
    }


    private function restoreRealTemplateFiles()
    {
        $this->deleteIfExists('views/home.blade.php');
        $this->deleteIfExists('views/page.blade.php');
        $this->deleteIfExists('views/category.blade.php');
        $this->deleteIfExists('views/profile.blade.php');

        
        Storage::disk('resources')->rename('views/home.blade.php.backup', 'views/home.blade.php');
        Storage::disk('resources')->rename('views/page.blade.php.backup', 'views/page.blade.php');
        Storage::disk('resources')->rename('views/category.blade.php.backup', 'views/category.blade.php');
        Storage::disk('resources')->rename('views/profile.blade.php.backup', 'views/profile.blade.php');
    }

    private function deleteIfExists($fileName)
    {
        if (Storage::disk('resources')->exists($fileName)) {
            Storage::disk('resources')->delete($fileName);
        }
    }
}
