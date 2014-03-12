<div class="panel panel-default">
	<div class="panel-heading clearfix">
		<div class="float-left" style="max-width: 315px">
			<div class="input-group">
				<label for="date_from" class="input-group-addon btn btn-primary text-white"><span class="glyphicon glyphicon-search"></span> Historie docházky</label>
				<input type="text" class="form-control" id="date_from" show-button-bar="false" datepicker-popup="yyyy-MM-dd" ng-model="searchDateFrom.date" placeholder="vyhledat datum" is-open="openedTo" ng-required="true">
				<label for="date_from" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
			</div>
		</div>

		@if($scope == 'user')
		<div class="btn-group float-right" ng-click="store()">
			<button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button>
			<button class="btn btn-success">Přidat docházku</button>
		</div>
		@else
		<button type="button" class="btn btn-danger btn-sm float-right" data-dismiss="modal" aria-hidden="true" ng-click="cancel()">
			<span class="glyphicon glyphicon-remove-circle"></span>
		</button>
		@endif

		@if($scope == 'admin')
		<div class="clearfix"></div>
		<alert ng-repeat="alert in alerts" type="alert.type" close="closeAlert($index)">@{{alert.msg}}</alert>
		@endif
	</div>
	<table class="attendances table table-striped table-hover table-responsive">
		<thead>
		<tr>
			<th><span class="glyphicon glyphicon-calendar"></span></th>
			<th class="text-center"><span class="glyphicon glyphicon-time"></span></th>
			<th class="text-center"><span class="glyphicon glyphicon-time"></span></th>
			<th class="text-center"><span class="glyphicon glyphicon-usd"></span></th>
			<th class="text-center"><span class="glyphicon glyphicon-pencil"></span></th>
		</tr>
		</thead>
		<tbody>
		<tr ng-repeat="attendance in {{$scope == 'user' ? 'attendances' : 'user.attendance'}} | filter:(searchDateFrom.date | date:'yyyy-MM-dd')" ng-controller="timeEdit">
			<th>
				@{{attendance.date_from | date:'yyyy-MM-dd'}}
			</th>
			<td class="text-center">
				<div buttons="no" editable-bstime="attendance.date_from" e-form="dateEdit" e-show-meridian="false">
					<span>@{{attendance.date_from | date:'HH:mm'}}</span>
				</div>
			</td>
			<td class="text-center">
				<div buttons="no" editable-bstime="attendance.date_to" e-form="dateEdit" e-show-meridian="false">
					<span>@{{attendance.date_to | date:'HH:mm'}}</span>
				</div>
			</td>
			<td class="text-center">
				@{{attendance.calculatedRate}}
			</td>
			<td style="width: 100px">
				@if($scope == 'user')
				<div ng-show="compareDate((attendance.date | date:'yyyy-MM-dd' ), '{{date('Y-m-d')}}')">
					@endif
					<div ng-hide="dateEdit.$visible" class="btn-group float-right">
						<button class="btn btn-info glyphicon glyphicon-edit" ng-click="dateEdit.$show()"></button>
						<button class="btn btn-danger glyphicon glyphicon-trash" ng-click="remove(attendance, $index)"></button>
					</div>

					<form editable-form name="dateEdit" onaftersave="put()" ng-show="dateEdit.$visible" class="form-inline">
						<div class="btn-group float-right">
							<button type="submit" class="btn btn-success glyphicon glyphicon-ok-circle" ng-disabled="dateEdit.$waiting"></button>
							<button type="button" class="btn btn-info glyphicon glyphicon-remove-circle" ng-disabled="dateEdit.$waiting" ng-click="dateEdit.$cancel()"></button>
						</div>
					</form>
					@if($scope == 'user')
				</div>
				@endif
			</td>
		</tr>
		</tbody>
	</table>
	@if($scope != 'user')
	<div class="panel-footer text-center">
		@{{username}}
	</div>
	@endif
</div>

<div class="panel panel-default">
	<div class="panel-heading clearfix">
		<div class="float-left" style="max-width: 315px">
			<div class="input-group">
				<label for="month" class="input-group-addon btn btn-primary text-white"><span class="glyphicon glyphicon-search"></span> Historie plateb</label>
				<input type="text" class="form-control" id="month" show-button-bar="false" datepicker-popup="yyyy-MM" ng-model="searchDate.month" placeholder="vyhledat datum" is-open="openedMonth" ng-required="true">
				<label for="month" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
			</div>
		</div>
	</div>
	<table class="payments table table-striped table-hover table-responsive">
		<thead>
		<th>
			<span class="glyphicon glyphicon-calendar"></span>
		</th>
		<th class="text-center">
			<span class="glyphicon glyphicon-calendar"></span>
		</th>
		<th class="text-center">
			<span class="glyphicon glyphicon-time"></span>
		</th>
		<th class="text-center">
			<span class="glyphicon glyphicon-usd"></span>
		</th>
		<th class="text-center"><span class="glyphicon glyphicon-pencil"></span></th>
		</thead>
		<tbody>
		<tr ng-repeat="payment in payments | filter:(searchDate.month | date:'yyyy-MM')">
			<th>@{{payment.created_at | date:'yyyy-MM'}}</th>
			<td class="text-center">@{{payment.days}}</td>
			<td class="text-center">@{{payment.hours}}</td>
			<td class="text-center">@{{payment.amount}}</td>
			<td class="text-center">
				<div class="btn-group btn-group-sm">
					<label for="payed" class="btn" ng-class="payment.payed ? 'btn-success' : 'btn-danger'">
						<span class="glyphicon glyphicon-remove" ng-show="!payment.payed"></span>
						<span class="glyphicon glyphicon-ok" ng-show="payment.payed"></span>
					</label>
					<span for="payed" class="btn btn-default">ZAPLACENO</span>
				</div>
			</td>
		</tr>
		</tbody>
	</table>
</div>