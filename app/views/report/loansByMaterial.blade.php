@extends('templates/reportTemplate')
@section('content')
	<h1>Reporte de préstamos por material</h1>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('code') }}</strong></p>
		</div>
	@endif

	@if (Session::has('danger'))
		<div class="alert alert-danger">{{ Session::get('danger') }}</div>
	@endif
	<div style="height:140px; position:relative;">
		<a href="" id="toggle-button" class="btn btn-default">-</a>
		{{ Form::open(array('url'=>'report/submit_loans_by_material', 'id'=>'toggle-form', 'role'=>'form')) }}
			<div class="col-xs-6" style="margin-bottom:20px;">
				<div class="row">
					<div class="form-group col-xs-8">
						{{ Form::label('code','Código (4 letras)') }}
						{{ Form::text('code',$code,array('class'=>'form-control')) }}
					</div>
				</div>
				{{ Form::submit('Generar reporte',array('id'=>'submit-report', 'class'=>'btn btn-primary')) }}
				<a href="" id="submit_loans_by_material_excel_button" class="btn btn-success"><span class="glyphicon glyphicon-download-alt"></span> Exportar a Excel</a>
				{{ HTML::link('','Cancelar',array('id'=>'cancel')) }}
			</div>
			<div class="col-xs-6">
				<div class="row">
					{{ Form::label('date_ini','Fecha de inicio') }}
					<div class="form-group input-group col-xs-8">
						{{ Form::text('date_ini',$date_ini,array('class'=>'form-control','readonly'=>'')) }}
						<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
					</div>
				</div>
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
	{{ Form::open(array('url'=>'report/submit_loans_by_material_excel', 'id' => 'submit_loans_by_material_excel' ,'role'=>'form')) }}
		{{ Form::hidden('code_excel',$code) }}
		{{ Form::hidden('date_ini_excel',$date_ini) }}
		{{ Form::hidden('date_end_excel',$date_end) }}
	{{ Form::close() }}

	@if($total)
		<h4>Título del material: {{ $material_title }}</h4>
		<h4>Total de usuarios a los que se le prestó el material: {{ $total_users }}</h4>
		<h4>Total de préstamos en el período: {{ $total }}</h4></br>
	@endif
	@if($report_rows)
		<h4>Resumen de préstamos</h4>
		<table class="table table-hover">
			<tr class="info">
				<th>Número de Documento</th>
				<th>Nombres</th>
				<th>Apellidos</th>
				<th>E-mail</th>
				<th>Veces prestadas</th>
			</tr>
			@foreach($report_rows as $report_row)
			<tr>
				<td>
					{{$report_row->doc_number}}
				</td>
				<td>
					{{$report_row->name}}
				</td>
				<td>
					{{$report_row->lastname}}
				</td>
				<td>
					{{$report_row->email}}
				</td>
				<td>
					{{$report_row->loans_by_user}}
				</td>
			</tr>
			@endforeach
		</table>
	@endif
	@if($report_rows_detailed)
		<h4>Detalle de préstamos</h4>
		<table class="table table-hover">
			<tr class="info">
				<th>Número de Documento</th>
				<th>Nombres</th>
				<th>Apellidos</th>
				<th>E-mail</th>
				<th>Fecha y hora de préstamo</th>
			</tr>
			@foreach($report_rows_detailed as $report_row_detailed)
			<tr>
				<td>
					{{$report_row_detailed->doc_number}}
				</td>
				<td>
					{{$report_row_detailed->name}}
				</td>
				<td>
					{{$report_row_detailed->lastname}}
				</td>
				<td>
					{{$report_row_detailed->email}}
				</td>
				<td>
					{{$report_row_detailed->created_at}}
				</td>
			</tr>
			@endforeach
		</table>
	@endif
@stop