<?php

namespace App\Providers;

use Swift_Mailer;
use Swift_SmtpTransport;
use Illuminate\Mail\Mailer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class BlogEmailServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // define a custom mailer with custom smtp settings
        $this->app->bind('blog.mail', function ($app, $parameters) {

            $transport = new Swift_SmtpTransport($parameters['host'], $parameters['port']);
            $transport->setUsername($parameters['username']);
            $transport->setPassword($parameters['password']);
            $transport->setEncryption($parameters['encryption']);

            $swift_mailer = new Swift_Mailer($transport);

            $mailer = new Mailer($app->get('view'), $swift_mailer, $app->get('events'));
            $mailer->alwaysFrom($parameters['username'], $parameters['name']);
            // $mailer->alwaysReplyTo($from_email, $from_name);
            dump('service provider executed');
            
            return $mailer;
        });
    }



    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['blog.mail'];
    }



    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
