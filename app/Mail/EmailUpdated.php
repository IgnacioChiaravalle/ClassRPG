<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailUpdated extends Mailable {
	use Queueable, SerializesModels;

	public $user;
 
	/**
	 * Create a new message instance.
	 */
	public function __construct($user) {
		$this->user = $user;
	}
 
	/**
	 * Build the message.
	 */
	public function build() {
		return $this->from($address = 'nachochiara@gmail.com', $name = 'ClassRPG')
					->subject('ClassRPG - Cambio de dirección de correo electrónico')
					->view('emails.email_updated');
	}
}
