@extends('templates/configurationTemplate')
@section('content')

	<h1>Lista de Sedes</h1>
	<div class="container">
		<table class="table table-hover">
			<tr class="info">
				<th>Nombre</th>
				<th>Dirección</th>
				<th>Horario de Atención</th>
				<th>Días de Atención</th>
				<th>Turnos</th>
				<th>Estado</th>
				<th class="text-center">Seleccione{{ Form::checkbox('select_all') }}</th>
			</tr>
			@foreach( $branches as $branch)
			<tr class="@if($branch->deleted_at) bg-danger @endif">
				<td>
					@if($branch->deleted_at)
						{{$branch->name}}
					@else
						<a href="{{URL::to('/config/edit_branch/')}}/{{$branch->id}}">{{$branch->name}}</a>
					@endif
				</td>
				<td>
					{{ $branch->address }}
				</td>
				<td>
					{{ $branch->hour_ini }} - {{ $branch->hour_end }}
				</td>
				<td>
					<?php
						switch ($branch->day_ini) {
					    	case 0:
					        	$dia_inicio = "Domingo";
					        	break;
					    	case 1:
					        	$dia_inicio = "Lunes";
					        	break;
					    	case 2:
					        	$dia_inicio = "Martes";
					        	break;
					    	case 3:
					        	$dia_inicio = "Miércoles";
					        	break;
					    	case 4:
					        	$dia_inicio = "Jueves";
					        	break;
					    	case 5:
					        	$dia_inicio = "Viernes";
					        	break;					        					        					        
					    	case 6:
					        	$dia_inicio = "Sabado";
					        	break;						    				       
						}
						switch ($branch->day_end) {
					    	case 0:
					        	$dia_final = "Domingo";
					        	break;
					    	case 1:
					        	$dia_final = "Lunes";
					        	break;
					    	case 2:
					        	$dia_final = "Martes";
					        	break;
					    	case 3:
					        	$dia_final = "Miércoles";
					        	break;
					    	case 4:
					        	$dia_final = "Jueves";
					        	break;
					    	case 5:
					        	$dia_final = "Viernes";
					        	break;					        					        					        
					    	case 6:
					        	$dia_final = "Sabado";
					        	break;	
					    }
					?>
					
					{{ $dia_inicio }} - {{ $dia_final }}
				</td>								
				<td>
					@if($branch->deleted_at)
						-
					@else
						<a href="{{URL::to('/config/create_turn/')}}/{{$branch->id}}">Turnos</a>
					@endif
				</td>
				<td>
					@if(!$branch->deleted_at)
						{{'Activa'}}
					@else
						{{'Inactiva'}}
					@endif		
				</td>
				<td class="text-center">
					@if(!$branch->deleted_at)
						{{ Form::checkbox('branches',$branch->id) }}
					@else
						{{ HTML::link('','Restaurar',array('id'=>'restore-selected-branches', 'class'=>'btn btn-primary', 'style'=>'background-color: green','data-id'=>$branch->id)) }}
					@endif
				</td>
			</tr>
			@endforeach
		</table>
		@if($branches)
			<div class="text-right">
				<div class="loader_container">
					{{ HTML::image('img/loader.gif') }}
				</div>
				{{ HTML::link('','Inhabilitar',array('id'=>'delete-selected-branches', 'class'=>'btn btn-danger')) }}
			</div>
		@endif	
	</div>
	
@stop