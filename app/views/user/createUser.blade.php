@extends('templates/userTemplate')
@section('content')

	<h1>Registrar Usuario</h1>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('num_documento') }}</strong></p>
			<p><strong>{{ $errors->first('nombres') }}</strong></p>
			<p><strong>{{ $errors->first('apellidos') }}</strong></p>
			<p><strong>{{ $errors->first('nacionalidad') }}</strong></p>
			<p><strong>{{ $errors->first('telefono') }}</strong></p>
			<p><strong>{{ $errors->first('email') }}</strong></p>
			<p><strong>{{ $errors->first('direccion') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_nacimiento') }}</strong></p>
			<p><strong>{{ $errors->first('genero') }}</strong></p>
			@if($errors->first('perfil'))
				<p><strong>Seleccione un perfil válido</strong></p>
			@endif
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif

	{{ Form::open(array('url'=>'user/submit_create_user', 'role'=>'form')) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('tipo_doc','Tipo de documento') }}
					<select name="tipo_doc" class="form-control">
						@foreach($document_types as $document_type)
							<option value="{{ $document_type->id }}">{{ $document_type->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombres')) has-error has-feedback @endif">
					{{ Form::label('nombres','Nombres') }}
					{{ Form::text('nombres',Input::old('nombres'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nacionalidad')) has-error has-feedback @endif">
					{{ Form::label('nacionalidad','Nacionalidad') }}
					{{ Form::text('nacionalidad',Input::old('nacionalidad'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('telefono')) has-error has-feedback @endif">
					{{ Form::label('telefono','Teléfono') }}
					{{ Form::text('telefono',Input::old('telefono'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('direccion')) has-error has-feedback @endif">
					{{ Form::label('direccion','Dirección') }}
					{{ Form::text('direccion',Input::old('direccion'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				{{ Form::label('fecha_nacimiento','Fecha de nacimiento') }}
				<div class="form-group input-group col-xs-8 @if($errors->first('fecha_nacimiento')) has-error has-feedback @endif">
					
					{{ Form::text('fecha_nacimiento',Input::old('fecha_nacimiento'),array('class'=>'form-control','readonly'=>'')) }}
					<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
				</div>
			</div>
			{{ Form::submit('Registrar',array('id'=>'submit-create', 'class'=>'btn btn-primary')) }}
			{{ HTML::link('','Limpiar Campos',array('id'=>'clear-fields', 'class'=>'btn btn-default')) }}
			{{ HTML::link('','Cancelar',array('id'=>'cancel')) }}
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('num_documento')) has-error has-feedback @endif">
					{{ Form::label('num_documento','Número de documento') }}
					{{ Form::text('num_documento',Input::old('num_documento'),array('class'=>'form-control')) }}
					{{ HTML::image('img/loader.gif') }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('apellidos')) has-error has-feedback @endif">
					{{ Form::label('apellidos','Apellidos') }}
					{{ Form::text('apellidos',Input::old('apellidos'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('genero','Género') }}</br>
					{{ Form::radio('genero', 'M') }} M
					{{ Form::radio('genero', 'F',false,array('style'=>'margin-left:20px')) }} F
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('email')) has-error has-feedback @endif">
					{{ Form::label('email','E-mail') }}
					{{ Form::text('email',Input::old('email'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('perfil','Perfil') }}
					<select name="perfil" class="form-control">
						<option value="0">Seleccione un perfil</option>
						@foreach($profiles as $profile)
							<option value="{{ $profile->id }}" @if(Input::old('perfil') && Input::old('perfil') == $profile->id) selected @endif>{{ $profile->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>

	{{ Form::close() }}
	
@stop