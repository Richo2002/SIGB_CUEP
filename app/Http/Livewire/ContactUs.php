<?php

namespace App\Http\Livewire;

use App\Mail\ContactUs as MailContactUs;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;

class ContactUs extends Component
{
    public $name;
    public $email;
    public $message;

    protected $rules = [
        'name' => 'required|min:6|max:50',
        'email' => 'required|email',
        'message' => 'required|min:50'
    ];

    public function sendMail()
    {
        $this->validate();

        $user = [
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
        ];

        Mail::to('cuep@gmail.com')->send(new MailContactUs($user));

        session()->flash('message', 'Votre e-mail a été envoyé avec succès !');

        $this->reset('name');
        $this->reset('email');
        $this->reset('message');
    }

    public function render()
    {
        return view('livewire.contact-us');
    }
}
