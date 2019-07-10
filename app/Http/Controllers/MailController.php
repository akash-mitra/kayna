<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class MailController extends Controller
{

    /**
     * shows a list of available email templates
     */
    public function index () 
    {
        $templates = $this->findOrFailMailInfo();
        return view('admin.mails.index', compact('templates'));
    }



    /**
     * Shows a form to edit the contents of a mail
     */
    public function standardForm($mailSlug)
    {
        $mail = $this->findOrFailMailInfo($mailSlug);

        if (Storage::disk('resources')->exists($mail['file']))
        {
            $mail['contents'] = Storage::disk('resources')->get($mail['file']);
        } 
        else {
            $mail['contents'] = $this->populateDefaultContent();
        }
        
        return view('admin.mails.form', $mail);
    }



    /**
     * Creates or updates the template of a mail file.
     */
    public function createOrUpdate (Request $request)
    {
        $request->validate([
            'mail_file_name' => 'required',
            'mail_content' => 'required'
        ]);

        $mailFileName = $request->input('mail_file_name');
        $content = $request->input('mail_content');

        $mail = $this->findOrFailMailInfo($mailFileName);

        if (empty ($mail)) {
            // this is a new, non-standard email template
            $this->saveNonStandardEmail($mail, $content);
        } else {
            // this is a standard email
            $this->saveStandardEmail($mail, $content);
        }

        session()->flash('flash', 'Mail template saved successfully');

        return back();
        
    }


    /**
     * Activates an email template
     */
    public function changeState ($mailSlug, Request $request)
    {
        $request->validate([
            'active'=> 'required'
        ]);

        $active = $request->input('active');

        // If there is a request to enable the mail,
        // perform below additional checks.
        if ($active == '1') {

            $this->ensureTemplateFileExists($mailSlug);
            $this->ensureMailServiceIsDefined();
        }

        // change the state
        param(
            $this->getParamName($mailSlug), 
            $active
        );

        return [
            'status' => 'success'
        ];

    }



    /**
     * Finds a particular mail by the mail slug.
     */
    private function findOrFailMailInfo ($mailSlug = null) 
    {
        $standardEmails = [
            [
                "slug" => "welcome_user_email",
                "name" => "New User Welcome Email",
                "event" => "This email is fired when a new user successfully registers in the site",
                "file" => "views/emails/standard/WelcomeUserEmail.blade.php",
                "url" => route('mails.standard.form', 'welcome_user_email'),
                "active" => alt(param($this->getParamName('welcome_user_email')), false),
            ],
        ];

        if (empty($mailSlug)) return $standardEmails;

        $found = array_filter($standardEmails, function ($mail) use ($mailSlug) {
            return $mail['slug'] === $mailSlug;
        });

        if ($found) return $found[0];

        abort(404);
    }



    private function saveNonStandardEmail($mail, $content)
    {
        //TODO
    }

    
    private function saveStandardEmail($mail, $content)
    {
        return Storage::disk('resources')->put($mail['file'], $content);
    }


    /**
     * Throws an exception if the template file does not exist/
     */
    private function ensureTemplateFileExists ($slug)
    {
        $mail = $this->findOrFailMailInfo($slug);

        abort_if(
            ! Storage::disk('resources')->exists($mail['file']), 
            400, 
            'Mail Template Missing'
        );
    }


    private function populateDefaultContent()
    {
        return "@component('mail::message') \n\n@endcomponent";
    }

    private function getParamName ($slug)
    {
        return 'active_' . $slug;
    }


    private function ensureMailServiceIsDefined ()
    {
        abort_if(
            empty(param('mail_service')), 
            400, 
            'Mail service is not defined'
        );
    }
    
}
