var timesheetControllers = angular.module ('timesheetControllers', []);

timesheetControllers.controller ('AttendanceCtrl', ['$scope', 'Attendence', '$rootScope', 'Payment',
	function ($scope, Attendence, $rootScope, Payment) {

		$rootScope.admin = null;

		$scope.attendance = new Attendence ();
		$scope.attendance.date_from = new Date ();
		$scope.attendance.date_to = new Date ();

		$scope.hstep = 1;
		$scope.mstep = 1;

		$scope.attendances = null;

		$scope.$watch (
			"formData.date_from",
			function (newValue, oldValue) {
				if ( newValue == oldValue ) {
					return;
				}

				if ( (newValue > $scope.formData.date_to) || $scope.formData.date_to == undefined ) {
					$scope.formData.date_to = newValue;
				}
			}
		);

		$scope.$watch (
			"formData.date_to",
			function (newValue, oldValue) {
				if ( newValue == oldValue ) {
					return;
				}

				if ( (newValue < $scope.formData.date_from) || $scope.formData.date_from == undefined ) {
					$scope.formData.date_from = newValue;
				}
			}
		);

		$scope.compareDate = function (dateOne, dateTwo) {

			if ( dateOne == dateTwo ) {
				return true;
			}

			return false;
		};

		$scope.store = function () {

			postData = {
				"date_to"  : moment ($scope.attendance.date_to).local ().format (),
				"date_from": moment ($scope.attendance.date_from).local ().format ()
			}

			Attendence.save ({}, postData).$promise.then (
				//success
				function (data) {


					$scope.attendances.unshift (data);
					$rootScope.payments = Payment.query ();
				}
			)

		};

	}]);

timesheetControllers.controller ('AttendanceListCtrl', ['$scope', 'Attendence', '$rootScope', 'Payment',
	function ($scope, Attendence, $rootScope, Payment) {
		$scope.$parent.attendances = Attendence.query ();
		$rootScope.payments = Payment.query ();
	}]);

var calculateRate = function (from, to, rate) {
	var payment = 0;
	try {
		var payment = (to - from) / 1000 / 60 / 60 * rate;
	} catch ( e ) {

	}

	return payment.toFixed (2);
}

timesheetControllers.controller ('timeEdit', ['$scope', '$filter', 'Attendence', '$rootScope', 'Payment',
	function ($scope, $filter, Attendence, $rootScope, Payment) {

		$scope.attendance.date_from = new Date ($filter ('date') ($scope.attendance.date_from, 'yyyy-MM-dd HH:mm:ss Z'));
		$scope.attendance.date_to = new Date ($filter ('date') ($scope.attendance.date_to, 'yyyy-MM-dd HH:mm:ss Z'));

		$scope.attendance.calculatedRate = calculateRate ($scope.attendance.date_from, $scope.attendance.date_to, $scope.attendance.rate);

		$scope.put = function () {

			postData = {
				"date_from": moment ($scope.attendance.date_from).local ().format (),
				"date_to"  : moment ($scope.attendance.date_to).local ().format ()
			}

			Attendence.put ({attendance_id: $scope.attendance.attendance_id}, postData).$promise.then (
				function () {
					$rootScope.payments = Payment.query ();
					$scope.attendance.calculatedRate = calculateRate ($scope.attendance.date_from, $scope.attendance.date_to, $scope.attendance.rate);
				}
			);

		};

		$scope.remove = function (AttendenceItem, index) {
			Attendence.remove ({attendance_id: AttendenceItem.attendance_id}).$promise.then (
				//success
				function (data) {
					$rootScope.payments = Payment.query ();

					if($rootScope.admin === true){
						$scope.user.attendance.splice (index, 1);
					}else{
						$scope.attendances.splice (index, 1);
					}

				}
			)
		};
	}]);

timesheetControllers.controller ('AdminCtrl', ['$scope', 'User', '$rootScope',
	function ($scope, User, $rootScope) {

		$rootScope.admin = true;

		$scope.users = User.query ();

		$scope.store = function () {

			User.save ().$promise.then (
				//success
				function (data) {
					$scope.users.push (data);
				}
			)

		};

	}]);

timesheetControllers.controller ('userEdit', ['$scope', 'User', 'Role', '$rootScope', '$modal',
	function ($scope, User, Role, $rootScope, $modal) {

		$scope.roles = Role.query ();

		$scope.put = function () {

			postData = {
				"name"    : $scope.user.name,
				"username": $scope.user.username,
				"email"   : $scope.user.email,
				"password": $scope.user.password,
				"roles"   : $scope.user.roles,
				"rate"    : $scope.user.rate[0].rate
			}

			User.put ({user_id: $scope.user.user_id}, postData);
		};

		$scope.showRoles = function () {
			var selected = [];
			angular.forEach ($scope.user.roles, function (userRole, key) {

				//console.log(role.role_id)
				angular.forEach ($scope.roles, function (roleItem, key) {
					if ( roleItem.role_id == userRole.role_id ) {
						selected.push (roleItem.role_name);
					}
				});

			});
			return selected.length ? selected.join (', ') : 'Nenastaveno';
		};

		$scope.remove = function (user, index) {

			var modalInstance = $modal.open ({
				templateUrl: 'views/modal.confirmation',
				controller : ModalInstanceCtrl
			})

			modalInstance.result.then (function () {

				User.remove ({user_id: user.user_id}).$promise.then (
					//success
					function (data) {
						$scope.users.splice (index, 1);
					}
				)

			}, function () {
				return false;
			});

		};

		$scope.showAttendence = function () {

			$rootScope.showUser = $scope.user.user_id;

			var modalInstance = $modal.open ({
				templateUrl: 'views/attendance',
				controller : 'UserCtrl'
			})

			modalInstance.result.then (function () {
				$rootScope.username = null;
			}, function () {
				$rootScope.username = null;
			});
		}
	}]);

timesheetControllers.controller ('UserCtrl', ['$scope', 'User', '$rootScope', '$modalInstance', 'Payment',
	function ($scope, User, $rootScope, $modalInstance, Payment) {

		User.get ({user_id: $rootScope.showUser}).$promise.then (

			//success
			function (user) {

				Payment.query ({user_id: $rootScope.showUser}).$promise.then (
					function (payments) {
						console.log (payments);
						$rootScope.payments = payments;
					}
				);

				$rootScope.username = user.name;
				$scope.user = user;
			}
		)

		$scope.cancel = function () {
			$modalInstance.dismiss ('cancel');
		};

	}]);

timesheetControllers.controller ('loginCtrl', ['$scope', '$rootScope', '$http', '$location',
	function ($scope, $rootScope, $http, $location) {

		$scope.login = function () {

			$http ({
				method: 'post',
				async : true,
				cache : false,
				url   : 'login',
				data  : $scope.loginData
			}).success (function (url) {
				window.location.href = url;
			});
		}

	}]);

var ModalInstanceCtrl = function ($scope, $modalInstance) {

	$scope.ok = function () {
		$modalInstance.close ();
	};

	$scope.cancel = function () {
		$modalInstance.dismiss ('cancel');
	};
};