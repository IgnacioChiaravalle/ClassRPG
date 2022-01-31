<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class EmailUpdated extends Notification {
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
			->subject('ClassRPG - Cambio de dirección de correo electrónico')
			->greeting(new HtmlString('Hola, <i>' . $this->user->name . '</i>'))
			->line(new HtmlString('Este es un correo de confirmación del cambio del correo electrónico asociado a tu cuenta de <b><i>ClassRPG</i></b>.'))
			->line('Desde ahora, te contactaremos a través de esta nueva dirección: ' . $this->user->email)
			->action('Acceder al Sitio', url('/'))
			->salutation('Saludos, ClassRPG.');
	}
}
