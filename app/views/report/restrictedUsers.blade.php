@extends('templates/reportTemplate')
@section('content')
	<h1>Reporte de usuarios con multa</h1>
	{{ Form::open(array('url'=>'report/restricted_users_excel', 'role'=>'form')) }}
		<div class="col-xs-6" style="margin-bottom:20px;">
			<a href="" id="submit_restricted_users_excel_button" class="btn btn-success"><span class="glyphicon glyphicon-download-alt"></span> Exportar a Excel</a>
			{{ HTML::link('','Cancelar',array('id'=>'cancel')) }}
			<h4>Total de usuarios con multa: {{ $total_restricted_users }}</h4>
		</div>
	{{ Form::close() }}

	<table class="table table-hover">
		<tr class="info">
			<th>Num. Documento</th>
			<th>Nombres</th>
			<th>Apellidos</th>
			<th>E-mail</th>
			<th>Dirección</th>
			<th>Teléfono</th>
			<th>Género</th>
			<th>Fecha de Re-incorporación</th>
		</tr>
		@foreach($restricted_users as $restricted_user)
		<tr>
			<td>
				{{$restricted_user->doc_number}}
			</td>
			<td>
				{{$restricted_user->name}}
			</td>
			<td>
				{{$restricted_user->lastname}}
			</td>
			<td>
				{{$restricted_user->email}}
			</td>
			<td>
				{{$restricted_user->address}}
			</td>
			<td>
				{{$restricted_user->phone}}
			</td>
			<td>
				{{$restricted_user->gender}}
			</td>
			<td>
				{{$restricted_user->restricted_until}}
			</td>
		</tr>
		@endforeach
	</table>
@stop