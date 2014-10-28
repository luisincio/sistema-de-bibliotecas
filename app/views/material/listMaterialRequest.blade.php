@extends('templates/materialTemplate')
@section('content')

	<h1>Buscar Solicitudes</h1>
	<div class="container">
		
		@if (Session::has('danger'))
			<div class="alert alert-danger">
				<p><strong>{{ Session::get('danger') }}</strong></p>
			</div>
		@endif

		{{ Form::open(array('url'=>'/material/search_material_request','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
				<div class="search_bar">
					{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese Búsqueda')) }}
					{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
				</div>
				<br>
				<div>
					<select name="search_filter" class="form-control">
						<option value="0">Todo</option>
						@foreach($material_request_types as $material_request_type)
							@if($search_filter && ($material_request_type->id == $search_filter))
								<option value="{{ $material_request_type->id }}" selected>{{ $material_request_type->name }}</option>
							@else
								<option value="{{ $material_request_type->id }}">{{ $material_request_type->name }}</option>
							@endif
						@endforeach
					</select>
					{{ HTML::link('material/list_material_request','Listar Todos') }}
				</div>
				<br>
				<div class="col-xs">
					{{ Form::label('date_ini','Fecha Desde') }}
					<br>
					{{ Form::text('date_ini',$date_ini,array('class'=>'form-control','readonly'=>'')) }}
					<span class="col-xs"><span class="glyphicon-calendar glyphicon"></span></span>
				</div>
				<br>
				<div class="col-xs">
					{{ Form::label('date_end','Fecha Hasta') }}
					<br>
					{{ Form::text('date_end',$date_end,array('class'=>'form-control','readonly'=>'')) }}
					<span class="col-xs"><span class="glyphicon-calendar glyphicon"></span></span>
				</div>
		{{ Form::close() }}
		

		<div class="search-criteria">
			@if($search_criteria)
				<h3>
					Resultados de la búsqueda "{{ $search_criteria }}" 
					@if($search_filter == 0)
					en todas las solicitudes
					@else
					en solicitud de  "{{ $material_request_types[$search_filter-1]->name }}"
					@endif
				</h3>
			@endif
		</div>
		<table class="table table-hover">
			<tr class="info">				
				<th>Titulo</th>								
				<th>Autor</th>
				<th>Editorial</th>
				<th>Edición</th>
			</tr>
			@foreach( $materials_request as $material_request)
			<tr>
				<td>
					{{$material_request->title}}
				</td>				
				<td>
					{{ $material_request->author }}
				</td>
				<td>
					{{ $material_request->editorial }}
				</td>
				<td>
					{{ $material_request->edition }}
				</td>
			</tr>
			@endforeach
		</table>
		@if($search)
			{{ $materials_request->appends(array('search' => $search,'search_filter' => $search_filter))->links() }}
		@else
			{{ $materials_request->links() }}
		@endif
	</div>
	
@stop