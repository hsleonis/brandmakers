/*

 CONTROLLERS JS v1.0.1
 BRAND MAKER v1.1
 (c) 2016 DCASTALIA, http://dcastalia.com
 License: GPL v3
 Author: MD. Hasan Shahriar
 Author email: hsleonis2@gmail.com

*/

(function (angular) {

    // GLOBALS
    var company = "BRAND MAKERS";
    var data = '';

    /******** Main control ************/
    app.controller('mainController', function ($scope, $http, $routeParams, $location, $localStorage) {
        // Load data
        $scope.loadList = function(){
            if(typeof($localStorage.list)=='undefined'){
            $http.post(apis().jsonURL + "/project_list.json", {})
            .success(function (response) {
                    $localStorage.list = response.product_list;
                    $scope.list=$localStorage.list;
            });
            return $scope.list;
            }else return $localStorage.list;
        };
        
        $scope.loadPages = function(){
            if(typeof($localStorage.pages)=='undefined'){
            $http.post(apis().jsonURL + "/allpages.json", {})
            .success(function (response) {
                    $localStorage.pages = response;
                    $scope.pages=$localStorage.pages;
            });
            return $scope.pages;
            }else return $localStorage.pages;
        };
        
        $scope.loadDetails = function(){
            if(typeof($localStorage.detail)=='undefined'){
            $http.post(apis().jsonURL + "/project_detail.json", {})
            .success(function (response) {
                    $localStorage.detail = response;
                    $scope.detail=$localStorage.detail;
            });
            return $scope.detail;
            }else return $localStorage.detail;
        };
        
        $scope.pageChanger = function(){
            $scope.$apply(function(){
                $location.url($("#page-changer").val());
            });
        };
        
        $scope.logoChanger = function(){
            $(".logo").attr("src","resources/img/logo-2.png");
        };
        
        $scope.list = $scope.loadList();
        $scope.pages = $scope.loadPages();
        $scope.detail = $scope.loadDetails();
        
        $scope.sendmail = function(q){
            alert("Please click Ok to send mail.");
            $http.post(apis().baseURL+"/server/mail.php", {sub:'contact',name:q.name,topic:q.sub,message:q.msg,email:"info@brandmakers.com"})
            .success(function (response) {
                var s = response.replace(/(<\/div>|<div>|<\/p>|<p>|<\/ul>)/g, "").replace(/(<br\/>|<\/li>|<ul>)/g, "\n").replace(/<li>/g, "• ");
                if(response=='Mail successfully sent') {
                    $('.mail-response').html(s);
                    //$('#enquiry-form').hide(100);
                }
                alert(s);
            });
        };
        
        $scope.changeTitle = function(title) {
            document.title = title.toUpperCase() + " | Brand Maker";
        };
        
        function reloadData(){
            $http.post(apis().jsonURL + "/project_list.json", {})
            .success(function (response) {
                    $localStorage.list = response.product_list;
            });
            $http.post(apis().jsonURL + "/allpages.json", {})
            .success(function (response) {
                    $localStorage.pages = response;
            });
            $http.post(apis().jsonURL + "/project_detail.json", {})
            .success(function (response) {
                    $localStorage.detail = response;
            });
        }
        reloadData();
    });

    /******** Home control ************/
    app.controller('homeController', function ($scope, $http, $routeParams, $location, $localStorage) {
        $scope.changeTitle('Home');
        $(document).ready(function(){
            $(".logo").attr("src","resources/img/logo.png");
            $("#layerslider").layerSlider({
                pauseOnHover:false,
            });
        });
    });
    
    /******** Page control ************/
    app.controller('pageController', function ($scope, $http, $routeParams, $location, $localStorage) {
        if( $(".close-button").hasClass('close-sign'))
        window.closeMenu();
        $scope.logoChanger();
        
        $scope.page = $routeParams.page;
        $scope.subpage = $routeParams.subpage;
        $scope.pages = $scope.loadPages();
        
        if(typeof $scope.pages[$scope.page]!=='undefined'){
            $scope.pageData = $scope.pages[$scope.page];
            $scope.rootTitle = $scope.pages[$scope.page].page_data.page_title;
            $scope.pageMenu = $scope.pageData.child_pages.menu;

            if(typeof $scope.pages[$scope.page].child_pages[$scope.subpage]!=='undefined'){
                $scope.pageData = $scope.pages[$scope.page].child_pages[$scope.subpage];
            }
        }
        $scope.changeTitle($scope.pageData.page_data.page_title);
    });
    
    /******** List control ************/
    app.controller('listController', function ($scope, $http, $routeParams, $location, $localStorage, $filter) {
        $scope.logoChanger();
        if( $(".close-button").hasClass('close-sign'))
        window.closeMenu();
        $scope.type = $routeParams.type;
        $scope.changeTitle($scope.type.toUpperCase()+" Projects");
        
        $scope.fullList = $filter('filter')($scope.loadList(), {project_category: $scope.type});
        $scope.currentList = $scope.fullList;
        $scope.limit = 0;
        
        $scope.nxtPage = function(a,b){
            $scope.limit+=($scope.limit+a<b)?a:0;
        };

        $scope.prvPage = function(a){
            $scope.limit-=($scope.limit>=a)?a:0;
        };
        
        function locationHashChanged() {
          if (location.hash == "#residential" || location.hash == "#commercial") {
            $scope.hash = location.hash.substring(1,location.hash.length);
            $scope.currentList = $filter('filter')($scope.fullList, {project_type: $scope.hash});
          }
        }
        locationHashChanged();
        window.addEventListener('hashchange', locationHashChanged);
    });
    
    /******** Project control ************/
    app.controller('projectController', function ($scope, $http, $routeParams, $location, $localStorage, $filter) {
        if( $(".close-button").hasClass('close-sign'))
        window.closeMenu();
        $scope.logoChanger();
        $scope.term = $routeParams.term;
        $scope.limit = 0;
        $scope.curPage = 1;
        $scope.projectPages = 1;
        $scope.currentList = $scope.loadList();
        $scope.tmp = $scope.loadDetails();
        
        function projectSwitch(val, apply){
            if(!apply){
                $scope.currentList = $filter('filter')($scope.list, {project_category: val});
                if($scope.currentList.length>0)
                $scope.projectPages = Math.ceil($scope.currentList.length/6);
                $scope.curPage = 1;
            }
            else
            $scope.$apply(function(){
                $scope.currentList = $filter('filter')($scope.list, {project_category: val});
                if($scope.currentList.length>0)
                $scope.projectPages = Math.ceil($scope.currentList.length/6);
                $scope.curPage = 1;
                $scope.limit = 0;
            });
        }
        
        if(typeof $scope.tmp!=='undefined' && typeof $scope.tmp[$scope.term]!=='undefined'){
            $scope.project = $scope.tmp[$scope.term];
            $scope.changeTitle($scope.project.title);
            $scope.menuList = $scope.project.category;
            projectSwitch($scope.menuList,0);
        }
        
        $scope.nxtPage = function(a,b){
            $scope.limit+=($scope.limit+a<b)?a:0;
            if($scope.curPage<$scope.projectPages)
            $scope.curPage++;
            console.table([{'page':$scope.curPage,"b":b,"limit":$scope.limit}]);
        };

        $scope.prvPage = function(a){
            $scope.limit-=($scope.limit>=a)?a:0;
            if($scope.curPage>1)
            $scope.curPage--;
            console.table([{'page':$scope.curPage,"limit":$scope.limit}]);
        };
        
        $scope.slickto = function(a){
            $('.slick-wrapper').slick('slickGoTo',a);
        };
        
        function locationHashChanged() {
          if (location.hash=="#glance"||location.hash=="#amenities"||location.hash=="#floor"||location.hash=="#gallery") {
              if($(location.hash).hasClass("tab-on")) return;
                $(".tab-on").removeClass("tab-on");
                $(location.hash).addClass("tab-on");
                
                $(".projects-nav li").removeClass("active");
                $(".projects-nav li[data-target='"+location.hash+"']").addClass("active");
          }
        }
        locationHashChanged();
        window.addEventListener('hashchange', locationHashChanged);
        
        $scope.listSwitcher = function(){
            $scope.menuList = $("#list-switcher").val();
            projectSwitch($scope.menuList,1);
        };
    });
    
    /******** Media control ************/
    app.controller('mediaController', function ($scope, $http, $routeParams, $location, $localStorage) {
        if( $(".close-button").hasClass('close-sign'))
        window.closeMenu();
        $scope.logoChanger();
        
        var page = 'media',
        subpage = $routeParams.subpage,
        detailpage = $routeParams.detailpage;
        $scope.page = page;
        $scope.pages = $scope.loadPages();
        
        function setData(p,q,r,s){
            $scope.pageData = p;
            $scope.pageMenu = q;
            $scope.rootTitle = r;
            $scope.rootSlug = s;
        }
        
        if(typeof $scope.pages[page]!=='undefined'){
            var a = $scope.pages[page];
            
            if(typeof a.child_pages[subpage]!=='undefined'){
                var b = a.child_pages[subpage];
                
                if(typeof b.child_pages[detailpage]!=='undefined'){
                    setData(b.child_pages[detailpage], b.child_pages.menu, b.page_data.page_title, b.page_data.page_slug);
                }
                else {
                    setData(b, b.child_pages.menu, a.page_data.page_title, b.page_data.page_slug);
                }
            }
            else {
                setData(a, a.child_pages.menu, a.page_data.page_title, a.page_data.page_slug);
            }
            $scope.changeTitle($scope.pageData.page_data.page_title);
        }
    });
    // ========================================================== //
})(window.angular);