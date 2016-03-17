/*
 CONTROLLERS JS v1.0.1
 (c) 2015 DCASTALIA. http://dcastalia.com
 License: GPL v3
*/

(function(angular) {
    'use strict';
	var url = location.href;
	 var check = url.split('localhost');
	 if(!check[1]){
	  var host = '192.168.1.41';
	 }else{
	  var host = 'localhost';
	 }
	
    var API = "http://"+host+"/tropical_home/administrator/json/";
	var landing=[];

    // Main control
    app.controller('mainController', function($scope, $http, $routeParams, $location, $localStorage) {
        
    });

    // Side navbar control
    app.controller('sideNavController', function($scope, $http, $routeParams, $location, $localStorage) {
		
    });

    // Main menu control
    app.controller('mainMenuController', function($scope, $http, $routeParams, $location, $localStorage) {
		$scope.main_menu = [];
		$scope.home_slide = [];
		landing=$localStorage.menu;
		if(!$localStorage.menu) {
			$http.post(API+"landing_json.json", {})
            .success(function(response) {
				$localStorage.menu = response;
                $scope.main_menu = $localStorage.menu.main_menu;
				$scope.home_slide = $localStorage.menu.home_slide;
            });	
		}
		else {
			 $scope.main_menu = $localStorage.menu.main_menu;
			 $scope.home_slide = $localStorage.menu.home_slide;
		}
		$http.post(API+"landing_json.json", {})
            .success(function(response) {
				$localStorage.menu = response;
            });	
    });

    // Right navbar control
    app.controller('rightNavController', function($scope, $http, $routeParams, $location, $localStorage) {

    });

    // Right navbar element control
    app.controller('rightNavElementController', function($scope, $http, $routeParams, $location, $localStorage) {

    });

    // Project detail control
    app.controller('projectDetailsController', function($scope, $http, $routeParams, $location, $localStorage) {

    });

})(window.angular);