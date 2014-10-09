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
				@if($staff->role_id == 1)
				<li class="dropdown">
					<a href="" class="dropdown-toggle" data-toggle="dropdown">
						<span class="glyphicon glyphicon-cog"></span> Configuración <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li>{{ HTML::link('/config/general_configuration','Configuración General') }}</li>
						<li>{{ HTML::link('#','Políticas') }}</li>
						<li>{{ HTML::link('#','Registrar Infraestructura') }}</li>
						<li class="divider"></li>
						<li>{{ HTML::link('#','Mostrar Sedes') }}</li>
						<li>{{ HTML::link('#','Registrar Sede') }}</li>
						<li class="divider"></li>
						<li>{{ HTML::link('/config/list_supplier','Buscar Proveedores') }}</li>
						<li>{{ HTML::link('/config/create_supplier','Registrar Proveedor') }}</li>
						<li class="divider"></li>
						<li>{{ HTML::link('/config/list_material_type','Mostrar Tipos de Materiales') }}</li>
						<li>{{ HTML::link('/config/create_material_type','Registrar Tipo de Material') }}</li>
					</ul>
				</li>
				@endif
				@if($staff && $staff->role_id == 3)
				<li class="dropdown">
					<a href="" class="dropdown-toggle" data-toggle="dropdown">
						<span class="glyphicon glyphicon-book"></span> Materiales <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li>{{ HTML::link('#','Buscar Ordenes de Compra') }}</li>
						<li>{{ HTML::link('#','Registrar Orden de Compra') }}</li>
						<li>{{ HTML::link('#','Ver Solicitudes') }}</li>
						<li class="divider"></li>
						<li>{{ HTML::link('/material/list_material','Buscar Materiales') }}</li>
						<li>{{ HTML::link('/material/create_material','Registrar Material') }}</li>
					</ul>
				</li>
				@endif
				@if($staff->role_id == 1 || $staff->role_id == 2)
				<li class="dropdown">
					<a href="" class="dropdown-toggle" data-toggle="dropdown">
						<span class="glyphicon glyphicon-user"></span> Usuarios <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li>{{ HTML::link('#','Buscar Usuarios') }}</li>
						<li>{{ HTML::link('#','Registrar Usuario') }}</li>
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
						<li>{{ HTML::link('#','Buscar Personal') }}</li>
						<li>{{ HTML::link('#','Registrar Personal') }}</li>
					</ul>
				</li>
				@endif
				@if($user || $staff->role_id == 3)
				<li class="dropdown">
					<a href="" class="dropdown-toggle" data-toggle="dropdown">
						<span class="glyphicon glyphicon-refresh"></span> Préstamos <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						@if($staff->role_id == 3)
						<li>{{ HTML::link('#','Registrar Préstamo') }}</li>
						<li>{{ HTML::link('/loan/return_register','Registrar Devolución') }}</li>
						@endif
						@if($user)
						<li>{{ HTML::link('#','Mis Préstamos') }}</li>
						@endif
					</ul>
				</li>
				<li class="dropdown">
					<a href="" class="dropdown-toggle" data-toggle="dropdown">
						<span class="glyphicon glyphicon-tags"></span> Reservas <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						@if($staff->role_id == 3)
						<li>{{ HTML::link('#','Materiales Reservados') }}</li>
						<li>{{ HTML::link('#','Ver Reserva de Cubículos') }}</li>
						@endif
						@if($user)
						<li class="divider"></li>
						<li>{{ HTML::link('#','Reservar Cubículo') }}</li>
						<li>{{ HTML::link('#','Mis Cubículos Reservados') }}</li>
						@endif
					</ul>
				</li>
				@endif
				<li class="dropdown">
					<a href="" class="dropdown-toggle" data-toggle="dropdown">
						<span class="glyphicon glyphicon-log-in"></span> Mi Cuenta <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li>{{ HTML::link('/myaccount/change_password','Cambiar Contraseña') }}</li>
						@if($user)
						<li class="divider"></li>
						<li>{{ HTML::link('#','Registrar Solicitud') }}</li>
						@endif
					</ul>
				</li>
				@if($staff->role_id == 1 || $staff->role_id == 2)
				<li class="dropdown">
					<a href="" class="dropdown-toggle" data-toggle="dropdown">
						<span class="glyphicon glyphicon-stats"></span> Reportes <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li>{{ HTML::link('#','Materiales más Solicitados') }}</li>
						<li class="divider"></li>
						<li>{{ HTML::link('#','Usuarios con Multa') }}</li>
						<li class="divider"></li>
						<li>{{ HTML::link('#','Libros Ingresados') }}</li>
						<li class="divider"></li>
						<li>{{ HTML::link('#','Solicitudes de Compra') }}</li>
					</ul>
				</li>
				@endif
				<li>{{ HTML::link('#','Catálogo') }}</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li>{{ HTML::link('/logout','Cerrar Sesión') }}</li>
			</ul>
		</div>
	</div>
</nav>