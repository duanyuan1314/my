var app = angular.module('app', []);
app.controller('my_controller', ['$scope', '$timeout', function($scope, $timeout) {
	$scope.has_login = false;
	$scope.login_btn = function() {
		$scope.has_login = true;
	}

	$scope.goPage = function(path) {
		mui.openWindow({
			url: path
		});
	}
	$scope.goPage = function (path) {
		mui.openWindow({
			url: path
		});
	}
	$scope.share_friend = function () {
		mui('#pop_type').popover('show');
	}
	$scope.close_pop = function () {
		mui('#pop_type').popover('hide');
	}
}]);