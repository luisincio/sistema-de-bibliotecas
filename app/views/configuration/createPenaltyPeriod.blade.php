@extends('templates/configurationTemplate')
@section('content')

	<h1>Lista de Periodos de Penalidad</h1>
		<div class="row">	
			@if ($errors->has())
				<div class="alert alert-danger" role="alert">
					<p><strong>{{ $errors->first('nombre') }}</strong></p>
					<p><strong>{{ $errors->first('fecha_ini') }}</strong></p>
					<p><strong>{{ $errors->first('fecha_fin') }}</strong></p>
					<p><strong>{{ $errors->first('dias_penalidad') }}</strong></p>
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
			{{ Form::open(array('url'=>'config/submit_create_penalty_period', 'role'=>'form')) }}
				<div class="col-xs-6">
					<div class="row">
						<div class="form-group col-xs-8 @if($errors->first('nombre')) has-error has-feedback @endif">
							{{ Form::label('nombre','Nombre') }}
							{{ Form::text('nombre',Input::old('nombre'),array('class'=>'form-control')) }}
						</div>
					</div>
					<div class="row">
						{{ Form::label('fecha_ini','Fecha Inicio') }}
						<div class="form-group input-group col-xs-8 @if($errors->first('fecha_ini')) has-error has-feedback @endif">
							{{ Form::text('fecha_ini',Input::old('fecha_ini'),array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
						</div>
					</div>						
					{{ Form::submit('Registrar',array('id'=>'submit-create', 'class'=>'btn btn-primary')) }}
					{{ HTML::link('','Limpiar Campos',array('id'=>'clear-fields', 'class'=>'btn btn-default')) }}
					{{ HTML::link('','Cancelar',array('id'=>'cancel')) }}
					<br></br>
				</div>		
				<div class="col-xs-6">
					<div class="row">
						<div class="form-group col-xs-8  @if($errors->first('nombre')) has-error has-feedback @endif">
							{{ Form::label('dias_penalidad','Días de penalidad') }}
							{{ Form::text('dias_penalidad',Input::old('dias_penalidad'),array('class'=>'form-control')) }}
						</div>
					</div>		
					<div class="row">
						{{ Form::label('fecha_fin','Fecha Fin') }}
						<div class="form-group input-group col-xs-8 @if($errors->first('fecha_fin')) has-error has-feedback @endif">
							{{ Form::text('fecha_fin',Input::old('fecha_fin'),array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
						</div>
					</div>
				</div>		
			<br></br>
			{{ Form::close() }}
		</div>
		<div class="container">
			<table class="table table-hover">
				<tr class="info">
					<th>Nombre de Periodo</th>
					<th>Fecha Inicio</th>
					<th>Fecha Fin</th>
					<th>Días de Penalidad</th>
					<th class="text-center">Seleccione{{ Form::checkbox('select_all') }}</th>
				</tr>
				@foreach( $penalty_periods as $penalty_period)
				<tr>
					<td>
						{{$penalty_period->name}}
					</td>
					<td>
						{{ $penalty_period->date_ini }}
					</td>
					<td>
						{{ $penalty_period->date_end }}
					</td>
					<td>
						{{ $penalty_period->penalty_days }}
					</td>					
					<td class="text-center">
						{{ Form::checkbox('penalty_periods',$penalty_period->id) }}
					</td>
				</tr>
				@endforeach
			</table>
			@if($penalty_periods)
				@if(!$penalty_periods->isEmpty())
					<div class="text-right">
						<div class="loader_container">
							{{ HTML::image('img/loader.gif') }}
						</div>
						{{ HTML::link('','Eliminar',array('id'=>'delete-selected-penalty_periods', 'class'=>'btn btn-danger')) }}
					</div>
				@endif
			@endif
		</div>	
	
@stop