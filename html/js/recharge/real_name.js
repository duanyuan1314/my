var app = angular.module('app', []);
app.controller('real_name_controller', ['$scope', '$timeout','$interval',function($scope, $timeout,$interval) {
	$scope.wrong_flag = false;
	$scope.submit_form = function() {
		mui('#pop_into').popover('show');
	}
	
	$scope.canClick=false;  
    $scope.description = "发送验证码";  
    var second=59;  
    var timerHandler;  
    $scope.getTestCode = function(){  
        timerHandler =$interval(function(){  
            if(second<=0){  
                $interval.cancel(timerHandler);    //当执行的时间59s,结束时，取消定时器 ，cancle方法取消   
                second=59;  
                $scope.description="发送验证码";  
                $scope.canClick=false;    //因为 ng-disabled属于布尔值，设置按钮可以点击，可点击发送  
            }else{  
                $scope.description=second+"S后重试";  
                second--;  
                $scope.canClick=true;  
            }  
        },1000)   //每一秒执行一次$interval定时器方法  
    }; 
	
	$scope.close_pop = function() {
		mui('#pop_into').popover('hide');
	}
}]);