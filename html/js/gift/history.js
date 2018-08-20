var app = angular.module('app', []);
app.controller('history_controller', ['$scope', '$timeout', function($scope, $timeout) {
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

	$scope.search_logistics=function(){
		mui('#pop_into').popover('show');
	}

	$scope.copy_order=function(){
		mui('#pop_into').popover('hide');
		mui.toast('复制成功',{ duration:'long', type:'div' })
	}

	$scope.close_pop = function() {
		mui('#pop_into').popover('hide');
	}
}]);