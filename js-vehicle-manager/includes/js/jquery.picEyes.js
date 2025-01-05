/*
* jQuery picPlay plugin
* @name jquery-picEyes-1.0.js
* @author xiaoyan - frbao
* @version 1.0
* @date Jan 14, 2016
* @category jQuery plugin
* @github https://github.com/xiaoyan0552/jquery.picEyes
*/
(function($){
	$.fn.picEyes = function(defaultdata){
		var $obj = this;
		var num,zg = $obj.length - 1;
		var win_w = $(window).width();
		var win_h = $(window).height();
		var eyeHtml = '<div class="jsvm_picshade"></div>'
			+'<a title="Close" alt="Close" class="jsvm_pictures_eyes_close" href="javascript:;"></a>'
			+'<div class="jsvm_pictures_eyes">'
			+'<div class="jsvm_pictures_eyes_in">'
			+'<img alt="Vehicle Image" title="Vehicle Image" src="" class="jsvm_mainimage" />'
			+'<div class="jsvm_next"></div>'
			+'<div class="jsvm_prev"></div>'
			+'<div class="jsvm_cm_vehicle_detail">'
			+'<span class="jsvm_mileage"><img alt="Mileages Icon" title="Mileages" src="'+defaultdata.fuelgage+'" /><span class="jsvm_value"></span></span>'
			+'<span class="jsvm_transmission"><img alt="Transmission Icon" title="Transmission" src="'+defaultdata.transmission+'" /><span class="jsvm_value"></span></span>'
			+'<span class="jsvm_fueltype"><img alt="Fuel Icon" title="Fuel" src="'+defaultdata.fueltype+'" /><span class="jsvm_value"></span></span>'
			+'<span class="jsvm_cm_vlb_price"><h5><span class="jsvm_value"></span></h5></span>'
			+'</div>'
			+'</div>'
			+'</div>'
			+'<div class="jsvm_pictures_eyes_indicators"></div>';
		$('body').append(eyeHtml);
		$obj.click(function() {
			$(".jsvm_picshade").css("height", win_h);
			num = $obj.index(this);
			assignData($(this));
			popwin($('.jsvm_pictures_eyes'));
		});
		function assignData($object){
			var fueltype = $($object).find("img.jsvm_mainimage").attr('data-fuel');
			var transmission = $($object).find("img.jsvm_mainimage").attr('data-transmission');
			var mileage = $($object).find("img.jsvm_mainimage").attr('data-mileage');
			var price = $($object).find("img.jsvm_mainimage").attr('data-price');
			var n = $($object).find("img.jsvm_mainimage").attr('data-src-main');
			$(".jsvm_pictures_eyes img.jsvm_mainimage").attr("src", n);			
			$(".jsvm_pictures_eyes .jsvm_cm_vehicle_detail").find('span.jsvm_mileage span.jsvm_value').html(mileage);
			$(".jsvm_pictures_eyes .jsvm_cm_vehicle_detail").find('span.jsvm_transmission span.jsvm_value').html(transmission);
			$(".jsvm_pictures_eyes .jsvm_cm_vehicle_detail").find('span.jsvm_fueltype span.jsvm_value').html(fueltype);
			$(".jsvm_pictures_eyes .jsvm_cm_vehicle_detail").find('span.jsvm_cm_vlb_price span.jsvm_value').html(price);
		}
		$(".jsvm_pictures_eyes_close,.jsvm_picshade,.jsvm_pictures_eyes").click(function() {
			$(".jsvm_picshade,.jsvm_pictures_eyes,.jsvm_pictures_eyes_close,.jsvm_pictures_eyes_indicators").fadeOut('slow', function(){
				$(".jsvm_picshade,.jsvm_pictures_eyes,.jsvm_pictures_eyes_close,.jsvm_pictures_eyes_indicators").remove();
			});			
			$('body').css({'overflow':'auto'});
		});
		$('.jsvm_pictures_eyes img').click(function(e){
			stopPropagation(e);
		});


		$(".jsvm_next").click(function(e){
			if(num < zg){
				num++;
			}else{
				num = 0;
			}
			assignData($obj.eq(num));
			stopPropagation(e);
			popwin($('.jsvm_pictures_eyes'));
		});
		$(".jsvm_prev").click(function(e){
			if(num > 0){
				num--;
			}else{
				num = zg;
			}
			assignData($obj.eq(num));
			stopPropagation(e);
			popwin($('.jsvm_pictures_eyes'));
		});


		function popwin(obj){
			$('body').css({'overflow':'hidden'});
			var Pwidth = obj.width();			
			var Pheight = obj.height();
			obj.show();
			$('.jsvm_picshade,.jsvm_pictures_eyes_close').fadeIn();
			indicatorsList();
		}
		function updatePlace(obj){
			var Pwidth = obj.width();
			var Pheight = obj.height();
		}
		function indicatorsList(){
			var indHtml = '';
			$('.jsvm_pictures_eyes_indicators').html(indHtml);
			$obj.each(function(){				
				var img = $(this).find('img').attr('data-src');
				var mainimg = $(this).find('img').attr('data-src-main');
				var fueltype = $(this).find('img').attr('data-fuel');
				var transmission = $(this).find('img').attr('data-transmission');
				var mileage = $(this).find('img').attr('data-mileage');
				var price = $(this).find('img').attr('data-price');
				indHtml +='<a title="Vehicle Image" href="javascript:;"><img alt="Vehicle Image" title="Vehicle Image" class="jsvm_mainimage" src="'+img+'" data-src-main="'+mainimg+'" data-src="'+mainimg+'" data-price="'+price+'" data-fuel="'+fueltype+'" data-transmission="'+transmission+'" data-mileage="'+mileage+'"/></a>';
			});
			$('.jsvm_pictures_eyes_indicators').html(indHtml).fadeIn();
			$('.jsvm_pictures_eyes_indicators').find('a').eq(num).addClass('jsvm_current').siblings().removeClass('jsvm_current');
			$('.jsvm_pictures_eyes_indicators a').click(function(){
				$(this).addClass('jsvm_current').siblings().removeClass('jsvm_current');
				assignData($(this));
				updatePlace($('.jsvm_pictures_eyes'));
			});
		}
		function stopPropagation(e) {
			e = e || window.event;  
			if(e.stopPropagation) {
				e.stopPropagation();  
			} else {  
				e.cancelBubble = true;
			}  
		}
	}
})(jQuery);
jQuery(document).ready(function($){
	$(document).keydown(function (e) {
		if(jQuery('div.jsvm_pictures_eyes:visible')){
			var keyCode = e.keyCode || e.which;
			var key = {left: 37, up: 38, right: 39, down: 40, esc: 27 };
			switch (keyCode) {
				case key.left:
					$(".jsvm_prev").click();
				break;
				case key.up:
					$(".jsvm_prev").click();
				break;
				case key.right:
					$(".jsvm_next").click();
				break;
				case key.down:
					$(".jsvm_next").click();
				break;
				case key.esc:
					$('div.jsvm_picshade').click();
				break;
			}
		}
	});
});
