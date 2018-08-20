var app = angular.module('app', []);
app.controller('admin_address_controller', ['$scope', '$timeout', function($scope, $timeout) {
	$scope.user_select=1;
	$scope.check_address=function(i){
		$scope.user_select=i;
		$timeout(function(){
			$scope.goPage('../order/confirm_order.html');
		},200)
	}
	$scope.goPage = function(path) {
		mui.openWindow({
			url: path
		});
	}
	$scope.goPage2 = function(path,id) {
		mui.openWindow({
			url: path+'/id/'+id
		});
	}
	$scope.no_address = function() {
		mui('#pop_into').popover('show');
	}
	$scope.close_pop = function() {
		mui('#pop_into').popover('hide');
	}

	$("#onoffswitch").on('click', function() {
		clickSwitch()
	});
	var clickSwitch = function() {
		if($("#onoffswitch").is(':checked')) {
			console.log("在ON的状态下");
		} else {
			console.log("在OFF的状态下");
		}
	};
}]);