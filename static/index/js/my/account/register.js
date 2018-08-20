var app = angular.module('app', []);
app.controller('register_controller', ['$scope', '$timeout', '$interval', function($scope, $timeout, $interval) {
	$scope.wrong_flag = false;
	$scope.go_home = "跳转到首页（3s）";

	$scope.goPage = function(path) {
		mui.openWindow({
			url: path
		});
	}

	$scope.submit_form = function() {
		mui('#pop_into').popover('show');
		var home_second = 3;
		var homeTimer;
		var homeTimer = $interval(function() {
			home_second--;
			$scope.go_home = "跳转到首页（" + home_second + "s）";
			if(home_second <= 0) {
				$interval.cancel(homeTimer);
				$scope.goPage('../../home/index.html');
			}
		}, 1000)
	}

	$scope.canClick = false;
	$scope.description = "发送验证码";
	var code_second = 59;
	var timerHandler;
	$scope.getTestCode = function() {
		$scope.canClick = true;
		timerHandler = $interval(function() {
			if(code_second <= 0) {
				$interval.cancel(timerHandler); //当执行的时间59s,结束时，取消定时器 ，cancle方法取消   
				code_second = 59;
				$scope.description = "发送验证码";
				$scope.canClick = false; //因为 ng-disabled属于布尔值，设置按钮可以点击，可点击发送  
			} else {
				$scope.description = code_second + "S后重试";
				code_second--;
				$scope.canClick = true;
			}
		}, 1000) //每一秒执行一次$interval定时器方法  
	};

	$scope.close_pop = function() {
		mui('#pop_into').popover('hide');
	}
}]);