@extends('templates/configurationTemplate')
@section('content')

	<h1>Lista de Periodos de Devolución</h1>
		<div class="row">	
			@if ($errors->has())
				<div class="alert alert-danger" role="alert">
					<p><strong>{{ $errors->first('nombre') }}</strong></p>
					<p><strong>{{ $errors->first('fecha_ini') }}</strong></p>
					<p><strong>{{ $errors->first('fecha_fin') }}</strong></p>
					<p><strong>{{ $errors->first('max_dias_devolucion') }}</strong></p>
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
			{{ Form::open(array('url'=>'config/submit_create_devolution_period', 'role'=>'form')) }}
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
					<div class="row">
						<div class="form-group col-xs-8  @if($errors->first('max_dias_devolucion')) has-error has-feedback @endif">
							{{ Form::label('max_dias_devolucion','Máximo días de devolución') }}
							{{ Form::text('max_dias_devolucion',Input::old('max_dias_devolucion'),array('class'=>'form-control')) }}
						</div>
					</div>					
					{{ Form::submit('Registrar',array('id'=>'submit-create', 'class'=>'btn btn-primary')) }}
					{{ HTML::link('','Limpiar Campos',array('id'=>'clear-fields', 'class'=>'btn btn-default')) }}
					{{ HTML::link('','Cancelar',array('id'=>'cancel')) }}
					<br></br>
				</div>		
				<div class="col-xs-6">
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::label('descripcion','Descripción') }}
							{{ Form::text('descripcion',Input::old('descripcion'),array('class'=>'form-control')) }}
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
					<th>Nombre de periodo</th>
					<th>Descripción</th>
					<th>Fecha Inicio</th>
					<th>Fecha Fin</th>
					<th>Máximo días de devolución</th>
					<th class="text-center">Seleccione{{ Form::checkbox('select_all') }}</th>
				</tr>
				@foreach( $devolution_periods as $devolution_period)
				<tr>
					<td>
						{{$devolution_period->name}}
					</td>
					<td>
						{{$devolution_period->description}}
					</td>
					<td>
						{{ $devolution_period->date_ini }}
					</td>
					<td>
						{{ $devolution_period->date_end }}
					</td>
					<td>
						{{ $devolution_period->max_days_devolution }}
					</td>					
					<td class="text-center">
						{{ Form::checkbox('devolution_periods',$devolution_period->id) }}
					</td>
				</tr>
				@endforeach
			</table>
			@if($devolution_periods)
				@if(!$devolution_periods->isEmpty())
					<div class="text-right">
						<div class="loader_container">
							{{ HTML::image('img/loader.gif') }}
						</div>
						{{ HTML::link('','Eliminar',array('id'=>'delete-selected-devolution_periods', 'class'=>'btn btn-danger')) }}
					</div>
				@endif
			@endif
		</div>	
	
@stop