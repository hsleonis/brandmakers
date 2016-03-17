/*
 APP JS v1.0.1
 BRAND MAKER v1.1
 (c) 2016 DCASTALIA, http://dcastalia.com
 License: GPL v3
 Author: MD. Hasan Shahriar
 Author email: hsleonis2@gmail.com
  _____   _____           _____ _______       _      _____          
 |  __ \ / ____|   /\    / ____|__   __|/\   | |    |_   _|   /\    
 | |  | | |       /  \  | (___    | |  /  \  | |      | |    /  \   
 | |  | | |      / /\ \  \___ \   | | / /\ \ | |      | |   / /\ \  
 | |__| | |____ / ____ \ ____) |  | |/ ____ \| |____ _| |_ / ____ \ 
 |_____/ \_____/_/    \_\_____/   |_/_/    \_\______|_____/_/    \_\

*/

// App
var modules = [
                'ngRoute',
                'ngStorage',
                'ngAnimate',
                'ngSanitize',
                'slick'
            ];

var app = angular.module('brand', modules).run(function ($templateCache, $http, $route, $rootScope, $location) {
    $http.get('templates/header.html', {
        cache: $templateCache
    });
    $http.get('templates/home.html', {
        cache: $templateCache
    });
    $http.get('templates/listview.html', {
        cache: $templateCache
    });
    $http.get('templates/menu.html', {
        cache: $templateCache
    });
    $http.get('templates/page.html', {
        cache: $templateCache
    });
    $http.get('templates/project.html', {
        cache: $templateCache
    });
    
    var original = $location.path;
    $location.path = function (path, reload) {
        if (reload === false) {
            var lastRoute = $route.current;
            var un = $rootScope.$on('$locationChangeSuccess', function () {
                $route.current = lastRoute;
                un();
            });
        }
        return original.apply($location, [path]);
    };
});

app.config(function($sceProvider) {
  $sceProvider.enabled(false);
});

// API links
function apis(){
    var base = "/brand";
    var path = "/projects/web";
    var API = {
        baseURL: location.origin + path + base,
        adminURL: location.origin + path + base + "/cms/administrator",
        jsonURL: location.origin + path + base + "/cms/administrator/json",
    };
    return API;
}
