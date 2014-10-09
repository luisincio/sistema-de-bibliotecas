@extends('templates/userTemplate')
@section('content')

	<h1>Lista de Perfiles</h1>
	<div class="container">
		<table class="table table-hover">
			<tr class="info">
				<th>Nombre</th>
				<th class="text-center">Seleccione{{ Form::checkbox('select_all') }}</th>
			</tr>
			@foreach($profiles as $profile)
			<tr>
				<td>
					<a href="{{URL::to('/user/edit_profile/')}}/{{$profile->id}}">{{$profile->name}}</a>
				</td>
				<td class="text-center">
					{{ Form::checkbox('profiles',$profile->id) }}
				</td>
			</tr>
			@endforeach
		</table>
		@if(!$profiles->isEmpty())
			<div class="text-right">
				<div class="loader_container">
					{{ HTML::image('img/loader.gif') }}
				</div>
				{{ HTML::link('','Eliminar',array('id'=>'delete-selected-profiles', 'class'=>'btn btn-danger')) }}
			</div>
		@endif
		{{ $profiles->links() }}
	</div> 
	
@stop