var timesheetServices = angular.module ('timesheetServices', ['ngResource']);

app.factory ('Attendence', ['$resource', '$rootScope',
	function ($resource, $rootScope) {
		return $resource ('attendance/:attendance_id', {attendance_id: '@attendance_id'}, {
			'put': { method: 'PUT' }
		});
	}]);

app.factory ('User', ['$resource', '$rootScope',
	function ($resource, $rootScope) {
		return $resource ('user/:user_id', {user_id: '@user_id'}, {
			'put': { method: 'PUT' }
		});
	}]);

app.factory ('Role', ['$resource', '$rootScope',
	function ($resource, $rootScope) {
		return $resource ('roles/:role_id', {role_id: '@role_id'}, {
			'put': { method: 'PUT' }
		});
	}]);

app.factory ('Payment', ['$resource', '$rootScope',
	function ($resource, $rootScope) {
		return $resource ('payment/:user_id', {user_id: '@user_id'}, {
			'query':  {method:'GET', isArray:true},
			'put': { method: 'PUT' }
		});
	}]);