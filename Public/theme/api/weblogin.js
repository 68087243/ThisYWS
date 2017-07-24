function submitLoginInfo() {
    var result = checkuser_login($('#login-username')) && checkpwd_login($('#login-password'));
    if (result) {
        $.ajax({
            type: "get",
            async: false,
            url: $('#loginform').attr('action'),
            dataType: "jsonp",
            jsonp: "callback",
            data: $('#loginform').serialize(),
            success: function (data) {
                if (data.msg == 'success') {
                    $('body').append(data.script);
                    document.location.reload();
                }
                else {
                    
                    var msg = data.msg;
                    if (msg == null || msg == undefined || msg == '' || msg.password || msg.username)
                        msg = '用户名或密码错误';
                    showLoginError(msg);
                }
            }   
        });
    }
    return false;
}

//检查登录用户 
function checkuser_login(self) {
    $input = $(self);
    var username_login = $.trim($input.val());
    if (!username_login) {
        showLoginError('请输入用户名');
        return false;
    }
    if (username_login.length < 4 || username_login.length > 15) {
        showLoginError('用户名不存在');
        return false;
    }
    showLoginError('');
    return true;
}

function checkpwd_login(self) {
    $input = $(self);
    var pwd_login = $.trim($input.val());
    if (!pwd_login) {
        showLoginError('请输入密码');
        return false;
    }
    else if (pwd_login.length < 6) {
        showLoginError('密码错误');
        return false;
    }
    showLoginError('');
    return true;
}

function showLoginError(errorMsg) {
    if (errorMsg) {
        var error = $("#login-error");
        if (error.length > 0) {
            $("#login-error").html(errorMsg);
        } else {
            alert(errorMsg);
        }
    } else
        $("#login-error").html();
}
document.onkeydown = function mykeyDown(e) {
    e = e || event;
    if (e.keyCode == 13) {
        var nameNode = document.getElementById('login-username'),
            pwdNode = document.getElementById('login-password');
        if(nameNode == document.activeElement || pwdNode == document.activeElement) {
            submitLoginInfo();
        } else if(typeof(enterGame) == 'function') {
            enterGame();
        }
    }
    return;
}