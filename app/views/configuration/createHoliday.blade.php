@extends('templates/configurationTemplate')
@section('content')

	<h1>Registrar Feriados</h1>
	<div class="container">		
		{{ Form::open(array('url'=>'/configuration/submit_create_holiday','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}			
		<br>
		<div class="form-group col-xs-6">	
			<div class="row">
				<div class="col-xs-8">
					{{ Form::label('date_holiday','Ingrese Fecha') }}
					<br>
					{{ Form::text('date_holiday','',array('class'=>'form-control','readonly'=>'')) }}
					<span class="col-xs"><span class="glyphicon-calendar glyphicon"></span></span>
					{{ HTML::link('','Añadir Feriado',array('id'=>'register-holiday', 'class'=>'btn btn-default')) }}
				</div>				
				{{ Form::close() }}
			</div>
		<br>

		</div>	
		
		

		<table class="table table-hover">
			<tr class="info">				
				<th>Fecha</th>		
				<th class="text-center">Seleccione{{ Form::checkbox('select_all') }}</th>										
			</tr>
			@foreach($holidays as $holiday)
			<tr>
				<td>
					{{$holiday->date}}		
				</td>
				<td class="text-center">												
					{{ Form::checkbox('holidays',$holiday->id) }}
				</td>		
			</tr>
			@endforeach
		</table>
		
		@if($holidays)
			<div class="text-right">
				<div class="loader_container">
					{{ HTML::image('img/loader.gif') }}
				</div>
				{{ HTML::link('','Quitar Feriados',array('id'=>'delete-selected-holiday', 'class'=>'btn btn-danger')) }}
			</div>
		@endif	

	</div>
	
@stop