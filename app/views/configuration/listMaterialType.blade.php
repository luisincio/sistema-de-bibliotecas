@extends('templates/configurationTemplate')
@section('content')

	<h1>Lista de Tipos de Materiales</h1>
	<div class="container">
		<table class="table table-hover">
			<tr class="info">
				<th>Nombre</th>
				<th>¿Físico o Digital?</th>
				<th>Descripcion</th>
				<th class="text-center">Seleccione{{ Form::checkbox('select_all') }}</th>
			</tr>
			@foreach( $material_types as $material_type)
			<tr>
				<td>
					<a href="{{URL::to('/config/edit_material_type/')}}/{{$material_type->id}}">{{$material_type->name}}</a>
				</td>
				<td>
					@if($material_type->flag_phys_dig == 1)
						<span>Físico</span>
					@else
						<span>Digital</span>
					@endif
				</td>
				<td>
					{{ $material_type->description }}
				</td>
				<td class="text-center">
					{{ Form::checkbox('material_types',$material_type->id) }}
				</td>
			</tr>
			@endforeach
		</table>
		@if(!$material_types->isEmpty())
			<div class="text-right">
				<div class="loader_container">
					{{ HTML::image('img/loader.gif') }}
				</div>
				{{ HTML::link('','Eliminar',array('id'=>'delete-selected-material-types', 'class'=>'btn btn-danger')) }}
			</div>
		@endif
		{{ $material_types->links() }}
	</div>
	
@stop