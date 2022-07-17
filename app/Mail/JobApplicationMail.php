<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $jobApplicationRequest;
    public $company;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($jobApplicationRequest, $company)
    {
        $this->jobApplicationRequest = $jobApplicationRequest;
        $this->company = $company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fromEmail = 'info@' . config('services.site.domain');
        $siteName = config('services.site.name');

        $mail = $this->from($fromEmail, $siteName)
            ->view('emails.job-application-submit')
            ->subject('Job application - ' . config('services.site.name'));


        if ($this->jobApplicationRequest['resume']) {
            $mail->attach(
                $this->jobApplicationRequest['resume']->getRealPath(),
                [
                    'as' => $this->jobApplicationRequest['resume']->getClientOriginalName(),
                    'mime' => $this->jobApplicationRequest['resume']->getClientMimeType(),
                ]
            );
        }

        if ($this->jobApplicationRequest['coverLetter']) {
            $mail->attach(
                $this->jobApplicationRequest['coverLetter']->getRealPath(),
                [
                    'as' => $this->jobApplicationRequest['coverLetter']->getClientOriginalName(),
                    'mime' => $this->jobApplicationRequest['coverLetter']->getClientMimeType(),
                ]
            );
        }

        return $mail;
    }
}
