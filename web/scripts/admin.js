"use strict";$("ul.nav-tabs li a").on("click",function(){var a=$(this).parents(".admin-form").data("place");$("."+a+" ul.nav-tabs li ").removeClass("active"),$(this).parent("li").addClass("active");var e=$(this).data("target");$("."+a+" .tab-pane").removeClass("active"),$("."+a).find(e).addClass("active")}),$(".wrapper-dropdown").on("click",function(a){$(this).toggleClass("active"),a.stopPropagation()}),$("#appbundle_document_file").on("change",function(){var a=this.value.match(/\.([^\.]+)$/)[1];switch(a){case"pdf":$(".file-error").addClass("hide");break;default:$(".file-error").removeClass("hide"),this.value=""}});