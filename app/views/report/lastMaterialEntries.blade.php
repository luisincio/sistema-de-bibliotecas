@extends('templates/reportTemplate')
@section('content')
	<h1>Reporte de libros ingresados</h1>

	@if (Session::has('danger'))
		<div class="alert alert-danger">{{ Session::get('danger') }}</div>
	@endif
	<div style="height:140px; position:relative;">
		<a href="" id="toggle-button" class="btn btn-default">-</a>
		{{ Form::open(array('url'=>'report/submit_last_material_entries', 'id'=>'toggle-form','role'=>'form')) }}
			<div class="col-xs-6" style="margin-bottom:20px;">
				<div class="row">
					{{ Form::label('date_ini','Fecha de inicio') }}
					<div class="form-group input-group col-xs-8">
						{{ Form::text('date_ini',$date_ini,array('class'=>'form-control','readonly'=>'')) }}
						<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-xs-8">
						{{ Form::label('branch','Sede') }}
						<select name="branch" class="form-control">
							<option value="0">Todas las sedes</option>
							@foreach($branches as $branch)
								@if($branch->id == $selected_branch)
									<option value="{{ $branch->id }}" selected>{{ $branch->name }}</option>
								@else
									<option value="{{ $branch->id }}">{{ $branch->name }}</option>
								@endif
							@endforeach
						</select>
					</div>
				</div>
				{{ Form::submit('Generar reporte',array('id'=>'submit-report', 'class'=>'btn btn-primary')) }}
				<a href="" id="submit_last_material_entries_excel_button" class="btn btn-success"><span class="glyphicon glyphicon-download-alt"></span> Exportar a Excel</a>
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
				<div class="row">
					<div class="form-group col-xs-8">
						{{ Form::label('thematic_area','Área temática') }}
						<select name="thematic_area" class="form-control">
							<option value="0">Todas las áreas temáticas</option>
							@foreach($thematic_areas as $thematic_area)
								@if($thematic_area->id == $selected_thematic_area)
									<option value="{{ $thematic_area->id }}" selected>{{ $thematic_area->name }}</option>
								@else
									<option value="{{ $thematic_area->id }}">{{ $thematic_area->name }}</option>
								@endif
							@endforeach
						</select>
					</div>
				</div>
			</div>
		{{ Form::close() }}
	</div>
	{{ Form::open(array('url'=>'report/submit_last_material_entries_excel', 'id' => 'submit_last_material_entries_excel' ,'role'=>'form')) }}
		{{ Form::hidden('date_ini_excel',$date_ini) }}
		{{ Form::hidden('date_end_excel',$date_end) }}
		{{ Form::hidden('branch_excel',$selected_branch) }}
		{{ Form::hidden('thematic_area_excel',$selected_thematic_area) }}
	{{ Form::close() }}

	@if($total)
		<h4>Total de libros: {{ $total }}</h4>
	@endif
	@if($report_rows)
		<table class="table table-hover">
			<tr class="info">
				<th>Código base</th>
				<th>ISBN</th>
				<th>Título</th>
				<th>Autor</th>
				<th>Editorial</th>
				<th>Edición</th>
				<th>Cantidad</th>
			</tr>
			@foreach($report_rows as $report_row)
			<tr>
				<td>
					{{$report_row->base_cod}}
				</td>
				<td>
					{{$report_row->isbn}}
				</td>
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
					{{$report_row->total_entries}}
				</td>
			</tr>
			@endforeach
		</table>
	@endif
@stop