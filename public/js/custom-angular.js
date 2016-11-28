var guest_house =  angular.module('guest_house', [], function($interpolateProvider){
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});
 guest_house.controller('guestCtr', function($scope, $http){
       $scope.no_of_visitors = '';
       
        var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }
       $scope.init = function(val){
           $scope.no_of_visitors = val;
           //console.log($scope.no_of_visitors);
       }
       $scope.changeVisitors = function(){
           console.log($scope.no_of_visitors);
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