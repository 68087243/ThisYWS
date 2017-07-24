$(".go_span").click(function(e){
	var obj=$(this);
	//obj.attr('id') 
	//obj.attr("class","go_span2");
	//obj.html('已领取');
	var _arr=obj.attr('id').split('_');
	$.getJSON(U('User/Vip/task','tid='+_arr[1]+'&callback=?'),function(data){
                if(data.code==1)
                {
					obj.html('已领取');
					obj.attr("class","go_span2");
                    var percent = (parseInt(data["scoreInfo"]["score"]) - parseInt(data["scoreInfo"]["min"]))*100/(parseInt(data["scoreInfo"]["max"]) - parseInt(data["scoreInfo"]["min"]));
                    var title = "我的等级：VIP"+data["scoreInfo"]["level"]+"&nbsp;&nbsp;;&nbsp;&nbsp;成长值："+data["scoreInfo"]["score"];
					$('.p-jfwrap').replaceWith('<div class="p-jfwrap"><div class="p-slidetop">我的等级：<span>'+data["scoreInfo"]["levelName"]+'</span>我的成长值：<span>'+data["scoreInfo"]["score"]+'</span></div><div class="p-slides"><span class="p-islide" style="width:'+percent+'%" title = "'+title+'"></span></div><div class="p-slidel"><span>LV'+(parseInt(data["scoreInfo"]["level"]) + 1)+' ('+data["scoreInfo"]["max"]+')</span>LV'+data["scoreInfo"]["level"]+' ('+data["scoreInfo"]["min"]+')</div></div>');
					
                }else{
					return;
				}
    });
});