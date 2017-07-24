var turl=window.location.href;


	
var str;
function callWrap(){
  //window.parent.login_hide();

  if(typeof window.parent.login_hide == 'function'){

    window.parent.login_hide();

  }else{

    window.parent.parent.login_hide();

  }

}

function closeWrap(){


        // if(typeof window.parent.close_hide == 'function'){
        //       window.parent.close_hide();
        // }else{
        //       window.parent.login_hide();
        // }

        if(typeof window.parent.close_hide == 'function'){

            window.parent.close_hide();

            return;

        }

        if(typeof window.parent.parent.close_hide == 'function'){

            window.parent.parent.close_hide();

            return;

        }



            //window.parent.parent.close_hide();

       if(typeof window.parent.login_hide == 'function'){

          window.parent.login_hide();

          return;

        }


        if(typeof window.parent.parent.login_hide == 'function'){

          window.parent.parent.login_hide();

          return;

        }
        


}

$("#lr_colseid").click(function(){
    closeWrap();
});


$(".lr_qqbtn").click(function(){

      var src = $(this).attr('href'),
          divs = $("#lr_conone>div");

      $("#qq_logins").attr("src",src);

      divs.hide();

      divs.eq(2).show();

      return false;
});