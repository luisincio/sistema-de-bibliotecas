@extends('templates/staffTemplate')
@section('content')

	<h1>Registrar Personal</h1>

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
			@if($errors->first('rol'))
				<p><strong>Seleccione un rol válido</strong></p>
			@endif
			@if($errors->first('sede'))
				<p><strong>Seleccione una sede válida</strong></p>
			@endif
			@if($errors->first('turno'))
				<p><strong>Seleccione un turno válido</strong></p>
			@endif
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif

	{{ Form::open(array('url'=>'staff/submit_create_staff', 'role'=>'form')) }}
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
				<div class="form-group col-xs-8 @if($errors->first('sede')) has-error has-feedback @endif">
					{{ Form::label('branch','Sede') }}
					<select name="sede" class="form-control">
						<option value="0">Seleccione una sede</option>
						@if($staff->role_id == 1)
							@foreach($branches as $branch)
									<option value="{{ $branch->id }}" @if(Input::old('branch') && Input::old('branch') == $branch->id) selected @endif>{{ $branch->name }}</option>
							@endforeach
						@else
							@foreach($branches as $branch)
									<option value="{{ $branch->id }}" @if(Input::old('branch') && Input::old('branch') == $branch->id) selected @endif>{{ $branch->name }}</option>
							@endforeach
						@endif	
					</select>
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
			</br>
			</br>
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
				<div class="form-group col-xs-8 @if($errors->first('rol')) has-error has-feedback @endif">
					{{ Form::label('role','Rol') }}
					<select name="rol" class="form-control">
						<option value="0">Seleccione un rol</option>
						@if($staff->role_id == 1)
							@foreach($roles as $role)
								@if($role->id != 1 && $role->id != 4)
									<option value="{{ $role->id }}" @if(Input::old('role') && Input::old('role') == $role->id) selected @endif>{{ $role->name }}</option>
								@endif
							@endforeach
						@else
							@foreach($roles as $role)
								@if($role->id == 3)
									<option value="{{ $role->id }}" @if(Input::old('role') && Input::old('role') == $role->id) selected @endif>{{ $role->name }}</option>
								@endif
							@endforeach
						@endif	
					</select>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('turno')) has-error has-feedback @endif">
					{{ Form::label('turn','Turno') }}
					<select name="turno" class="form-control">
						<option value="0">Seleccione un turno</option>
						@foreach($turns as $turn)
								<option value="{{ $turn->id }}" @if(Input::old('turn') && Input::old('turn') == $turn->id) selected @endif>{{ $turn->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>

	{{ Form::close() }}
	
@stop