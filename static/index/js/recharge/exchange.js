var app = angular.module('app', []);
app.controller('exchange_controller', ['$scope', '$timeout', function($scope, $timeout) {
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
			var user_key = $("#user_key").val();
			$.ajax({
				type: 'POST',
				dataType: "json",
				url: "ledou",
				data: { userkey: user_key},
				success: function (re) {
					if (re.code == 1){
						var cons = '成功兑换' + re.money +'乐豆';
					    loading(cons);
					} else if (re == false){
						layer.msg("网络异常", { time: 2000 });
					}else{
						layer.msg(re.msg, { time: 2000 });
					}
				}
			}); 
			//mui('#pop_into').popover('show');
		}
	}
	function loading(cons) {
		mui('#pop_into').popover('show');
		$('.pop_container p').text(cons);
		var home_second = 3;
		var homeTimer;
		var homeTimer = setInterval(function () {
			home_second--;
			if (home_second <= 0) {
				window.clearInterval(homeTimer);
				//执行跳转操作
				location.href = "index";
			}
		}, 1000)
	}
	$scope.close_pop = function(i) {
		if(i == 1) {
			mui('#pop_into').popover('hide');
		} else {
			mui('#pop_type').popover('hide');
		}
	}
}]);