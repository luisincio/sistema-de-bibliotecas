<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="{{ URL::to('/') }}">
				<img src="{{ asset('img') }}/{{ $config->logo_path }}" width="42" style="display:block;margin-top:4px;"/>
			</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				@if($staff)
					@if($staff->role_id == 1 || $staff->role_id == 2)
					<li class="dropdown">
						<a href="" class="dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-cog"></span> Configuración <span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							@if($staff->role_id == 1)
								<li>{{ HTML::link('/config/general_configuration','Configuración General') }}</li>
								<li>{{ HTML::link('/config/create_devolution_period','Periodos de Devolución') }}</li>
								<li>{{ HTML::link('/config/create_penalty_period','Periodos de Penalidad') }}</li>
								<li>{{ HTML::link('/config/list_physical_elements','Infraestructura') }}</li>
								<li class="divider"></li>
							@endif
								<li>{{ HTML::link('/config/list_branch','Mostrar Sedes') }}</li>
							@if($staff->role_id == 1)
								<li>{{ HTML::link('/config/create_branch','Registrar Sede') }}</li>
								<li class="divider"></li>
								<li>{{ HTML::link('/config/list_supplier','Buscar Proveedores') }}</li>
								<li>{{ HTML::link('/config/create_supplier','Registrar Proveedor') }}</li>
								<li class="divider"></li>
								<li>{{ HTML::link('/config/list_material_type','Mostrar Tipos de Materiales') }}</li>
								<li>{{ HTML::link('/config/create_material_type','Registrar Tipo de Material') }}</li>
								<li class="divider"></li>
								<li>{{ HTML::link('/config/list_cubicle_type','Mostrar Tipos de Cubículos') }}</li>
								<li>{{ HTML::link('/config/create_cubicle_type','Registrar Tipo de Cubículo') }}</li>
								<li class="divider"></li>
								<li>{{ HTML::link('/config/create_holiday','Feriados') }}</li>
								<li class="divider"></li>
								<li>{{ HTML::link('/config/render_commands','Comandos') }}</li>
							@endif
						</ul>
					</li>
					@endif
					@if($staff->role_id == 2 || $staff->role_id == 3)
					<li class="dropdown">
						<a href="" class="dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-book"></span> Materiales <span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							@if($staff->role_id == 2 || $staff->role_id == 3)
							<li>{{ HTML::link('/material/list_purchase_order','Buscar Ordenes de Compra') }}</li>
							@endif
							@if($staff->role_id == 3)
							<li>{{ HTML::link('/material/create_purchase_order','Registrar Orden de Compra') }}</li>
							<li>{{ HTML::link('/material/list_material_request','Ver Solicitudes') }}</li>
							@endif
							@if($staff->role_id == 2 || $staff->role_id == 3)
							<li class="divider"></li>
							<li>{{ HTML::link('/material/list_material','Buscar Materiales') }}</li>
							<li>{{ HTML::link('/material/create_material','Registrar Material') }}</li>
							@endif
						</ul>
					</li>
					@endif
					@if($staff->role_id == 1 || $staff->role_id == 2)
					<li class="dropdown">
						<a href="" class="dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-user"></span> Usuarios <span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							<li>{{ HTML::link('/user/list_user','Buscar Usuarios') }}</li>
							<li>{{ HTML::link('/user/create_user','Registrar Usuario') }}</li>
							<li class="divider"></li>
							<li>{{ HTML::link('/user/list_profile','Mostrar Perfiles') }}</li>
							<li>{{ HTML::link('/user/create_profile','Registrar Perfil') }}</li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="" class="dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-eye-open"></span> Personal <span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							<li>{{ HTML::link('/staff/list_staff','Buscar Personal') }}</li>
							<li>{{ HTML::link('/staff/create_staff','Registrar Personal') }}</li>
						</ul>
					</li>
					@endif
				@endif
				@if($user || ($staff && $staff->role_id == 3))
				<li class="dropdown">
					<a href="" class="dropdown-toggle" data-toggle="dropdown">
						<span class="glyphicon glyphicon-refresh"></span> Préstamos <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						@if($staff && $staff->role_id == 3)
						<li>{{ HTML::link('/loan/loan_register','Registrar Préstamo') }}</li>
						<li>{{ HTML::link('/loan/return_register','Registrar Devolución') }}</li>
						<li class="divider"></li>
						<li>{{ HTML::link('/loan/damage_register','Registrar Daño o Perdida') }}</li>
						@endif
						@if($user)
						<li class="divider"></li>
						<li>{{ HTML::link('/loan/my_loans','Mis Préstamos') }}</li>
						@endif
					</ul>
				</li>
				<li class="dropdown">
					<a href="" class="dropdown-toggle" data-toggle="dropdown">
						<span class="glyphicon glyphicon-tags"></span> Reservas <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						@if($user)
						<li>{{ HTML::link('/reservation/my_material_reservations','Materiales Reservados') }}</li>
						@endif
						@if($staff && $staff->role_id == 3)
						<li>{{ HTML::link('/reservation/search_cubicle_reservations','Ver Reserva de Cubículos') }}</li>
						@endif
						@if($user && $staff)
						<li class="divider"></li>
						@endif
						@if($user)
						<li>{{ HTML::link('/reservation/cubicle_reservations','Reservar Cubículo') }}</li>
						<li>{{ HTML::link('/reservation/my_cubicle_reservations','Mis Cubículos Reservados') }}</li>
						@endif
					</ul>
				</li>
				@endif

				@if($staff && ($staff->role_id == 4))
				@else
				<li class="dropdown">
					<a href="" class="dropdown-toggle" data-toggle="dropdown">
						<span class="glyphicon glyphicon-log-in"></span> Mi Cuenta <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li>{{ HTML::link('/myaccount/change_password','Cambiar Contraseña') }}</li>
						@if($user)
						<li class="divider"></li>
						<li>{{ HTML::link('/myaccount/create_material_request','Registrar Solicitud') }}</li>
						@endif
					</ul>
				</li>
				@endif
				@if($staff)
					@if($staff->role_id == 1 || $staff->role_id == 2)
					<li class="dropdown">
						<a href="" class="dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-stats"></span> Reportes <span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							<li>{{ HTML::link('/report/top_loans','Materiales más Solicitados') }}</li>
							<li>{{ HTML::link('/report/most_requested_materials','Solicitudes de Materiales para Compra') }}</li>
							<li class="divider"></li>
							<li>{{ HTML::link('/report/restricted_users','Usuarios con Multa') }}</li>
							<li>{{ HTML::link('/report/loans_by_user','Préstamos por Usuario') }}</li>
							<li>{{ HTML::link('/report/loans_by_teachers','Préstamos solicitados por Profesores') }}</li>
							<li class="divider"></li>
							<li>{{ HTML::link('/report/last_material_entries','Libros Ingresados') }}</li>
							<li>{{ HTML::link('/report/loans_by_material','Préstamos por Material') }}</li>
							<li class="divider"></li>
							<li>{{ HTML::link('/report/approved_rejected_purchase_orders','Solicitudes de Compra') }}</li>
						</ul>
					</li>
					@endif
				@endif
				@if($staff && ($staff->role_id==4))
				<li>{{ HTML::link('/staff/assistance','Toma de asistencia') }}</li>
				@else
				<li>{{ HTML::link('/catalog/catalog','Catálogo') }}</li>
				@endif
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li>{{ HTML::link('/logout','Cerrar Sesión( '.$person->name.' )') }}</li>
			</ul>
		</div>
	</div>
</nav>