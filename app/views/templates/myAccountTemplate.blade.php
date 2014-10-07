<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex, follow">
	<title>Mi Cuenta | {{ $config->name }}</title>
	<!-- Styles -->
	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/datepicker.css') }}">
	<link rel="stylesheet" href="{{ asset('css/general.css') }}">
	<!-- Scripts -->
	<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/general.js') }}"></script>
	<script type="text/javascript">
		var inside_url = "{{$inside_url}}";
	</script>
</head>

<body>
	<div id="main-container">
		@include('layouts.header', array('person'=>$person,'user'=>$user,'staff'=>$staff))
		<div id="content">
			@yield('content')
		</div>
	</div>
</body>
</html>