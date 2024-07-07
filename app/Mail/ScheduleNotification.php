<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use App\Models\SidangTa;

class ScheduleNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $sidang_ta;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(SidangTa $sidang_ta)
    {
        $this->sidang_ta = $sidang_ta;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Pemberitahuan Jadwal Sidang TA')
            ->view('emails.schedule_notification')
            ->with('sidang_ta', $this->sidang_ta);
    }
    /**
     * Get the message envelope.
     */

}
