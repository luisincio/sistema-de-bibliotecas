@extends('templates/configurationTemplate')
@section('content')

	<h1>Modificar Proveedor</h1>
	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('ruc') }}</strong></p>
			<p><strong>{{ $errors->first('representante') }}</strong></p>
			<p><strong>{{ $errors->first('direccion') }}</strong></p>
			<p><strong>{{ $errors->first('telefono') }}</strong></p>
			<p><strong>{{ $errors->first('celular') }}</strong></p>
			<p><strong>{{ $errors->first('email') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	
	{{ Form::open(array('url'=>'config/submit_edit_supplier', 'role'=>'form')) }}
		{{ Form::hidden('id', $supplier->id) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombre / Razón Social') }}
					{{ Form::text('nombre',$supplier->name,array('class'=>'form-control','readonly'=>'')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('ruc')) has-error has-feedback @endif">
					{{ Form::label('ruc','RUC / DNI') }}
					{{ Form::text('ruc',$supplier->ruc,array('class'=>'form-control','readonly'=>'')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('representante')) has-error has-feedback @endif">
					{{ Form::label('representante','Representante') }}
					{{ Form::text('representante',$supplier->sales_representative,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('direccion')) has-error has-feedback @endif">
					{{ Form::label('direccion','Dirección') }}
					{{ Form::text('direccion',$supplier->address,array('class'=>'form-control')) }}
				</div>
			</div>
			{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('telefono')) has-error has-feedback @endif">
					{{ Form::label('telefono','Teléfono') }}
					{{ Form::text('telefono',$supplier->phone,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('celular')) has-error has-feedback @endif">
					{{ Form::label('celular','Celular') }}
					{{ Form::text('celular',$supplier->cell,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('email')) has-error has-feedback @endif">
					{{ Form::label('email','E-mail') }}
					{{ Form::text('email',$supplier->email,array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('donador','¿Es donador?') }}
					@if($supplier->flag_doner)
						{{ Form::text('donador','Si',array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('donador','No',array('class'=>'form-control','readonly'=>'')) }}
					@endif
				</div>
			</div>
		</div>
	{{ Form::close() }}
	
@stop