@extends('templates/materialTemplate')
@section('content')

	<h1>Registrar Material</h1>
	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('titulo') }}</strong></p>
			<p><strong>{{ $errors->first('codigo') }}</strong></p>
			<p><strong>{{ $errors->first('autor') }}</strong></p>
			<p><strong>{{ $errors->first('editorial') }}</strong></p>
			<p><strong>{{ $errors->first('num_edicion') }}</strong></p>
			<p><strong>{{ $errors->first('isbn') }}</strong></p>
			<p><strong>{{ $errors->first('anio_publicacion') }}</strong></p>
			<p><strong>{{ $errors->first('num_paginas') }}</strong></p>
			<p><strong>{{ $errors->first('cant_ejemplares') }}</strong></p>
			<p><strong>{{ $errors->first('orden_compra') }}</strong></p>
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
	
	{{ Form::open(array('url'=>'material/submit_create_material', 'role'=>'form')) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('tipo_material','Tipo de material') }}
					
					<select name="tipo_material" class="form-control">
						@foreach($material_types as $material_type)
						<option value="{{ $material_type->id }}">{{ $material_type->name }}</option>
						@endforeach
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
				<div class="form-group col-xs-8 @if($errors->first('codigo')) has-error has-feedback @endif">
					{{ Form::label('codigo','Código(4 letras)') }}
					{{ Form::text('codigo',Input::old('codigo'),array('class'=>'form-control')) }}
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
				<div class="form-group col-xs-8">
					{{ Form::label('area_tematica','Área Temática') }}
					<select name="area_tematica" class="form-control">
						@foreach($thematic_areas as $thematic_area)
						<option value="{{ $thematic_area->id }}">{{ $thematic_area->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('isbn')) has-error has-feedback @endif">
					{{ Form::label('isbn','ISBN') }}
					{{ Form::text('isbn',Input::old('isbn'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('anio_publicacion')) has-error has-feedback @endif">
					{{ Form::label('anio_publicacion','Año de publicación') }}
					{{ Form::text('anio_publicacion',Input::old('anio_publicacion'),array('class'=>'form-control')) }}
				</div>
			</div>
			{{ Form::submit('Registrar',array('id'=>'submit-create', 'class'=>'btn btn-primary')) }}
			{{ HTML::link('','Limpiar Campos',array('id'=>'clear-fields', 'class'=>'btn btn-default')) }}
			{{ HTML::link('','Cancelar',array('id'=>'cancel')) }}
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('num_edicion')) has-error has-feedback @endif">
					{{ Form::label('num_edicion','Número de edicion') }}
					{{ Form::text('num_edicion',Input::old('num_edicion'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('num_paginas')) has-error has-feedback @endif">
					{{ Form::label('num_paginas','Número de páginas') }}
					{{ Form::text('num_paginas',Input::old('num_paginas'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('cant_ejemplares')) has-error has-feedback @endif">
					{{ Form::label('cant_ejemplares','Cantidad de ejemplares') }}
					{{ Form::text('cant_ejemplares',Input::old('cant_ejemplares'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('ubicacion_estante','Ubicación en estante') }}
					<select name="estante" class="form-control">
						@foreach($shelves as $shelf)
						<option value="{{ $shelf->id }}">{{ $shelf->code }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('orden_compra') || Session::has('danger')) has-error has-feedback @endif">
					{{ Form::label('orden_compra','Orden de compra') }}
					{{ Form::text('orden_compra',Input::old('orden_compra'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('suscripcion','Suscripción') }}
					{{ Form::checkbox('suscripcion') }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('to_home','Solo préstamo a casa') }}
					{{ Form::checkbox('to_home') }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('materiales_adicionales')) has-error has-feedback @endif">
					{{ Form::label('materiales_adicionales','Materiales adicionales') }}
					{{ Form::text('materiales_adicionales',Input::old('materiales_adicionales'),array('class'=>'form-control')) }}
				</div>
			</div>
		</div>
	{{ Form::close() }}
	
@stop