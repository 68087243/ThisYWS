var hovtabs = function(t, i, a) {
	var n = $(t),
		s = $(i),
		o = a;
	n.live("mouseover",
		function() {
			var t = n.index(this);
			$(this).addClass(o).siblings().removeClass(o);
			s.eq(t).animate({
					opacity: "show"
				},
				500,
				function() {
					$(this).show()
				}).siblings().hide()
		})
};
hovtabs("#txtnav>span", "#txtcon>ul", "cur");
var renTabs = function() {
	$(document).delegate("#ren_nav span", "mouseover",
		function() {
			var t = $(this).index(),
				i = $("#ren_con>div").eq(t);
			$(this).addClass("cur").siblings().removeClass("cur");
			i.find("div:first").stop().animate({
				right: "0",
				opacity: "1"
			});
			i.find("div:last").stop().animate({
				right: "386"
			});
			i.siblings().find("div:first").stop().animate({
				right: "0",
				opacity: "0"
			});
			i.siblings().find("div:last").stop().animate({
				right: "860"
			})
		})
};
renTabs();
var dataDrop = function() {
	$(document).delegate("#databox li", "mouseover",
		function() {
			$(this).find(".dt_drop").stop().animate({
				top: "0"
			})
		}).delegate("#databox li", "mouseout",
		function() {
			$(this).find(".dt_drop").stop().animate({
				top: "-318"
			})
		})
};
dataDrop();