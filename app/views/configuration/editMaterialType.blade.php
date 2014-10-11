@extends('templates/configurationTemplate')
@section('content')

	<h1>Modificar Tipo de Material</h1>
	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	
	{{ Form::open(array('url'=>'config/submit_edit_material_type', 'role'=>'form')) }}
		{{ Form::hidden('id', $material_type->id) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('nombre','Nombre') }}
					{{ Form::text('nombre',$material_type->name,array('class'=>'form-control','readonly'=>'')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('descripcion')) has-error has-feedback @endif">
					{{ Form::label('descripcion','Descripción') }}
					{{ Form::text('descripcion',$material_type->description,array('class'=>'form-control')) }}
				</div>
			</div>
			{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
			{{ HTML::link('','Cancelar',array('id'=>'cancel')) }}
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('phys_dig','¿Físico o Digital?') }}
					<div>
						<label class="radio-inline">
							@if($material_type->flag_phys_dig == 1)
								{{ Form::radio('phys_dig','1',true) }} Físico
							@else
								{{ Form::radio('phys_dig','1') }} Físico
							@endif
						</label>
						<label class="radio-inline">
							@if($material_type->flag_phys_dig == 1)
								{{ Form::radio('phys_dig','2') }} Digital
							@else
								{{ Form::radio('phys_dig','2',true) }} Digital
							@endif
						</label>
					</div>
				</div>
			</div>
		</div>
	{{ Form::close() }}
	
@stop