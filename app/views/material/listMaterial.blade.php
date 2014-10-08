@extends('templates/materialTemplate')
@section('content')

	<h1>Buscar Materiales</h1>
	<div class="container">
		{{ Form::open(array('url'=>'/material/search_material','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
				<div class="search_bar">
					{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese Búsqueda')) }}
					{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
				</div>
				<br>
				<div>
					<select name="search_filter" class="form-control">
						<option value="0">Todo</option>
						@foreach($thematic_areas as $thematic_area)
							<option value="{{ $thematic_area->id }}">{{ $thematic_area->name }}</option>
						@endforeach
					</select>
				</div>
		{{ Form::close() }}
		<div class="search-criteria">
			@if($search_criteria)
				<h3>
					Resultados de la búsqueda "{{ $search_criteria }}"
				</h3>
			@endif
		</div>
		<table class="table table-hover">
			<tr class="info">
				<th>Titulo</th>
				<th>Código</th>
				<th>Autor</th>
				<th>Editorial</th>
				<th>ISBN</th>
				<th class="text-center">Seleccione</th>
			</tr>
			@foreach( $materials as $material)
			<tr>
				<td>
					<a href="{{URL::to('/material/edit_material/')}}/{{$material->mid}}">{{$material->title}}</a>
				</td>
				<td>
					{{ $material->auto_cod }}
				</td>
				<td>
					{{ $material->author }}
				</td>
				<td>
					{{ $material->editorial }}
				</td>
				<td>
					{{ $material->isbn }}
				</td>
				<td class="text-center">
					{{ Form::checkbox('material',$material->mid) }}
				</td>
			</tr>
			@endforeach
		</table>
		@if(!$materials->isEmpty())
			<div class="text-right">
				<div class="loader_container">
					{{ HTML::image('img/loader.gif') }}
				</div>
				{{ HTML::link('','Eliminar',array('id'=>'delete-selected-materials', 'class'=>'btn btn-danger')) }}
			</div>
		@endif
		@if($search)
			{{ $materials->appends(array('search' => $search,'search_filter' => $search_filter))->links() }}
		@else
			{{ $materials->links() }}
		@endif
	</div>
	
@stop