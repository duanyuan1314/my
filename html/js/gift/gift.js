var app = angular.module('app', []);
app.controller('gift_controller', ['$scope', '$timeout', function($scope, $timeout) {
	$scope.goPage=function(path){
		mui.openWindow({
			url: path
		});
	}
	$scope.no_address=function(){
		mui('#pop_into').popover('show');
	}
	$scope.close_pop = function(i) {
		if(i == 1){
			mui('#pop_into').popover('hide');
		}else{
			mui('#pop_into_2').popover('hide');
		}
	}
	$scope.submit_order=function(){
		mui('#pop_into_2').popover('show');
	}
}]);