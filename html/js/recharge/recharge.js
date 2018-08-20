var app = angular.module('app', []);
app.controller('recharge_controller', ['$scope', '$timeout', function($scope, $timeout) {
	$scope.pop_info = {};

	$scope.select_size = function(size) {
			$scope.user_size = size;
			mui('#pop_type').popover('show');
		},
		$scope.goPage = function(path) {
			mui.openWindow({
				url: path
			});
		}
	
	$scope.other_option = function() {
		mui('#pop_into').popover('show');
	}
	$scope.close_pop = function(i) {
		if(i == 1) {
			mui('#pop_into').popover('hide');
		} else {
			mui('#pop_type').popover('hide');
		}
	}
}]);