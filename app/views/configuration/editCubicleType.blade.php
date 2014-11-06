@extends('templates/configurationTemplate')
@section('content')

	<h1>Editar Tipo de Cubículo</h1>
	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	
	{{ Form::open(array('url'=>'config/submit_edit_cubicle_type', 'role'=>'form')) }}
		{{ Form::hidden('id', $cubicle_type->id) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('nombre','Nombre de tipo de cubículo') }}
					{{ Form::text('nombre',$cubicle_type->name,array('class'=>'form-control','readonly'=>'')) }}
				</div>
			</div>
			{{ Form::submit('Registrar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
			{{ HTML::link('','Limpiar Campos',array('id'=>'clear-fields', 'class'=>'btn btn-default')) }}
			{{ HTML::link('','Cancelar',array('id'=>'cancel')) }}
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('descripcion')) has-error has-feedback @endif">
					{{ Form::label('descripcion','Descripción') }}
					{{ Form::text('descripcion',$cubicle_type->description,array('class'=>'form-control')) }}
				</div>
			</div>
		</div>
	{{ Form::close() }}
	
@stop