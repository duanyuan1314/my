var app = angular.module('app', []);
app.controller('rank_controller', ['$scope', '$timeout', '$interval', function($scope, $timeout, $interval) {
	$scope.animate = false;
	$scope.all_game = false;
	$scope.luck_list = [{
			msg: "恭喜人在江湖**在超能争霸赢取30算力。"
		},
		{
			msg: "恭喜人在一二三四在超能争霸赢取50算力。"
		},
		{
			msg: "恭喜人在五六七八在超能争霸赢取70算力。"
		}
	];

	$scope.scroll = function() {
		$scope.animate = true;
		$timeout(function() {
			$scope.luck_list.push($scope.luck_list[0]);
			$scope.luck_list.shift();
			$scope.animate = false;
		}, 500)
	};
	$scope.luck_timer = $interval(function() {
		$scope.scroll();
	}, 2000)
	$scope.pop_b_select = function() {
		mui('#b_select_container').popover('toggle', document.getElementById("b_select_btn")); //show hide toggle
	}
	$scope.show_all_game = function(e) {
		$scope.all_game = !$scope.all_game;
		if($scope.all_game) {
			$(e.currentTarget).html('收起<i class="mui-icon mui-icon-arrowup"></i>');
		} else {
			$(e.currentTarget).html('全部游戏<i class="mui-icon mui-icon-arrowdown"></i>');
		}
	}

	$scope.goPage=function(){
		var id = "123";
		var pass = "456";
		var url = 'rank.html?id=' + id + '&pass=' + pass;
		mui.openWindow({
			url: url
		});
	}

	//获得slider插件对象
	var gallery = mui('.mui-slider');
	gallery.slider({
		interval: 3000 //自动轮播周期，若为0则不自动播放，默认为0；
	});

}]);