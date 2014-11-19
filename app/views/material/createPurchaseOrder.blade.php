@extends('templates/materialTemplate')
@section('content')
	
	<h1>Registrar Orden de Compra</h1>
	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('femision') }}</strong></p>
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
	
	{{ Form::open(array('url'=>'material/submit_create_purchase_order', 'role'=>'form')) }}
	<div class="col-xs-6">
		<div class="row">
			{{ Form::label('femision','Fecha de emisión*') }}
			<div class="form-group input-group col-xs-8 @if($errors->first('femision')) has-error has-feedback @endif">	
				<?php 	
					$today = Date("Y-m-d");			
				?>									
				{{ Form::text('femision',$today,array('class'=>'form-control', 'readonly'=>'')) }}
				<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
			</div>
		</div>
		
		<div class="row">
			<div class="form-group input-group col-xs-8 @if($errors->first('descripcion')) has-error has-feedback @endif">
				{{ Form::label('descripcion','Descripción*') }}
				{{ Form::text('descripcion',Input::old('descripcion'),array('class'=>'form-control')) }}
			</div>
		</div>
		
		<hr width="145%" align="left" />			
		
		<div class="row">
			<div class="form-group input-group col-xs-8 @if($errors->first('codigo')) has-error has-feedback @endif">
				{{ Form::label('codigo','Código') }}
				{{ Form::text('codigo',Input::old('codigo'),array('class'=>'form-control')) }}
			</div>
		</div>
		<div class="row">
			<div class="form-group input-group col-xs-8 @if($errors->first('titulo')) has-error has-feedback @endif">
				{{ Form::label('titulo','Título') }}
				{{ Form::text('titulo',Input::old('titulo'),array('class'=>'form-control')) }}
			</div>
		</div>
			
		<div class="row">
			<div class="form-group input-group col-xs-8 @if($errors->first('autor')) has-error has-feedback @endif">
				{{ Form::label('autor','Autor') }}
				{{ Form::text('autor',Input::old('autor'),array('class'=>'form-control')) }}
			</div>
		</div>
		
		<div class="row">
			<div class="row">
				<div class="form-group col-xs-8">				
						{{ HTML::link('','Añadir Lista',array('id'=>'add-list', 'class'=>'btn btn-default')) }}
				</div>
			</div>			
		</div>
	</div>
	<div class = "col-xs-6">
		<div class="row">
			{{ Form::label('fvencimiento','Fecha de vencimiento*') }}
			<div class="form-group input-group col-xs-8 @if($errors->first('fecha_vencimiento')) has-error has-feedback @endif">				
				{{ Form::text('fecha_vencimiento',Input::old('fecha_vencimiento'),array('class'=>'form-control', 'readonly'=>'')) }}
				<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
	 		</div>
		</div>

		<div class="row">
				<div class="form-group input-group col-xs-8 @if($errors->first('proveedor')) has-error has-feedback @endif">
					{{ Form::label('proveedor','Proveedor*') }}
					<select name="proveedor" class="form-control">		
						@foreach($suppliers as $supplier)
						<option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
						@endforeach
					</select>
				</div>
		</div>

		<HR width="30%">

		<div class="row">
			<div class="form-group input-group col-xs-8 @if($errors->first('cantidad_ordenes')) has-error has-feedback @endif">
				{{ Form::label('cantidad_ordenes','Cantidad') }}
				{{ Form::text('cantidad_ordenes',Input::old('cantidad_ordenes'),array('class'=>'form-control')) }}
			</div>
		</div>
		<div class="row">
			<div class="form-group input-group col-xs-8 @if($errors->first('precio')) has-error has-feedback @endif">
				{{ Form::label('precio','Precio Unitario') }}
				{{ Form::text('precio',Input::old('precio'),array('class'=>'form-control')) }}
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
			<th>Eliminar</th>
		</tr>		
		<?php 
			$details_code = Input::old('details_code');		
			$details_title = Input::old('details_title');	
			$details_author = Input::old('details_author');	
			$details_quantity = Input::old('details_quantity');			
			$details_unit_price = Input::old('details_unit_price');
			$count = count($details_code);	
		?>	
		<?php for($i=0;$i<$count;$i++){ ?>
		<tr>
			<td>
				<input name='details_code[]' value='{{ $details_code[$i] }}' readonly/>
			</td>
			<td>
				<input name='details_title[]' value='{{ $details_title[$i] }}' readonly/>
			</td>
			<td>
				<input name='details_author[]' value='{{ $details_author[$i] }}' readonly/>
			</td>
			<td>
				<input name='details_quantity[]' value='{{ $details_quantity[$i] }}' readonly/>
			</td>
			<td>
				<input name='details_unit_price[]' value='{{ $details_unit_price[$i] }}' readonly/>
			</td>
			<td>
				<a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>X</a>
			</td>						
		</tr>
		<?php } ?>
	</table>
	<br>
	{{ Form::submit('Registrar',array('id'=>'submit-create', 'class'=>'btn btn-primary')) }}
	{{ HTML::link('','Limpiar Campos',array('id'=>'clear-fields-purchase-order', 'class'=>'btn btn-default')) }}
	{{ Form::close() }}
	<br>
	<br>
@stop