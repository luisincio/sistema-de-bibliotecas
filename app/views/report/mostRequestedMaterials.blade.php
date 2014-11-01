@extends('templates/reportTemplate')
@section('content')
	<h1>Reporte de materiales más solicitados</h1>

	@if (Session::has('danger'))
		<div class="alert alert-danger">{{ Session::get('danger') }}</div>
	@endif
	<div style="height:140px; position:relative;">
		<a href="" id="toggle-button" class="btn btn-default">-</a>
		{{ Form::open(array('url'=>'report/submit_most_requested_materials', 'id'=>'toggle-form', 'role'=>'form')) }}
			<div class="col-xs-6" style="margin-bottom:20px;">
				<div class="row">
					{{ Form::label('date_ini','Fecha de inicio') }}
					<div class="form-group input-group col-xs-8">
						{{ Form::text('date_ini',$date_ini,array('class'=>'form-control','readonly'=>'')) }}
						<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
					</div>
				</div>
				{{ Form::submit('Generar reporte',array('id'=>'submit-report', 'class'=>'btn btn-primary')) }}
				<a href="" id="submit_most_requested_materials_excel_button" class="btn btn-success"><span class="glyphicon glyphicon-download-alt"></span> Exportar a Excel</a>
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
	{{ Form::open(array('url'=>'report/submit_most_requested_materials_excel', 'id' => 'submit_most_requested_materials_excel' ,'role'=>'form')) }}
		{{ Form::hidden('date_ini_excel',$date_ini) }}
		{{ Form::hidden('date_end_excel',$date_end) }}
	{{ Form::close() }}

	@if($total)
		<h4>Total de solicitudes: {{ $total }}</h4>
	@endif
	@if($report_rows)
		<table class="table table-hover">
			<tr class="info">
				<th>Título</th>
				<th>Autor</th>
				<th>Editorial</th>
				<th>Edición</th>
				<th>Tipo de solicitud</th>
				<th>Cantidad de solicitudes</th>
			</tr>
			@foreach($report_rows as $report_row)
			<tr>
				<td>
					{{$report_row->title}}
				</td>
				<td>
					{{$report_row->author}}
				</td>
				<td>
					{{$report_row->editorial}}
				</td>
				<td>
					{{$report_row->edition}}
				</td>
				<td>
					{{$report_row->name}}
				</td>
				<td>
					{{$report_row->total_requests}}
				</td>
			</tr>
			@endforeach
		</table>
	@endif
@stop