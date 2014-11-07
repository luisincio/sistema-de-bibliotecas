@extends('templates/reportTemplate')
@section('content')
	<h1>Reporte de solicitudes de compra</h1>

	@if (Session::has('danger'))
		<div class="alert alert-danger">{{ Session::get('danger') }}</div>
	@endif
	<div style="height:220px; position:relative;">
		<a href="" id="toggle-button" class="btn btn-default">-</a>
		{{ Form::open(array('url'=>'report/submit_approved_rejected_purchase_orders', 'id'=>'toggle-form','role'=>'form')) }}
			<div class="col-xs-6" style="margin-bottom:20px;">
				<div class="row">
					{{ Form::label('date_ini','Fecha de inicio') }}
					<div class="form-group input-group col-xs-8">
						{{ Form::text('date_ini',$date_ini,array('class'=>'form-control','readonly'=>'')) }}
						<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
					</div>
				</div>
				<div class="row">
					<div class="form-group input-group col-xs-8">
						{{ Form::label('approved_rejected_filter','Estado de la orden de compra') }}
						<select name="approved_rejected_filter" class="form-control">
							<option value="0" @if($approved_rejected_filter == 0) selected @endif>Aprobadas y Rechazadas</option>
							<option value="1" @if($approved_rejected_filter == 1) selected @endif>Solo Aprobadas</option>
							<option value="2" @if($approved_rejected_filter == 2) selected @endif>Solo Rechazadas</option>
						</select>
					</div>
				</div>
				{{ Form::submit('Generar reporte',array('id'=>'submit-report', 'class'=>'btn btn-primary')) }}
				<a href="" id="submit_approved_rejected_purchase_orders_excel_button" class="btn btn-success"><span class="glyphicon glyphicon-download-alt"></span> Exportar a Excel</a>
				{{ HTML::link('','Cancelar',array('id'=>'cancel')) }}
			</div>
			<div class="col-xs-6">
				<div class="row">
					{{ Form::label('date_end','Fecha fin') }}
					<div class="form-group input-group col-xs-8">
						{{ Form::text('date_end',$date_end,array('class'=>'form-control','readonly'=>'')) }}
						<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
					</div>
				</div>
			</div>
		{{ Form::close() }}
	</div>
	{{ Form::open(array('url'=>'report/submit_approved_rejected_purchase_orders_excel', 'id' => 'submit_approved_rejected_purchase_orders_excel' ,'role'=>'form')) }}
		{{ Form::hidden('date_ini_excel',$date_ini) }}
		{{ Form::hidden('date_end_excel',$date_end) }}
		{{ Form::hidden('approved_rejected_filter_excel',$approved_rejected_filter) }}
	{{ Form::close() }}

	@if($total)
		<div class="col-xs-6">
			<div class="row">
				@if($report_rows_approved)
					<h4>Total de solicitudes aprovadas: {{ $total_approved }}</h4>
					<h4>Costo total de solicitudes aprobadas: S/. {{ $total_amount_approved }}</h4>
				@endif
				<h4>Total de solicitudes: {{ $total }}</h4>
			</div>
		</div>
		@if($report_rows_rejected)
			<div class="col-xs-6">
				<div class="row">
					<h4>Total de solicitudes rechazadas: {{ $total_rejected }}</h4>
					<h4>Costo total de solicitudes rechazadas: S/. {{ $total_amount_rejected }}</h4>
				</div>
			</div>
		@endif
	@endif
	@if($total)
		<table class="table table-hover">
			<tr class="info">
				<th>ID</th>
				<th>Fecha de emisión</th>
				<th>Fecha de expiración</th>
				<th>Descripción</th>
				<th>Proveedor</th>
				<th>Costo total</th>
				<th>Estado</th>
			</tr>
			@if($report_rows_approved)
				@foreach($report_rows_approved as $report_row_approved)
				<tr>
					<td>
						{{$report_row_approved->id}}
					</td>
					<td>
						{{$report_row_approved->date_issue}}
					</td>
					<td>
						{{$report_row_approved->expire_at}}
					</td>
					<td>
						{{$report_row_approved->description}}
					</td>
					<td>
						{{$report_row_approved->name}}
					</td>
					<td>
						{{$report_row_approved->total_amount}}
					</td>
					<td>
						Aprobado
					</td>
				</tr>
				@endforeach
			@endif
			@if($report_rows_rejected)
				@foreach($report_rows_rejected as $report_row_rejected)
				<tr class="bg-danger">
					<td>
						{{$report_row_rejected->id}}
					</td>
					<td>
						{{$report_row_rejected->date_issue}}
					</td>
					<td>
						{{$report_row_rejected->expire_at}}
					</td>
					<td>
						{{$report_row_rejected->description}}
					</td>
					<td>
						{{$report_row_rejected->name}}
					</td>
					<td>
						{{$report_row_rejected->total_amount}}
					</td>
					<td>
						Rechazado
					</td>
				</tr>
				@endforeach
			@endif
		</table>
	@endif
@stop