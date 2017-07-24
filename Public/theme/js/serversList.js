$.ajax({
    type: "get",
    async: false,
    url: U('Api/Game/getLastestServers','callback=?&gid='+gid),
    dataType: "jsonp",
    jsonp: "callback",
    success: function(data){
            var length = data.length;
            if(length > 0)
            {
                var maxSid = length;
                var count = Math.ceil(maxSid/100);
                for(var i = count -1;i >= 0 ;i--)
                {
                    var span = '<li';
                    if(i == count -1)
                        span += ' class="cur"';
                    span += '>';
                    span += '<a href="javascript:void(0)" class="btn_btn orange">'+(100*(i+1) + '-' +(i*100+1)+'</a></span>');
                    $(navNode).append(span);
                }

                var j = 0;
				var _server_class="";
				
				if(typeof(server_class)!="undefined"){
				 _server_class=server_class;
				}
                for(var i = count -1;i >= 0; i--)
                {
                    var list = '<ul  class="server_con clearfix d-server_all';
                    if(i != count -1) 
                        list += ' hidden';
                    list += '">';
                    for(var k in data)
                    {
                        var hottrue = (j < 2)?true:false;
                        if(data[k]['sort'] <= (i+1)*100 && data[k]['sort'] >= i*100+1)
                        {
							
                            list += ('<li><a href="'+data[k]['url']+'"  class="btn_btn '+_server_class+'"  id="server_'+data[k]['sort']+'"  ><span>'+data[k]['name']+'</span>');
                            if(hottrue && data[k]['status'] == 1&& data[k]['kstatus'] == 1){
								if(typeof(server_kstatus)!="undefined"){
									list +=server_kstatus.replace('replace','火爆');
								}else{
									list += '火爆';
								}
}
if(data[k]['status'] == 0&& data[k]['kstatus'] == 1){
								if(typeof(server_kstatus)!="undefined"){
									list +=server_kstatus.replace('replace','[维护]');
								}else{
									list += '[维护]';
								}
}
         if(data[k]['kstatus'] == 0){
			 if(typeof(server_kstatus)!="undefined"){
									list +=server_kstatus.replace('replace','[即将开服]');
								}else{
									list += '[即将开服]';
								}
}                       
                        
                            list += '</a></li>';
                        }
                        j++;
                    }
                    list += '</ul>';
                    $(serverListNode).append(list);
                }
            }
        
    }
});

if(latestLimit !='' && latestLimit !=undefined && latestLimit !=null)
{
    $.ajax({
        type: "get",
        async: false,
		url: U('Api/Game/getLastestPlayed','callback=?&gid='+gid),
        dataType: "jsonp",
        jsonp: "callback",
        success: function(data){
			if(data.msg != -1){
            for(var i in data)
            {
			if(isExitsVariable(latestNode_html)){
				var latest ='<li><a href="'+data[i]['url']+'" class="orange"><span>'+data[i]['name']+'</span>火爆</a></li>';
			}else{
				 var latest ='<a href="'+data[i]['url']+'" class="orange">'+data[i]['name']+'</a>';
			}
               
                $(latestNode).append(latest);
            }
			}
        }
    });
}
$(navNode).delegate('li','click',function(){
	var g_tags=$(navNode+'>li'),
	 	g_index=g_tags.index(this);
	$(this).addClass('cur').siblings().removeClass('cur');
	$(serverListNode+'>ul').eq(g_index).show().siblings().hide();
});

function isExitsVariable(variableName) {
    try {
        if (typeof(variableName) == "undefined") {
            //alert("value is undefined"); 
            return false;
        } else {
            //alert("value is true"); 
            return true;
        }
    } catch(e) {}
    return false;
}