@extends('templates/configurationTemplate')
@section('content')

	<h1>Comandos</h1>

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	
	{{ Form::open(array('url'=>'config/clean_reservations_command', 'role'=>'form')) }}
		{{ Form::submit('Limpiar Reservas Caducadas',array('id'=>'submit-create', 'class'=>'btn btn-primary')) }}	
	{{ Form::close() }}
	</br>
	{{ Form::open(array('url'=>'config/clean_users_command', 'role'=>'form')) }}
		{{ Form::submit('Quitar Penalidad a Usuarios',array('id'=>'submit-create', 'class'=>'btn btn-success')) }}	
	{{ Form::close() }}
	</br>
	{{ Form::open(array('url'=>'config/penalize_users_command', 'role'=>'form')) }}
		{{ Form::submit('Aplicar Penalizar Usuarios',array('id'=>'submit-create', 'class'=>'btn btn-default')) }}	
	{{ Form::close() }}
	</br>
	
@stop