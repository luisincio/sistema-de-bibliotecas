@extends('templates/passwordTemplate')
@section('content')
	<h4 class="text-center">Cambie su contraseña</h4>

	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif
	<div id="reset-password-container" class="bg-info">
		<form action="{{ action('RemindersController@postReset') }}" method="POST">
			{{ Form::hidden('token', $token) }}
			{{ Form::label('email','Ingrese su correo') }}
			{{ Form::text('email','',array('class'=>'form-control')) }}
			{{ Form::label('password','Contraseña Nueva') }}
			{{ Form::password('password',array('class'=>'form-control')) }}
			{{ Form::label('password_confirmation','Confirme su Contraseña') }}
			{{ Form::password('password_confirmation',array('class'=>'form-control')) }}
			{{ Form::submit('Cambiar',array('class'=>'btn btn-lg btn-primary')) }}
		</form>
	</div>
@stop