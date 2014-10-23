@extends('templates/myAccountTemplate')
@section('content')

	<h1>Registrar Solicitud</h1>
	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('titulo') }}</strong></p>
			<p><strong>{{ $errors->first('autor') }}</strong></p>
			<p><strong>{{ $errors->first('editorial') }}</strong></p>
			<p><strong>{{ $errors->first('num_edicion') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	
	{{ Form::open(array('url'=>'myaccount/submit_create_material_request', 'role'=>'form')) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('tipo_sugerencia','Tipo de sugerencia*') }}										
					<select name="tipo_sugerencia" class="form-control">
						@if($material_request_types)
							@foreach($material_request_types as $material_request_type)							
							<option value="{{ $material_request_type->id }}">{{ $material_request_type->name }}</option>							
							@endforeach
						@endif
					</select>					
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('titulo')) has-error has-feedback @endif">
					{{ Form::label('titulo','Título') }}
					{{ Form::text('titulo',Input::old('titulo'),array('class'=>'form-control')) }}
				</div>
			</div>			
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('autor')) has-error has-feedback @endif">
					{{ Form::label('autor','Autor') }}
					{{ Form::text('autor',Input::old('autor'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('editorial')) has-error has-feedback @endif">
					{{ Form::label('editorial','Editorial') }}
					{{ Form::text('editorial',Input::old('editorial'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('num_edicion')) has-error has-feedback @endif">
					{{ Form::label('num_edicion','Número de edicion') }}
					{{ Form::text('num_edicion',Input::old('num_edicion'),array('class'=>'form-control')) }}
				</div>
			</div>
			{{ Form::submit('Registrar',array('id'=>'submit-create', 'class'=>'btn btn-primary')) }}
			{{ HTML::link('','Limpiar Campos',array('id'=>'clear-fields', 'class'=>'btn btn-default')) }}
			{{ HTML::link('','Cancelar',array('id'=>'cancel')) }}
		</div>		
	{{ Form::close() }}
	
@stop