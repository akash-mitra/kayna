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

    protected $light, $dark;
    protected $tearDownList = [];
    protected $lightTemplate, $darkTemplate;

    /*
    *-----------------------------------------------------------
    * Create two initial templates
    *-----------------------------------------------------------
    */
    protected function setUp(): void
    {
        parent::setUp();

        // define a LIGHT template
        $this->lightTemplate = new Template([
            'name' => 'light_' . Str::random(10),
            'description' => Str::random(50)
        ]);
        // create that light template
        $this->lightTemplate = $this->createTemplate(
            $this->lightTemplate->name, 
            $this->lightTemplate->description,
            'Y'
        );
        // add some template files to the light template
        $this->addFileToTemplate($this->lightTemplate, 'home.blade.php', 'some random html code here');
        $this->addFileToTemplate($this->lightTemplate, 'application.css', 'some random css code here');
        


        // define a DARK template
        $this->darkTemplate = new Template([
            'name' => 'dark_' . Str::random(10),
            'description' => Str::random(50)
        ]);
        // create that dark template
        $this->darkTemplate = $this->createTemplate(
            $this->darkTemplate->name, 
            $this->darkTemplate->description
        );
        // add some template files to the dark template
        $this->addFileToTemplate($this->darkTemplate, 'page.blade.php', 'some random html code here for dark template');
        $this->addFileToTemplate($this->darkTemplate, 'main.js', 'some random javascript code here for dark template');
        
    }



    //---------------------------------------------------------------------------------------------------------
    // TemplateController@index
    public function test_admin_can_index_all_templates()
    {
        return $this->actingAs($this->user_admin)
                    ->get(route('templates.index'))
                    ->assertOk()
                    ->assertViewHas('templates')
                    ->assertSee($this->lightTemplate->description);
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
            
        $this->markForTearDown ($template['name']);

        $this->assertDatabaseHas('templates', [
            'name' => $template['name']
        ]);
    }


    // TemplateController@store
    public function test_admin_can_view_the_edit_screen ()
    {
        
        $this->ActingAs($this->user_admin)
            ->get(route('templates.edit', $this->lightTemplate->id))

            // check that the same template is loaded
            ->assertSee($this->lightTemplate->name)
            ->assertSee($this->lightTemplate->description)

            // check the files of the templates are also shown
            ->assertSee('application.css')
            ;
     
    }


    //TemplateFileController@form
    public function test_admin_can_view_standard_files_in_template ()
    {
        $this->actingAs($this->user_admin)
            ->get(route('templates.file', [$this->lightTemplate->id, 'home']))
            ->assertSee('some random html code here');
    }


    public function test_admin_can_view_non_standard_files_in_template ()
    {
        $url = route('templates.file', [$this->lightTemplate->id, 'other']) . '?filename=' . 'application.css';

        $this->actingAs($this->user_admin)
            ->get($url)
            ->assertSee('some random css code here');
    }

    //TemplateFileController@save
    public function test_admin_can_save_a_non_standard_template_file ()
    {
        $this->actingAs($this->user_admin)
            ->post(route('templates.file.save', [$this->lightTemplate->id, 'other']), [
                'data' => 'some random data here',
                'filename' => 'abcd.js'
            ]);

        // check the file exists in the directory
        Storage::disk('local')->assertExists('templates/'. $this->lightTemplate->name .'/abcd.js');

        // read the file and check the contents are as expected
        $this->assertEquals('some random data here', Storage::disk('local')->get('templates/'. $this->lightTemplate->name .'/abcd.js'));

    }

    public function test_admin_can_save_a_standard_template_file ()
    {
        // category template
        $this->actingAs($this->user_admin)
            ->post(route('templates.file.save', [$this->lightTemplate->id, 'category']), [
                'data' => 'some random data for category file'
            ]);

        // profile template
        $this->actingAs($this->user_admin)
            ->post(route('templates.file.save', [$this->lightTemplate->id, 'profile']), [
                'data' => 'some random data for profile file'
            ]);

        // page template
        $this->actingAs($this->user_admin)
            ->post(route('templates.file.save', [$this->lightTemplate->id, 'page']), [
                'data' => 'some random data for page file'
            ]);

        // check the file exists in the directory
        Storage::disk('local')->assertExists('templates/'. $this->lightTemplate->name .'/category.blade.php');
        Storage::disk('local')->assertExists('templates/'. $this->lightTemplate->name .'/profile.blade.php');
        Storage::disk('local')->assertExists('templates/'. $this->lightTemplate->name .'/page.blade.php');

        // read the file and check the contents are as expected
        $this->assertEquals('some random data for category file', Storage::disk('local')->get('templates/'. $this->lightTemplate->name .'/category.blade.php'));
        $this->assertEquals('some random data for profile file', Storage::disk('local')->get('templates/'. $this->lightTemplate->name .'/profile.blade.php'));
        $this->assertEquals('some random data for page file', Storage::disk('local')->get('templates/'. $this->lightTemplate->name .'/page.blade.php'));
    }


    // TemplateController@setDefault
    public function test_admin_can_set_another_template_as_default ()
    {
        // In the initial setup we set the light template as the default
        // template. In this test, we will try to set the dark template
        // as the default template and see if that works

        $this->actingAs($this->user_admin)
            ->post(route('templates.setDefault'), [
                'template_id' => $this->darkTemplate->id
            ]);

        // check in the database that only this template is active
        $activeTemplate = Template::where('active', 'Y')->first();
        $this->assertEquals($this->darkTemplate->id, $activeTemplate->id);

        // check that all the files of the dark template has been moved to 
        // correct directories (standard files in resources/views and static
        // files in public directory)
        Storage::disk('resources')->assertExists('views/page.blade.php');
        Storage::disk('public')->assertExists('main.js');
    }



    // TemplateController@destroy
    


    //---------------------------------------------------------------------------------------------------------
    /**
     * Tear Down processes
     */
    public function tearDown() : void
    {

        array_map(function ($templateName) {
            
            Storage::disk('local')->deleteDirectory('templates/' . $templateName);

        }, $this->tearDownList);
        
        DB::table('templates')->where('name', $this->lightTemplate->name)->delete();

        parent::tearDown();

    }


    /**
     * To keep track of all the templates created during the 
     * testing process so that the directories of those 
     * templates can be deleted during teardown.
     */
    private function markForTearDown ($templateName)
    {
        array_push($this->tearDownList, $templateName);
    }


    /**
     * A useful private method to create a random template
     */
    private function createTemplate($name, $description = 'some random template for testing', $default = 'N') 
    {

        // create template table entry
        DB::table('templates')->insert([
            'name' => $name, 
            'description' => $description,
            'active' => $default,
            'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
        ]);

        // create template directory
        Storage::disk('local')->makeDirectory('templates/' . $name);

        $this->markForTearDown($name);
        
        // retrieve the id of the just created light template
        return Template::where('name', $name)->first();
    }


    private function addFileToTemplate ($template, $filename, $content)
    {
        Storage::disk('local')->put('templates/'. $template->name .'/' . $filename, $content);
    }
        
}
