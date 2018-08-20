var app = angular.module('app', []);
app.controller('change_info_controller', ['$scope', '$timeout', function($scope, $timeout) {
	$scope.has_login = false;
	$scope.param = {};
	$scope.disabled = false;
	$scope.login_btn = function() {
		$scope.has_login = true;
	}

	$scope.goPage = function(path) {
		mui.openWindow({
			url: path
		});
	}

	$scope.submit_btn = function() {
		//					$scope.disabled=true;
		if($scope.param.name == undefined || $scope.param.name == '') {
			$('.pop_text').removeClass('gray_text').addClass('wh_text');
			$('.pop_text').html('<img src="/static/index/img/my/danger.png" alt="" />此昵称已经被别人注册，再换一个昵称吧');
		} else {
			$('.pop_text').removeClass('wh_text').addClass('gray_text');
			$('.pop_text').html('昵称请控制在4-30个字符，支持中英文、数字');
			//						$scope.disabled=false;
		}
	}

	$scope.upload_photo = function() {
		mui('#photo_menu').popover('toggle');
	}

	$scope.galleryImg = function() {
//		mui.toast('选了从本地选择', {
//			duration: 'long',
//			type: 'div'
//		});
		mui('#photo_menu').popover('toggle');
	}

	$scope.getImage = function() {
//		mui.toast('选了自己拍一张', {
//			duration: 'long',
//			type: 'div'
//		});
		mui('#photo_menu').popover('toggle');
	}

	$scope.close_menu = function() {
//		mui.toast('取消了选择', {
//			duration: 'long',
//			type: 'div'
//		});
		mui('#photo_menu').popover('toggle');
	}
}]);