
function checkuser(self)
{
  $input=$(self);
  var usernamecheck = $input.val();
  if(!usernamecheck){
    showError($input,'用户名不能为空');
    return false;
  }
  var patrn=/^[a-zA-Z0-9]{1}([a-zA-Z0-9]|[_]){3,14}$/;
  if(!patrn.test(usernamecheck)){
    showError($input,'用户名长度为4-15字符');
    return false;
  }
  if(usernamecheck.length < 4){
    showError($input,'用户名长度为4-15字符');
    return false;
  }
  var url = U('Api/User/checkdata');
  var tmp = true;
  var data ='str='+usernamecheck+'&type=username';
  $.ajax({
      url:url,
	  type:'POST',
      dataType:"jsonp",
      data:data,
      jsonp:"callback",
      async:false,
      timeout:5000,
      success:function(obj){
        if(obj.msg=='success'){
          tmp = true;
        }
        else{
          showError($input,obj.msg);
          tmp = false;
        }
      }
   })
    return tmp;
}

function submitInfo()
{
  var reuser= $('#register-username');
    var repwd = $('#txtPassWord');
    var reprwd = $('#txtRPassWord');
    var result = checkuser(reuser) && UserPassName(repwd) && UserRPass(reprwd);
  if(result)
  {
     var newWindow=window.open('','_top');
      $.post(U('Api/User/ajaxRegister'),$('#form1').serialize(),function(data){
          if(data.msg=='success')
          {
             if(typeof(logonSuccess)!='undefined'){
                logonSuccess($('#register-username').val() ,$('#txtPassWord').val());
                return;
             }
             $('body').append(data.script);
             parent.location.reload();
          }else{
			  showError($input,data.msg);
		  }
      },'jsonp');
  }
  return false;
}

function UserPassName(self)
{
    $input=$(self);
    var reg = /(.)\1\1/;
    var pwd =$.trim($input.val());
    if(!pwd){
        showError($input,'密码不能为空');
        return false;
    }
    if(pwd.length<6 || pwd.length>20)
    {
        showError($input,'请控制您的密码在6-20之内');
        return false;
    }
    return true;
}

function UserRPass(self)
{
  $input=$(self);
  var password = $("#txtPassWord").val();
  var password2 = $("#txtRPassWord").val();
  if(!password2){
    showError($input,'请再次输入您的密码');
    return false;
  }
  if(password!=password2)
  {
    showError($input,'两次输入的密码请保持一致！');
    return false;
  }
    return true;
}

function trim(str){ //删除左右两端的空格
　　     return str.replace(/(^\s*)|(\s*$)/g, "");
}
function submitLoginInfo()
{
    var loguser =$('#login-username');
    var logpwd = $('#login-password');
    var result = checkuser_login(loguser) && checkpwd_login(logpwd);
    if(result)
    {
      $.post(U('Api/User/ajaxLogin'),$('#loginform').serialize(),function(data){
          if(data.msg=='success')
          {
             if(typeof(logonSuccess)!='undefined'){
                logonSuccess($('#login-username').val() ,$('#login-password').val());
                return;
             }
             $('body').append(data.script);
			 parent.location.reload();
          }
          else
          {
            showLoginError($('#login-username'),'用户名或密码错误');
          }
      },'jsonp');
  }
  return false;
}

//检查登录用户 
function checkuser_login(self){
  $input=$(self);
  var username_login = $.trim($input.val());
  if(!username_login){
    showLoginError($input,'请输入用户名');
    return false;
  }
  if(username_login.length < 4 || username_login.length > 15){
    showLoginError($input,'用户名不存在');
    return false;
  }
  return true;
}

function checkpwd_login(self){
  $input=$(self);
  var pwd_login = $.trim($input.val());
  if(!pwd_login){
    showLoginError($input,'请输入密码');
    return false;
  }
  if(pwd_login.length < 6){
    showLoginError($input,'密码错误');
    return false;
  }
  return true;
}

$('#login-holder').click(function(){
               $('#register-div').hide();
               $('#login-div').show();
       });
       $('#new_userbtn').click(function(){
               $('#register-div').show();
               $('#login-div').hide();
});