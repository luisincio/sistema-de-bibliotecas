@extends('templates/configurationTemplate')
@section('content')

	<h1>Lista de Turnos</h1>
		<div class="row">	
			@if ($errors->has())
				<div class="alert alert-danger" role="alert">
					<p><strong>{{ $errors->first('nombre') }}</strong></p>
					<p><strong>{{ $errors->first('hora_ini') }}</strong></p>
					<p><strong>{{ $errors->first('hora_fin') }}</strong></p>
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
			{{ Form::open(array('url'=>'config/submit_create_turn', 'role'=>'form')) }}
				<div class="form-group col-xs-4 @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombre') }}
					{{ Form::text('nombre',Input::old('nombre'),array('class'=>'form-control')) }}
					{{ Form::hidden('branch_id',$branch_id) }}
				</div>
				<div class="form-group col-xs-4 @if($errors->first('hora_ini')) has-error has-feedback @endif">
					{{ Form::label('hora_ini','Hora Inicio') }}
					{{ Form::text('hora_ini',Input::old('hora_ini'),array('class'=>'form-control','readonly'=>'')) }}
				</div>
				<div class="form-group col-xs-4 @if($errors->first('hora_fin')) has-error has-feedback @endif">
					{{ Form::label('hora_fin','Hora Fin') }}
					{{ Form::text('hora_fin',Input::old('hora_fin'),array('class'=>'form-control','readonly'=>'')) }}
				</div>
				<div class="form-group col-xs-4">
					{{ Form::submit('Registrar',array('id'=>'submit-create', 'class'=>'btn btn-primary')) }}
					{{ HTML::link('','Limpiar Campos',array('id'=>'clear-fields', 'class'=>'btn btn-default')) }}
					{{ HTML::link('','Cancelar',array('id'=>'cancel')) }}	
				</div>	
			<br></br>
			{{ Form::close() }}
		</div>
		<div class="container">
			<table class="table table-hover">
				<tr class="info">
					<th>Nombre de Turno</th>
					<th>Hora Inicio (HH:MM)</th>
					<th>Hora Fin (HH:MM)</th>
					<th class="text-center">Seleccione{{ Form::checkbox('select_all') }}</th>
				</tr>
				@if($turns)
					@foreach( $turns as $turn)
					<tr>
						<td>
							{{$turn->name}}
						</td>
						<td>
							{{ $turn->hour_ini }}
						</td>
						<td>
							{{ $turn->hour_end }}
						</td>
						<td class="text-center">
							{{ Form::checkbox('turns',$turn->id) }}
						</td>
					</tr>
					@endforeach
				@endif	
			</table>
			@if($turns)
				@if(!$turns->isEmpty())
					<div class="text-right">
						<div class="loader_container">
							{{ HTML::image('img/loader.gif') }}
						</div>
						{{ HTML::link('','Eliminar',array('id'=>'delete-selected-turns', 'class'=>'btn btn-danger')) }}
					</div>
				@endif
			@endif
		</div>	
	
@stop