function close_hide() {
    webComObj.backHide()
}
function login_hide() {
    Login.login(),
    webComObj.backHide()
}
if (document.domain = document.domain.split(".").slice(-2).join("."), "undefined" == typeof Login) var Login = {
    params: {},
    init: function(e) {
        $.extend(Login.params, e)
    },
    login: function() {
        for (key in Login)"function" == typeof Login[key] && "login" != key && Login[key]()
    }
};
if ("undefined" == typeof Logout) var Logout = {
    init: function(e) {
        $.extend({},
        e)
    },
    logout: function() {
        for (key in Logout)"function" == typeof Logout[key] && "logout" != key && Logout[key]()
    },
    doAjaxLogout: function() {
        //var e = url;
       // $.getJSON(e,
        //function(e) {
        //    $("body").append(e.script)
        //})
    }
};
var webComObj = webComObj || {};
webComObj.username = "",
webComObj.userInfo = [],
Logout.topBarLogout = function() {
    $("#w-tmyplayId .w-twrapbox").html('<div class="w-pno_tp"><span>请<a href="#" target="_self" id="w-tplog">登录</a>后查看游戏记录</span></div>'),
    $("#w-tmyId").html(""),
    $("#w-favall").html('<a href="#" target="_self" id="w-log">登录</a>|<a href="#" target="_self" id="w-reg">注册</a>|')
},
Login.topBarLogin = function() {
    $("#w-favall").html(""),
    webComObj.topBarLogin(),
    webComObj.isGuest()
},
webComObj.topBarLogin = function() {
    var e = null;
    $("#pop-wrap").length && (e = $("#pop-wrap"), e.html(e.html()))
},
webComObj.backHide = function() {
    $("#backgray").hide().css({
        width: 0,
        height: 0
    }),
    $("#lriframe").html(""),
    $("html").removeClass("logohidden")
},
webComObj.backShow = function() {
    var e = document.documentElement,
    t = document.body,
    a = null;
    $("#backgray").length || $("body").append('<div id="backgray"></div>'),
    a = $("#backgray"),
    a.show(),
    a.css($.browser.msie && 6 == $.browser.version ? {
        width: e.scrollWidth,
        height: e.scrollHeight
    }: {
        width: t.clientWidth,
        height: t.clientHeight
    })
},
webComObj.iframeshow = function(e) {
    var t = null;
    $("html").addClass("logohidden"),
    $("#lriframe").length || $("body").append('<div id="lriframe"></div>'),
    t = $("#lriframe"),
    $.browser.msie && 6 == $.browser.version && t.css({
        top: $(document).scrollTop() + ($(window).height() - t.height()) / 2
    });
    var a = window.location.href,
    n = arguments[1] ? arguments[1] : 0;
    n && (a = a + "&pos=" + n),
    t.html(e ? '<iframe id="frame_login" name="frame_login" src="'+U('Api/User/loginframe')+'#signup" width="100%" height="100%" scrolling="no" frameborder="0"></iframe>': '<iframe id="frame_login" name="frame_login" src="'+U('Api/User/loginframe')+'#login" width="100%" height="100%" scrolling="no" frameborder="0"></iframe>')
},
webComObj.isGuest = function(e) {
    var t = U('Api/User/getuser','callback=?');
    $.getJSON(t,
    function(t) {
		T3T2=t;
        0 == t.isGuest ? (webComObj.username = t.username, e && $("#w-favall").html(""), webComObj.myPlayGames()) : Logout.logout()
    })
},
webComObj.myPlayGames = function() {
    $.ajax({
        type: "POST",
        url: U('Api/User/userplay','callback=?'),
        dataType: "jsonp",
        success: function(e) {
            var t = 0,
            a = "",
            n = $("#w-tmyplayId .w-twrapbox");
            if (e && e.length) {
                for (; t < e.length; t++) a += '<a href="' + e[t].url + '" target="_blank"><span class="w-mpqf">' + e[t].s_name + "</span><span>" + e[t].name + "</span></a>";
                n.html('<div class="w-myplay">' + a + '</div><a href="'+U('User/record/index')+'" class="w-mpmore" target="_blank">查看更多</a>')
            } else n.html('<div class="w-dt_tp"><span>您暂无玩过的游戏，</span><br>不如到<a href="'+U('Game/index/index')+'">游戏中心</a>挑一款</div>');
            webComObj.myInfo()
        },
        error: function() {}
    })
},
webComObj.myInfo = function() {
    $("#w-tmyId").html('<span class="w-twrapbtn">' + webComObj.username + "</span>")
},
webComObj.isGuest(),
$.ajax({
    url: U('Api/Game/whole','callback=?'),
    type: "post",
    async: !1,
    dataType: "json",
    success: function(e) {
        if (e.list) {
            for (var t = e.list.slice(0, 23), a = "", n = 0; n < t.length; n++) a += 1 == t[n].biaozhu ? '<li><a href="' + t[n].redirect_url + '" class="cur" target="_blank">' + t[n].name + "</a>": '<li><a href="' + t[n].redirect_url + '" target="_blank">' + t[n].name + "</a>";
            $("#w-thotId .w-twrapbox").html('<ul class="w-thotgames">' + a + '<li><a href="'+U('Game/index/index')+'" target="_blank" class="cur">更多游戏<i>&gt;&gt;</i></a></ul>')
        }
    }
}),
$(document).delegate("#w-thotId", "mouseover",
function() {
    var e = $(this);
    e.addClass("w-twrap-cur")
}).delegate("#w-thotId", "mouseout",
function() {
    $(this).removeClass("w-twrap-cur")
}).delegate("#w-log,#w-tplog", "click",
function() {
    return webComObj.iframeshow(0),
    webComObj.backShow(),
    !1
}).delegate("#w-reg", "click",
function() {
    return webComObj.iframeshow(1),
    webComObj.backShow(),
    !1
}).delegate("#w-tmyId", "mouseover",
function() {
    var e = $(this);
    e.addClass("w-twrap-cur"),
    webComObj.userInfo.length || $.ajax({
        type: "POST",
        url: U('Api/User/userapi','callback=?'),
        dataType: "jsonp",
        success: function(t) {
            webComObj.userInfo[0] = t;
            var a = t.level,
            n = t.hy,
            o = "";
            0 == a && (n = 1),
            o = 0 == n ? "lv_g" + a: "lv" + a,
            e.find(".w-twrapsub").length || e.append('<div class="w-twrapsub"><div class="w-twrapbox"><div class="w-nameinfo"><a class="w-nametxt" href="'+U('User/index/index')+'">' + webComObj.username + '</a><a class="lv_ico lv_' + t.xlevel + '" href="'+U('User/score/index')+'"></a><a class="level_ico ' + o + '" href="'+U('User/Vip/index')+'"></a><a class="w-checks" target="_self" href="' + U('Api/User/logout','redirect='+location.href) + '">退出</a></div><ul class="w-infosub"><li><a href="'+U('Score/index/index')+'">[查看]</a>我的积分：' + t.score + '<li><a href="'+U('User/Vip/index')+'">[获取]</a>VIP成长值：' + t.value + '<li><a href="'+U('User/Gift/index')+'">[记录]</a>礼包数：' + t.packs + '</ul></div><div class="w-thotico"></div></div>')
        },
        error: function() {}
    })
}).delegate("#w-tmyId", "mouseout",
function() {
    $(this).removeClass("w-twrap-cur")
}).delegate("#w-tmyplayId", "mouseover",
function() {
    $(this).addClass("w-twrap-cur")
}).delegate("#w-tmyplayId", "mouseout",
function() {
    $(this).removeClass("w-twrap-cur")
}).delegate("#sitefav", "click",
function() {
    var e = navigator.userAgent.toLowerCase(),
    t = U('Game/index/index'),
    a = document.title,
    n = -1 != navigator.userAgent.toLowerCase().indexOf("mac") ? "Command/Cmd": "CTRL";
    if (e.indexOf("msie 8") > -1) external.AddToFavoritesBar(t, a, "");
    else try {
        window.external.addFavorite(t, a)
    } catch(o) {
        try {
            window.sidebar.addPanel(a, t, "")
        } catch(o) {
            alert("您可以尝试通过快捷键" + n + " + D 加入到收藏夹!")
        }
    }
    return ! 1
}).delegate("#w-navdown", "mouseover",
function() {
    $(this).addClass("w-navd_cur")
}).delegate("#w-navdown", "mouseout",
function() {
    $(this).removeClass("w-navd_cur")
}),
function(e, t) {
    var a = function() {
        var a = t.body,
        n = a.className,
        o = 1200,
        i = 1419,
        r = function() {
            var e = a.className;
            if (t.documentElement.clientWidth < o) - 1 == e.indexOf("web980") && (a.className = e + " web980");
            else if ( - 1 != e.indexOf("web980")) {
                for (var n = e.split(" "), i = n.length - 1; i >= 0; i--)"web980" == n[i] && n.splice(i, 1);
                a.className = n.join(" ")
            }
        },
        s = function() {
            var e = a.className;
            if (t.documentElement.clientWidth < i) - 1 == e.indexOf("w1441") && (a.className = e + " w1441");
            else if ( - 1 != e.indexOf("w1441")) {
                for (var n = e.split(" "), o = n.length - 1; o >= 0; o--)"w1441" == n[o] && n.splice(o, 1);
                a.className = n.join(" ")
            }
        },
        l = {
            addHandle: function(e, t, a) {
                e.addEventListener ? e.addEventListener(t, a, !1) : e.attachEvent ? e.attachEvent("on" + t, a) : e["on" + t] = a
            },
            removeHandler: function(e, t, a) {
                e.removeEventListener ? e.removeEventListener(t, a, !1) : e.detachEvent ? e.detachEvent("on" + t, a) : e["on" + t] = null
            }
        };
        e.screen.width < o ? a.className = n + " web980": l.addHandle(e, "resize", r),
        e.screen.width < i ? a.className = n + " w1441": l.addHandle(e, "resize", s)
    };
    /msie [6|7|8]/i.test(navigator.userAgent) && a()
} (window, document);











$(function(){
	//Add Favorites
	$("#site_fav").click(function() { 
		var ua = navigator.userAgent.toLowerCase(),
			url =U('Game/index/index'),
			sitename =document.title,
			vctrl = (navigator.userAgent.toLowerCase()).indexOf('mac') != -1 ? 'Command/Cmd' : 'CTRL';
		if(ua.indexOf("msie 8")>-1){
				external.AddToFavoritesBar(url,sitename,"");//IE8
		}else{
			try{
				window.external.addFavorite(url,sitename);
			}catch(e){
			  try{
			  window.sidebar.addPanel(sitename,url,"");//firefox
			  }catch(e){
				alert('\u60A8\u53EF\u4EE5\u5C1D\u8BD5\u901A\u8FC7\u5FEB\u6377\u952E' + vctrl + ' + D \u52A0\u5165\u5230\u6536\u85CF\u5939!');
			  }
			}
		}
	});

	//username
	$("#LoginForm_username").focus(function(){
		$(this).css("background-position","0 -80px");
		var txt_value=this.value;
		if(txt_value==this.defaultValue){this.value='';}
	}).blur(function(){
		$(this).css("background-position","0 0");
		var txt_value=this.value;
		if(txt_value==''){this.value=this.defaultValue}
	});
	//password
	$("#passtips").click(function(){
		$(this).hide();
		$("#LoginForm_password").focus();
	})
	$("#LoginForm_password").focus(function(){
		$("#passtips").hide();
	}).blur(function(){
		$("#passtips").show();
		if($(this).val()!="") $("#passtips").hide();
	})
	$("#LoginForm_password").focus(function(){
		$(this).css("background-position","0 -120px");
	}).blur(function(){
		$(this).css("background-position","0 -40px");
	})
	
	//photo slide
	$("#ph_nav>span").mouseover(function(){
		var index=$("#ph_nav>span").index(this);
		$(this).addClass('cur').siblings().removeClass('cur');
		 if( !$("#ph_box p").is(":animated") ){ 
			$("#ph_box>p").animate({left: -(942*index)},50);
		 }
	});
	$("#LoginForm_password").blur();
	$("#LoginForm_username").blur();
});

//laba
$(function(){
	var _wrap=$('.laba');
	var _interval=2000;
	var _moving;
	_wrap.hover(function(){
	 clearInterval(_moving);
	},function(){
	 _moving=setInterval(function(){
		 var _field=_wrap.find('li:first');
		 var _h=_field.height();
		 _field.animate({marginTop:-_h+'px'},600,function(){
			 _field.css('marginTop',0).appendTo(_wrap);
		 })
	 },_interval)
	}).trigger('mouseleave');
});

//user played more
var interPlayed={
	minh:72,
	init:function(){
		$(".btn_list").each(function(){
			var h=$(this).height();
			if(h>interPlayed.minh){
				$(this).after('<i class="more_s">全部</i>');
			}
		});
		$(".more_s").toggle(function(){
			$(this).parent().removeClass('max_h').end().html("收起");
		},function(){
			$(this).parent().addClass('max_h').end().html("全部");
		});

	}
}
interPlayed.init();