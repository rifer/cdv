'use strict';

var myApp = angular.module('myApp', [
    'ngStorage',
    '720kb.tooltips'
    ]);

myApp.controller('TableCtrl', ['$scope', '$http', '$localStorage', function ($scope, $http, $localStorage) {
    var url = "http://carceldeventas.net/sources/deceased.json";
    $scope.allItems = [];
    if ($localStorage.list != undefined) {
        $scope.allItems = $localStorage.list;
        $scope.filteredList = $scope.allItems;
    }
    else {
        $http.get(url).
        success(function(data, status, headers, config) {
            $scope.allItems = data;
            $scope.filteredList = $scope.allItems;
            $localStorage.list = $scope.allItems;
        }).
        error(function(data, status, headers, config) {
          // log error
        });
    };


    $scope.search = function () {
        $scope.filteredList = _.filter($scope.allItems,
        function (item) {
            return searchUtil(item, $scope.searchText);
        });

        if ($scope.searchText == '') {
            $scope.filteredList = $scope.allItems;
        }
    }
}]);
/*myApp.filter("dateformatter", function($filter){
  // this should return 'yyyy-MM-dd h:mm:ss'
  return function(dt) {
    var _dt = dt.split(" ");
    var date = _dt[0];
    var _date = date.split("-");
    var death = _dt[0];
    var _death = date.split("-");
    return _date[2]+"-"+_date[0]+"-"+_date[1];
    return _death[2]+"-"+_death[0]+"-"+_death[1];
  };
});*/
function searchUtil(item, toSearch) {
    return (
        item.date.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 ||
        item.death.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
        item.name.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
        item.years.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 ||
        item.files.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
        item.deathtype.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 ) 
        ? true : false;
}


