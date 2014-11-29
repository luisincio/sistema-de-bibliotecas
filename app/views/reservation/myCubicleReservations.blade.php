@extends('templates/reservationTemplate')
@section('content')

	<h1>Mis cubículos reservados</h1>
	<div class="container">

		<table class="table table-hover" style="margin-top:20px;">
			<tr class="info">
				<th>Sede</th>
				<th>Cubículo</th>
				<th>Número de personas</th>
				<th>Hora de inicio</th>
				<th>Hora de finalización</th>
				<th>Fecha de reserva</th>
				<th class="text-center">Seleccione{{ Form::checkbox('select_all') }}</th>
			</tr>
			@foreach( $reservations as $reservation)
			<tr>
				<td>
					{{$reservation->name}}
				</td>
				<td>
					{{$reservation->code}}
				</td>
				<td>
					{{$reservation->num_person}}
				</td>
				<td>
					{{$reservation->hour_in}}
				</td>
				<td>
					{{$reservation->hour_out}}
				</td>
				<td>
					{{$reservation->reserved_at}}
				</td>
				<td class="text-center">
					{{ Form::checkbox('reservacion',$reservation->id) }}
				</td>
			</tr>
			@endforeach
		</table>
		@if($reservations)
			<div class="text-right">
				<div class="loader_container">
					{{ HTML::image('img/loader.gif') }}
				</div>
				{{ HTML::link('','Eliminar',array('id'=>'delete-selected-cubicle-reservations', 'class'=>'btn btn-danger')) }}
			</div>
		@endif
	</div>
	
@stop