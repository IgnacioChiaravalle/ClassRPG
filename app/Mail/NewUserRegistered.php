<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserRegistered extends Mailable {
	use Queueable, SerializesModels;

	public $user;
	public $password;
 
	/**
	 * Create a new message instance.
	 */
	public function __construct($user, $password) {
		$this->user = $user;
		$this->password = $password;
	}
 
	/**
	 * Build the message.
	 */
	public function build() {
		return $this->from($address = 'nachochiara@gmail.com', $name = 'ClassRPG')
					->subject('¡Bienvenido a ClassRPG, ' . $this->user->name . '!')
					->view('emails.new_user');
	}
}