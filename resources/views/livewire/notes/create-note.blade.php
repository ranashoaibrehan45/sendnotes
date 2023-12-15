<?php

use Livewire\Volt\Component;

new class extends Component {
    public $title;
    public $body;
    public $recipient;
    public $send_date;


    public function submit()
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'min:5'],
            'body' => ['required', 'string', 'min:20'],
            'recipient' => ['required', 'email'],
            'send_date' => ['required', 'date'],
        ]);

        Auth::user()->notes()->create($validated);

        return redirect()->route('notes.index');
    }
}; ?>

<div>
    <form wire:submit='submit' class="space-y-4">
        <x-input wire:model='title' label="Note Title" placeholder="It's been a great a day" />
        <x-textarea wire:model='body' label="Your Note" placeholder="Share all your thoughts with your fiends" />
        <x-input type="email" wire:model='recipient' label="Recipient" placeholder="friend@email.com" icon="user" />
        <x-input type='date' wire:model='send_date' label="Send Date" icon="calendar" />
        
        <div class="pt-5">
            <x-button primary type="submit" right-icon="calendar">Schedule Note</x-button>
        </div>

        <x-errors></x-errors>
    </form>
</div>
