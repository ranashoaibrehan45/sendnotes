<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Note;
use Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Note $note)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $noteUrl = route('notes.view', ['note' => $this->note]);

        $emailContent = "Hello, You've received a new note. View it here: {$noteUrl}";

        Mail::raw($emailContent, function ($message) {
            $message->from('info@sendnotes.com', 'Send Notes');
            $message->to($this->note->recipient);
            $message->subject('You have a new note from '. $this->note->user->name);
        });
    }
}
