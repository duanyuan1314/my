var app = angular.module('app', []);
app.controller('change_phone_2_controller', ['$scope', '$timeout', function($scope, $timeout) {

	$scope.goPage = function(path) {
		mui.openWindow({
			url: path
		});
	}
	
	$scope.canClick = false;
	$scope.description = "发送验证码";
	var code_second = 59;
	var timerHandler;
	$scope.getTestCode=function(){
		$('.send_code').text("59s后重试").attr('disabled','disabled');
		var code_second = 58;
		var timerHandler;
		timerHandler = setInterval(function() {
			if(code_second <= 0) {
				window.clearInterval(timerHandler); //当执行的时间59s,结束时，取消定时器    
				code_second = 58;
				$('.send_code').text('发送验证码').removeAttr('disabled');
			} else {
				$('.send_code').text(code_second + "s后重试").attr('disabled','disabled');
				code_second--;
			}
		}, 1000)
	}
	
	$scope.submit_btn = function() {
		mui('#pop_into').popover('show');
	}

	$scope.close_pop = function() {
		mui('#pop_into').popover('hide');
	}
}]);