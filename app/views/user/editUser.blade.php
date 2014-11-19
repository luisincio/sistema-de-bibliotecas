@extends('templates/userTemplate')
@section('content')

	<h1>Editar Usuario</h1>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
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

	{{ Form::open(array('url'=>'user/submit_edit_user', 'role'=>'form')) }}
		{{ Form::hidden('user_id', $user_info->id) }}
		{{ Form::hidden('person_id', $user_info->person_id) }}

		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('tipo_documento','Tipo de documento') }}
					@foreach($document_types as $document_type)
						@if($document_type->id == $user_info->document_type)
							{{ Form::text('numero_documento',$document_type->name,array('class'=>'form-control','readonly'=>'')) }}
						@endif	
					@endforeach
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombres')) has-error has-feedback @endif">
					{{ Form::label('nombres','Nombres') }}
					{{ Form::text('nombres',$user_info->name,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nacionalidad')) has-error has-feedback @endif">
					{{ Form::label('nacionalidad','Nacionalidad') }}
					{{ Form::text('nacionalidad',$user_info->nacionality,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('telefono')) has-error has-feedback @endif">
					{{ Form::label('telefono','Teléfono') }}
					{{ Form::text('telefono',$user_info->phone,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('direccion')) has-error has-feedback @endif">
					{{ Form::label('direccion','Dirección') }}
					{{ Form::text('direccion',$user_info->address,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				{{ Form::label('fecha_nacimiento','Fecha de nacimiento') }}
				<div class="form-group input-group col-xs-8 @if($errors->first('fecha_nacimiento')) has-error has-feedback @endif">
					
					{{ Form::text('fecha_nacimiento',$user_info->birth_date,array('class'=>'form-control','readonly'=>'')) }}
					<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
				</div>
			</div>
			{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
			{{ HTML::link('','Cancelar',array('id'=>'cancel')) }}
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('num_documento')) has-error has-feedback @endif">
					{{ Form::label('num_documento','Número de documento') }}
					{{ Form::text('num_documento',$user_info->doc_number,array('class'=>'form-control','readonly'=>'')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('apellidos')) has-error has-feedback @endif">
					{{ Form::label('apellidos','Apellidos') }}
					{{ Form::text('apellidos',$user_info->lastname,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('genero','Género') }}</br>
					@if($user_info->gender == 'M')
						{{ Form::radio('genero', 'M',true) }} M
					@else
						{{ Form::radio('genero', 'M') }} M
					@endif

					@if($user_info->gender == 'F')
						{{ Form::radio('genero', 'F',true,array('style'=>'margin-left:20px')) }} F
					@else
						{{ Form::radio('genero', 'F',false,array('style'=>'margin-left:20px')) }} F
					@endif
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('email')) has-error has-feedback @endif">
					{{ Form::label('email','E-mail') }}
					{{ Form::text('email',$user_info->email,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('perfil','Perfil') }}
					<select name="perfil" class="form-control">
						<option value="0">Seleccione un perfil</option>
						@foreach($profiles as $profile)
							@if($profile->id == $user_info->profile_id)
								<option value="{{ $profile->id }}" selected>{{ $profile->name }}</option>
							@else
								<option value="{{ $profile->id }}">{{ $profile->name }}</option>
							@endif
						@endforeach
					</select>
				</div>
			</div>
		</div>

	{{ Form::close() }}
	
@stop