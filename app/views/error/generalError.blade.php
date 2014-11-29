<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex, follow">
	<title>Acceso No Autorizado | Sistema de Biblioteca</title>
</head>

<body>
	<div id="main-container" style="text-align:center;">
		<h2>Usted está intentando ingresar a un contenido que no está permitido para su usuario</h2>
		<h3>Para regresar al inicio haga click <a href="{{ URL::to('/') }}">aquí</a><h3>
		<img src="{{asset('img/error_img.jpg')}}">
	</div>
</body>
</html>