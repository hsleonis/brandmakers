/*
 ROUTER v1.0.1
 BASE TECHNOLOGIES. v3.1
 (c) 2015 DCASTALIA, http://dcastalia.com
 License: GPLv-3
 Author: MD. Hasan Shahriar
 Author email: hsleonis2@gmail.com

*/

app.config(function($routeProvider,$locationProvider) {
    $routeProvider
    .when('/', {
        templateUrl : 'templates/home.html',
        controller  : 'homeController'
    })
    .when('/pages/media', {
        templateUrl : 'templates/media-list.html',
        controller  : 'mediaController'
    })
    .when('/pages/media/:subpage', {
        templateUrl : 'templates/media-sublist.html',
        controller  : 'mediaController'
    })
    .when('/pages/media/:subpage/:detail', {
        templateUrl : 'templates/media.html',
        controller  : 'mediaController'
    })
    .when('/pages/:page', {
        templateUrl : 'templates/page.html',
        controller  : 'pageController'
    })
    .when('/pages/:page/:subpage', {
        templateUrl : 'templates/page.html',
        controller  : 'pageController'
    })
    .when('/:term', {
        templateUrl : 'templates/project.html',
        controller  : 'projectController'
    })
    .when('/projects/:type', {
        templateUrl : 'templates/listview.html',
        controller  : 'listController'
    });
    $locationProvider.html5Mode(true);
});