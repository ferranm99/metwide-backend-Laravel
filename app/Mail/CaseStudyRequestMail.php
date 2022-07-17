<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CaseStudyRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $caseStudyRequest;
    public $company;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($caseStudyRequest, $company)
    {
        $this->caseStudyRequest = $caseStudyRequest;
        $this->company = $company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $location = storage_path('download/case-studies/case-study-template.pdf');

        $fromEmail = 'info@' . config('services.site.domain');
        $siteName = config('services.site.name');

        return $this->from($fromEmail, $siteName)
            ->view('emails.case-study-request')
            ->subject('Case Study request - ' . config('services.site.name'))
            ->attach($location);
    }
}
