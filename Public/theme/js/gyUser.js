function back_show(){
  /*弹出提示*/
	if(!$("#backgray").length){
  		$("body").append('<div id="backgray"></div>');
	}
  var doc=document.documentElement,
  docbody=document.body,
  addbalc=$("#backgray");
  addbalc.show();
  if($.browser.msie && $.browser.version==6){
    addbalc.css({position:'absolute',width:doc.scrollWidth,height:doc.scrollHeight});
  }else{
    addbalc.css({position:'fixed',width:docbody.clientWidth,height:docbody.clientHeight});
  }
   $('html').addClass('adhidden');
}

function back_hide(){
   $("#backgray").hide().css({width:0,height:0});
   $("#lriframe").html('');
   $('html').removeClass('logohidden');
   $('html').removeClass('adhidden');
}

function tips_show(){
	var wraps=$("#tipswrap");
	if($.browser.msie && $.browser.version==6){
		wraps.css({top:$(document).scrollTop()+($(window).height()-wraps.height())/2});
	}else{
		wraps.css({'margin-top':-wraps.height()/2});
	}
}
function tips_hide(){
	$("#tipswrap").remove();
}

/*弹出登录注册框*/
function iframeshow(register){
  $('html').addClass('logohidden');
  if($.browser.msie && $.browser.version==6){
    $("#lriframe").css({top:$(document).scrollTop()+($(window).height()-$("#flowersid").height())/2});
  }
  $("#lriframe").html('<iframe id="frame_login" name="frame_login" src="'+U('Api/User/loginframe','t='+Math.random())+'" width="100%" height="100%" scrolling="no" frameborder="0"></iframe>');
  if(register){
    $("#lriframe iframe").attr('src',$("#lriframe iframe").attr('src')+'?1&reg='+Math.random());
  }
  back_show();
}

function gyPtLogin()
    {
	   var url = U('Api/User/getuser','callback=?');
       $.getJSON(url,function (data){
           if(data.isGuest==0)
           {
              callback(data);
           }
       });
}

function login_hide(){
  Login.login();
  back_hide();
}

if(typeof Login == "undefined"){
	var Login = {
		params:{},
		init:function(options){//set params
			$.extend(
				Login.params,options
			)
		},
		login:function(){
			for(key in Login){
				if(typeof Login[key] == "function"&&key != "login"){
					Login[key]();
				}
			}
		}
	}
}

if(typeof Logout == "undefined"){
	var Logout = {
		init:function(options){
			$.extend(
				{},options
			)
		},
		logout:function(){
			for(key in Logout){
				if(typeof Logout[key] == "function"&&key != "logout"){
					Logout[key]();
				}
			}
		},
		doAjaxLogout:function(){
			//var url = ;
    		//$.getJSON(url,function(respon){
            //	$('body').append(respon.script);
          	//});
		}
	}
}
