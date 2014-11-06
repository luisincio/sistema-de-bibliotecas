@extends('templates/loanTemplate')
@section('content')

	<h1>Registrar Daño o Pérdida</h1>
	<div class="container">
		{{ Form::open(array('url'=>'/loan/search_user_loans_damage','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
			<div class="search_bar">
				{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese Num. de documento')) }}
				{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
			</div>
		{{ Form::close() }}
		<div class="search-criteria">
			@if($search_criteria)
				{{ Form::hidden('user_id',$user_id) }}
				<h3>
					@if($searched_user_name)
						Préstamos activos de {{ $searched_user_name }} ({{ $search_criteria }})
					@else
						No se encontró usuario con número de documento {{ $search_criteria }}
					@endif
				</h3>
			@endif
		</div>
		<table class="table table-hover">
			<tr class="info">
				<th><center>Código</center></th>
				<th><center>ISBN</center></th>
				<th><center>Título</center></th>
				<th><center>Autor</center></th>
				<th><center>Editorial</center></th>
				<th><center>Fecha de vencimiento</center></th>
				<th class="text-center"><center>Seleccione{{ Form::checkbox('select_all') }}</center></th>
			</tr>
			@if($loans)
				@foreach( $loans as $loan )
				<tr>
					<td>
						{{ $loan->auto_cod }}</a>
					</td>
					<td>
						{{ $loan->isbn }}
					</td>
					<td>
						{{ $loan->title }}</a>
					</td>
					<td>
						{{ $loan->author }}
					</td>
					<td>
						{{ $loan->editorial }}
					</td>
					<td>
						{{ $loan->expire_at }}
					</td>
					<td class="text-center">
						{{ Form::checkbox('loans',$loan->id) }}
					</td>
				</tr>
				@endforeach
			@endif
		</table>
		@if($loans)
			@if(!$loans->isEmpty())
				<div class="text-right">
					<div class="loader_container">
						{{ HTML::image('img/loader.gif') }}
					</div>
					{{ HTML::link('','Registrar Daño ó Perdida',array('id'=>'delete-damage-loans', 'class'=>'btn btn-warning')) }}
				</div>
			@endif
		@endif
		@if($loans)
			{{ $loans->links() }}
		@endif
	</div>
	
@stop