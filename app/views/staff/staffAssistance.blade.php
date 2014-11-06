@extends('templates/staffTemplate')
@section('content')
	
	<h1>Registro de asistencia de {{ $staff_info->name }} {{ $staff_info->lastname }}</h1>
	<div class="container">

		<table class="table table-hover">
			<tr class="info">
				<th>Fecha</th>
				<th>Hora de entrada</th>
				<th>Hora de salida</th>
			</tr>
			@foreach($staff_assistances as $staff_assistance)
			<tr>
				<td>
					{{$staff_assistance->date}}
				</td>
				<td>
					{{$staff_assistance->hour_in}}
				</td>
				<td>
					{{$staff_assistance->hour_out}}
				</td>
			</tr>
			@endforeach
		</table>
		{{ $staff_assistances->links() }}
	</div> 
	
@stop