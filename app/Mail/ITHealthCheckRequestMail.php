<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ITHealthCheckRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $itHealthCheckRequest;
    public $company;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($itHealthCheckRequest, $company)
    {
        $this->itHealthCheckRequest = $itHealthCheckRequest;
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
            ->view('emails.it-health-check-request')->subject('Free IT Health Check request - ' . config('services.site.name'));
    }
}
