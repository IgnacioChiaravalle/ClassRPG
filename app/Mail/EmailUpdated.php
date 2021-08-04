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
		return $this->from('nachochiara@gmail.com')
					->view('mails.email_updated');
	}
}
