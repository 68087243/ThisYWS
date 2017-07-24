  $("#re_select").click(function(){
    $("#upload-avatar-file").val("");
      $("#upload-avatar-file").trigger("click");
  })

var Avatarid=0;

function uploadImage(){
  var fileName = $("#upload-avatar-file").val();
  var pos = fileName.lastIndexOf(".");
  var last = fileName.substring(pos+1);
  var allowed = ["png","jpg","gif"];
  var flag = false;
  for(key in allowed){
    if(last == allowed[key]){
       flag = true;
       break;
    }
  }

  if(flag){
    $('#avatar_form').submit();
    $("#file_box").hide();
    $("#file_clik").hide();
    $("#file_uploading").show();
  }else{
    alert("图片格式仅限jpg,png,gif,bmp");
  }
  //限制上传图片大小

}
var jcrop_api;	
	function init_crop(width,height){
		$('#cropbox').Jcrop({
		      // start off with jcrop-light class
		      bgOpacity: 0.5,
		      bgColor: 'white',
		      addClass: 'jcrop-light',
		      aspectRatio:1,
		      onSelect:updateCoords
		    },function(){
		      jcrop_api = this;
		      jcrop_api.setSelect([(width/2)-60, (height/2)-60,(width/2)+60, (height/2)+60]);	
		      jcrop_api.setOptions({ bgFade: true });
		      jcrop_api.ui.selection.addClass('jcrop-selection');
		    });		
	}	

	function upload_avatar(img,width,height){		
		$("#cropbox").attr("src",img);				
		$(".p-avatar").hide();
		$(".crop_box").show();
    $('.p-subbtn').attr('data-type',1);
		if($.browser.msie){
			$('#re_select').hide();
		}
		init_crop(width,height);					
		if(typeof jcrop_api != 'undefined'){
			jcrop_api.setImage(img);	
			jcrop_api.setSelect([(width/2)-60, (height/2)-60,(width/2)+60, (height/2)+60]);			
      		jcrop_api.ui.selection.addClass('jcrop-selection');				
		}
	}

function updateCoords(c)
  {
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
  };

  function checkCoords()
  {
    if (parseInt($('#w').val())) return true;   
    return false;
  };

  $(".p-subbtn").click(function(){    
      var $data_type = $(this).attr('data-type');
      switch($data_type)
      {
        case undefined:
          alert("请选择图片上传");
          break;
        case '1':
          cropboxImage();
          break;
        case '2':
          quickAvatar();
          break;
        default:
          alert('错误参数');
          break;
      }
  });

/**
 * 设置快捷头
 */
$(".p-diyimgs img").click(function(){
  $(".p-diyimgs img").each(function(){
    $(this).attr('data-watiting','');
  });
  $('.p-subbtn').attr('data-type',2);
  $(this).attr('data-watiting','watiting');
  var img = $(this).attr("src");
  $(".p-curimg span").hide();
  $(".p-curimg img").attr("src",img);
});

function cropboxImage()
{
      var w = $("#w").val(),
      h = $("#h").val(),
      x = $("#x").val(),
      y = $("#y").val(),
      img = Avatarid;     
      $.ajax({
        type:"post",
        data:{img:img,w:w,h:h,x:x,y:y},
        //保存头像到uc
        url: U('User/Setavatar/saveAvatar','callback=?'),
        dataType:"jsonp",
        success:function(data){
          if(data.code == 0){
            $(".p-userimg img").attr("src",data.img);
            $(".p-curimg img").attr("src",data.img);
            $(".p-curimg span").show();
            $('.p-subbtn').removeAttr('data-type');
          }else{
            alert("保存头像失败");
          }
        }
      });
}


function quickAvatar()
{
  var $img = $('img[data-watiting="watiting"]'),
  img = $img.attr('imgid');
  
  $.ajax({
        type:"post",
        data:{img:img},
        //保存头像到uc
        url: U('User/Setavatar/saveAvatar','callback=?'),
        dataType:"jsonp",
        success:function(data){
          if(data.code == 0){
            $(".p-userimg img").attr("src",data.img);
            $(".p-curimg img").attr("src",data.img);
            $(".p-curimg span").show();
            $('.p-subbtn').removeAttr('data-type');
          }else{
            alert("保存头像失败");
          }
        }
      });
}