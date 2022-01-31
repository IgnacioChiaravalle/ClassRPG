<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class AccountDeleted extends Notification {
	use Queueable;

	public $user;

	public function __construct($user) {
		$this->user = $user;
	}

	public function via($notifiable) {
		return ['mail'];
	}

	public function toMail($notifiable) {
		return (new MailMessage)
			->from($address = 'nachochiara@gmail.com', $name = 'ClassRPG')
			->subject('ClassRPG - Cuenta eliminada')
			->greeting(new HtmlString('Hola, <i>' . $this->user->name . '</i>'))
			->line(new HtmlString('Este es un correo de confirmación de la eliminación de tu cuenta de <b><i>ClassRPG</i></b>.'))
			->line('Ya no te enviaremos más correos. ¡Ha sido un placer!')
			->salutation('Saludos, ClassRPG.');
	}
}
