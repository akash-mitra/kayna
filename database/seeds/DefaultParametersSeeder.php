<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultParametersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
    }
}
