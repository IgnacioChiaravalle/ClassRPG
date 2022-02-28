<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification {
	use Queueable;

	public $token;

	public function __construct($token) {
		$this->token = $token;
	}

	public function via($notifiable) {
		return ['mail'];
	}

	public function toMail($notifiable) {
		return (new MailMessage)
			->from($address = 'classrpg.bb@gmail.com', $name = 'ClassRPG')
			->subject('ClassRPG - Recuperación de contraseña')
			->greeting('¡Hola!')
			->line('Estás recibiendo este correo porque recibimos una solicitud de recuperación de contraseña para tu cuenta.')
			->action('Recuperar Contraseña', url('password/reset', $this->token))
			->line('Si no solicitaste una recuperación de contraseña, no es necesario que tomes ninguna acción adicional.')
			->salutation('Saludos, ClassRPG.');
	}
}
