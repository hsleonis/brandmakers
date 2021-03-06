(function(){
    "use strict";
    $(document).ready(function(){
        new WOW().init();
    });
    
    window.openMenu = function(){
        $(".main-menu").stop().animate({
            'z-index': 999,
        }, 0, function(){
            $(".menu-button.close-button").addClass('close-sign');
            $(".main-menu").animate({
                'top': 0
            }, 500, function(){
                $(".search-wrapper").css({
                    'display':'block'
                });
            });
        });
    };
    
    window.closeMenu = function(){
        $(".search-wrapper").css({
            'display':'none'
        });
        $(".main-menu").stop().animate({
            'top': -100+'%',
        }, 500, function(){
            $(".menu-button.close-button").removeClass('close-sign');
            $(".main-menu").animate({
                'z-index': 0,
            }, 0);
        });
        $(".nav-ul-pages").show("slow");
        $(".search-cross-wrapper, .nav-ul-products").hide("slow");
    };
    
    $(document).on("click",".menu-button", function(){
        window.openMenu();
    });
    
    $(document).on("click",".projects-info .minimize-btn", function(){
        if($(".projects-info").hasClass("info-hidden")) {
            $(".projects-info").removeClass("info-hidden");
            $(".projects-info .minimize-btn .fa-plus").removeClass("fa-plus").addClass("fa-minus");
        }
        else {
            $(".projects-info").addClass("info-hidden");
            $(".projects-info .minimize-btn .fa-minus").removeClass("fa-minus").addClass("fa-plus");
        }
    });
    
    $(document).on("focusin", ".search-wrapper input", function(){
        $(".nav-ul-pages").hide("slow");
        $(".nav-ul-products, .search-cross-wrapper").show("slow");
    });
    
    $(document).on("click", ".search-cross-wrapper", function(){
        $(".nav-ul-pages").show("slow");
        $(".search-cross-wrapper, .nav-ul-products").hide("slow");
    });
    
    $(document).on("click",".close-sign", function(){
        window.closeMenu();
    });
    
    $(document).on("click",".main-slider-button .fa-angle-right", function(){
        $("#layerslider").layerSlider('next');
    });

    $(document).on("click",".main-slider-button .fa-angle-left", function(){
        $("#layerslider").layerSlider('prev');
    });
    
    $(document).on("click",".list-filter li", function(){
        $(".list-filter li").removeClass('list-active');
        $(this).addClass('list-active');
    });
    
}());