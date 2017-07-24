var getHost=function(url){var host="null";if(typeof url=="undefined"||null==url){url=window.location.href}var regex=/.*\:\/\/([^\/|:]*).*/;var match=url.match(regex);if(typeof match!="undefined"&&null!=match){host=match[1]}if(typeof host!="undefined"&&null!=host){var strAry=host.split(".");if(strAry.length>1){host=strAry[strAry.length-2]+"."+strAry[strAry.length-1]}}return host};
document.domain = getHost();
function showLoginError(errorMsg){
    
   $('div.login-tips').html(errorMsg);
}

function submitLoginInfo(){

      if( !checkLogin() ) {

            showLoginError('用户名或密码错误');

            return;
      }

      $('input.sub-css').next().show();

      $('input.sub-css').hide();

      $.post($('#login-form').attr('action'),$('#login-form').serialize(),function(data){

          if(data.msg == 'success'){

                $('body').append(data.script);

                document.location.reload();

          }else{

                $('input.sub-css').next().hide();

                $('input.sub-css').show();
                var msg = data.errors;
                 if(msg == null || msg == undefined || msg=='' || msg.password || msg.username)
                      msg = '用户名或密码错误';
                showLoginError(msg);

          }
      },'json');

  return false;
}

//检查登录用户 
function checkLogin(){

    var txt = $('#LoginForm_username').val(),

        pass = $('#LoginForm_password').val();

    txt = txt.replace(/^\s*/,"").replace(/\s*$/,"");

    if(txt == '' || txt == '用户名'){

        return false;

    }

    if(pass == '' || pass.length < 6){

        return false;

    }

    showLoginError('');

    return true;
}



$(document).keydown(function(event){

        if(event.keyCode == 13){

            submitLoginInfo();

        }

        return;
});



$(document).delegate('#LoginForm_username','focus',function(){

    $(this).parent().addClass("namfocus");

    var txt = this.value;

    if(txt == this.defaultValue){

        this.value = '';

    }

}).delegate('#LoginForm_username','blur',function(){

    $(this).parent().removeClass("namfocus");

    var txt = this.value;

    txt = txt.replace(/^\s*/,"").replace(/\s*$/,"");

    if(txt == ''){

        this.value = this.defaultValue;
    }

}).delegate('#passtips','click',function(){

    $(this).hide();

    $("#LoginForm_password").focus();

}).delegate('#LoginForm_password','focus',function(){

    $(this).parent().addClass("pasfocus");

    $("#passtips").hide();
    
}).delegate('#LoginForm_password','blur',function(){

    $("#passtips").show();

    if($(this).val() != "") $("#passtips").hide();

    $(this).parent().removeClass("pasfocus");
    
});



if(typeof window.parent.webComObj == 'object'){
    window.parent.webComObj.isGuest(1);//父页面执行是否登录操作
}