@extends('templates/reservationTemplate')
@section('content')

	<h1>Ver reservas de cubículos por usuario</h1>
	<div class="container">

		{{ Form::open(array('url'=>'/reservation/submit_search_cubicle_reservations','role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
				<div class="search_bar @if($errors->first('search')) has-error @endif">
					{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese num. documento')) }}
					{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
				</div>
		{{ Form::close() }}

		@if($search)
			@if($reservation_person)
				<h4>Cubículos reservados por {{ $reservation_person->lastname }}, {{ $reservation_person->name }} ({{ $reservation_person->doc_number }})</h4>
			@else
				<h4>No se encontró al usuario.</h4>
			@endif
		@endif

		<table class="table table-hover" style="margin-top:20px;">
			<tr class="info">
				<th>Cubículo</th>
				<th>Número de personas</th>
				<th>Hora de inicio</th>
				<th>Hora de finalización</th>
				<th>Fecha de reserva</th>
			</tr>
			@if($search && $reservations)
				@foreach( $reservations as $reservation)
				<tr>
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
				</tr>
				@endforeach
			@endif
		</table>
	</div>
	
@stop