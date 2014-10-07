@extends('templates/configurationTemplate')
@section('content')

	<h1>Buscar Proveedores</h1>
	<div class="container">
		{{ Form::open(array('url'=>'/config/search_supplier','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
				<div class="search_bar">
					{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese Búsqueda')) }}
					{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
				</div>
				<div>
					<label class="radio-inline">
						{{ Form::radio('search_filter','1') }} Proveedor
					</label>
					<label class="radio-inline">
						{{ Form::radio('search_filter','2') }} Donador
					</label>
					<label class="radio-inline">
						{{ Form::radio('search_filter','3',true) }} Ambos
					</label>
					<label class="radio-inline">
						{{ HTML::link('config/list_supplier','Listar Todos') }}
					</label>
				</div>
		{{ Form::close() }}
		<div class="search-criteria">
			@if($search_criteria)
				<h3>
					Resultados de la búsqueda "{{ $search_criteria }}" de
					@if($search_filter == 1)
						Proveedor
					@elseif($search_filter == 2)
						Donador
					@else
						Proveedor y/o Donador
					@endif
				</h3>
			@endif
		</div>
		<table class="table table-hover">
			<tr class="info">
				<th>Nombre</th>
				<th>Tipo</th>
				<th>RUC</th>
				<th>Representante</th>
				<th>Teléfono</th>
				<th>Celular</th>
				<th>E-mail</th>
				<th class="text-center">Seleccione</th>
			</tr>
			@foreach( $suppliers as $supplier)
			<tr>
				<td>
					<a href="{{URL::to('/config/edit_supplier/')}}/{{$supplier->id}}">{{$supplier->name}}</a>
				</td>
				<td>
					@if($supplier->flag_doner)
						<span>Donador</span>
					@else
						<span>Proveedor</span>
					@endif
				</td>
				<td>
					{{ $supplier->ruc }}
				</td>
				<td>
					{{ $supplier->sales_representative }}
				</td>
				<td>
					{{ $supplier->phone }}
				</td>
				<td>
					{{ $supplier->cell }}
				</td>
				<td>
					{{ $supplier->email }}
				</td>
				<td class="text-center">
					{{ Form::checkbox('supplier',$supplier->id) }}
				</td>
			</tr>
			@endforeach
		</table>
		@if(!$suppliers->isEmpty())
			<div class="text-right">
				<div class="loader_container">
					{{ HTML::image('img/loader.gif') }}
				</div>
				{{ HTML::link('','Eliminar',array('id'=>'delete-selected-suppliers', 'class'=>'btn btn-danger')) }}
			</div>
		@endif
		@if($search)
			{{ $suppliers->appends(array('search' => $search,'search_filter' => $search_filter))->links() }}
		@else
			{{ $suppliers->links() }}
		@endif
	</div>
	
@stop