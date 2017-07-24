function clicktabs(tit_id,box_id,cur){
	var g_tags=$(tit_id),
		g_conts=$(box_id),
		g_current=cur;
	g_tags.live('mouseover',function(){
		var g_index=g_tags.index(this);
		$(this).addClass(g_current).siblings().removeClass(g_current);
		g_conts.eq(g_index).show().siblings().hide();
	})
};
clicktabs(".news_nav>span",".news_con>ul","cur");
clicktabs(".rw_nav>span",".rw_con>div","cur");
clicktabs(".server_nav>span",".server_wrap>ul","cur");


$("#ser_con a:even").css("background-color","#3b4040");

$("#ser_con a:even").hover(function(){

		$(this).css("background-color","#222222");

	},

	function(){

		$(this).css("background-color","#3b4040");

	}

);

$('.data_ul ').delegate('li','mouseover',function(){
	$(this).children('i').stop().animate({'height':"0"},200);
});


$('.data_ul').delegate('li','mouseleave',function(){
	$(this).children('i').stop().animate({'height':"225px"},200);
});