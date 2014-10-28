@extends('templates/loanTemplate')
@section('content')
<script type="text/javascript">
	var current_staff_branch_id = "{{$branch->id}}";
</script>
	<h1>Registrar Préstamo</h1>
	<div class="container">
		<ul id="physical-elements-nav-tabs" class="nav nav-tabs" role="tablist">
			<li class="active"><a href="#no-reservation-tab" role="tab" data-toggle="tab">Sin Reserva</a></li>
			<li><a href="#reservation-tab" role="tab" data-toggle="tab">Con Reserva</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="no-reservation-tab">
				<div class="col-xs-6" style="margin-top: 30px;">
					{{ Form::hidden('nr_id_usuario') }}
					{{ Form::hidden('nr_base_cod_libro') }}
					<div class="row">
						<div class="form-group form-group-num-doc col-xs-8">
							{{ Form::label('nr_num_doc_usuario','Núm. de documento de usuario') }}
							{{ Form::text('nr_num_doc_usuario','',array('class'=>'form-control')) }}
							{{ HTML::image('img/loader.gif') }}
						</div>
					</div>
					<div class="row">
						<div class="form-group form-group-material-code col-xs-8">
							{{ Form::label('nr_codigo_libro','Código del libro(4 letras)') }}
							{{ Form::text('nr_codigo_libro','',array('class'=>'form-control')) }}
							{{ HTML::image('img/loader.gif') }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::label('nr_titulo_libro','Título del libro') }}
							{{ Form::text('nr_titulo_libro','',array('class'=>'form-control', 'readonly'=>'')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::label('nr_autor_libro','Autor del libro') }}
							{{ Form::text('nr_autor_libro','',array('class'=>'form-control', 'readonly'=>'')) }}
						</div>
					</div>
					{{ Form::submit('Registrar Préstamo',array('id'=>'nr-submit-loan-register', 'class'=>'btn btn-info')) }}
				</div>
				<div class="col-xs-6" style="border: 1px solid #ddd;border-radius:5px;margin-top: 20px;padding-top:10px;">
					<div class="row">
						<div class="form-group col-xs-12">
							{{ Form::label('nr_nombre_usuario','Nombre de usuario') }}
							{{ Form::text('nr_nombre_usuario','',array('class'=>'form-control', 'readonly'=>'')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-12">
							{{ Form::label('nr_perfil_usuario','Perfil') }}
							{{ Form::text('nr_perfil_usuario','',array('class'=>'form-control', 'readonly'=>'')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-12">
							{{ Form::label('nr_email_usuario','E-mail') }}
							{{ Form::text('nr_email_usuario','',array('class'=>'form-control', 'readonly'=>'')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-12">
							{{ Form::label('nr_estado_usuario','Estado') }}
							{{ Form::text('nr_estado_usuario','',array('class'=>'form-control', 'readonly'=>'')) }}
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="reservation-tab">
				<div class="col-xs-6" style="margin: 30px 0;">
					<div class="row">
						{{ Form::open(array('url'=>'','role'=>'form', 'class' => 'form-inline')) }}
						<div class="form-group form-group-r-num-doc col-xs-8">
							{{ Form::label('r_num_doc_usuario','Núm. de documento de usuario') }}
							{{ Form::text('r_num_doc_usuario','',array('class'=>'form-control')) }}
							{{ Form::submit('Buscar',array('id'=>'search-user-loans', 'class'=>'btn btn-info')) }}
							{{ HTML::image('img/loader.gif') }}
						</div>
						{{ Form::close() }}
					</div>
				</div>
				<table id="user-active-loans" class="table table-hover">
				</table>
			</div>
		</div>
	</div>
	
@stop