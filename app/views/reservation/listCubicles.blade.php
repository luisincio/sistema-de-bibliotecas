@extends('templates/reservationTemplate')
@section('content')

	<script type="text/javascript">
		var max_hour_cubicle_loan = "{{$config->max_hours_loan_cubicle}}";
	</script>
	<h1>Reservar Cubículo</h1>
	<div class="container">
		{{ Form::open(array('url'=>'','role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
			<div class="search-cubicles-bar">
				<select name="branch_filter" class="form-control">
					@foreach($branches as $branch)
						<option value="{{ $branch->id }}">{{ $branch->name }}</option>
					@endforeach
				</select>
				<select name="cubicle_type_filter" class="form-control">
					@foreach($cubicle_types as $cubicle_type)
						<option value="{{ $cubicle_type->id }}">{{ $cubicle_type->name }}</option>
					@endforeach
				</select>
				{{ Form::submit('Buscar',array('id'=>'submit-search-cubicles','class'=>'btn btn-info')) }}
			</div>
		{{ Form::close() }}
		<h4>El tiempo máximo para reservas de cubículos es de: <strong>{{ $config->max_hours_loan_cubicle }} horas</strong>.</h4>
		<div class="big-loader-container">
			{{ HTML::image('img/big-loader.gif','',array('id' => 'img-loader')) }}
		</div>
		<div id="cubicle-table-container">
			<table id="cubicle-table" class="table table-bordered">
			</table>
		</div>
	</div>

	<div class="modal fade" id="cubicle-reservation-detail" tabindex="-1" role="dialog" aria-labelledby="cubicle-reservation-detail" aria-hidden="true" data-backdrop="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="loader-container" style="text-align:center">
					{{ HTML::image('img/loader.gif') }}
				</div>
		    	<div class="modal-header">
					<h3 class="modal-title" id="cubicle-reservation-title">Información de reserva de cubículo</h3>
				</div>
				<div class="modal-body">
					<table style="width:100%;">
						<tr style="vertical-align: top;">
							<td style="width:50%;">
								<span><strong>Usuario que realizó la reserva</strong></span>
								<p id="cubicle-reservation-user"></p>
							</td>
							<td>
								<span><strong>Cantidad de personas</strong></span>
								<p id="cubicle-reservation-num-person"></p>
							</td>
						</tr>
						<tr style="vertical-align: top;">
							<td style="width:50%;">
								<span><strong>Hora de inicio</strong></span>
								<p id="cubicle-reservation-hour-in"></p>
							</td>
							<td>
								<span><strong>Hora de finalización</strong></span>
								<p id="cubicle-reservation-hour-out"></p>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="cubicle-reservation-form" tabindex="-1" role="dialog" aria-labelledby="cubicle-reservation-form" aria-hidden="true" data-backdrop="true">
		<div class="modal-dialog">
			<div class="modal-content">
		    	<div class="modal-header">
					<h3 class="modal-title" id="cubicle-reservation-form-title">Formulario de reserva de cubículo</h3>
				</div>
				<div class="modal-body">
					<table style="width:100%;">
						<tr style="vertical-align: top;">
							<div class="col-xs-8">
								<strong><p id="cubicle-reservation-form-info"></p></strong>
							</div>
						</tr>
						<tr style="vertical-align: top;">
							<td style="width:50%;">
								<div class="col-xs-8">
									<span><strong>Usuario que reserva</strong></span>
									<p id="cubicle-reservation-form-user">{{ $person->lastname }}, {{ $person->name }}</p>
									{{ Form::hidden('cubicle_id', '') }}
								</div>
							</td>
							<td>
								<div class="col-xs-8">
									<span><strong>Cantidad de personas</strong></span>
									{{ Form::text('cubicle_reservation_form_num_person','',array('class'=>'form-control')) }}
								</div>
							</td>
						</tr>
						<tr style="vertical-align: top;">
							<td style="width:50%;">
								<div class="col-xs-8">
									<span><strong>Hora de inicio</strong></span>
									{{ Form::text('cubicle_reservation_form_hour_in','',array('class'=>'form-control','readonly'=>'')) }}
								</div>
							</td>
							<td>
								<div class="col-xs-8">
									<span><strong>Hora de finalización</strong></span>
									{{ Form::text('cubicle_reservation_form_hour_out','',array('class'=>'form-control','readonly'=>'')) }}
								</div>
							</td>
						</tr>
					</table>
					{{ HTML::link('','Reservar',array('id'=>'submit-cubicle-reservation-form', 'class'=>'btn btn-success','style'=>'margin: 15px 0 0 15px;')) }}
					<div class="loader_container">
						{{ HTML::image('img/loader.gif') }}
					</div>
				</div>
			</div>
		</div>
	</div>
	
@stop