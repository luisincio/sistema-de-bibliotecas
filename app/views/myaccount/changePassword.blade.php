@extends('templates/myAccountTemplate')
@section('content')
	<h1>Cambiar Contraseña</h1>
	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('contrasena') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif

	{{ Form::open(array('url'=>'myaccount/submit_change_password', 'role'=>'form')) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('contrasena')) has-error has-feedback @endif">
					{{ Form::label('contrasena','Contraseña Nueva') }}
					{{ Form::password('contrasena',array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('contrasena')) has-error has-feedback @endif">
					{{ Form::label('contrasena_confirmation','Confirme su Contraseña') }}
					{{ Form::password('contrasena_confirmation',array('class'=>'form-control')) }}
				</div>
			</div>
			{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
		</div>
	{{ Form::close() }}
@stop