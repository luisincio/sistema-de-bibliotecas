@extends('templates/configurationTemplate')
@section('content')

	<h1>Registrar Tipo de Material</h1>
	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	
	{{ Form::open(array('url'=>'config/submit_create_material_type', 'role'=>'form')) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombre') }}
					{{ Form::text('nombre',Input::old('nombre'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('descripcion','Descripción') }}
					{{ Form::text('descripcion',Input::old('descripcion'),array('class'=>'form-control')) }}
				</div>
			</div>
			{{ Form::submit('Registrar',array('id'=>'submit-create', 'class'=>'btn btn-primary')) }}
			{{ HTML::link('','Limpiar Campos',array('id'=>'clear-fields', 'class'=>'btn btn-default')) }}
			{{ HTML::link('','Cancelar',array('id'=>'cancel')) }}
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('phys_dig','¿Físico o Digital?') }}
					<div>
						<label class="radio-inline">
							{{ Form::radio('phys_dig','1',true) }} Físico
						</label>
						<label class="radio-inline">
							{{ Form::radio('phys_dig','2') }} Digital
						</label>
					</div>
				</div>
			</div>
		</div>
	{{ Form::close() }}
	
@stop