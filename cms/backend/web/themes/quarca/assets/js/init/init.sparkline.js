"use strict";
$(document).ready(function() {
/*******************************
SPARKLINES
*******************************/
    $("#demo5").sparkline([5,6,7,9,9,5,3,2,2,4,6,7], {
	type: 'line',
	width: '200',
	height: '80',
	lineColor: '#83bf17',
	fillColor: '#dcefb8',
	lineWidth: 2,
	spotColor: '#F15D58',
	minSpotColor: '#F15D58',
	maxSpotColor: '#F15D58',
	highlightSpotColor: '#83bf17',
	highlightLineColor: '#F15D58',
	spotRadius: 5
    });
    
    $("#demo6").sparkline([5,6,7,2,0,-4,-2,4], {
	type: 'bar',
	height: '50',
	barWidth: 8,
	barSpacing: 6,
	barColor: '#83bf17',
	negBarColor: '#f15d58',
	zeroColor: '#83bf17'
    });
    
    $("#demo7").sparkline([1,1,0,1,-1,-1,1,-1,0,0,1,1], {
	type: 'tristate',
	posBarColor: '#83bf17',
	negBarColor: '#f15d58',
	zeroBarColor: '#A68F58',
	barWidth: 8,
	barSpacing: 6
    });
    
    $("#demo8").sparkline([4,6,7,7,4,3,2,1,4,4], {
	type: 'discrete',
	width: '100',
	height: '30',
	lineColor: '#83bf17',
	lineHeight: 'auto'
    });
    
    $("#demo9").sparkline([10,12,12,9,7], {
	type: 'bullet',
	height: '25',
	targetWidth: 4,
	targetColor: '#f15d58',
	performanceColor: '#83bf17',
	rangeColors: ['#9fe028','#92c92c','#79aa1e ']
    });
    
    $("#demo10").sparkline([1,1,1,1], {
	type: 'pie',
	width: '50',
	height: '50',
	sliceColors: ['#F15D58','#A68F58','#83BF17','#DCDDCD'],
	borderWidth: 4,
	borderColor: '#ffffff'
    });
    
});//END