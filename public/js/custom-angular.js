var guest_house =  angular.module('guest_house', [], function($interpolateProvider){
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});
guest_house.controller('guestCtr', function($scope, $http){
    $scope.no_of_visitors = '';
    $scope.type_of_guest = '';
    $scope.extendUsers = false;

    var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
    $scope.init = function(val){
        $scope.no_of_visitors = val;
    }
    $scope.changeVisitors = function(){
        $scope.extendUsers = true;
    }

});

guest_house.filter('range', function() {
  return function(input, total) {
    total = parseInt(total);

    for (var i=0; i<total; i++) {
      input.push(i);
    }

    return input;
  };
});




var allotment =  angular.module('allotment', [], function($interpolateProvider){
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

allotment.controller('allotmentCtrl', function ($scope) {
    $scope.changeRoom = function ($rooms) {
        angular.forEach($rooms, function (v, k) {
            if (v.id == $scope.room_no) {
                //Got the room. display it
                $scope.msgText = 'Room ' +v.room_no+ ' has capacity of ' + v.capacity + ' guests and currently ' + v.cnt + ' guests are allocated.';
            }
        })
    }
})