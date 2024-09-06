<?php

namespace App\Jobs;

use App\Mail\InviteMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendInviteJob implements ShouldQueue
{
    use Queueable;
    protected $email;
    protected $invite_link;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $invite_link)
    {
        $this->{'email'} = $email;
        $this->{'invite_link'} = $invite_link;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new InviteMail($this->{'invite_link'}));
    }
}
