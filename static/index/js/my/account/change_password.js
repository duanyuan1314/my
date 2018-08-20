var app = angular.module('app', []);
app.controller('change_password_controller', ['$scope', '$timeout', function($scope, $timeout) {

	$scope.goPage = function(path) {
		mui.openWindow({
			url: path
		});
	}
	
	
	$scope.submit_btn = function() {
		mui('#pop_into').popover('show');
	}

	$scope.close_pop = function() {
		mui('#pop_into').popover('hide');
	}
}]);