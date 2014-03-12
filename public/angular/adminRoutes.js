app.config (['$routeProvider', '$locationProvider',
	function ($routeProvider, $locationProvider) {

		$locationProvider.html5Mode(false);
		$locationProvider.hashPrefix('!');

		$routeProvider.
			when ('/', {
			templateUrl: 'views/users',
			controller : 'AdminCtrl'

		})
			.when ('/:user_id', {
			templateUrl: 'views/user',
			controller : 'UserCtrl'

		})
			.otherwise ({ redirectTo: '/' })

	}
]);