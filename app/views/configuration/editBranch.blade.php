@extends('templates/configurationTemplate')
@section('content')

	<h1>Modificar Sede</h1>
	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('direccion') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif

	@if (Session::has('danger'))
		<div class="alert alert-danger">{{ Session::get('danger') }}</div>
	@endif
	
	{{ Form::open(array('url'=>'config/submit_edit_branch', 'role'=>'form')) }}
		{{ Form::hidden('id', $branch->id) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombre') }}
					{{ Form::text('nombre',$branch->name,array('class'=>'form-control','readonly'=>'')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('hora_ini')) has-error has-feedback @endif">
					{{ Form::label('hora_ini','Hora Apertura') }}
					{{ Form::text('hora_ini',$branch->hour_ini,array('class'=>'form-control','readonly'=>'')) }}					
				</div>
			</div>
			{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
			{{ HTML::link('','Cancelar',array('id'=>'cancel')) }}
		</div>	
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('direccion','Dirección') }}
					{{ Form::text('direccion',$branch->address,array('class'=>'form-control')) }}
				</div>
			</div>		
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('hora_fin')) has-error has-feedback @endif">
					{{ Form::label('hora_fin','Hora Cierre') }}
					{{ Form::text('hora_fin',$branch->hour_end,array('class'=>'form-control','readonly'=>'')) }}					
				</div>
			</div>
		</div>			
	{{ Form::close() }}



	
@stop