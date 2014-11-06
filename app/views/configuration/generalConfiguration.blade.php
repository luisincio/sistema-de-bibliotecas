@extends('templates/configurationTemplate')
@section('content')

	<h1>Configuración General</h1>
	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('ruc') }}</strong></p>
			<p><strong>{{ $errors->first('direccion') }}</strong></p>
			<p><strong>{{ $errors->first('logo') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('tiempo_maximo_prestamo_cubiculo') }}</strong></p>
			<p><strong>{{ $errors->first('tiempo_suspencion') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif

	@if (Session::has('danger'))
		<div class="alert alert-danger">{{ Session::get('danger') }}</div>
	@endif
	
	{{ Form::open(array('url'=>'config/submit_general_configuration', 'role'=>'form','files' => true)) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombre / Razón Social') }}
					{{ Form::text('nombre',$general_configuration->name,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('ruc')) has-error has-feedback @endif">
					{{ Form::label('ruc','RUC') }}
					{{ Form::text('ruc',$general_configuration->ruc,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('direccion')) has-error has-feedback @endif">
					{{ Form::label('direccion','Dirección') }}
					{{ Form::text('direccion',$general_configuration->address,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('logo')) has-error has-feedback @endif">
					{{ Form::label('logo','Logo') }}
					{{ Form::file('logo','',array('class'=>'form-control')) }}
				</div>
			</div>
			{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
			{{ HTML::link('','Cancelar',array('id'=>'cancel')) }}
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('descripcion')) has-error has-feedback @endif">
					{{ Form::label('descripcion','Descripción') }}
					{{ Form::textarea('descripcion',$general_configuration->description,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('tiempo_maximo_prestamo_cubiculo')) has-error has-feedback @endif">
					{{ Form::label('tiempo_maximo_prestamo_cubiculo','Tiempo máximo de préstamo de cubículo (horas)') }}
					{{ Form::text('tiempo_maximo_prestamo_cubiculo',$general_configuration->max_hours_loan_cubicle,array('class'=>'form-control')) }}
				</div>
			</div>
		</div>
	{{ Form::close() }}
	
@stop