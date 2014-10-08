@extends('templates/userTemplate')
@section('content')

<h1>Modificar Perfil</h1>
	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('max_materiales') }}</strong></p>
			<p><strong>{{ $errors->first('max_dias_prestamo') }}</strong></p>
		</div>
	@endif
	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	{{ Form::open(array('url'=>'user/submit_edit_profile', 'role'=>'form')) }}
	{{ Form::hidden('id', $profile->id) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('nombre','Nombre') }}
					{{ Form::text('nombre',$profile->name,array('class'=>'form-control','readonly'=>'')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('max_materiales','Máximo de materiales a ser prestados') }}
					{{ Form::text('max_materiales',$profile->max_material,array('class'=>'form-control')) }}
				</div>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('descripcion','Descripción') }}
					{{ Form::text('descripcion',$profile->description,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('max_dias_prestamo','Máximo de días de préstamo') }}
					{{ Form::text('max_dias_prestamo',$profile->max_days_loan,array('class'=>'form-control')) }}
				</div>
			</div>
		</div>
		<table class="table table-hover">
			<tr class="info">
				<th>Nombre</th>
				<th>¿Físico o Digital?</th>
				<th>Descripción</th>
				<th class="text-center">Seleccione</th>
			</tr>
			@foreach($material_types as $material_type)
			<tr>
				<td>
					{{$material_type->name}}
				</td>
				<td>
					@if($material_type->flag_phys_dig == 1)
						<span>Físico</span>
					@else
						<span>Digital</span>
					@endif
				</td>
				<td>
					{{ $material_type->description }}
				</td>
				<td class="text-center">
					{{ Form::checkbox('selected_material_types[]',$material_type->id) }}
				</td>
			</tr>
			@endforeach
		</table>
	{{ Form::submit('Registrar',array('id'=>'submit-create', 'class'=>'btn btn-primary')) }}
	{{ HTML::link('','Limpiar Campos',array('id'=>'clear-fields', 'class'=>'btn btn-default')) }}
	{{ Form::close() }}	
	
@stop
