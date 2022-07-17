<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InfrastructureAuditRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $InfrastructureAuditRequest;
    public $company;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($InfrastructureAuditRequest, $company)
    {
        $this->InfrastructureAuditRequest = $InfrastructureAuditRequest;
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
            ->view('emails.infrastructure-audit-request')->subject('MWC - Infrastructure Audit Request');
    }
}
