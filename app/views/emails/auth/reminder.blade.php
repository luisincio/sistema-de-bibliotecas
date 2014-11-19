<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Renovación de contraseña</h2>

		<div>
			Para renovar su contraseña, llene el siguiente formulario: {{ URL::to('password/reset', array($token)) }}.<br/>
			Este enlace expirará en {{ Config::get('auth.reminder.expire', 60) }} minutos.</br>
			Ignore este mensaje si usted no realizó esta petición.
		</div>
	</body>
</html>
