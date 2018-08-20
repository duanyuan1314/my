var app = angular.module('app', []);
app.controller('growth_prop_controller', ['$scope', '$timeout', function($scope, $timeout) {
	$scope.goPage = function(path) {
		mui.openWindow({
			url: path
		});
	}
}]);