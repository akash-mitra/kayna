<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            
            // creates the default parameters
            DefaultParametersSeeder::class,

            // creates the entry for the default template
            DefaultTemplatesSeeder::class,

            
        ]);

        if (App::Environment() === 'local') 
        {
                $this->call([
                    AdminUserSeeder::class
                ]);
        }
    }
}
