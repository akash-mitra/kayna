<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // create an admin user
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'type' => 'admin',
            'password' => bcrypt('secret'),
            'slug' => uniqid(mt_rand(0, 9999), true),
            'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
        ]);

        // create default template associations
        DB::table('content_type_templates')->insert([
            'id' => 1,
            'type' => 'page',
            'template_id' => 1,
            'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
        ]);

        // create config file entries
        DB::table('parameters')->insert(['key' => 'installation', 'value' => '1']);
        
        DB::table('parameters')->insert(['key' => 'login_native_active', 'value' => 'yes']);
        DB::table('parameters')->insert(['key' => 'login_google_active', 'value' => 'no']);
        DB::table('parameters')->insert(['key' => 'login_facebook_active', 'value' => 'no']);
        DB::table('parameters')->insert(['key' => 'login_google_client_id', 'value' => '']);
        DB::table('parameters')->insert(['key' => 'login_google_client_secret', 'value' => '']);
        DB::table('parameters')->insert(['key' => 'login_facebook_client_id', 'value' => '']);
        DB::table('parameters')->insert(['key' => 'login_facebook_client_secret', 'value' => '']);
        DB::table('parameters')->insert(['key' => 'storage_s3_active', 'value' => 'no']);
        DB::table('parameters')->insert(['key' => 'storage_s3_bucket', 'value' => '']);
        DB::table('parameters')->insert(['key' => 'storage_s3_secret', 'value' => '']);
        DB::table('parameters')->insert(['key' => 'storage_s3_key', 'value' => '']);
        DB::table('parameters')->insert(['key' => 'storage_s3_region', 'value' => '']);

        

        // $users = factory(App\User::class, 5)
        //     ->create()
        //     ->each(function ($user) {

        //         factory(App\Page::class, 5)
        //             ->create(['user_id' => $user->id])
        //             ->each(function ($page) {
        //                 $page->content()->save(factory(App\PageContent::class)->make());
        //             });
        //     });
    }
}
