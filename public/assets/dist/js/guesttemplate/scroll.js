function iefmoove() {
	$("body").addClass("iemoove");
}


function picresize(ipicframe) {
	ww = $(ipicframe).width();
	wh = $(ipicframe).height();

	//lastOffset = wh + 2150;

	/*	picw = $(ipic).width();
		pich = $(ipic).height();*/

	/*	bodyh = wh + 2150;
		$("#framesBlock").height(bodyh);
		*/
	if (ww / wh < 1.5) {
		var scale = wh / 1280;
	}
	else {
		var scale = ww / 1920;
	};
	$("#ingredients").attr({ "style": "-moz-transform:scale(" + scale + ");-webkit-transform:scale(" + scale + ");-o-transform:scale(" + scale + ");-ms-transform:scale(" + scale + ");transform:scale(" + scale + ");" });

	/*	if((pich<=wh)&&(picw>=ww)){
			$(".picposition").addClass("picsize");
		}
		else{
			$(".picposition").removeClass("picsize");		
		};*/

	/*	picw = -$(ipic).width()/2;
		pich = -$(ipic).height()/2;
		$(".picposition").css({"margin":pich+"px 0 0 "+picw+"px"});*/

	/*	frameh = $("#framesBlock").height();
		
		lastOffset = frameh - wh;
	
		$(".bullets>li").removeClass("current");*/

}

function fmoove() {

	first = true;
	flagtop = true;
	flagbottom = true;
	finish = true;

	bullets = $(".bullets");

	is_touch_device = 'ontouchstart' in document.documentElement;

	var cont = $("#container");
	var frames = $("#frames");
	var gotop = $("#gotop");

	//	wh = $("#frames").height();	
	//frameh = $("#container").height();	
	//	lastOffset = wh + 2150;

	pichash = 1;

	skrollr.init({
		render: function (data) {

			//			wh = $("#frames").height();	
			//			frameh = $("#container").height();
			//			lastOffset = wh + 2150;


			if (first) {
				this.setScrollTop(0);
				first = false;

			};

			thistop = this.getScrollTop();

			//			$("#logo").text("lastOffset="+lastOffset+"   thistop="+thistop);


			pic = $(frames).css("text-indent");
			if (pichash != pic) {
				pichash = pic;
				$(frames).css({ "background-image": "url(../bitrix/templates/cava/images/frames/frame" + pic + ".jpg)" });
			};

			if (thistop < 1400) {
				$(cont).removeClass("show2pic");
			}
			else {
				$(cont).addClass("show2pic");
			};


			if (thistop < 30) {
				$("body").addClass("framestart");
			}
			else {
				$("body").removeClass("framestart");
			};

			$(".bullets>li").removeClass("current");

			mooveblock = this;

			if (is_touch_device) {
				$("#moovebtn").bind('touchstart', function () {
					mooveblock.animateTo(2150, { easing: 'sqrt', duration: 4000, done: function () { } });
				});
				$("#gotop").bind('touchstart', function () {
					mooveblock.animateTo(0, { easing: 'swing', duration: 4000, done: function () { } });
				});
			}
			else {
				$("#moovebtn").click(function () {
					mooveblock.animateTo(2150, { easing: 'sqrt', duration: 3500, done: function () { } });
				});
				$("#gotop").click(function () {
					mooveblock.animateTo(0, { easing: 'swing', duration: 3500, done: function () { } });
				});
			};




			if (thistop >= 2145) {
				$(bullets).addClass("bullshow");
			}
			else {
				$(bullets).removeClass("bullshow");
			};

			if (thistop >= 2150) {
				if (finish) {
					finish = false;
					$("body").addClass("scrfinish");
					setTimeout("finish = true,$('body').removeClass('scrfinish');", 300);
				};
			};


		}
	});

}

(function ($) {
	var cache = [];
	$.preLoadImages = function () {
		var args_len = arguments.length;
		for (var i = args_len; i--;) {
			var cacheImage = document.createElement('img');
			cacheImage.src = arguments[i];
			cache.push(cacheImage);
		}
	}
})(jQuery);

$(document).ready(function () {

	$("nav a").bind('touchstart', function () {
		document.location.href = $(this).attr("href");
	});

	ipicframe = $("#frames");
	picresize(ipicframe);
	$(window).resize(function () {
		picresize(ipicframe);
	});


	$(".bullets>li").click(function () {
		$(".bullets>li").removeClass("current");
		$(this).addClass("current");
	});

	$(".bullets>li").bind('touchstart', function () {
		$(".bullets>li").removeClass("current");
		$(this).addClass("current");
	});

	$("#scale").click(function () {
		$(".bullets>li").removeClass("current");
	});
	$("#scale").bind('touchstart mousedown', function () {
		$(".bullets>li").removeClass("current");
	});

	is_touch_device = 'ontouchstart' in document.documentElement;

	if (is_touch_device) {
		$("body").addClass("istouch");
	};




	$.preLoadImages(
		"bitrix/templates/cava/images/frames/frame1px.jpg",
		"bitrix/templates/cava/images/frames/frame2px.jpg",
		"bitrix/templates/cava/images/frames/frame3px.jpg",
		"bitrix/templates/cava/images/frames/frame4px.jpg",
		"bitrix/templates/cava/images/frames/frame5px.jpg",
		"bitrix/templates/cava/images/frames/frame6px.jpg",
		"bitrix/templates/cava/images/frames/frame7px.jpg",
		"bitrix/templates/cava/images/frames/frame8px.jpg",
		"bitrix/templates/cava/images/frames/frame9px.jpg",
		"bitrix/templates/cava/images/frames/frame10px.jpg",
		"bitrix/templates/cava/images/frames/frame11px.jpg",
		"bitrix/templates/cava/images/frames/frame12px.jpg",
		"bitrix/templates/cava/images/frames/frame13px.jpg",
		"bitrix/templates/cava/images/frames/frame14px.jpg",
		"bitrix/templates/cava/images/frames/frame15px.jpg",
		"bitrix/templates/cava/images/frames/frame16px.jpg",
		"bitrix/templates/cava/images/frames/frame17px.jpg",
		"bitrix/templates/cava/images/frames/frame18px.jpg",
		"bitrix/templates/cava/images/frames/frame19px.jpg",
		"bitrix/templates/cava/images/frames/frame20px.jpg",
		"bitrix/templates/cava/images/frames/frame21px.jpg",
		"bitrix/templates/cava/images/frames/frame22px.jpg",
		"bitrix/templates/cava/images/frames/frame23px.jpg",
		"bitrix/templates/cava/images/frames/frame24px.jpg",
		"bitrix/templates/cava/images/frames/frame25px.jpg",
		"bitrix/templates/cava/images/frames/frame26px.jpg",
		"bitrix/templates/cava/images/frames/frame27px.jpg",
		"bitrix/templates/cava/images/frames/frame28px.jpg",
		"bitrix/templates/cava/images/frames/frame29px.jpg",
		"bitrix/templates/cava/images/frames/frame30px.jpg",
		"bitrix/templates/cava/images/frames/frame31px.jpg",
		"bitrix/templates/cava/images/frames/frame32px.jpg",
		"bitrix/templates/cava/images/frames/frame33px.jpg",
		"bitrix/templates/cava/images/frames/frame34px.jpg",
		"bitrix/templates/cava/images/frames/frame35px.jpg",
		"bitrix/templates/cava/images/frames/frame36px.jpg",
		"bitrix/templates/cava/images/frames/frame37px.jpg",
		"bitrix/templates/cava/images/frames/frame38px.jpg",
		"bitrix/templates/cava/images/frames/frame39px.jpg",
		"bitrix/templates/cava/images/frames/frame40px.jpg",
		"bitrix/templates/cava/images/frames/frame41px.jpg",
		"bitrix/templates/cava/images/frames/frame42px.jpg",
		"bitrix/templates/cava/images/frames/frame43px.jpg",
		"bitrix/templates/cava/images/frames/frame44px.jpg",
		"bitrix/templates/cava/images/frames/frame45px.jpg",
		"bitrix/templates/cava/images/frames/frame46px.jpg",
		"bitrix/templates/cava/images/frames/frame47px.jpg",
		"bitrix/templates/cava/images/frames/frame48px.jpg",
		"bitrix/templates/cava/images/frames/frame49px.jpg",
		"bitrix/templates/cava/images/frames/frame50px.jpg",
		"bitrix/templates/cava/images/frames/frame51px.jpg",
		"bitrix/templates/cava/images/frames/frame52px.jpg",
		"bitrix/templates/cava/images/frames/frame53px.jpg",
		"bitrix/templates/cava/images/frames/frame54px.jpg",
		"bitrix/templates/cava/images/frames/frame55px.jpg"
	);



});