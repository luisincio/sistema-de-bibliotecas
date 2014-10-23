@extends('templates/reservationTemplate')
@section('content')

	<h1>Mis Materiales Reservados</h1>
	<div class="container">
		<table class="table table-hover">
			<tr class="info">
				<th>Código</th>
				<th>Título</th>
				<th>Autor</th>
				<th>Fecha de reserva</th>
				<th>Fecha de expiración</th>
				<th class="text-center">Seleccione{{ Form::checkbox('select_all') }}</th>
			</tr>
			@foreach( $reservations as $reservation)
			<tr>
				<td>
					{{$reservation->auto_cod}}
				</td>
				<td>
					{{$reservation->title}}
				</td>
				<td>
					{{$reservation->author}}
				</td>
				<td>
					{{$reservation->reservation_date}}
				</td>
				<td>
					@if($reservation->expire_at)
						{{$reservation->expire_at}}
					@else
						En cola de espera
					@endif
				</td>
				<td class="text-center">
					{{ Form::checkbox('reservations',$reservation->id) }}
				</td>
			</tr>
			@endforeach
		</table>
		@if(!$reservations->isEmpty())
			<div class="text-right">
				<div class="loader_container">
					{{ HTML::image('img/loader.gif') }}
				</div>
				{{ HTML::link('','Anular',array('id'=>'delete-selected-reservations', 'class'=>'btn btn-danger')) }}
			</div>
		@endif
		{{ $reservations->links() }}
	</div>
	
@stop