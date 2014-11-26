@extends('templates/loanTemplate')
@section('content')

	<h1>Mis préstamos actuales</h1>
	<div class="container">
		<table class="table table-hover">
			<tr class="info">
				<th>Código</th>
				<th>ISBN</th>
				<th>Título</th>
				<th>Autor</th>
				<th>Editorial</th>
				<th>Fecha de vencimiento</th>
				<th>Seleccione</th>
				<th>Forzar expiración</th>
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
					<td>
						@if(!$user->restricted_until && ($loan->expire_at == $today))
							{{ HTML::link('','Renovar',array('class'=>'btn btn-success renew-button','data-user'=>$user->id,'data-material'=>$loan->material_id,'data-loan'=>$loan->id)) }}
						@endif
					</td>
					<td>
						<a href="/loan/force_expiration/{{ $loan->id }}">Expirar</a>
					</td>
				</tr>
				@endforeach
			@endif
		</table>
		@if($loans)
			{{ $loans->links() }}
		@endif
	</div>
	
@stop