@extends('templates/configurationTemplate')
@section('content')

	<h1>Lista de Sedes</h1>
	<div class="container">
		<table class="table table-hover">
			<tr class="info">
				<th>Nombre</th>
				<th>Dirección</th>
				<th>Turnos</th>
				<th>Estado</th>
				<th class="text-center">Seleccione{{ Form::checkbox('select_all') }}</th>
			</tr>
			@foreach( $branches as $branch)
			<tr class="@if($branch->deleted_at) bg-danger @endif">
				<td>
					<a href="{{URL::to('/config/edit_branch/')}}/{{$branch->id}}">{{$branch->name}}</a>
				</td>
				<td>
					{{ $branch->address }}
				</td>
				<td>
					<a href="{{URL::to('/config/create_turn/')}}/{{$branch->id}}">{{'Turnos'}}</a>
				</td>
				<td>
					@if(!$branch->deleted_at)
						{{'Activa'}}
					@else
						{{'Inactiva'}}
					@endif		
				</td>
				<td class="text-center">
					@if(!$branch->deleted_at)
						{{ Form::checkbox('branches',$branch->id) }}
					@else
						{{ HTML::link('','Restaurar',array('id'=>'restore-selected-branches', 'class'=>'btn btn-primary', 'style'=>'background-color: green','data-id'=>$branch->id)) }}
					@endif
				</td>
			</tr>
			@endforeach
		</table>
		@if($branches)
			<div class="text-right">
				<div class="loader_container">
					{{ HTML::image('img/loader.gif') }}
				</div>
				{{ HTML::link('','Inhabilitar',array('id'=>'delete-selected-branches', 'class'=>'btn btn-danger')) }}
			</div>
		@endif	
	</div>
	
@stop