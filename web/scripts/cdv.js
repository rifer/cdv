'use strict';
$(document).ready(function(){
    setTimeout(function(){
        $('.hr-image.animated').addClass('bounceInDown').removeClass('hide');          
    },500);

	var sticky = new Waypoint.Sticky({
	  element: $('.main-nav')[0]
	})

});