var app = angular.module('app', []);
app.controller('confirm_order_controller', ['$scope', '$timeout', function($scope, $timeout) {
	$scope.user_select=1;
	$scope.count_num = 1;
	$scope.check_address=function(i){
		$scope.user_select=i;
	}
	$scope.goPage = function(path) {
		mui.openWindow({
			url: path
		});
	}
	
	$scope.count_btn=function(i){
		if(i == 1){
			$scope.count_num++;
		}else{
			if($scope.count_num == 1){
				return;
			}else{
				$scope.count_num--;
			}
		}
	}
}]);