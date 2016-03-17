
$(document).ready(function() {
/*******************************
DRAG & DROP
*******************************/
    $('#widgets-container').gridstack({
	width: 4,
	cell_height: 110,
	vertical_margin: 10,
	animate: true,
	handle: '.widget .drag'
    });
    
/*******************************
SCROLL PANEL
*******************************/
    $('.scrollpane').each(function() {
        $(this).jScrollPane({
            autoReinitialise: true
        })
        
        .on('mousewheel',function(e){
            e.preventDefault();
        });
        
        var api = $(this).data('jsp');
        var throttleTimeout;
        $(window).on('resize',function() {
            if (!throttleTimeout) {
                throttleTimeout = setTimeout(function(){
                    api.reinitialise();
                    throttleTimeout = null;
                },
                50
                );
            }
        });
    });

/*******************************
FLOT CHART RANDOM DATA
*******************************/
    function GenerateSeries(added){
	var i = GenerateSeries;
	var data = [];
	var start = 1 + added;
	var end = 100 + added;
    
	for(i=1;i<=20;i++){
	    var d = Math.floor(Math.random() * (end - start + 1) + start);        
	    data.push([i, d]);
	    start++;
	    end++;
	}
    
	return data;
    }
    
/*******************************
MONTHLY STATISTICS
*******************************/
    //TYPOGRAPHY - Fit Text
    jQuery(".widget-monthly-statistics h4").fitText(1.2, { minFontSize: '14px', maxFontSize: '26px' });
    jQuery(".widget-monthly-statistics h5").fitText(1.2, { minFontSize: '16px', maxFontSize: '28px' });

    
    
/*******************************
QUICK ALERTS
*******************************/
    //TYPOGRAPHY - Fit Text
    jQuery(".quick-alerts .fit-text").fitText(0.9, { minFontSize: '10px', maxFontSize: '18px' });
    

});//END