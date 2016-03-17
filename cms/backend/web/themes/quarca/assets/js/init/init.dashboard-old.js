"use strict";
$(document).ready(function() {
/*******************************
DRAG & DROP
*******************************/
    $('#widgets-container').gridstack({
	width: 4,
	cell_height: 110,
	vertical_margin: 10,
	animate: true,
    });
    
/*******************************
FLOT CHART
*******************************/
    //RANDOM DATA
    function GenerateSeries(added){
	var i = GenerateSeries;
	var data = [];
	var start = 1 + added;
	var end = 10 + added;
    
	for(i=1;i<=20;i++){
	    var d = Math.floor(Math.random() * (end - start + 1) + start);        
	    data.push([i, d]);
	    start++;
	    end++;
	}
    
	return data;
    }
    
    var data1 = GenerateSeries(0);
    var data2 = GenerateSeries(10);
    var data3 = GenerateSeries(40);
    var data4 = GenerateSeries(10);
    var data5 = GenerateSeries(0);
	
/*******************************
TODAY'S SALES
*******************************/
    $.plot($("#line-chart"), [{data: data1}],
	{
	    lines: {
		show: true,
		lineWidth: 1,
		fill: false
	    },
	    points: {
		show: true,
		radius: 5,
	    },
	    shadowSize: 0,
	    grid: {
		clickable: true,
		hoverable: true,
		borderWidth: 1,
		borderColor: "#a3afaf",
		tickColor: "#a3afaf",
	    },
	    colors: ["#fff"],
	    tooltip: true,
	    tooltipOpts: {
		content: "%x hr = %y Delivered"
	    },
	}
    );
	
/*******************************
NEW ORDERS
*******************************/
    $.plot($("#mini-orders"), [{data: data2}],
	{
	    lines: {
		show: true,
		lineWidth: 2,
		fill: true,
		fillColor: "rgba(52, 152, 219, 0.3)",
	    },
	    points: {
		show: true,
		radius: 3,
	    },
	    shadowSize: 0,
	    grid: {
		show: true,
		clickable: true,
		hoverable: true,
		borderWidth: 1,
		borderColor: "rgba(255, 255, 255, 0.2)",
		tickColor: "rgba(255, 255, 255, 0.2)",
	    },
	    colors: ["#3498DB"],
	    tooltip: true,
	    tooltipOpts: {
		content: "%x hr = %y Orders"
	    },
	}
    );
	
/*******************************
REVENUE
*******************************/
    $.plot($("#mini-revenue"), [{data: data3}],
	{
	    lines: {
		show: true,
		lineWidth: 2,
		fill: true,
		fillColor: "rgba(131, 191, 23, 0.2)",
	    },
	    points: {
		show: true,
		radius: 3,
	    },
	    shadowSize: 0,
	    grid: {
		show: true,
		clickable: true,
		hoverable: true,
		borderWidth: 1,
		borderColor: "rgba(255, 255, 255, 0.2)",
		tickColor: "rgba(255, 255, 255, 0.2)",
	    },
	    colors: ["#83bf17"],
	    tooltip: true,
	    tooltipOpts: {
		content: "%x hr = $%y"
	    },
	}
    );
	
/*******************************
IN CART
*******************************/
    $.plot($("#mini-in-cart"), [{data: data4}],
	{
	    lines: {
		show: true,
		lineWidth: 2,
		fill: true,
		fillColor: "rgba(178, 142, 10, 0.3)",
	    },
	    points: {
		show: true,
		radius: 3,
	    },
	    shadowSize: 0,
	    grid: {
		show: true,
		clickable: true,
		hoverable: true,
		borderWidth: 1,
		borderColor: "rgba(255, 255, 255, 0.2)",
		tickColor: "rgba(255, 255, 255, 0.2)",
	    },
	    colors: ["#b28e0a"],
	    tooltip: true,
	    tooltipOpts: {
		content: "%x hr = %y in carts"
	    },
	}
    );
	
/*******************************
CANCELLED
*******************************/
    $.plot($("#mini-cancelled"), [{data: data5}],
	{
	    lines: {
		show: true,
		lineWidth: 2,
		fill: true,
		fillColor: "rgba(150, 40, 27, 0.3)",
	    },
	    points: {
		show: true,
		radius: 3,
	    },
	    shadowSize: 0,
	    grid: {
		show: true,
		clickable: true,
		hoverable: true,
		borderWidth: 1,
		borderColor: "rgba(255, 255, 255, 0.2)",
		tickColor: "rgba(255, 255, 255, 0.2)",
	    },
	    colors: ["#96281B"],
	    tooltip: true,
	    tooltipOpts: {
		content: "%x hr = %y Cancelled"
	    },
	}
    );
	
/*******************************
WEBSITE STATISTICS
*******************************/
    var web1 = [[0,70],[1,80],[2,75],[3,70],[4,78],[5,70],[6,80],[7,75],[8,70],[9,78],[10,70],[11,80],[12,75],[13,70],[14,78]];
    var web2 = [[0,50],[1,60],[2,55],[3,50],[4,58],[5,50],[6,60],[7,55],[8,50],[9,58],[10,50],[11,60],[12,55],[13,50],[14,58]];
    var web3 = [[0,30],[1,40],[2,35],[3,30],[4,38],[5,30],[6,40],[7,35],[8,30],[9,38],[10,30],[11,40],[12,35],[13,30],[14,38]];
    var web4 = [[0,10],[1,20],[2,15],[3,10],[4,18],[5,10],[6,20],[7,15],[8,10],[9,18],[10,10],[11,20],[12,15],[13,10],[14,18]];
    
    var webData = [
	{
	    label: "Visitors",
	    data: web1
	},
	{
	    label: "Unique",
	    data: web2
	},
	{
	    label: "Returning",
	    data: web3
	},
	{
	    label: "Returning",
	    data: web4
	},
    ];
    $.plot($("#website-stats"), webData,
	{
	    bars: {
		show: true,
		lineWidth: 0,
		barWidth: 0.90,
		fillColor: {colors: [ {opacity: 0.2}, {opacity: 0.2} ] }
	    },
	    shadowSize: 0,
	    grid: {
		show: false,
		hoverable: true
	    },
	    legend: {
		show: false,    
	    },
	    colors: ["#22A7F0", "#83bf17", "#e26a6a", "#f1c40f"],
	    tooltip: true,
	    tooltipOpts: {
		content: "%x.1 = %y.4"
	    },
	    
	}
    );
	
/*******************************
SERVER STATUS
*******************************/
    var data = [], totalPoints = 100;
    function getRandomData() {
	
	if (data.length > 0)
	data = data.slice(1);
	
	while (data.length < totalPoints) {
	var prev = data.length > 0 ? data[data.length - 1] : 50;
	var y = prev + Math.random() * 10 - 5;
	if (y < 0)
	    y = 0;
	if (y > 100)
	    y = 100;
	data.push(y);
	}
    
	var res = [];
	for (var i = 0; i < data.length; ++i)
	res.push([i, data[i]])
	return res;
    }
    
    var updateInterval = 500;
    $("#updateInterval").val(updateInterval).change(function () {
    var v = $(this).val();
    if (v && !isNaN(+v)) {
	updateInterval = +v;
	if (updateInterval < 1)
	    updateInterval = 1;
	    if (updateInterval > 2000)
	    updateInterval = 2000;
	    $(this).val("" + updateInterval);
	    }
    });
    
    var options = {
	lines: {
	    show: true,
	    lineWidth: 0,
	    fill: true,
	    fillColor: "rgba(147, 155, 148, 0.3)",
	},
	grid:{
	    borderWidth: 0,
	    tickColor: "#c5ccc7"
	},
	series: {
	    shadowSize: 0,
	},
	yaxis:{
	    min: 0,
	    max: 100
	},
	xaxis:{
	    show: false
	}
    };
    
    var plot = $.plot($("#server-status"), [ getRandomData() ], options);
	
    function update() {
	plot.setData([ getRandomData() ]);
	plot.draw();
	setTimeout(update, updateInterval);
    }
    
    update();
	
/*******************************
SOCIAL STATISTICS
*******************************/
    var piedata = [
	{label: "Twitter Followers", data: 250},
	{label: "Youtube Subscribers", data: 112},
	{label: "Facebook Likes", data: 128},
	{label: "Google+ Followers", data: 98}
    ];
    
    $.plot($("#social-stats"), piedata,
	{
	    series: {
		pie: {
		    show: true,
		    stroke: {width: 1, color: "#fff"},
		    innerRadius: 0.8,
		}
	    },
	    legend: {
		show: true,
	    },
	    colors: ["#63cdf1", "#f16261", "#507cbe", "#DB5952"],
	    grid: {
		hoverable: true
	    },
	    tooltip: true,
	    tooltipOpts: {
		content: "New %s: %p.0%",
	    },
	}
    );
	
/*******************************
SOCIAL STATISTICS CAROUSEL
*******************************/
    var owl = $('#social-carousel');
    owl.owlCarousel({
	loop: true,
	nav: true,
	dots: false,
	margin: 5,
	navText: [
	    "<i class='fa fa-angle-left fa-lg'></i>",
	    "<i class='fa fa-angle-right fa-lg'></i>"
	],
	responsive: {
	    0:{
		items:1
	    },
	    600:{
		items:3
	    },
	    1000:{
		items:3
	    }
	}
    });
    owl.on('mousewheel', '.owl-stage', function (e) {
	if (e.deltaY>0) {
	    owl.trigger('next.owl');
	} else {
	    owl.trigger('prev.owl');
	}
	e.preventDefault();
    });
	
});//END