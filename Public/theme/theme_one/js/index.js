function clicktabs(tit_id,box_id,cur){
	var g_tags=$(tit_id),
		g_conts=$(box_id),
		g_current=cur;
	g_tags.live('mouseover',function(){
		var g_index=g_tags.index(this);
		$(this).addClass(g_current).siblings().removeClass(g_current);
		g_conts.eq(g_index).show().siblings().hide();
	})
}
clicktabs(".news_nav>span",".news_con>ul","cur");
clicktabs("#rw_tit>a","#rw_con>div","cur");
clicktabs(".rw_nav>span",".tu_box>div","cur");
clicktabs("#server_nav>span","#server_con>ul","cur");