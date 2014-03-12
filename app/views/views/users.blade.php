<div class="panel panel-default">
	<!-- Default panel contents -->
	<div class="panel-heading clearfix">
		<div class="float-left" style="max-width: 250px">
			<div class="input-group">
				<label for="username" class="input-group-addon btn btn-primary" style="color: #fff"><span class="glyphicon glyphicon-search"></span> Vyhledat</label>
				<input type="text" class="form-control" id="username" placeholder="klíčové slovo" ng-required="true" ng-model="search">
				<label for="username" class="input-group-addon"><span class="glyphicon glyphicon-user"></span></label>
			</div>
		</div>

		<div class="btn-group float-right" ng-click="store()">
			<button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button>
			<button class="btn btn-success">Přidat uživatele</button>
		</div>
	</div>

	<!-- Table -->
	<table class="users table table-striped table-hover table-responsive text-center">
		<thead>
		<tr>
			<th class="text-center"><span class="glyphicon glyphicon-tag"></span></th>
			<th class="text-center"><span class="glyphicon glyphicon-user"></span></th>
			<th class="text-center"><span class="glyphicon glyphicon-user"></span></th>
			<th class="text-center"><span class="glyphicon glyphicon-envelope"></span></th>
			<th class="text-center"><span class="glyphicon glyphicon-barcode"></span></th>
			<th class="text-center"><span class="glyphicon glyphicon-cog"></span></th>
			<th class="text-center"><span class="glyphicon glyphicon-calendar"></span></th>
			<th class="text-center"><span class="glyphicon glyphicon-usd"></span></th>
			<th class="text-center"><span class="glyphicon glyphicon-pencil"></span></th>
		</tr>
		</thead>
		<tbody>
		<tr ng-repeat="user in users | filter:search:strict" ng-controller="userEdit">
			<td>@{{user.user_id}}</td>
			<td editable-text="user.name" onaftersave="put()">@{{user.name}}</td>
			<td editable-text="user.username" onaftersave="put()">@{{user.username}}</td>
			<td editable-email="user.email" onaftersave="put()">@{{user.email}}</td>
			<td editable-text="user.password" onaftersave="put()">NOVÉ HESLO</td>
			<td editable-select="user.roles" e-multiple e-ng-options="role as role.role_name for role in roles" onaftersave="put()">
				@{{ showRoles() }}
			</td>
			<td>@{{user.created_at}}</td>
			<td editable-text="user.rate[0].rate" onaftersave="put()">@{{user.rate[0].rate}}</td>
			<td>
				<div class="btn-group">
					<!-- href="#!/@{{user.user_id}}" -->
					<a ng-click="showAttendence()" class="btn btn-info glyphicon glyphicon-list"></a>
					<button class="btn btn-danger glyphicon glyphicon-trash" ng-click="remove(user, $index)"></button>
				</div>
			</td>
		</tr>
		</tbody>
	</table>
</div>