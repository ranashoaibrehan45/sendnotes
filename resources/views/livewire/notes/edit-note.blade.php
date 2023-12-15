<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Note;

new #[Layout('layouts.app')] class extends Component {
    public Note $note;

    public $title;
    public $body;
    public $recipient;
    public $send_date;
    public $is_published;
 
    public function mount(Note $note)
    {
        $this->authorize('update', $note);
        $this->fill($note);
    }

    public function submit()
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'min:5'],
            'body' => ['required', 'string', 'min:20'],
            'recipient' => ['required', 'email'],
            'send_date' => ['required', 'date'],
            'is_published' => ['nullable'],
        ]);

        $this->note->update($validated);

        $this->dispatch("Note saved!");
    }
}; ?>

<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Edit Note') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="p-6 text-gray-900">
            <form wire:submit='submit' class="space-y-4">
                <x-input wire:model='title' label="Note Title" placeholder="It's been a great a day" />
                <x-textarea wire:model='body' label="Your Note" placeholder="Share all your thoughts with your fiends" />
                <x-input type="email" wire:model='recipient' label="Recipient" placeholder="friend@email.com" icon="user" />
                <x-input type='date' wire:model='send_date' label="Send Date" icon="calendar" />
                <x-checkbox label="Is published" wire:model='is_published'>Published</x-checkbox>

                <div class="flex justify-between pt-5">
                    <x-button type="submit" secondary spiner="submit">Save Note</x-button>
                    <x-button href="{{route('notes.index')}}" flat negative>Back to Notes</x-button>
                </div>
        
                <x-action-message on="submit"></x-action-message>
                <x-errors></x-errors>
            </form>
        </div>
    </div>
</div>
