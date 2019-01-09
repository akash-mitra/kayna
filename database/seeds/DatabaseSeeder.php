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

        // load default template

        // create default template associations
        DB::table('content_type_templates')->insert([
            'id' => 1,
            'type' => 'page',
            'template_id' => 1,
            'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
        ]);


        // create an admin user
        DB::table('users')->insert([
            'name' => 'Akash Mitra',
            'email' => 'akash.mitra@gmail.com',
            'password' => bcrypt('pakamala'),
            'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
        ]);

        
        $users = factory(App\User::class, 5)
            ->create()
            ->each(function ($user) {

                factory(App\Page::class, 5)
                    ->create(['user_id' => $user->id])
                    ->each(function ($page) {
                        $page->content()->save(factory(App\PageContent::class)->make());
                    });
                
            });

        
    }
}
