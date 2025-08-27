<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;

class ContactForm extends Component
{
    public $name;
    public $email;
    public $phone_number;
    public $content;

    public $buttonText = 'Kirim Pesan';
    public $loading = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone_number' => 'required|string|max:20',
        'content' => 'required|string',
    ];

    public function submit()
    {
        $this->validate();

        $this->loading = true;
        $this->buttonText = 'Mengirim Pesan';

        sleep(1); // simulasi proses kirim

        Message::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'content' => $this->content,
        ]);

        $this->buttonText = 'Terkirim';
        $this->loading = false;

        $this->dispatch('messageCreated'); // <-- ini benar, method emit

        $this->reset(['name', 'email', 'phone_number', 'content']);

        $this->dispatch('resetButton');
    }


    public function render()
    {
        return view('livewire.contact-form');
    }
}
