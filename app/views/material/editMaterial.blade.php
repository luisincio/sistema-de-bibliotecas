@extends('templates/materialTemplate')
@section('content')

	<h1>Editar Material</h1>
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
			@if($errors->first('fecha_ini'))
				<p><strong>Si el material es una suscripción, la fecha inicial es requerida y debe ser menor a la final</strong></p>
			@endif
			@if($errors->first('fecha_fin'))
				<p><strong>Si el material es una suscripción, la fecha final es requerida y debe ser mayor a la inicial</strong></p>
			@endif
			@if($errors->first('periodicidad'))
				<p><strong>Si el material es una suscripción, debe especificar la periodicidad y debe ser numérico</strong></p>
			@endif
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	
	{{ Form::open(array('url'=>'material/submit_edit_material', 'role'=>'form')) }}
		{{ Form::hidden('id', $material->mid) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8">
					@foreach($material_types as $material_type)
						@if($material->material_type == $material_type->id)
						{{ Form::label('tipo_material','Tipo de material') }}
						{{ Form::text('tipo_material',$material_type->name,array('class'=>'form-control','readonly'=>'')) }}
						@endif
					@endforeach
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('titulo')) has-error has-feedback @endif">
					{{ Form::label('titulo','Título') }}
					{{ Form::text('titulo',$material->title,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('codigo')) has-error has-feedback @endif">
					{{ Form::label('codigo','Código(4 letras)') }}
					{{ Form::text('codigo',$material->auto_cod,array('class'=>'form-control','readonly'=>'')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('autor')) has-error has-feedback @endif">
					{{ Form::label('autor','Autor') }}
					{{ Form::text('autor',$material->author,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('editorial')) has-error has-feedback @endif">
					{{ Form::label('editorial','Editorial') }}
					{{ Form::text('editorial',$material->editorial,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('area_tematica','Área Temática') }}
					<select name="area_tematica" class="form-control">
						@foreach($thematic_areas as $thematic_area)
							@if($thematic_area->id == $material->thematic_area)
							<option value="{{ $thematic_area->id }}" selected>{{ $thematic_area->name }}</option>
							@else
							<option value="{{ $thematic_area->id }}">{{ $thematic_area->name }}</option>
							@endif
						@endforeach
					</select>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('isbn')) has-error has-feedback @endif">
					{{ Form::label('isbn','ISBN / ISCN') }}
					{{ Form::text('isbn',$material->isbn,array('class'=>'form-control','readonly'=>'')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('anio_publicacion')) has-error has-feedback @endif">
					{{ Form::label('anio_publicacion','Año de publicación') }}
					{{ Form::text('anio_publicacion',$material->publication_year,array('class'=>'form-control')) }}
				</div>
			</div>
			{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
			{{ HTML::link('','Cancelar',array('id'=>'cancel')) }}
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('num_edicion')) has-error has-feedback @endif">
					{{ Form::label('num_edicion','Número de edicion') }}
					{{ Form::text('num_edicion',$material->edition,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('num_paginas')) has-error has-feedback @endif">
					{{ Form::label('num_paginas','Número de páginas') }}
					{{ Form::text('num_paginas',$material->num_pages,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('ubicacion_estante','Ubicación en estante') }}
					<select name="estante" class="form-control">
						@foreach($shelves as $shelf)
						@if($shelf->id == $material->shelve_id)
							<option value="{{ $shelf->id }}" selected>{{ $shelf->code }}</option>
						@else
							<option value="{{ $shelf->id }}">{{ $shelf->code }}</option>
						@endif
						@endforeach
					</select>
				</div>
			</div>

			@if($material->doner)
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('doner','Donador') }}
					{{ Form::text('doner',$doner->name,array('class'=>'form-control','readonly'=>'')) }}
				</div>
			</div>
			@else
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('orden_compra')) has-error has-feedback @endif">
					{{ Form::label('orden_compra','Orden de compra') }}
					{{ Form::text('orden_compra',$material->purchase_order_id,array('class'=>'form-control','readonly'=>'')) }}
				</div>
			</div>
			@endif
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('to_home','Se puede prestar a casa') }}					
					@if($material->to_home == 1)
						{{ Form::checkbox('to_home',$material->to_home,true) }}
					@else
						{{ Form::checkbox('to_home') }}
					@endif
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('materiales_adicionales')) has-error has-feedback @endif">
					{{ Form::label('materiales_adicionales','Materiales adicionales') }}
					{{ Form::text('materiales_adicionales',$material->additional_materials,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('suscripcion','Suscripción') }}
					@if($material->subscription)
						{{ Form::checkbox('suscripcion',$material->subscription,true) }}
					@else
						{{ Form::checkbox('suscripcion') }}
					@endif
				</div>
			</div>
			<div id="toggle-suscripcion" style="@if(!$material->subscription)display:none;@endif">

				<div class="row">
					<div class="form-group col-xs-8 @if($errors->first('periodicidad')) has-error has-feedback @endif">
						{{ Form::label('periodicidad','Periodicidad') }}
						{{ Form::text('periodicidad',$material->periodicity,array('class'=>'form-control')) }}
					</div>
				</div>

				<div class="row">
					{{ Form::label('fecha_ini','Inicio de suscripción') }}
					<div class="form-group input-group col-xs-8 @if($errors->first('fecha_ini')) has-error has-feedback @endif">
						{{ Form::text('fecha_ini',$material->date_ini,array('class'=>'form-control','readonly'=>'')) }}
						<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
					</div>
				</div>

				<div class="row">
					{{ Form::label('fecha_fin','Fin de suscripción') }}
					<div class="form-group input-group col-xs-8 @if($errors->first('fecha_fin')) has-error has-feedback @endif">
						{{ Form::text('fecha_fin',$material->date_end,array('class'=>'form-control','readonly'=>'')) }}
						<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
					</div>
				</div>

			</div>
		</div>
	{{ Form::close() }}
	
@stop