@extends('templates/passwordTemplate')
@section('content')
	<h4 class="text-center">Ingrese su email para poder enviarle instrucciones de renovación de contraseña</h4>

	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	@if (Session::has('status'))
		<div class="alert alert-success">{{ Session::get('status') }}</div>
	@endif
	<div id="reset-password-container" class="bg-info">
		<form action="{{ action('RemindersController@postRemind') }}" method="POST">
			{{ Form::label('email','Ingrese su correo') }}
			{{ Form::text('email','',array('class'=>'form-control')) }}
			{{ Form::submit('Enviar',array('class'=>'btn btn-lg btn-primary')) }}
		</form>
	</div>
@stop