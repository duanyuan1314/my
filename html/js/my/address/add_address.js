var app = angular.module('app', []);
app.controller('add_address_controller', ['$scope', '$timeout', function($scope, $timeout) {
	$scope.goPage = function(path) {
		mui.openWindow({
			url: path
		});
	}
	$scope.no_address = function() {
		mui('#pop_into').popover('show');
	}
	$scope.close_pop = function() {
		mui('#pop_into').popover('hide');
	}

	$("#onoffswitch").on('click', function() {
		clickSwitch()
	});
	var clickSwitch = function() {
		if($("#onoffswitch").is(':checked')) {
			console.log("在ON的状态下");
		} else {
			console.log("在OFF的状态下");
		}
	};
	mui.init();
	mui(function() {
		cityPicker = new mui.PopPicker({
			layer: 3
		});
		cityPicker.setData(cityData3);
	});
	//选择区域
	$scope.chooseArea = function() {　　
		cityPicker.show(function(items) {　　 // items为选中的三级区域信息
			console.log(items)
			var text = items[0].text + ' ' + items[1].text + ' ' + items[2].text;
			$('#select_address').val(text)　　
		});
	}
	//关闭选择器
	function closeChoose() {　　
		cityPicker.hide();
	}
}]);