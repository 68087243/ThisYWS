 $("#favid,#add_favid").live('click',function() { 
	var ctrl = (navigator.userAgent.toLowerCase()).indexOf('mac') != -1 ? 'Command/Cmd' : 'CTRL'; 
	if (document.all && window.external){ 
	  window.external.addFavorite(game_url,game_title); 
	  }else if (window.sidebar){ 
	 window.sidebar.addPanel(game_title,game_url, ""); 
   }else { 
		   alert('您可以尝试通过快捷键' + ctrl + ' + D 加入到收藏夹!'); 
   } 
});


function tracking(e)
{
  e=e?e:window.event;
  var s=e.srcElement?e.srcElement:e.target;
  var a=s.tagName;
  var u=s.href;
  var t=s.innerText?s.innerText:s.textContent;
  if(a=='B' || a=='STRONG'){a='A';u=parentNode.href;}
  if(a=='IMG'){t=u;u=s.parentNode.href;}
  if(a=='A' || a=='IMG'){
    try{
        new Image().src = "http://trace2144.2144.cn/trace.js?addd="+a+"&uddd="+escape(u)+"&tddd="+t;
    }catch(ex){}
  }
  return true;
}

function clickImgs(tit_id,box_id,cur){
		var g_tags=$(tit_id),
		g_conts=$(box_id),
		g_current=cur;
		g_tags.click(function(){
		var g_index=g_tags.index(this),
		g_this=g_conts.eq(g_index);
		$(this).addClass(g_current).siblings().removeClass(g_current);
		g_this.show().siblings().hide();
		if(!g_index||g_this.attr('varwrods')) return;
		//alert("b");
		g_this.html(htmlencode(g_this.find('textarea').html())).attr('varwrods',false);
		});
	}


function lazyload(option){
				var settings={
				  defObj:null,
				  defHeight:0
				};
				settings=$.extend(settings,option||{});
				var defHeight=settings.defHeight,
					defObj=(typeof settings.defObj=="object")?settings.defObj.find("img"):$(settings.defObj).find("img");
				var pageTop=function(){
				  return document.documentElement.clientHeight+Math.max(document.documentElement.scrollTop,document.body.scrollTop)-settings.defHeight;
				};
				var imgLoad=function(){
				  defObj.each(function(){               
				   if ($(this).offset().top<=pageTop()){
					var src2=$(this).attr("a");
					if (src2){
						 $(this).attr("src",src2).removeAttr("a");
					}
				   }
				  });
				};
				imgLoad();
				$(window).bind("scroll", function(){
					imgLoad();
				});

}



function hotKeys() {
        var ua = navigator.userAgent.toLowerCase();
        var str = '';
        var isWebkit = (ua.indexOf('webkit') != - 1);
        var isMac = (ua.indexOf('mac') != - 1);
        var isIEmac = false;

        if (ua.indexOf('konqueror') != - 1) {
            str = 'CTRL + B';
        } else if (window.home || isWebkit || isIEmac || isMac) {
            str = (isMac ? 'Command/Cmd' : 'CTRL') + ' + D';
        }
        return ((str) ? '您可以尝试通过快捷键 ' + str + ' 加入到收藏夹!' : str);
    }

function addBookmark(title,url)
{
  if (document.all && window.external){
    window.external.addFavorite(url,title);
  }else if (window.sidebar){
    window.sidebar.addPanel(title,url, "");
  }else {
    alert(hotKeys());
  }
}

function clickAddFavorite(className,title,url){
  $(className).click(function(){
    addBookmark(title,url);
  });
}

function getDomain()
{
  var domain=document.domain;
  var from=domain.indexOf('.');
  domain=domain.substring(from,domain.length);
  domain=domain.toLowerCase();
  return domain;
}

var Site=new Object();
Site.Cookie={
  _expires:24*3600*99999,
  _domain:getDomain(),
  set:function(name,value,expires,path,domain){
    expires=new Date(new Date().getTime()+(expires?expires:this._expires));
    document.cookie=name+"="+escape(value)+"; expires="+expires.toGMTString()+"; path="+(path?path:"/")+"; domain="+(domain?domain:this._domain);
  },
  get:function(name){
    var arr=document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
    if(arr!=null) return unescape(arr[2]);
    return null;
  },
  clear:function(name,path,domain){
    if(this.get(name)) document.cookie=name+"=; path="+(path?path:"/")+"; domain="+(domain?domain:this._domain)+"; expires=Fri, 02-Jan-1970 00:00:00 GMT";
  }
};


var islogin=Site.Cookie.get('user_auth');

function gb_fav(){
    var url =location.href;
    var sitename =document.title;
    addBookmark(sitename,url);
    return false;
}

$("#fav_addid").live('click',function(){
  gb_fav();
});

/*copy btn*/
var gy={};
(function(){
  var env={};
  gy.scriptLoad =function(url,func){
    var callback=func||function(){};
    if(env[url]){
      if(env[url]['status'] ==4){       
        callback();
      }else{
        env[url].fn.push(callback);
      }     
      return;
    }
    var script=document.createElement('script'),READY_STATE = script.readyState;
    script.setAttribute("type" ,"text/javascript");
    env[url]={fn:[],"status":1};
    env[url].fn.push(callback);
    if(READY_STATE){
      script.onreadystatechange = function () {
        var rs = script.readyState;
        if (rs === 'loaded' || rs === 'complete') {
          script.onreadystatechange = null;
          env[url].status=4;
          for(var i=0,len=env[url].fn.length;i<len;i++){
            env[url].fn.shift()();
          }
          env[url].fn=undefined;
        }
      };
    }else{
      script.addEventListener('load', function(){
        env[url].status=4;
        for(var i=0,len=env[url].fn.length;i<len;i++){
          env[url].fn.shift()();
        }
        env[url].fn=undefined;
      }, false);
    }
    script.src = url;
    document.getElementsByTagName("head")[0].appendChild(script);
  }
})();

function copyToClipBoard(id){
    var vfont='复制成功,您可以发送给你的好友啦!',doc=document,gamelink=doc.title+doc.location.href;
    if(document.all){
        $('#share_id').bind('click',function(){
            window.clipboardData.setData("Text",gamelink);
            alert(vfont);
        })
        
    }else{
        gy.scriptLoad('http://'+self.location.host+'/js/ZeroClipboard.js',function(){
                new ZeroClipboard.Client();
                clip = new ZeroClipboard.Client();
                clip.setHandCursor( true );
                clip.setText(gamelink);
                clip.addEventListener('complete', function (client, text) {
                    alert(vfont);
                });
                clip.glue('share_id');
        })
    }
}

$('#form1').submit(function(){
    if($('input[name="keyword"]').val().length==0 || $('input[name="keyword"]').val()=='请输入关键字')
    {
       $('input[name="keyword"]').val('请输入关键字');
       return false;
    }
});
$('input[name="keyword"]').focusin(function(){
   if(this.value=='请输入关键字')
   {
      this.value='';
   }
});
$('input[name="keyword"]').focusout(function(){
   if(this.value.length==0)
   {
     this.value='请输入关键字';
   }
});

if($('input[name="keyword"]').length>0)
{
   $('input[name="keyword"]').val('请输入关键字');
}
/*-----------------------------*/
/*-----------------------------*/
var timer=null;
$(window).bind("scroll", function(){
    if(timer){
    timer=null;
    clearTimeout(timer);
    }
    if(typeof scroll_fn=='function')
    {
     timer=setTimeout(scroll_fn,200);
    }
});

function scroll_eixt(scroll_handle){
  var wraps=$(scroll_handle);
  if(wraps.length>0)
  {
    var offset=wraps.offset(),
        doc_top=$(document).scrollTop(),
        win_h=$(window).height();
    if(doc_top+win_h>offset.top){
      if(!wraps.attr('scr_vale')){
        wraps.html(htmlencode(wraps.find('textarea').html())).attr('scr_vale',1);
      }
    }
  }
}
function scroll_act_comment(){
  var gid=arguments[0]?arguments[0]:0;
  var wraps=$("#commentdiv"),
      offset=wraps.offset(),
      doc_top=$(document).scrollTop(),
      win_h=$(window).height(); 
  if(doc_top+win_h>offset.top){
    if(!wraps.attr('v')){
      wraps.attr('v',1);
      $.ajax({
        type: 'GET',
        url: 'http://app.2144.cn/images/comment.act.js',
        success: function() {
            comment=new comment(gid,commentId);comment.init();
        },
        dataType: 'script',
        scriptCharset: 'utf-8'
        });
    }
  }
}



    function scroll_new_comment()
    {
    var comments_tit = $("#comments_tit");
    if(comments_tit.length > 0){
      var gid=arguments[0]?arguments[0]:0;
      var wraps=comments_tit,
          offset=wraps.offset(),
          doc_top=$(document).scrollTop(),
          win_h=$(window).height();
      if(doc_top+win_h>offset.top){
        if(!wraps.attr('v')){
          wraps.attr('v',1);
          $.ajax({
            type: 'GET',
            url: 'http://static.2144.cn/app/assets/ncomment/n5/js/comments.min.js',
            success: function() {
                $.fn.GyComment({gid:gid,cat_id:commentId,app_id:commentId,page:1,obj_name:game_title,obj_url:game_url});
            },
            dataType: 'script',
            scriptCharset: 'utf-8'
            });
        }
      }
  }
}

    function scroll_game_comment()
    {
    var comments_tit = $("#comments_tit");
    if(comments_tit.length > 0){
      var gid=arguments[0]?arguments[0]:0;
      var wraps=comments_tit,
          offset=wraps.offset(),
          doc_top=$(document).scrollTop(),
          win_h=$(window).height();
      if(doc_top+win_h>offset.top){
        if(!wraps.attr('v')){
          wraps.attr('v',1);
          $.ajax({
            type: 'GET',
            url: 'http://static.2144.cn/app/assets/ncomment/n5/js/comments.min.js',
            success: function() {
                $.fn.GyComment({gid:gid,cat_id:1,app_id:1,page:1,obj_name:game_title,obj_url:game_url});
            },
            dataType: 'script',
            scriptCharset: 'utf-8'
            });
        }
      }
    }
}

function htmlencode(str) {
 str = str.replace(/&lt;/gi, '<');
 str = str.replace(/&gt;/gi, '>');
 return str;
}
$(document).ready(function(){
  $(".speakher").append(",也可以通过<a href=' http://www.baidu.com/s?wd=T3T2&rsv_bp=0&inputT=1094' target='_blank'>百度</a>T3T2");
});

(function($){
  $.fn.placeholder = function(){
  var searchText = this,
    searchValue = searchText.attr('placeholder');
  if ( !( 'placeholder' in document.createElement('input') ) ){
  searchText.removeAttr('placeholder').val(searchValue).bind('focus',function(){
  if ( this.value==searchValue) {this.value=''; };
  }).bind('blur',function(){
  if ( this.value=='' ){ this.value=searchValue; };
  });
  }else{
  searchText.bind('focus',function(){
  if ( jQuery(this).attr('placeholder') == searchValue ){ jQuery(this).attr('placeholder','') };
  }).bind('blur',function(){
  if ( jQuery(this).attr('placeholder','') ){ jQuery(this).attr('placeholder',searchValue) };
  });
  }
  }
})(jQuery);
$('#smart_input').placeholder();//placeholder句柄

//new header 
function hd_Pop(){
  $("#all_a").mouseover(function(){
    $("#hd_pop").show();
  });
  $("#hd_pop").mouseover(function(){
    $("#hd_pop").show();
  });
  $("#all_a").mouseout(function(){
    $("#hd_pop").hide();
  });
  $("#hd_pop").mouseout(function(){
    $("#hd_pop").hide();
  });
}
hd_Pop();
