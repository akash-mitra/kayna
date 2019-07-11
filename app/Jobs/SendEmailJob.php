<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;


/**
 * This is a generic Email Queue for the application.
 * This email queue allows us to use the custom
 * SMTP configuration parameters as needed.
 */
class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $parameters;
    public $to;
    public $mailable;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $to, Mailable $mailable)
    {
        $this->to = $to;
        $this->mailable = $mailable;
        $this->parameters =  $this->getMailTransportParameters();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mailer = app()->makeWith('blog.mail', $this->parameters);

        $mailer->to($this->to)->send($this->mailable);
    }



    /**
     * Validate all necessary parameters for emailing are present.
     * Some of the parameters can be enriched with default values
     * even if the parameter values are missing.
     */
    private function getMailTransportParameters ()
    {
        $parameters = [
            'host'       => param('mail_host'),
            'port'       => param('mail_port'),
            'name'       => param('mail_name'),
            'username'   => param('mail_username'),
            'password'   => param('mail_password'),
            'encryption' => param('mail_encryption'),
        ];

        $service = param('mail_service');
        
        // additional parametes based on specific mail 
        // services can be added here
        if ($service === 'google') {
            return $this->updateGmailParameters($parameters);
        }

        return $parameters;
    }


    private function updateGmailParameters ($parameters)
    {
        $parameters['mail_host'] = 'smtp.gmail.com';
        $parameters['mail_port'] = '587';
        $parameters['mail_encryption'] = 'tls';

        return $parameters;
    }
}
