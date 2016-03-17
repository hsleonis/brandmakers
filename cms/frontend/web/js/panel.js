$(document).ready(function() {
   /* $('.nav-button').on('click', function() {
        rightbarHide();
        $('#main-menu').addClass('show');
    });*/
    $('#main-menu li').on('click', function() {
        $('#second').addClass('show');
    });
    $('#second').on('click', function() {
        $('#detail').addClass('show');
    });
    $('.done').on('click', function() {
        $('#detail').removeClass('show');
    });
    var subbar = function() {
        return $('#main-menu').removeClass('show');
    };
    var third = function() {
        return $('#second').removeClass('show');
    };
    var detail = function() {
        return $('#detail').removeClass('show');
    };
    var delay = 300;
    var leftbar = function() {
        if ($('#main-menu').hasClass('show')) {
            leftbarHide();
        } else {
            $('#main-menu').addClass('show');
        }
    };

    var leftbarHide = function() {
        $.when().then(function() {
            detail();
            setTimeout(function() {
                third();
            }, delay);
            setTimeout(function() {
                detail();
                third();
                subbar();
            }, delay * 2);
        });
    };

    var rightbarHide = function() {
        if ($('#right-nav-element').hasClass('show-alter')) {
			$('#project-details').removeClass('show-alter');
			setTimeout(function() {
				$('#right-nav-element').removeClass('show-alter');
            }, delay);
        }
    };

    var rightbar = function() {
        if ($('#right-nav-element').hasClass('show-alter')) {
            $('#right-nav-element').removeClass('show-alter');
        } else {
            $('#right-nav-element').addClass('show-alter');
        }
    };

    $('.nav-button').on('click', function() {
        rightbarHide();
        leftbar();
    });

    $('.bottom_slider').on('click', function() {
        leftbarHide();
        rightbarHide();
    });

    $('#right-nav').on('click', function() {
        if ($('#main-menu').hasClass('show')) {
            leftbarHide();
        }
        rightbar();
    });
	
	$('#right-nav-element li').on('click',function(){
		$('#project-details').addClass('show-alter');
	});
});