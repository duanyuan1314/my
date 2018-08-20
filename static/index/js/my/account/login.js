var app = angular.module('app', []);
app.controller('register_controller', ['$scope', '$timeout', '$interval', function($scope, $timeout, $interval) {
	$scope.wrong_flag = false;
	$scope.param = {};
	$scope.goPage = function(path) {
		mui.openWindow({
			url: path
		});
	}

	$scope.submit_form = function() {
		if(($scope.param.phone == undefined || $scope.param.phone == '') || ($scope.param.password == undefined || $scope.param.password == '')) {
			$('.account_container input[type=text].input_case,.account_container input[type=password].input_case').css('border', '1px solid #EB7433');
			if($('.wrong_msg').length == 0) {
				$('#password_input').after('<p class="wrong_msg">账号或密码错误</p>');
			}
		} else {
			$('.account_container input[type=text].input_case,.account_container input[type=password].input_case').css('border', '1px solid #fff');
			$('.wrong_msg').remove();
		}
	}

	$scope.close_pop = function() {
		mui('#pop_into').popover('hide');
	}
}]);