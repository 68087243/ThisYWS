if (typeof Login == "undefined") {
    var Login = {
        params: {},
        init: function(options) {
            $.extend(Login.params, options)
        },
        login: function() {
            for (key in Login) {
                if (typeof Login[key] == "function" && key != "login") {
                    Login[key]()
                }
            }
        }
    }
}
if (typeof Logout == "undefined") {
    var Logout = {
        init: function(options) {
            $.extend({}, options)
        },
        logout: function() {
            for (key in Logout) {
                if (typeof Logout[key] == "function" && key != "logout") {
                    Logout[key]()
                }
            }
        },
        doAjaxLogout: function() {
            var url = 'http://ptlogin.2144.cn/ptlogin/ajaxlogout/ajax/1' + "?t=" + Math.random() + "&callback=?";
            $.getJSON(url, function(respon) {
                $('body').append(respon.script)
            })
        }
    }
}

function back_show() {
    if (!$("#backgray").length) {
        $("body").append('<div id="backgray"></div>')
    }
    var doc = document.documentElement,
        docbody = document.body,
        addbalc = $("#backgray");
    addbalc.show();
    if ($.browser.msie && $.browser.version == 6) {
        addbalc.css({
            position: 'absolute',
            width: doc.scrollWidth,
            height: doc.scrollHeight
        })
    } else {
        addbalc.css({
            position: 'fixed',
            width: docbody.clientWidth,
            height: docbody.clientHeight
        })
    }
    $('html').addClass('logohidden')
}
function back_hide() {
    $("#backgray").hide().css({
        width: 0,
        height: 0
    });
    $("#lriframe").html('');
    $('html').removeClass('logohidden')
}
function tips_show() {
    var wraps = $("#tipswrap");
    if ($.browser.msie && $.browser.version == 6) {
        wraps.css({
            top: $(document).scrollTop() + ($(window).height() - wraps.height()) / 2
        })
    } else {
        wraps.css({
            'margin-top': -wraps.height() / 2
        })
    }
}
function tips_hide() {
    $("#tipswrap").remove()
}
function iframeshow(register) {
    if ($.browser.msie && $.browser.version == 6) {
        $("#lriframe").css({
            top: $(document).scrollTop() + ($(window).height() - $("#flowersid").height()) / 2
        })
    }
    $("#lriframe").html('<iframe id="frame_login" name="frame_login" src="http://ptlogin.2144.cn/ptlogin/login" width="100%" height="100%" scrolling="no" frameborder="0"></iframe>');
    if (register) {
        $("#lriframe iframe").attr('src', $("#lriframe iframe").attr('src') + '?1')
    }
    back_show()
}

function login_hide() {
    Login.login();
    back_hide()
}



var gy_person = typeof gy_person ?  {} : gy_person;//个人中心声明一个gy_person大类

gy_person.oppWrap = {

        popShow : function(title,con,other){

                var oclass = other || '';

                $("body").append('<div id="p-alertbox" class="p-alertbox '+ oclass +'"><div class="p-alertit"><h5>' + title + '</h5><span class="p-alertclose"></span></div><div class="p-alertwrap">'+ con +'</div></div><div id="backgroudgary" class="backgroudgary"></div>');

                $("#backgroudgary").css({

                        width: $("body").width(),

                        height: $("body").height()

                });

                

        },



        popHidden : function(){

                $("#backgroudgary").remove();
                $("#p-alertbox").remove();
        }
};


gy_person.isUserId = 0;//用户id号


gy_person.MyplayedAPI = {//所有接口对象

                requestDomain : "http://bar.2144.cn/api/",

                getPlayedList : function(uid,callback){
                    var url = U('Api/Game/GetPlayedList','callback=?');
                    $.ajax({
                        type : "get",
                        async : false,
                        url : url,
                        dataType : "jsonp",
                        jsonp : "callback",
                        success : function(data){
                            callback(data);
                        }
                    });
                },

                deletePlayedGame : function(uid,gid,callback){

                        var url = this.requestDomain + "delPlay/?callback=?",

                            data = {
                                gid : gid,
                                uid : uid
                            };

                        $.ajax({
                            type : "get",
                            async : false,
                            url : url,
                            dataType : "jsonp",
                            jsonp : "callback",
                            data : data,
                            success : function(data) {
                                callback(data);
                            }
                        });
                },

                getAllFavorite : function(uid,callback){                
                                        var uid = uid,

                                            url = U('Api/Game/getcollects','callback=?'),

                                            data = {uid:uid};

                                        $.ajax({
                                            type : "get",
                                            async : false,
                                            url : url,
                                            dataType : "jsonp",
                                            jsonp : "callback",
                                            data : data,
                                            success : function(data) {
                                                callback(data);
                                            }
                                        });
                },

                delFavorite : function(uid,gid,callback){
                            var uid = uid,

                                url = U('Api/Game/gameCollects','callback=?'),
								
                                data = {gid:gid,uid:uid};

                            $.ajax({
                                type : "get",
                                async : false,
                                url : url,
                                dataType : "jsonp",
                                jsonp : "callback",
                                data : data,
                                success : function(data) {
                                    callback(data);
                                }
                            });
                },

                delAllFavorite:function(uid,callback){

                            var uid = uid,

                                url = U('Api/Game/gameCollects','callback=?'),

                                data = {uid:uid};

                            $.ajax({
                                type : "get",
                                async : false,
                                url : url,
                                dataType : "jsonp",
                                jsonp : "callback",
                                data : data,
                                success : function(data) {
                                    callback(data);
                                }
                            });
                }



};


gy_person.Login = {//登录接口

        mainurl : 'http://ptlogin.2144.cn/ptlogin',

        isLogin : function(callback){

                var url = U('Api/user/getuser',"callback=?");


                $.getJSON(url,function (data){

                        if(typeof callback == 'function'){

                                callback(data);
                        }
                });
        },

        isLogout : function(callback){

                var url = gy_person.Login.mainurl + '/ajaxlogout/ajax/1' + "?t="+ Math.random() +"&callback=?";


                $.getJSON(url,function (data){

                        $('body').append(data.script);
                        
                        if(typeof callback == 'function'){

                                callback();
                        }
                });
        },
        
        isReload : function(){
        
            location.reload();
            
        }
        
        
        
};


gy_person.Login.isLogin(function(data){

        if(data.isGuest == 0){//登录后操作方法

                gy_person.isUserId = data.id;

        }

});

var Cookie = {
    setCookie:function(key,value,expire){
        var exp = new Date(); 
        exp.setTime(exp.getTime() + expire*24*60*60*1000); 
        document.cookie = key + "="+ escape (value) + ";expires=" + exp.toGMTString(); 
    },
    getCookie:function(key){
        var arr,reg=new RegExp("(^| )"+key+"=([^;]*)(;|$)");
        if(arr=document.cookie.match(reg))
            return unescape(arr[2]); 
        else 
            return null; 
    },
    deleteCookie:function(key){
        var exp = new Date(); 
        exp.setTime(exp.getTime() - 1); 
        var cval=this.getCookie(key); 
        if(cval!=null) 
            document.cookie= key + "="+cval+";expires="+exp.toGMTString(); 
    }
}

$(document).delegate('.p-rtips-c','click',function(){

    var bindKey_email = 0;
    var bindKey_mobile = 0;

     if($(this).attr('data-type') == 'mobile')
     {
        $(this).parent().next().removeClass('hidden');
        $(this).parent().remove();
        bindKey_email = 1;
        Cookie.setCookie('bindKey_mobile', 1   ,1);
     }
     else if($(this).attr('data-type') == 'email')
     {
        $(this).parent().remove();
        bindKey_mobile = 2;
        Cookie.setCookie('bindKey_email', 1  ,1);
     }

}).delegate('.p-checkb','click',function(event,a){
    if(typeof pageId == 'undefined'){

            var _this = $(this),
                _date = _this.find('em').html();
            $.getJSON(U('Api/User/usersign','callback=?'),function(data){
                
                if(data.code==0)
                {
                    var percent = (parseInt(data["scoreInfo"]["score"]) - parseInt(data["scoreInfo"]["min"]))*100/(parseInt(data["scoreInfo"]["max"]) - parseInt(data["scoreInfo"]["min"]));
                    var title = "当前等级：LV"+data["scoreInfo"]["level"]+"&nbsp;&nbsp;;&nbsp;&nbsp;积分："+data["scoreInfo"]["score"];
                    if(_this.attr('data-type') != null)
                    {
                       
                        $('.p-jfwrap').replaceWith('<div class="p-jfwrap"><div class="p-slidetop">我的等级：<span>LV'+data["scoreInfo"]["level"]+'</span>我的积分：<span>'+data["scoreInfo"]["score"]+'</span></div><div class="p-slides"><span class="p-islide" style="width:'+percent+'%" title = "'+title+'"></span></div><div class="p-slidel"><span>LV'+(parseInt(data["scoreInfo"]["level"]) + 1)+' ('+data["scoreInfo"]["max"]+')</span>LV'+data["scoreInfo"]["level"]+' ('+data["scoreInfo"]["min"]+')</div></div>');
                    }
                    else
                    {
                        $('.p-jfwrap').replaceWith('<div class="p-jfwrap"><div class="p-slidetop"><a href="/game/score" class="p-kscz">加速成长</a>我的等级：<span>LV'+data["scoreInfo"]["level"]+'</span>我的积分：<span>'+data["scoreInfo"]["score"]+'</span></div><div class="p-slides"><span class="p-islide" style="width:'+percent+'%" title = "'+title+'"></span></div><div class="p-slidel"><span>LV'+(parseInt(data["scoreInfo"]["level"]) + 1)+' ('+data["scoreInfo"]["max"]+')</span>LV'+data["scoreInfo"]["level"]+' ('+data["scoreInfo"]["min"]+')</div></div>');
                    }


                }else{
					return;
				}
            });

            _this.append("<strong>+1</strong>");

            _this.find("strong").animate({top: '-30px',fontSize: "18px"}, 500);

            _this.find("strong").fadeOut(500,function(){

                _this.parent().html('<div class="p-checka"><em>'+ _date +'</em><span>已签到</span></div>');

            });
			
            $('#sign-task').trigger('click',[1]);
    }

}).delegate('#logout','click',function(){

    gy_person.Login.isLogout(gy_person.Login.isReload);

}).delegate('#sign-task','click',function(event,a){

     var span = $(this).children('span');
    $(this).replaceWith('<a href="#"><img src="/Public/theme/user/images/qd.jpg" alt="">每日签到 +10积分<span class="p-ywch">已完成</span></a>');
    $('.p-checkb').trigger('click',[1]);
    var $completeNum = $('.p-subtit span');
    var num = parseInt($completeNum.text());
    ++num;
    $completeNum.text( num > 4 ? 4 : num);
    var completeTitle = $('.p-subtit');
    completeTitle.attr('title','已完成'+num+'项,待完成'+(4-parseInt(num))+'项');
});



