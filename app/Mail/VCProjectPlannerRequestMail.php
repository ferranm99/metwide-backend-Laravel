<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VCProjectPlannerRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $projectPlannerRequest;
    public $company;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($projectPlannerRequest, $company)
    {
        $this->projectPlannerRequest = $projectPlannerRequest;
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
            ->view('emails.vc-project-planner-request')->subject('MWC - Videoconferencing project planner request - ' . config('services.site.name'));
    }
}
