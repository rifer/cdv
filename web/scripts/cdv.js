'use strict';
$(document).ready(function(){
    setTimeout(function(){
        $('.hr-image.animated').addClass('bounceInDown').removeClass('hide');          
    },500);

    $('.menu-icon').on('click', function(){
    	$('.menu-wrapper').toggleClass('show-menu');
    })

	var sticky = new Waypoint.Sticky({
	  element: $('.main-nav')[0]
	})

});
