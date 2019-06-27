<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('templates')->insert([
            'name' => 'LightSail', 
            'description' => 'The default light theme template for BlogTheory.',
            'active' => 'Y',
            'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
        ]);
        
    }
}
