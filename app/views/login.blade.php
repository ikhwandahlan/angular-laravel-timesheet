<div class="modal fade login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" ng-controller="loginCtrl">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">{{Config::get('timesheet.name')}}</h4>
			</div>
			<form role="form" ng-submit="login()">
				<div class="modal-body">

					<alert ng-repeat="alert in alerts" type="alert.type" close="closeAlert($index)">@{{alert.msg}}</alert>

					<div class="form-group">
						<div class="input-group">
							<label for="username" class="input-group-addon btn btn-primary text-white"><span class="glyphicon glyphicon-user"></span></label>
							<input type="text" required class="form-control" ng-model="loginData.username" id="username" placeholder="uživatelské jméno">
						</div>
					</div>

					<div class="form-group form-control-static">
						<div class="input-group">
							<label for="password" class="input-group-addon btn btn-primary text-white"><span class="glyphicon glyphicon-barcode"></span></label>
							<input type="password" required class="form-control" ng-model="loginData.password" id="password" placeholder="heslo">
						</div>
					</div>

				</div>
				<div class="modal-footer">

					<div class="btn-group float-left">
						<label for="remember" class="btn" ng-class="loginData.remember ? 'btn-success' : 'btn-danger'">
							<input hidden="" type="checkbox" id="remember" ng-model="loginData.remember">
							<span class="glyphicon glyphicon-remove" ng-show="!loginData.remember"></span>
							<span class="glyphicon glyphicon-ok" ng-show="loginData.remember"></span>
						</label>
						<label for="remember" class="btn btn-default">ZAPAMATOVAT</label>
					</div>

					<div class="btn-group">
						<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-log-in"></span></button>
						<button type="submit" class="btn btn-success">PŘIHLÁSIT</button>
					</div>

				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$ ('.login').modal ('show');
</script>