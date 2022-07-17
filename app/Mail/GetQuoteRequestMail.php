<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GetQuoteRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bookDemoRequest;
    public $company;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($bookDemoRequest, $company)
    {
        $this->bookDemoRequest = $bookDemoRequest;
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

        return $this->from($fromEmail, $siteName)
            ->view('emails.get-quote-request')->subject('MWC website get quote request - ' . config('services.site.name'));
    }
}
