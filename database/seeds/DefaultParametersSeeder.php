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
        $this->addIfMissing('installation', '1');

        // login related
        $this->addIfMissing('login_native_active', 'no');
        $this->addIfMissing('login_google_active', 'no');
        $this->addIfMissing('login_facebook_active', 'no');
        $this->addIfMissing('login_google_client_id', '');
        $this->addIfMissing('login_google_client_secret', '');
        $this->addIfMissing('login_facebook_client_id', '');
        $this->addIfMissing('login_facebook_client_secret', '');

        // storage related
        $this->addIfMissing('storage_s3_active', 'no');
        $this->addIfMissing('storage_s3_bucket', '');
        $this->addIfMissing('storage_s3_secret', '');
        $this->addIfMissing('storage_s3_key', '');
        $this->addIfMissing('storage_s3_region', '');

        // editor
        $this->addIfMissing('editor', 'plain');

        // feeds
        $this->addIfMissing('enable_site_feeds', 'yes');

        // mail related
        $this->addIfMissing('mail_service', 'google');
        $this->addIfMissing('mail_driver', 'smtp');
        $this->addIfMissing('mail_host', '');
        $this->addIfMissing('mail_port', '587');
        $this->addIfMissing('mail_name', '');
        $this->addIfMissing('mail_username', '');
        $this->addIfMissing('mail_password', '');
        $this->addIfMissing('mail_encryption', 'tls');
        
    }
    

    /**
     * Adds a key value pair to the database if the key is not
     * already present in the database. 
     */
    private function addIfMissing ($key, $value)
    {
        if (! DB::table('parameters')->where('key', trim($key))->exists()) {
            
            DB::table('parameters')->insert([
                'key' => trim($key), 
                'value' => $value, 
                'created_at' => now()
            ]);
        }
    }
}
