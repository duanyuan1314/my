var app = angular.module('app', []);
app.controller('safe_controller', ['$scope', '$timeout', function($scope, $timeout) {
	$scope.has_login = false;
	$scope.login_btn = function() {
		$scope.has_login = true;
	}

	$scope.goPage = function(path) {
		mui.openWindow({
			url: path
		});
	}
	
	
	$scope.upload_photo = function() {
		mui('#photo_menu').popover('toggle');
	}

	$scope.galleryImg = function() {
		mui.toast('选了从本地选择', {
			duration: 'long',
			type: 'div'
		});
		mui('#photo_menu').popover('toggle');
	}

	$scope.getImage = function() {
		mui.toast('选了自己拍一张', {
			duration: 'long',
			type: 'div'
		});
		mui('#photo_menu').popover('toggle');
	}

	$scope.close_menu = function() {
		mui.toast('取消了选择', {
			duration: 'long',
			type: 'div'
		});
		mui('#photo_menu').popover('toggle');
	}
}]);