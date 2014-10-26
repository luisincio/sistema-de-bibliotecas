@extends('templates/materialTemplate')
@section('content')

	<h1>Buscar Orden de Compra</h1>
	<br>
	{{ Form::open(array('url'=>'/material/search_purchase_order','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
	<div class="col-xs-6">
		<div class="row"> 
			<div class="form-group col-xs-8"> 
				{{ Form::text('fecha_emision',$date_ini,array('class'=>'form-control','placeholder'=>'Ingrese Fecha Inicial', 'readonly'=>'')) }}
				<span class="form-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
				<br>
				<br>
			</div>
		</div>	
		<div class="row">
			<div class="form-group col-xs-8"> 
				{{ Form::text('fecha_vencimiento',$date_end,array('class'=>'form-control','placeholder'=>'Ingrese Fecha Final', 'readonly'=>'')) }}					
				<span class="form-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
				<br>
				<br>
				{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}												
				{{ HTML::link('material/list_purchase_order','Listar Todos',array('class'=>'')) }}
			</div>	
		</div>		
		<br>
		<br>
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
	
@stop