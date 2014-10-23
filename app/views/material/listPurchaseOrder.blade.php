@extends('templates/materialTemplate')
@section('content')

	<h1>Buscar Orden de Compra</h1>
	<div class="container">
		{{ Form::open(array('url'=>'/material/search_purchase_order','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
				<div class="form-group input-group col-xs-6">
					{{ Form::text('fecha_emision',Input::old('fecha_emision'),array('class'=>'form-control','placeholder'=>'Ingrese Fecha Inicial', 'readonly'=>'')) }}
					<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
					<br>
					{{ Form::text('fecha_vencimiento',Input::old('fecha_vencimiento'),array('class'=>'form-control','placeholder'=>'Ingrese Fecha Final', 'readonly'=>'')) }}					
					<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
					<br>
					{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}												
					{{ HTML::link('material/list_purchase_order','Listar Todos') }}
					
				</div>				
		{{ Form::close() }}
		<br>
		<table class="table table-hover">
			<tr class="info">
				<th>Código</th>
				<th>Fecha Emisión</th>
				<th>Fecha Vencimiento</th>
				<th>Estado</th>				
			</tr>			
			@foreach($purchase_orders as $purchase_order)
			<tr>
				<td>
					<a href="{{URL::to('/material/edit_purchase_order/')}}/{{$purchase_order->id}}">{{ $purchase_order->id }}</a>
				</td>
				<td>
					{{ $purchase_order->date_issue }}
				</td>
				<td>
					{{ $purchase_order->expire_at }}
				</td>	
				<td>
					@if($purchase_order->state == 0)
						{{	'No revisado'	}}
					@endif
					@if($purchase_order->state == 1)
						{{	'Aprobado'	}}					
					@endif	
				</td>			
			</tr>
			@endforeach
		</table>
		
		{{ $purchase_orders->links() }}
	</div>
	
@stop