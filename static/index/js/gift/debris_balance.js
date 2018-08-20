var app = angular.module('app', []);
app.controller('debris_controller', ['$scope', '$timeout', function($scope, $timeout) {
	$scope.wrong_flag = false;
	$scope.exchange_opro = function() {
		if($scope.user_key == null || $scope.user_key == '') {
			if($('.wrong_msg').length == 0) {
				$scope.wrong_flag = true;
				$("#user_key").before('<p class="wrong_msg">密钥不正确，请重新尝试</p>');
			}
		} else {
			$scope.wrong_flag = false;
			$('.wrong_msg').remove();
			mui('#pop_into').popover('show');
		}
	}

	$scope.close_pop = function(i) {
		if(i == 1) {
			mui('#pop_into').popover('hide');
		} else {
			mui('#pop_type').popover('hide');
		}
	}
}]);