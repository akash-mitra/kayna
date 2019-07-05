<?php

namespace Tests\Feature;

use DB;
use App\Media;
use Tests\TestCaseSetup;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * This tests various controller end points 
 * pertaining to Media controller
 * 
 */
class MediaTest extends TestCaseSetup
{

    /**
     * Tests for the MediaController@index method
     */

    public function test_author_can_load_index_page_successfully ()
    {
        $this->actingAs($this->user_author)->get(route('media.index'))->assertSuccessful();
    }


    public function test_admin_can_load_index_page_successfully ()
    {
        $this->actingAs($this->user_admin)->get(route('media.index'))->assertSuccessful();
    }


    public function test_general_users_can_not_load_index_page_successfully ()
    {
        $this->actingAs($this->user_general)->get(route('media.index'))->assertForbidden();
    }



    /**
     * Tests for the MediaController@apiIndex method
     */

    public function test_author_can_access_json_api ()
    {
        $this->user_can_access_media_index_via_json_api($this->user_author);
    }


    public function test_general_user_can_not_access_json_api ()
    {
        $this->actingAs($this->user_general)
            ->get(route('api.media.index'))
            ->assertForbidden();
    }



    /**
     * Test that media files can be uploaded to local disk
     */
    public function test_author_can_upload_media_to_local()
    {
        param('storage_s3_active', 'no');
        
        $media = $this->assert_user_can_upload_media_to_a_disk($this->user_author);

        // cleanup
        $this->delete_media_from_a_disk($media['storage'], $media['path']);
    }


    /**
     * Test that media files can be uploaded to s3 disk
     */
    public function test_author_can_upload_media_to_s3()
    {
        param('storage_s3_active', 'yes');
        param('storage_s3_key', env('S3_KEY'));
        param('storage_s3_secret', env('S3_SECRET'));
        param('storage_s3_region', 'ap-southeast-1');
        param('storage_s3_bucket', 'bloggytest');
        
        $media = $this->assert_user_can_upload_media_to_a_disk($this->user_author);

        // cleanup
        $this->delete_media_from_a_disk($media['storage'], $media['path']);
    }



    public function test_admin_can_delete_media_from_local()
    {
        param('storage_s3_active', 'no');
        
        $this->assert_user_can_delete_media($this->user_admin);
    }



    public function test_admin_can_delete_media_from_s3()
    {
        param('storage_s3_active', 'yes');
        param('storage_s3_key', env('S3_KEY'));
        param('storage_s3_secret', env('S3_SECRET'));
        param('storage_s3_region', 'ap-southeast-1');
        param('storage_s3_bucket', 'bloggytest');
        
        $this->assert_user_can_delete_media($this->user_admin);
    }




    //-----------------------------------------------------------------------------------------------------
    /**
     * Other utility and private methods.
     */
    protected function user_can_access_media_index_via_json_api($user)
    {
        $imageNames = $this->createAndStoreFakeMedia(2);

        $this->actingAs($user)
            ->get(route('api.media.index'))
            ->assertSuccessful()
            ->assertJsonCount(2, 'data')
            ->assertJsonFragment([
                'name' => $imageNames[0],
                'storage' => 'public',
                'path' => 'media/' . $imageNames[0]
            ])
            ->assertJsonFragment([
                'name' => $imageNames[1],
                'storage' => 'public',
                'path' => 'media/' . $imageNames[1]
            ]);

        $this->deleteFakeMediaByNames($imageNames);
    }


    private function assert_user_can_upload_media_to_a_disk($user)
    {
        $disk = Media::configureAndGetDiskStorageType();

        $name = Str::random(15) . '.jpeg';
        $photo = UploadedFile::fake()->image($name);

        // upload the photo
        $response = $this->actingAs($user)
        ->post(route('media.store'), [
            'media' => $photo,
            'name' => $name
        ])->assertSuccessful();

        // get the response
        $mediaJson = $response->decodeResponseJson();

        // assess the file is stored locally
        Storage::disk($disk)->assertExists($mediaJson['path']);

        // assert that the file information is stored in database
        $this->assertDatabaseHas('media', [
            'name' => $mediaJson['name'],
            'path' => $mediaJson['path'],
            'url' => $mediaJson['url']
        ]);

        return $mediaJson;
    }


    private function assert_user_can_delete_media($user)
    {
        $mediaJson = $this->assert_user_can_upload_media_to_a_disk($this->user_author);

        $path = $mediaJson['path'];

        $this->actingAs($user)->delete(route('media.destroy', $mediaJson['id']));

        // confirm the media has been deleted from database
        $this->assertDatabaseMissing('media', [
            'path' => $path
        ]);
        
        // confirm the actual media file has been deleted
        Storage::disk($mediaJson['storage'])->assertMissing($path);
    }


    private function delete_media_from_a_disk($disk, $path)
    {
        return Storage::disk($disk)->delete($path);
    }


    private function createAndStoreFakeMedia($number)
    {
        $faker = new Faker;
        $imageNames = [];

        for ($i = 0; $i < $number; $i++) 
        {
            $image = $faker::create()->image('storage/app/public/media', 400, 300, null, false);

            array_push($imageNames, $image);

            DB::table('media')->insert([
                'name' => $image,
                'type' => 'jpeg',
                'storage' => 'public',
                'path' => 'media/' . $image,
                'size' => 0
            ]);
        }

        return $imageNames;
    }


    private function deleteFakeMediaByNames ($images)
    {
        foreach($images as $image) {
            Storage::disk('public')->delete('media/' . $image);
        }
    }

}
