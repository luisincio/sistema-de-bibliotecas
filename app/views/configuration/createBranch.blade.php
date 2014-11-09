@extends('templates/configurationTemplate')
@section('content')

	<h1>Registrar nueva Sede</h1>
	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('direccion') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif

	@if (Session::has('danger'))
		<div class="alert alert-danger">
			<p><strong>{{ Session::get('danger') }}</strong></p>
		</div>
	@endif	
	
	{{ Form::open(array('url'=>'config/submit_create_branch', 'role'=>'form')) }}
		

		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombre') }}
					{{ Form::text('nombre',Input::old('nombre'),array('class'=>'form-control')) }}
				</div>
			</div>		
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('hora_ini')) has-error has-feedback @endif">
					{{ Form::label('hora_ini','Hora Apertura') }}
					{{ Form::text('hora_ini',Input::old('hora_ini'),array('class'=>'form-control','readonly'=>'')) }}					
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('dia_ini','Día Inicio') }}
						<select name="dia_ini" class="form-control">
							<option value="0">Domingo</option>
							<option value="1" selected>Lunes</option>
							<option value="2">Martes</option>
							<option value="3">Miércoles</option>
							<option value="4">Jueves</option>
							<option value="5">Viernes</option>
							<option value="6">Sábado</option>
						</select>
				</div>
			</div>

			{{ Form::submit('Registrar',array('id'=>'submit-create', 'class'=>'btn btn-primary')) }}
			{{ HTML::link('','Limpiar Campos',array('id'=>'clear-fields', 'class'=>'btn btn-default')) }}
			{{ HTML::link('','Cancelar',array('id'=>'cancel')) }}
		</div>





		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('direccion','Dirección') }}
					{{ Form::text('direccion',Input::old('direccion'),array('class'=>'form-control')) }}
				</div>
			</div>					
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('hora_fin')) has-error has-feedback @endif">
					{{ Form::label('hora_fin','Hora Cierre') }}
					{{ Form::text('hora_fin',Input::old('hora_fin'),array('class'=>'form-control','readonly'=>'')) }}					
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('dia_fin','Día Fin') }}
						<select name="dia_fin" class="form-control">
							<option value="0">Domingo</option>
							<option value="1">Lunes</option>
							<option value="2">Martes</option>
							<option value="3">Miércoles</option>
							<option value="4">Jueves</option>
							<option value="5" selected>Viernes</option>
							<option value="6">Sábado</option>
						</select>
				</div>
			</div>

		</div>
	{{ Form::close() }}
	
@stop