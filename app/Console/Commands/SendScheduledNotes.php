<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendEmail;

class SendScheduledNotes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-scheduled-notes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = \Carbon\Carbon::now();

        $notes = \App\Models\Note::where('is_published', true)
            ->where('send_date', $now->toDateString())
            ->get();

        $notesCount = $notes->count();

        $this->info("Sending {$notesCount} scheduled notes");

        foreach ($notes as $note) {
            SendEmail::dispatch($note);
        }
    }
}
