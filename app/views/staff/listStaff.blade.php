@extends('templates/staffTemplate')
@section('content')
	
	<h1>Lista del Personal de Biblioteca</h1>
	<div class="container">

		{{ Form::open(array('url'=>'/staff/search_staff','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
			<div class="search_bar">
				{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese Búsqueda')) }}
				{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
			</div></br>
			<select name="search_filter" class="form-control">
				<option value="0" @if($search_filter && $search_filter == 0) selected @endif>Todos</option>
				<option value="1" @if($search_filter && $search_filter == 1) selected @endif>Activos</option>
				<option value="2" @if($search_filter && $search_filter == 2) selected @endif>Eliminados</option>
			</select>	
			{{ HTML::link('staff/list_staff','Listar Todos') }}
		{{ Form::close() }}</br>

		<table class="table table-hover">
			<tr class="info">
				<th>Num. de documento</th>
				<th>Nombre</th>
				<th>Hora de entrada</th>
				<th>Hora de salida</th>
				<th>Asistencia</th>
				<th>Sede</th>
				<th>Rol</th>
				<th class="text-center">Seleccione @if($search_filter!=2) {{ Form::checkbox('select_all') }} @endif</th>
			</tr>
			@foreach($staffs_data as $staff_data)
			<tr class="@if($staff_data->deleted_at) bg-danger @endif">
				<td>
					{{$staff_data->doc_number}}
				</td>
				<td>
					@if($staff_data->deleted_at)
						{{$staff_data->name}} {{$staff_data->lastname}}
					@else
						<a href="{{URL::to('/staff/edit_staff/')}}/{{$staff_data->id}}">{{$staff_data->name}} {{$staff_data->lastname}}</a>
					@endif
				</td>
				<td>
					{{$staff_data->hour_ini}}
				</td>
				<td>
					{{$staff_data->hour_end}}
				</td>
				<td class="text-center">
					@if($staff_data->deleted_at)
						-
					@else
						<a href="{{URL::to('/staff/staff_assistance/')}}/{{$staff_data->id}}">Asistencia</a>
					@endif
				</td>
				<td>
					{{$staff_data->branch_name}}
				</td>
				<td>
					{{$staff_data->role_name}}
				</td>
				<td class="text-center">
					@if($staff_data->deleted_at)
						{{ HTML::link('','Reactivar',array('class'=>'reactivate-staff btn btn-success','data-id'=>$staff_data->id)) }}
					@else
						{{ Form::checkbox('staffs_data',$staff_data->id) }}
					@endif
				</td>
			</tr>
			@endforeach
		</table>
		@if(!$staffs_data->isEmpty() && $search_filter!=2)
			<div class="text-right">
				<div class="loader_container">
					{{ HTML::image('img/loader.gif') }}
				</div>
				{{ HTML::link('','Eliminar',array('id'=>'delete-selected-staffs', 'class'=>'btn btn-danger')) }}
			</div>
		@endif

		@if($search)
			{{ $staffs_data->appends(array('search' => $search,'search_filter'=>$search_filter))->links() }}
		@else
			{{ $staffs_data->links() }}
		@endif
	</div> 
	
@stop