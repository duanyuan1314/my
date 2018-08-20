var app = angular.module('app', []);
app.controller('bean_balance_controller', ['$scope', '$timeout', function($scope, $timeout) {
	$scope.has_login = false;
	$scope.login_btn = function() {
		$scope.has_login = true;
	}

	$scope.goPage = function(path) {
		mui.openWindow({
			url: path
		});
	}
}]);