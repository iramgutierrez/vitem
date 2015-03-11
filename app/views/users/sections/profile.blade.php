<section class="panel" ng-show="tab == 'perfil' ">
	<div class="panel-heading">
		<h2>Datos personales. </h2>
	</div>
	<div class="panel-body bio-graph-info">
		<div class="row">
			<div class="col-sm-6">
				<span class="col-sm-6">Nombre </span><p class="col-sm-6"> {{ $user->name }}</p>
			</div>
			<div class="col-sm-6">
				<span class="col-sm-6">Correo electrónico </span><p class="col-sm-6"> {{ $user->email }}</p>
			</div>
			<div class="col-sm-6">
				<span class="col-sm-6">Usuario </span><p class="col-sm-6"> {{ $user->username }}</p>
			</div>
			@if(isset($user->role))
				<div class="col-sm-6">
					<span class="col-sm-6">Rol </span><p class="col-sm-6"> {{ $user->role->name }}</p>
				</div>
			@endif
			<div class="col-sm-6">
				<span class="col-sm-6">Calle</span><p class="col-sm-6"> {{ $user->street }}</p>
			</div>
			<div class="col-sm-6">
				<span class="col-sm-6">Número exterior</span><p class="col-sm-6"> {{ $user->outer_number }}</p>
			</div>
			<div class="col-sm-6">
				<span class="col-sm-6"> Número interior</span><p class="col-sm-6"> {{ $user->inner_number }}</p>
			</div>
			<div class="col-sm-6">
				<span class="col-sm-6">Código postal</span><p class="col-sm-6"> {{ $user->zip_code }}</p>
			</div>
			<div class="col-sm-6">
				<span class="col-sm-6">Colonia</span><p class="col-sm-6"> {{ $user->colony }}</p>
			</div>
			<div class="col-sm-6">
				<span class="col-sm-6">Delegación o municipio</span><p class="col-sm-6"> {{ $user->city }}</p>
			</div>
			<div class="col-sm-6">
				<span class="col-sm-6">Estado</span><p class="col-sm-6"> {{ $user->state }}</p>
			</div>
			<div class="col-sm-6">
				<span class="col-sm-6">Teléfono </span><p class="col-sm-6"> {{ $user->phone }}</p>
			</div>
			@if(isset($user->employee))
				<div class="col-sm-6">
					<span class="col-sm-6">Fecha de ingreso </span><p class="col-sm-6"> {{ $user->employee->entry_date }}</p>
				</div>
				<div class="col-sm-6">
					<span class="col-sm-6">Salario </span><p class="col-sm-6"> {{ <?php echo $user->employee->salary ?> | currency }}</p>
				</div>
			@endif
			<!--<div class="col-sm-6">
				<span class="col-sm-6">Status </span><p class="col-sm-6"> {{ <?php echo $user->status ?>  | boolean }}</p>
			</div>-->
		</div>
	</div>
</section>