<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
// use Symfony\Component\Process\Exception\ProcessFailedException;

class UpdateApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the blog application with the latest stable code version.';

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

        //TODO - should we put the below code?
        // #!/bin/sh
        // unset $(git rev-parse --local-env-vars)
        // cd /usr/local/apache2/htdocs/project_uat

        // env -i git reset --hard
        // env -i git clean -f -d
        // env -i git pull
        // php artisan cache:clear
        // php artisan config:cache
        // php artisan route:cache
        // php artisan optimize

        $commands = [
            'git pull origin master',
            'composer install --no-interaction --no-dev --prefer-dist',
            'php artisan migrate --force',
            'php artisan cache:clear',
            'php artisan config:cache',
            'php artisan queue:restart',
        ];

        $commandResults = [];

        foreach($commands as $command) {

            $result = [
                'command' => $command,
                'success' => false,
                'message' => '',
                'starttime' => now(),
                'endtime' => null
            ];

            //dump ($command);

            try {

                if (empty($process)) {
                    $process = new Process($command);
                } else {
                    $process->setCommandLine($command);
                }

                $process->run ();
                $result['success'] = true;
                $result['message'] = $process->getOutput();

            } catch (\Exception $e) {
                $result['message'] = $e->getMessage();
            }

            $result['endtime'] = now();

            if ( $process->isSuccessful() === false || $result['success'] === false) {
                $result['success'] = false;
                break;

            } else {
                $result['success'] = true;
                array_push($commandResults, $result); 
            }
        }

        $this->table(['command', 'success', 'message', 'starttime', 'endtime'], $commandResults);
    }

}
