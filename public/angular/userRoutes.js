app.config (['$routeProvider', '$locationProvider',
	function ($routeProvider, $locationProvider) {

		$locationProvider.html5Mode (false);

		$routeProvider.
			when ('/', {
			templateUrl: 'views/attendance',
			controller : 'AttendanceListCtrl'
		})
			.otherwise ({ redirectTo: '/' })

	}]);