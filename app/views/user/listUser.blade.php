@extends('templates/userTemplate')
@section('content')
	
	<h1>Lista de Usuarios</h1>
	<div class="container">

		{{ Form::open(array('url'=>'/user/search_user','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
			<div class="search_bar">
				{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese Búsqueda')) }}
				{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
			</div></br>
			<select name="search_filter" class="form-control">
				<option value="0" @if($search_filter && $search_filter == 0) selected @endif>Todos</option>
				<option value="1" @if($search_filter && $search_filter == 1) selected @endif>Activos</option>
				<option value="2" @if($search_filter && $search_filter == 2) selected @endif>Eliminados</option>
			</select>	
			{{ HTML::link('user/list_user','Listar Todos') }}
		{{ Form::close() }}</br>

		<table class="table table-hover">
			<tr class="info">
				<th>Número de documento</th>
				<th>Nombres</th>
				<th>Apellidos</th>
				<th>E-mail</th>
				<th class="text-center">Seleccione @if($search_filter!=2) {{ Form::checkbox('select_all') }} @endif</th>
			</tr>
			@foreach($users as $user)
			<tr class="@if($user->deleted_at) bg-danger @endif">
				<td>
					{{$user->doc_number}}
				</td>
				<td>
					@if($user->deleted_at)
						{{$user->name}}
					@else
						<a href="{{URL::to('/user/edit_user/')}}/{{$user->id}}">{{$user->name}}</a>
					@endif
				</td>
				<td>
					{{$user->lastname}}
				</td>
				<td>
					{{$user->mail}}
				</td>
				<td class="text-center">
					@if($user->deleted_at)
						{{ HTML::link('','Reactivar',array('class'=>'reactivate-user btn btn-success','data-id'=>$user->id)) }}
					@else
						{{ Form::checkbox('users',$user->id) }}
					@endif
				</td>
			</tr>
			@endforeach
		</table>
		@if(!$users->isEmpty() && $search_filter!=2)
			<div class="text-right">
				<div class="loader_container">
					{{ HTML::image('img/loader.gif') }}
				</div>
				{{ HTML::link('','Eliminar',array('id'=>'delete-selected-users', 'class'=>'btn btn-danger')) }}
			</div>
		@endif

		@if($search)
			{{ $users->appends(array('search' => $search,'search_filter'=>$search_filter))->links() }}
		@else
			{{ $users->links() }}
		@endif
	</div> 
	
@stop