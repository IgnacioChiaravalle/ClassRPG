<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class NewUserRegistered extends Notification {
	use Queueable;

	public $user;
	public $password;

	public function __construct($user, $password) {
		$this->user = $user;
		$this->password = $password;
	}

	public function via($notifiable) {
		return ['mail'];
	}

	public function toMail($notifiable) {
		$mailMessage = (new MailMessage)
			->from($address = 'nachochiara@gmail.com', $name = 'ClassRPG')
			->subject('¡Bienvenido a ClassRPG, ' . $this->user->name . '!')
			->greeting(new HtmlString('Hola, <i>' . $this->user->name . '</i>'))
			->line(new HtmlString('Este es un correo de confirmación de tu nuevo usuario de <b><i>ClassRPG</i></b>.'))
			->line(new HtmlString('<u>Tus datos de acceso son:</u>'))
			->line(new HtmlString('<b>Correo electrónico:</b>&nbsp;' . $this->user->email . '<br><b>Contraseña:</b>&nbsp;' . $this->password))
			->line('Para garantizar la seguridad de tus datos, recomendamos que cambies tu contraseña lo más pronto posible.');

		if ($this->user->type == "student")
			$mailMessage->line('¡Como regalo de bienvenida agregamos 10 monedas de oro a tu cuenta!');
		
		$mailMessage->action('Acceder al Sitio', url('/'));
		$mailMessage->salutation('Saludos, ClassRPG.');

		return $mailMessage;
	}
}
