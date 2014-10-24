@extends('templates/loginTemplate')
@section('content')

	<div class="container">
	<h1>Catálogo en linea</h1>
		{{ Form::open(array('url'=>'/submit_catalog','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
				<div class="search_bar">
					{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese Búsqueda')) }}
					{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
				</div>
				<br>
				<div>
					<select name="branch_filter" class="form-control">
						<option value="0">Todas las sedes</option>
						@foreach($branches as $branch)
							@if($branch_filter && ($branch->id == $branch_filter))
								<option value="{{ $branch->id }}" selected>{{ $branch->name }}</option>
							@else
								<option value="{{ $branch->id }}">{{ $branch->name }}</option>
							@endif
						@endforeach
					</select>
					<select name="thematic_area_filter" class="form-control">
						<option value="0">Área temática</option>
						@foreach($thematic_areas as $thematic_area)
							@if($thematic_area_filter && ($thematic_area->id == $thematic_area_filter))
								<option value="{{ $thematic_area->id }}" selected>{{ $thematic_area->name }}</option>
							@else
								<option value="{{ $thematic_area->id }}">{{ $thematic_area->name }}</option>
							@endif
						@endforeach
					</select>
				</div>
		{{ Form::close() }}
		</br>
		<div class="search-criteria">
			@if($search_criteria)
				<h3>
					Resultados de la búsqueda "<strong>{{ $search_criteria }}</strong>" 
					@if($thematic_area_filter == 0)
						en todas las áreas temáticas
					@else
						en el área temática "<strong>{{ $thematic_areas[$thematic_area_filter-1]->name }}</strong>"
					@endif
					@if($branch_filter == 0)
						y en todas las sedes
					@else
						y en la sede "<strong>{{ $branches[$branch_filter-1]->name }}</strong>"
					@endif
				</h3>
			@endif
		</div>
		<h4>Si desea reservar algún material, debe primero ingresar a su cuenta. De no tener una, contáctese con el bibliotecario más cercano.</h4>
		<table class="table table-hover">
			<tr class="info">
				<th>Titulo</th>
				<th>Código</th>
				<th>Autor</th>
				<th>Área temática</th>
				<th>Ejem. disponibles</th>
				<th>Sede</th>
			</tr>
			@if($materials)
				@foreach($materials as $material)
				<tr>
					<td>
						<a href="" class="material-title" data-id="{{$material->mid}}">{{$material->title}}</a>
					</td>
					<td>
						{{ $material->auto_cod }}
					</td>
					<td>
						{{ $material->author }}
					</td>
					<td class="thematic-area-field">
						@foreach($thematic_areas as $thematic_area)
							@if($thematic_area->id == $material->thematic_area)
								{{ $thematic_area->name }}
							@endif
						@endforeach
					</td>
					<td class="total-materials-field">
						{{ $material->total_materials }}
					</td>
					<td class="branches-field">
						@foreach($branches as $branch)
							@if($material->branch_id == $branch->id)
								{{ $branch->name }}
							@endif
						@endforeach
					</td>
				</tr>
				@endforeach
			@endif
		</table>
		@if($search)
			{{ $materials->appends(array('search' => $search,'branch_filter' => $branch_filter,'thematic_area_filter'=>$thematic_area_filter))->links() }}
		@else
			@if($materials)
				{{ $materials->links() }}
			@endif
		@endif
	</div>
	<div class="modal fade" id="material-detail" tabindex="-1" role="dialog" aria-labelledby="material-detail" aria-hidden="true" data-backdrop="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="loader-container" style="text-align:center">
					{{ HTML::image('img/loader.gif') }}
				</div>
		    	<div class="modal-header">
					<h3 class="modal-title" id="material-title"></h3>
				</div>
				<div class="modal-body">
					<table style="width:100%;">
						<tr>
							<td style="width:50%;">
								<span><strong>Autor</strong></span>
								<p id="material-author"></p>
							</td>
							<td>
								<span><strong>Editorial</strong></span>
								<p id="material-editorial"></p>
							</td>
						</tr>
						<tr>
							<td style="width:50%;">
								<span><strong>Área temática</strong></span>
								<p id="material-thematic-area"></p>
							</td>
							<td>
								<span><strong>Edición</strong></span>
								<p id="material-edition"></p>
							</td>
						</tr>
						<tr>
							<td style="width:50%;">
								<span><strong>ISBN</strong></span>
								<p id="material-isbn"></p>
							</td>
							<td>
								<span><strong>Año de publicación</strong></span>
								<p id="material-publication-year"></p>
							</td>
						</tr>
						<tr>
							<td style="width:50%;">
								<span><strong>Número de páginas</strong></span>
								<p id="material-num-pages"></p>
							</td>
							<td>
								<span><strong>Materiales adicionales</strong></span>
								<p id="material-aditional"></p>
							</td>
						</tr>
						<tr>
							<td style="width:50%;">
								<span><strong>Sede</strong></span>
								<p id="material-branch"></p>
							</td>
							<td>
								<span><strong>Ejemplares disponibles</strong></span>
								<p id="material-total-materials"></p>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop