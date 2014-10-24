@extends('templates/materialTemplate')
@section('content')

	<h1>Detalle Orden de Compra</h1>
	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_emision') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_vencimiento') }}</strong></p>			
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif

	@if (Session::has('danger'))
		<div class="alert alert-danger">
			<p><strong>{{ Session::get('danger') }}</strong></p>
		</div>
	@endif
	
	{{ Form::open(array('url'=>'material/submit_edit_purchase_order', 'role'=>'form')) }}
	{{ Form::hidden('id', $purchase_order->id) }}
	<div class="col-xs-6">
		<div class="row">
			{{ Form::label('femision','Fecha de emisión') }}
			<div class="form-group input-group col-xs-8 @if($errors->first('descripcion')) has-error has-feedback @endif">										
				{{ Form::text('femision',$purchase_order->date_issue,array('class'=>'form-control', 'readonly'=>'')) }}
				<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
			</div>
		</div>
		
		<div class="row">
			<div class="form-group input-group col-xs-8 @if($errors->first('descripcion')) has-error has-feedback @endif">
				{{ Form::label('descripcion','Descripción') }}
				{{ Form::text('descripcion',$purchase_order->description ,array('class'=>'form-control', 'readonly'=>'')) }}
			</div>
		</div>			
				
	</div>
	<div class = "col-xs-6">
		<div class="row">
			{{ Form::label('fvencimiento','Fecha de vencimiento') }}
			<div class="form-group input-group col-xs-8 @if($errors->first('fecha_vencimiento')) has-error has-feedback @endif">				
				{{ Form::text('fvencimiento', $purchase_order->expire_at,array('class'=>'form-control', 'readonly'=>'')) }}
				<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
	 		</div>
		</div>

		<div class="row">
				<div class="form-group input-group col-xs-8 @if($errors->first('proveedor')) has-error has-feedback @endif">
					{{ Form::label('proveedor','Proveedor') }}																		
					{{ Form::text('proveedor',$suppliers->name,array('class'=>'form-control', 'readonly'=>'')) }}									
				</div>
		</div>
			
	</div>
	<table class="table table-hover">
		<tr class="info">
			<th>Código</th>
			<th>Titulo</th>
			<th>Autor</th>
			<th>Cantidad</th>
			<th>Precio Unitario</th>			
		</tr>		
		@foreach($details_purchase_orders as $details_purchase_order)
			<tr>
				<td>
					{{ $details_purchase_order->code }}
				</td>
				<td>
					{{ $details_purchase_order->title }}
				</td>
				<td>
					{{ $details_purchase_order->author }}
				</td>
				<td>
					{{ $details_purchase_order->quantity }}
				</td>	
				<td>
					{{ $details_purchase_order->price }}
				</td>									
			</tr>
		@endforeach		
	</table>	
	<br>
	<div class = "col-xs-6">
		<div class ="row">
			{{ Form::label('total','Precio Total:') }}
			{{ Form::label('total_price',$purchase_order->total_amount) }}
		</div>
		<?php 	
			$today = Date("Y-m-d");			
		?>
		<br>
		<div class = "row">
			@if($purchase_order->expire_at > $today && $purchase_order->state == 0)
				{{ Form::submit('Aprobar',array('id'=>'submit-check', 'class'=>'btn btn-primary')) }}
				{{ HTML::link('','Rechazar',array('id'=>'submit-reject', 'class'=>'btn btn-danger','data-id'=> $purchase_order->id)) }}		
			@endif
		</div>
	</div>	
	{{ Form::close() }}
@stop