@extends('templates/configurationTemplate')
@section('content')
	<script type="text/javascript">
		var cubicle_types = {{$cubicle_types}};
	</script>
	<h1>Registrar Infraestructura</h1>
	<div class="container">
		{{ Form::open(array('url'=>'/config/search_supplier','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
		<div class="search_bar">
			<select name="branch_filter" class="form-control">
				<option class="form-control" value="0">Seleccione una sede</option>
				@foreach($branches as $branch)
					<option class="form-control" value="{{ $branch->id }}">{{ $branch->name }}</option>
				@endforeach
			</select>
			{{ Form::submit('Buscar',array('id'=>'submit-search-physical-elements-form','class'=>'btn btn-info','style'=>'display:none;')) }}
		</div>
		{{ Form::close() }}

		<ul id="physical-elements-nav-tabs" class="nav nav-tabs" role="tablist">
			<li class="active"><a href="#cubicle-tab" role="tab" data-toggle="tab">Cubículos</a></li>
			<li><a href="#shelves-tab" role="tab" data-toggle="tab">Estantes</a></li>
			<li><a href="#physical-elements-tab" role="tab" data-toggle="tab">Elementos Físicos</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="cubicle-tab">
				{{ Form::open(array('url'=>'','role'=>'form', 'class' => 'form-inline', 'style' => 'margin:15px 0')) }}
				<div class="form-group">
					{{ Form::label('codigo_cubiculo_crear','Código') }}
					{{ Form::text('codigo_cubiculo_crear','',array('class'=>'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('capacidad_cubiculo_crear','Capacidad') }}
					{{ Form::text('capacidad_cubiculo_crear','',array('class'=>'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('tipo_cubiculo_crear','Tipo de cubículo') }}
					<select name="tipo_cubiculo_crear" class="form-control">
						<option class="form-control" value="0">Seleccione un tipo de cubículo</option>
						@foreach($cubicle_types as $cubicle_type)
							<option class="form-control" value="{{ $cubicle_type->id }}">{{ $cubicle_type->name }}</option>
						@endforeach
					</select>
				</div>
				{{ HTML::link('','Registrar',array('id'=>'submit-create-cubicle', 'class'=>'btn btn-info')) }}
				{{ Form::close() }}

				<div class="big-loader-container">
					{{ HTML::image('img/big-loader.gif','',array('id' => 'img-loader')) }}
				</div>
				<table id="cubicle-table" class="table table-hover">
				</table>
			</div>
			<div class="tab-pane" id="shelves-tab">

				{{ Form::open(array('url'=>'','role'=>'form', 'class' => 'form-inline', 'style' => 'margin:15px 0')) }}
				<div class="form-group">
					{{ Form::label('codigo_estante_crear','Código') }}
					{{ Form::text('codigo_estante_crear','',array('class'=>'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('descripcion_estante_crear','Descripción') }}
					{{ Form::textarea('descripcion_estante_crear','',array('class'=>'form-control','rows'=>'1')) }}
				</div>
				{{ HTML::link('','Registrar',array('id'=>'submit-create-shelf', 'class'=>'btn btn-info')) }}
				{{ Form::close() }}

				<div class="big-loader-container">
					{{ HTML::image('img/big-loader.gif','',array('id' => 'img-loader')) }}
				</div>
				<table id="shelves-table" class="table table-hover">
				</table>
			</div>
			<div class="tab-pane" id="physical-elements-tab">

				{{ Form::open(array('url'=>'','role'=>'form', 'class' => 'form-inline', 'style' => 'margin:15px 0')) }}
				<div class="form-group">
					{{ Form::label('nombre_elemento_fisico_crear','Nombre') }}
					{{ Form::text('nombre_elemento_fisico_crear','',array('class'=>'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('cantidad_elemento_fisico_crear','Cantidad') }}
					{{ Form::text('cantidad_elemento_fisico_crear','',array('class'=>'form-control')) }}
				</div>
				{{ HTML::link('','Registrar',array('id'=>'submit-create-physical-element', 'class'=>'btn btn-info')) }}
				{{ Form::close() }}

				<div class="big-loader-container">
					{{ HTML::image('img/big-loader.gif','',array('id' => 'img-loader')) }}
				</div>
				<table id="physical-elements-table" class="table table-hover">
				</table>
			</div>
		</div>
	</div>

	<div class="modal fade" id="edit-physical-element" tabindex="-1" role="dialog" aria-labelledby="edit-physical-element" aria-hidden="true" data-backdrop="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h3 class="modal-title" id="physical-element-title">Editar Material Físico</h3>
				</div>
				<div class="modal-body">
					<table style="width:100%;">
						<tr style="vertical-align: top;">
							<td style="width:50%;">
								<div class="col-xs-12">
									{{ Form::hidden('id_elemento_fisico') }}
									{{ Form::label('nombre_elemento_fisico','Nombre') }}
									{{ Form::text('nombre_elemento_fisico','',array('class'=>'form-control')) }}
								</div>
							</td>
							<td>
								<div class="col-xs-12">
									{{ Form::label('cantidad_elemento_fisico','Cantidad') }}
									{{ Form::text('cantidad_elemento_fisico','',array('class'=>'form-control')) }}
								</div>
							</td>
						</tr>
					</table>
					{{ HTML::link('','Guardar',array('id'=>'submit-edit-physical-element', 'class'=>'btn btn-success','style'=>'margin: 15px 0 0 15px;')) }}
					<div class="edit_physical_element_loader_container">
						{{ HTML::image('img/loader.gif') }}
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="edit-shelf" tabindex="-1" role="dialog" aria-labelledby="edit-shelf" aria-hidden="true" data-backdrop="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h3 class="modal-title" id="shelf-title">Editar Estante</h3>
				</div>
				<div class="modal-body">
					<table style="width:100%;">
						<tr style="vertical-align: top;">
							<td style="width:50%;">
								<div class="col-xs-12">
									{{ Form::hidden('id_estante') }}
									{{ Form::label('codigo_estante','Código') }}
									{{ Form::text('codigo_estante','',array('class'=>'form-control')) }}
								</div>
							</td>
							<td>
								<div class="col-xs-12">
									{{ Form::label('descripcion_estante','Descripción') }}
									{{ Form::textarea('descripcion_estante','',array('class'=>'form-control','rows'=>'1')) }}
								</div>
							</td>
						</tr>
					</table>
					{{ HTML::link('','Guardar',array('id'=>'submit-edit-shelf', 'class'=>'btn btn-success','style'=>'margin: 15px 0 0 15px;')) }}
					<div class="edit_shelf_loader_container">
						{{ HTML::image('img/loader.gif') }}
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="edit-cubicle" tabindex="-1" role="dialog" aria-labelledby="edit-cubicle" aria-hidden="true" data-backdrop="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h3 class="modal-title" id="cubicle-title">Editar Cubículo</h3>
				</div>
				<div class="modal-body">
					<table style="width:100%;">
						<tr style="vertical-align: top;">
							<td style="width:50%;">
								<div class="col-xs-12">
									{{ Form::hidden('id_cubiculo') }}
									{{ Form::label('codigo_cubiculo','Código') }}
									{{ Form::text('codigo_cubiculo','',array('class'=>'form-control')) }}
								</div>
							</td>
							<td>
								<div class="col-xs-12">
									{{ Form::label('tipo_cubiculo','Tipo de cubículo') }}
									<select name="tipo_cubiculo" class="form-control"></select>
								</div>
							</td>
						</tr>
						<tr style="vertical-align: top;">
							<td>
								<div class="col-xs-12">
									{{ Form::label('capacidad_cubiculo','Capacidad máxima') }}
									{{ Form::text('capacidad_cubiculo','',array('class'=>'form-control')) }}
								</div>
							</td>
						</tr>
					</table>
					{{ HTML::link('','Guardar',array('id'=>'submit-edit-cubicle', 'class'=>'btn btn-success','style'=>'margin: 15px 0 0 15px;')) }}
					<div class="edit_cubicle_loader_container">
						{{ HTML::image('img/loader.gif') }}
					</div>
				</div>
			</div>
		</div>
	</div>
	
@stop