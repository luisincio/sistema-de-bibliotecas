@extends('templates/staffTemplate')
@section('content')

	<h1>Editar Personal</h1>

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
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'staff/submit_edit_staff', 'role'=>'form')) }}
		{{ Form::hidden('staff_id', $staff_info->id) }}
		{{ Form::hidden('person_id', $staff_info->person_id) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('nacionalidad','Tipo de Documento') }}
					@foreach($document_types as $document_type)
						@if($document_type->id == $staff_info->document_type)
							{{ Form::text('numero_documento',$document_type->name,array('class'=>'form-control','readonly'=>'')) }}
						@endif	
					@endforeach
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombres')) has-error has-feedback @endif">
					{{ Form::label('nombres','Nombres') }}
					{{ Form::text('nombres',$staff_info->name,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nacionalidad')) has-error has-feedback @endif">
					{{ Form::label('nacionalidad','Nacionalidad') }}
					{{ Form::text('nacionalidad',$staff_info->nacionality,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('telefono')) has-error has-feedback @endif">
					{{ Form::label('telefono','Teléfono') }}
					{{ Form::text('telefono',$staff_info->phone,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('direccion')) has-error has-feedback @endif">
					{{ Form::label('direccion','Dirección') }}
					{{ Form::text('direccion',$staff_info->address,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('sede')) has-error has-feedback @endif">
					{{ Form::label('branch','Sede') }}
						@if($staff->role_id == 1)
							<select name="sede" class="form-control">
								<option value="0">Seleccione una sede</option>
									@foreach($branches as $branch)
										@if($edit_staff_turn->branch_id == $branch->id)
											<option value="{{ $branch->id }}" selected>{{ $branch->name }}</option>
										@else
											<option value="{{ $branch->id }}">{{ $branch->name }}</option>
										@endif
									@endforeach
							</select>
						@else
							{{ Form::text('sede',$edit_staff_branch->name,array('class'=>'form-control','readonly'=>'')) }}
						@endif
				</div>
			</div>
			<div class="row">
				{{ Form::label('fecha_nacimiento','Fecha de nacimiento') }}
				<div class="form-group input-group col-xs-8 @if($errors->first('fecha_nacimiento')) has-error has-feedback @endif">
					
					{{ Form::text('fecha_nacimiento',$staff_info->birth_date,array('class'=>'form-control','readonly'=>'')) }}
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
					{{ Form::text('num_documento',$staff_info->doc_number,array('class'=>'form-control','readonly'=>'')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('apellidos')) has-error has-feedback @endif">
					{{ Form::label('apellidos','Apellidos') }}
					{{ Form::text('apellidos',$staff_info->lastname,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('genero','Género') }}</br>
					
					@if($staff_info->gender == 'M')
						{{ Form::radio('genero', 'M',true) }} M
					@else
						{{ Form::radio('genero', 'M') }} M
					@endif

					@if($staff_info->gender == 'F')
						{{ Form::radio('genero', 'F',true,array('style'=>'margin-left:20px')) }} F
					@else
						{{ Form::radio('genero', 'F',false,array('style'=>'margin-left:20px')) }} F
					@endif
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('email') || Session::has('error') ) has-error has-feedback @endif">
					{{ Form::label('email','E-mail') }}
					{{ Form::text('email',$staff_info->email,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('role','Rol') }}
					<select name="rol" class="form-control">
						<option value="0">Seleccione un rol</option>
						@foreach($roles as $role)
							@if($role->id == $staff_info->role_id)
								<option value="{{ $role->id }}" selected>{{ $role->name }}</option>
							@else
								<option value="{{ $role->id }}">{{ $role->name }}</option>
							@endif
						@endforeach
					</select>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('turno')) has-error has-feedback @endif">
					{{ Form::label('turn','Turno') }}
					<select name="turno" class="form-control">
						<option value="0">Seleccione un turno</option>
						@foreach($edit_staff_possible_turns as $edit_staff_possible_turn)
								@if($edit_staff_possible_turn->id == $staff_info->turn_id)
								<option value="{{ $edit_staff_possible_turn->id }}" selected>{{ $edit_staff_possible_turn->name }} ({{ $edit_staff_possible_turn->hour_ini }} - {{ $edit_staff_possible_turn->hour_end }})</option>
							@else
								<option value="{{ $edit_staff_possible_turn->id }}" >{{ $edit_staff_possible_turn->name }} ({{ $edit_staff_possible_turn->hour_ini }} - {{ $edit_staff_possible_turn->hour_end }})</option>
							@endif
						@endforeach
					</select>
				</div>
			</div>
		</div>

	{{ Form::close() }}
	
@stop