@extends('templates/staffTemplate')
@section('content')

	<h1>Registrar Asistencia</h1>

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif

	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'staff/submit_assistance', 'role'=>'form')) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('num_doc','Número de Documento') }}
					{{ Form::text('num_doc','',array('class'=>'form-control','autocomplete'=>'off')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('contrasena','Contraseña') }}
					{{ Form::password('contrasena',array('class'=>'form-control','autocomplete'=>'off')) }}
				</div>
			</div>
			{{ Form::submit('Registrar asistencia',array('class'=>'btn btn-primary')) }}
		</div>
	{{ Form::close() }}
	
@stop