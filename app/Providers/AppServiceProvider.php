<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Swift_SmtpTransport;
use Swift_Mailer;
use Illuminate\Mail\Mailer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // define a custom mailer with suctom smtp settings
        $this->app->bind('BlogMail', function ($app, $parameters) {

            $transport = new Swift_SmtpTransport($parameters->host, $parameters->port);
            $transport->setUsername($parameters->username);
            $transport->setPassword($parameters->password);
            $transport->setEncryption($parameters->encryption);

            $swift_mailer = new Swift_Mailer($transport);

            $mailer = new Mailer($app->get('view'), $swift_mailer, $app->get('events'));

            // $mailer->alwaysFrom($from_email, $from_name);
            // $mailer->alwaysReplyTo($from_email, $from_name);

            return $mailer;
        });
    }
}
