	function getServer()
	{
	  var gid = $("#gid").val();
	  $.ajax({
	      type: "GET",
	      url: U('Api/Game/GetServer','callback=?'),
	      data:{'gid':gid},
	      dataType: "jsonp",
	      async:false,
	      success:function(data){
	      	  var gid = $("#gid").val();
	      	  $('#sul').html('<li class="gs_first" attr="h"><span>最近玩过</span></li>');
	      	  $("a[tag='serverlist']").remove();
	          var payrate=$('#payrate').val();
	          $('#gamerate').val(data.currency);
	          $('#ybcn').val(data.money_cn);
	          var defSid=$('#defServerId').val();
	          var html = '';
	          var servers = data.servers;
	          if(servers!=null){
	          	  var i=0,from=0,to=0;
	              for(;i<servers.length;i++){
	              	if(servers.length>550){
	              		var pagenum = Math.ceil(servers.length/5);
	              	}else
	              		var pagenum = 110;
						if(i%pagenum == 0){
							if(to){
								$('#sul').append('<li attr='+from+'><span>'+from+'-'+to+'服</span></li>');
							}
							 from = servers.length-i;
						}
						 to = servers.length-i;
	              	  html += '<li><a href="#" sidval="'+servers[i]['sid']+'" from='+from+' tag=\'serverlist\'>'+servers[i]['s_name']+'</a></li>';
	              }
	              $('#sul').append('<li attr='+from+'><span attr='+from+'>'+from+'-'+to+'服</span></li>');
		          if(his[gid]){
			        for(var a in his[gid]){
			        	html += '<li><a href="#" sidval="'+his[gid][a]['sid']+'" from="h" tag=\'hislist\'></a></li>';
			        }
		          }
		          $(".p_servelist").html(html);
		          $("#sul>li").eq(1).trigger('click');
		          $(".p_servelist>li>a[tag='hislist']").each(function(i){
		          	  var sid = $(this).attr('sidval');
		          	  var sname = $(".p_servelist>li>a[tag='serverlist'][sidval="+sid+"]").html();
		          	  if(!sname)
		          	  	  $(this).remove()
		          	  else
		          	  	$(this).html(sname);
		          });
					if(cur_server == 1){
						$(".p_servelist>li>a[sidval='"+$("#defServerId").val()+"']").trigger('click');
					}
					if(his[gid]){
						$("#sul>li").eq(0).trigger('click');
					}
	          }
	          calculateMoney();
	      }
	  });
	}

	$('#sul>li').live("click",function(){
		var from = $(this).attr('attr');
		$(this).addClass('cur').siblings().removeClass('cur');
		$(".p_servelist >li").hide();
		$(".p_servelist >li>a[from='"+from+"']").parent().show();
	});

	function checkRole(){
	var gid=$('#gid').val();
	var sid=$('#sid').val();
	var username=$('#g_username').val();
	var valid=true;
	 $.ajax({
	      type: "GET",
	      url: U('Api/Game/GetRole','callback=?'),
	      data:{'gid':gid,'sid':sid,'username':username},
	      dataType: "jsonp",
	      async:true,
	      success:function(data){
	        if(data.error!=0){
	          $("#roleerror").html(data.msg);
	          $("#roleerror").show();
			  $(".confirm_btn").show();
			  $(".dazhuan").hide();
	          valid=false;
	        } else {
	          $("#rolename").val(data.name);
	          $("#payment_tip").html($("#paytitle").html());
				$("#game_tip").html($("#gname").html());
				$('#game_tip').parent().show();
				$("#role_tip").html($("#rolename").val());
				$('#role_tip').parent().show();
				$("#server_tip").html($("#sname").html());
				$("#user_tip").html($("#g_username").val());
				$("#cash_tip").html($("#cash").val());
				$("#bi_tip").html($("#viewybnum").html());
				$(".bicn_tip").html($("#unit").html());
				var payment=paytype[$("#paytype").val()];
				if(payment.card == "1"){
					var paycardid = $('#paycardid').val();
					var paycardpass = $('#paycardpass').val();
					if(paycardid == "" ){
						$('#paycardiderror').html('请输入卡号');
						$('#paycardiderror').show();
						$(".confirm_btn").show();
						$(".dazhuan").hide();
						return;
					}
					if(paycardpass == "" ){
						$('#paycardpasserror').html('请输入卡密');
						$('#paycardpasserror').show();
						$(".confirm_btn").show();
						$(".dazhuan").hide();
						return;
					}
				}else{
				  $('#paycardid').val('');
				  $('#paycardpass').val('');
				}
				
				if(payment.bank){
					var paybank = $('#paybank').val();
					$("#bankname").html($("#"+paybank).attr('title'));
				}else{
					$("#bankname").val('');
				}
				
		
				
				if(parseInt(money) < (parseInt($("#cash").val())*CURRENCY_RATE) &&  $("#paytype").val() =="_syspay" ){
					alert('抱歉，您余额不足，请充值!');
					$(".confirm_btn").show();
					$(".dazhuan").hide();
					return;
				}
				
				$("#qa").attr("href",$(".p_nav_ul>li[class='cur']").attr("url"));
				$.post($('#form1').attr('action'),$('#form1').serialize(),function(data){
					if(data.msg=='success')
					{
                        $(".pay_pop_sub").attr("target","_blank");
                        $(".pay_pop_sub").attr("href",U('Pay/orders/pay','orders='+data.id));
                        wrapshow("#payinfo");
					}else{
						alert(data.msg);
					}
					$(".confirm_btn").show();
					$(".dazhuan").hide();
				},'json');
	        }
	      }
	  });
	 return valid;
	}

	function checkPtb(){
	var username=$('#g_username').val();
	var type='username';
	var valid=true;
	 $.ajax({
	      type: "GET",
	      url: U('Api/User/checkdata','callback=?'),
	      data:{'type':type,'str':username},
	      dataType: "jsonp",
	      async:true,
	      success:function(data){
	        if(data.msg=="success"){
	          $("#roleerror").html('抱歉，充值的用户名不存在!');
	          $("#roleerror").show();
			  $(".confirm_btn").show();
			  $(".dazhuan").hide();
	          valid=false;
	        } else {
	          $("#rolename").val(data.name);
	          $("#payment_tip").html($("#paytitle").html());
				$('#game_tip').parent().hide();
				$('#role_tip').parent().hide();
				$("#user_tip").html($("#g_username").val());
				$("#cash_tip").html($("#cash").val());
				$("#bi_tip").html($("#viewybnum").html());
				$(".bicn_tip").html($("#unit").html());
				var payment=paytype[$("#paytype").val()];
				
				var payment=paytype[$("#paytype").val()];
				if(payment.card == "1"){
					var paycardid = $('#paycardid').val();
					var paycardpass = $('#paycardpass').val();
					if(paycardid == "" ){
						$('#paycardiderror').html('请输入卡号');
						$('#paycardiderror').show();
						$(".confirm_btn").show();
						$(".dazhuan").hide();
						return;
					}
					if(paycardpass == "" ){
						$('#paycardpasserror').html('请输入卡密');
						$('#paycardpasserror').show();
						$(".confirm_btn").show();
						$(".dazhuan").hide();
						return;
					}
				}else{
				  $('#paycardid').val('');
				  $('#paycardpass').val('');
				}
				
				
				if(payment.bank){
					var paybank = $('#paybank').val();
					$("#bankname").html($("#"+paybank).attr('title'));
				}else{
					$("#bankname").val('');
				}
				$("#qa").attr("href",$(".p_nav_ul>li[class='cur']").attr("url"));
				$.post($('#form1').attr('action'),$('#form1').serialize(),function(data){
					if(data.msg=='success')
					{
                        $(".pay_pop_sub").attr("target","_blank");
                        $(".pay_pop_sub").attr("href",U('Pay/orders/pay','orders='+data.id));
                        wrapshow("#payinfo");
					}else{
						alert(data.msg);
					}
					$(".confirm_btn").show();
					$(".dazhuan").hide();
				},'json');
	        }
	      }
	  });
	 return valid;
	}
	
	function calculateMoney()
	{
	var cash = $("#cash").val();
	var gamerate=$('#gamerate').val();
	var payrate=$('#payrate').val();
	var ybcn=$('#ybcn').val();
	var rate = gamerate*payrate;
	var gid=$('#gid').val();
	$("#unit").html(ybcn);
	$('#game_rate').html("1:"+rate);
	$("#viewybnum").html(cash*rate);
	checkMoney();
	}

	function checkMoney()
	{
	var gid=$('#gid').val();
	var cash=$("#cash").val();
	if(cash.length==0 || cash<1 || cash>100000)
	{
		//$("#casherror").html('请填写1-100000的整数');
		//$("#casherror").show();
	    return false;
	}
	else if(parseInt(cash) != cash)
	{
		//$("#casherror").html('请填写1-100000的整数');
		//$("#casherror").show();
	    return false;
	}
	else
	{
		$("#casherror").hide();
	    return true;
	}
	}

	function checkServer()
	{
		var sid=$('#sid').val();
		if(!sid)
		{
			alert('选择游戏服务器');
			return false;
		}
		return true;
	}

	function checkName()
	{
		var name=$('#g_username').val();
		var valid=true;
		if(name.length==0)
		{
			$('#usererror').html('帐号信息不能为空');
			$('#usererror').show();
			valid=false;
		}
		if(valid==true)
		{
			$("#usererror").hide();
		}
		return valid;
	}

	$(".p_nav_ul>li").bind("click",function(){
		var value = $(this).attr("val");
		if(!value)
			return false;
		$("#paytitle").html($(this).html());
		$("#paytitle > span").remove();
		$("#business").html($(this).attr('business'));
		$(".p_nav_ul>li").removeClass("cur");
		$(this).addClass("cur");
		if(value == "_sysrgpay")
		{
			$("#ren").html($("#_sysrgpay-intro>ol").html());
			$("#ren").show();
			$("#chongzhi").hide();
		}else{
			if(value == "_syspay"){
				$('.p_to_type').hide();
			}else{
				$('.p_to_type').show();
			}
				$("#ren").hide();
				$("#chongzhi").show();
			  $('.p_intro').hide();
			  $("#"+value+"-intro").show();
			  var payment=paytype[value];
			  $("#paytype").val(value);
			  $('#payrate').val(payment.rate);
			  
			  //bank
		      if(payment.fixSelect)
		      {
		        var listItem='';
		        $.each(payment.list,function(index,item){
		          listItem+='<a value="'+item+'" href="#">'+item+'元</a>';
		        });
		        $(".money_c>a").eq(0).addClass("cur");
		        $(".money_other").hide();
		      }else{
		      		var listItem = '<a value="10" class="cur" href="#">10元</a>\
					<a value="20" href="#">20元</a>\
					<a value="50" href="#">50元</a>\
					<a value="100" href="#">100元</a>\
					<a value="200" href="#">200元</a>\
					<a value="500" href="#">500元</a>\
					<a value="1000" href="#">1000元</a>\
					<a value="2000" href="#">2000元</a>\
					<a value="5000" href="#">5000元</a>\
					<a value="10000" href="#">10000元</a>\
					<a value="20000" href="#">20000元</a>\
					<a value="50000" href="#">50000元</a>';
		        $(".money_other").show();
		      }
		      $(".money_c").html(listItem);
		      $(".money_c>a").eq(0).trigger('click');
		      $(".money_c>a[value=100]").trigger('click');
		      $("#banklist").hide();
			  $("#card_v").hide();
			  if(payment.bank){
				$("#ICBC").trigger("click");
				$("#banklist").show();
			  }
			  if(payment.card == "1"){
				$("#card_v").show();
			  }
		      calculateMoney();
		}
	});

	$("#bank_list label").each(function(i){
	   if(i==0){
	       $(this).addClass("selected");
	       $(this).children().attr("checked",true);
	   }
	   if(i>8){
	       $(this).addClass("hidden");
	   }
	});

	$(".p_servelist>li>a").live("click",function(){
		$("#roleerror").hide();
		$("#sname").html($(this).html());
		$("#sid").val($(this).attr('sidval'));
		$('.p_gsbox').hide();
		$(".select_ico").hide();
		$("#serverlist").parent().removeClass('li_opacity');
		$("#serverlist>img").show();
		return false;
	});

	$(".confirm_btn").bind("click",function(){
        if(syusers)
            return false;
		if(!defname){
			iframeshow(0);
			return false;
		}
		var valid=true;
		var cash = $("#cash").val();
		var gid = $("#gid").val();
		if(cash==0){
			$("#casherror").show();
		}else{
			$("#casherror").hide();
		}
		$("#sure").trigger("click");
		
		valid&=checkName();
		valid&=checkMoney();
		switch($('#payto').val()){
				case "1":
				//充值到平台
					
				break;
				case "0":
					valid&=checkServer();
				break;
		}
		if(valid)
		{
			$(".confirm_btn").hide();
			$(".dazhuan").show();
			switch($('#payto').val()){
				case "1":
				//充值到平台
					valid&=checkPtb();
				break;
				case "0":
					valid&=checkRole();
				break;
			}
		}
		return false;
	});

	$(".money_c > a").live("click",function(){
		$(".money_c > a").removeClass("cur");
		$(".other_a").removeClass("cur");
		$(".other_ipt").val('');
		$(this).addClass("cur");
		$("#cash").val($(this).attr('value'));
		calculateMoney();
		return false;
	});

	$(".other_a").bind("click",function(){
		$("#cash").val(0);
		$(".other_ipt").val('');
		$(this).addClass("cur");
		$(".money_c > a").removeClass("cur");
		$(".other_ipt").focus();
		calculateMoney();
		return false;
	});

	$(".other_ipt").bind("click",function(){
		$(".other_a").trigger("click");
	});

	$(".other_ipt").bind("keyup",function(){
		var input = $(".other_ipt").val();
		if(parseInt(input) != input){
			$(".other_ipt").val('');
		}
		$("#cash").val($(this).val());
		checkMoney();
		calculateMoney();
	});

	$(".bank_c>a").bind("click",function(){
		$(".bank_c>a").removeClass("cur");
		$(this).addClass("cur");
		$("#paybank").val($(this).attr('value'));
		return false;
	});

	$("#sure").bind("click",function(){
		var name=$(".nam_ipt").val();
		if(!name){
			$('#usererror').html('帐号信息不能为空');
			$('#usererror').show();
			return false;
		}
		
		
		$(".account_input").hide();
		$(".account_txt").show();
		$("#payname").html(name);
		$("#g_username").val(name);
		$("#g_reusername").val(name);
	});

	$("#change").bind("click",function(){
		$('#usererror').hide();
		$(".account_input").show();
		$(".account_txt").hide();
		$("#g_username").val('');
		$("#g_reusername").val('');
	});

	$(".close").bind("click",function(){
		$(".pay_pop").hide();
		$("#backpng").hide();
		return false;
	});
	
	$(".pay_pop_sub").bind("click",function(){
        $(".pay_pop").hide();
        if($("#paytype").val()=='wechat')
        wrapshow("#wechat");
        else
		wrapshow("#paysuccess");
		
	});
	
	$("#sure_cardid").bind("click",function(){
		var carid=$("#cardid_ipt").val();
		if(!carid){
			$('#paycardiderror').html('帐号信息不能为空');
			$('#paycardiderror').show();
			return false;
		}
		$("#cardid_input").hide();
		$("#cardid_txt").show();
		$("#paycardid_em").html(carid);
		$("#paycardid").val(carid);
	});
	
	$("#change_cardid").bind("click",function(){
		$('#paycardiderror').hide();
		$("#cardid_input").show();
		$("#cardid_txt").hide();
		$("#paycardid").val('');
	});
	
	$("#sure_cardpass").bind("click",function(){
		var cardpass=$("#cardpass_ipt").val();
		if(!cardpass){
			$('#paycardpasserror').html('帐号信息不能为空');
			$('#paycardpasserror').show();
			return false;
		}
		$("#cardpass_input").hide();
		$("#cardpass_txt").show();
		$("#paycardpass_em").html(cardpass);
		$("#paycardpass").val(cardpass);
	});
	
	$("#change_cardpass").bind("click",function(){
		$('#paycardpasserror').hide();
		$("#cardpass_input").show();
		$("#cardpass_txt").hide();
		$("#paycardpass").val('');
	});
	
	$(".bank_c>a").eq(0).trigger('click');