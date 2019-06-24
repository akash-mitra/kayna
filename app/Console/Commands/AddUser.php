<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add {name} {email} {password} {type=admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds a new user to the system';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');
        $type = $this->argument('type');

        // TODO validation needed for the arguments

        DB::table('users')->insert([
            'name' => $name,
            'email' => $email,
            'type' => $type,
            'password' => bcrypt($password),
            'slug' => uniqid(mt_rand(0, 9999), true),
            'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $this->info('User ' . $name . ' added successfully');
    }
}
