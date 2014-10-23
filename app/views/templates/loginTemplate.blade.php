<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex, follow">
	<title>Home | {{ $config->name }}</title>
	<!-- Styles -->
	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/datepicker.css') }}">
	<link rel="stylesheet" href="{{ asset('css/login/login-style.css') }}">
	<!-- Scripts -->
	<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/catalog/catalog.js') }}"></script>
	<script type="text/javascript">
		var inside_url = "{{$inside_url}}";
	</script>
</head>

<body>
	<div id="main-container">
		<nav class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="{{ URL::to('/') }}">
						<img src="{{ asset('img') }}/{{ $config->logo_path }}" width="42" style="display:block;margin-top:4px;"/>
					</a>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li class="dropdown">
							{{ HTML::link('/catalog','Catálogo') }}
						</li>
					</ul>
				</div>
			</div>
		</nav>
		@yield('content')
	</div>
</body>
</html>