Hola <i>{{$user->name}}</i>,
<p>Este es un correo de confirmación de tu nuevo usuario de <b><i>ClassRPG</i></b>.</p>
 
<p><u>Tus datos de acceso son:</u></p>

<div>
<p><b>Correo electrónico:</b>&nbsp;{{$user->email}}</p>
<p><b>Contraseña:</b>&nbsp;{{$password}}</p>
</div>

<div>
<p>¡Como regalo de bienvenida agregamos 10 monedas de oro a tu cuenta!</p>
</div>

<a href="https://duckduckgo.com/">Hacé click aquí para acceder al sitio</a> <!-- TODO: Add link when available. -->
<br/>