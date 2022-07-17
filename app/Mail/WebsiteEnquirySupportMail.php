<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WebsiteEnquirySupportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $websiteEnquiry;

    public $company;

    public $serviceType;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($websiteEnquiry, $serviceType, $company)
    {
        $this->websiteEnquiry = $websiteEnquiry;
        $this->company = $company;
        $this->serviceType = $serviceType;
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

        return $this->from($fromEmail, $siteName)
            ->view('emails.start-conversation')->subject('Website start conversation - ' . config('services.site.name'));
    }
}
