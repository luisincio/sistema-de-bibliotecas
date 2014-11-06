@extends('templates/configurationTemplate')
@section('content')

	<h1>Lista de Tipos de Cubículos</h1>
	<div class="container">
		<table class="table table-hover">
			<tr class="info">
				<th>Nombre</th>
				<th>Descripcion</th>
				<th class="text-center">Seleccione{{ Form::checkbox('select_all') }}</th>
			</tr>
			@foreach( $cubicle_types as $cubicle_type)
			<tr>
				<td>
					<a href="{{URL::to('/config/edit_cubicle_type/')}}/{{$cubicle_type->id}}">{{$cubicle_type->name}}</a>
				</td>
				<td>
					{{ $cubicle_type->description }}
				</td>
				<td class="text-center">
					{{ Form::checkbox('cubicle_types',$cubicle_type->id) }}
				</td>
			</tr>
			@endforeach
		</table>
		@if(!$cubicle_types->isEmpty())
			<div class="text-right">
				<div class="loader_container">
					{{ HTML::image('img/loader.gif') }}
				</div>
				{{ HTML::link('','Eliminar',array('id'=>'delete-selected-cubicle-types', 'class'=>'btn btn-danger')) }}
			</div>
		@endif
		{{ $cubicle_types->links() }}
	</div>
	
@stop