var app = angular.module ('app', [
		'ngRoute',
		'timesheetControllers',
		'timesheetServices',
		'ui.bootstrap',
		'xeditable'
	]).run (function ($rootScope, editableOptions, editableThemes) {

	editableThemes.bs3.inputClass = 'input-sm';
	editableThemes.bs3.buttonsClass = 'btn-sm';
	editableOptions.theme = 'bs3';
	$rootScope.alerts = [];

	$rootScope.closeAlert = function (index) {
		$rootScope.alerts.splice (index, 1);
	};
});

app.config (['$httpProvider', function ($httpProvider) {

	/*
	 Response interceptors are stored inside the
	 $httpProvider.responseInterceptors array.
	 To register a new response interceptor is enough to add
	 a new function to that array.
	 */

	$httpProvider.responseInterceptors.push (['$q', '$rootScope', function ($q, $rootScope) {

		// More info on $q: docs.angularjs.org/api/ng.$q
		// Of course it's possible to define more dependencies.

		return function (promise) {

			/*
			 The promise is not resolved until the code defined
			 in the interceptor has not finished its execution.
			 */


			return promise.then (function (response) {

				// response.status >= 200 && response.status <= 299
				// The http request was completed successfully.

				/*
				 Before to resolve the promise
				 I can do whatever I want!
				 For example: add a new property
				 to the promise returned from the server.
				 */

				if ( response.data.message != undefined ) {
					$rootScope.alerts = [];
					$rootScope.alerts.push ({type: 'success', msg: response.data.message});
				}

				// ... or even something smarter.

				/*
				 Return the execution control to the
				 code that initiated the request.
				 */

				return response;

			}, function (response) {

				// The HTTP request was not successful.

				/*
				 It's possible to use interceptors to handle
				 specific errors. For example:
				 */
				$rootScope.alerts = [];
				angular.forEach (response.data.message, function (value, key) {
					$rootScope.alerts.push ({type: 'danger', msg: value});
				});

				/*
				 $q.reject creates a promise that is resolved as
				 rejectedwith the specified reason.
				 In this case the error callback will be executed.
				 */

				return $q.reject (response);

			});

		}

	}]);

}]);