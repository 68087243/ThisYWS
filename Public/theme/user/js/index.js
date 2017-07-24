gy_person.playGames = {

        descorGames : [],

        allData : [],//缓存所有数据

        allStr : [],//整理可用后的所有数据

        pnums : 21,//每页分数个数

        p : 0,//总页数

        indexcur_ : 0,//当前页索引

        dateFun : function(dates){

                var playday = new Date(dates),

                    year  = playday.getFullYear(),

                    month  = playday.getMonth(),

                    date  = playday.getDate(),

                    theday = new Date(),

                    tyear  = theday.getFullYear(),

                    tmonth  = theday.getMonth(),

                    tdate  = theday.getDate(),

                    datestr = '',

                    b = new Date(year,month,date),

                    e = new Date(tyear,tmonth,tdate),

                    dif = e.getTime() - b.getTime(),

                    day = Math.floor(dif/(1000 * 60 * 60 * 24));


                switch(true){

                    case day >= 360 :

                                datestr = '1\u5E74\u524D'; 

                            break;

                    case day >= 30 && day < 360:

                            if(day == 30){

                                datestr = '1\u4E2A\u6708\u524D';

                            }else{

                                datestr = parseInt(day/30)+'\u4E2A\u6708\u524D';

                            }
                             
                            break;

                    case day >= 7 && day < 30:

                            if(day == 7){

                                datestr = '1\u5468\u524D';

                            }else{

                                datestr = parseInt(day/7) +'\u5468\u524D';

                            }

                            break;

                    case day > 0 && day < 7:

                            datestr = day + '\u5929\u524D';

                            break;

                    default:

                        datestr = '\u4ECA\u5929';
                }


                return datestr;


        },  

        noneGames : function(){
                $.getJSON(U('Api/Game/RecGames','callback=?'),'',function(data){
                    if(data)
                    {
                        var str = '<div class="p-playnone"><p>您暂时还没有玩过的游戏哦，10万款游戏等你去发掘哦~</p><div class="p-pngame">';
                        for(var i in data)
                        {
                            str += '<a href="'+data[i].url+'" target="_blank"><img src="'+data[i].img+'" alt="'+data[i].name+'"></a>';
                        }
                        str += '</div></div>';
                        $('#myplaybox').html(str);
                    }
                });
        },

        hasGames : function(){

                var gp = gy_person.playGames,

                    data = gp.allData,

                    hsnum = data.length,

                    hscontent = [];

                if(!hsnum){

                    gp.noneGames();

                    $('#myplaynums').html('').removeAttr('title');

                    return;

                }

                for(var i = 0; i < hsnum; i++){


                            if(typeof data[i].gname == 'undefined' || data[i].gname == ''){

                                    continue;
                            }


                            var datestr = gp.dateFun(data[i].play_time*1000);

                            if(data[i].isWebGame){

                                hscontent.push('<li><a href="'+data[i].glink+'" class="tmya" target="_blank"><img src="'+data[i].gpic+'" alt="'+data[i].gname+'">'+data[i].gname+'<i class="bgrgb">'+datestr+'\u73A9\u8FC7</i></a><a href="'+data[i].server_url+'" class="fico" target="_blank">'+data[i].sid+'\u670D</a>' );


                            }else{

                                hscontent.push('<li><a href="'+data[i].glink+'" class="tmya" target="_blank"><img src="'+data[i].gpic+'" alt="'+data[i].gname+'">'+data[i].gname+'<i class="bgrgb">'+datestr+'\u73A9\u8FC7</i></a><i class="dele" title="\u5220\u9664" v="'+data[i].gid+'"></i>');
                            }
                }

                gp.allStr = hscontent;

                var allnums = gp.allStr.length,

                    playbox = $('#myplaybox'),

                    playul = playbox.find('ul'),

                    others = '';

                gp.p = Math.ceil(allnums/gp.pnums);


                $('#myplaynums').html('('+ allnums +')').attr('title','我玩过的游戏共有'+ allnums +'条');


                      //  if( !$("#clearmyplay").length ){
                            //$('#myplaynums').after('<span class="clearplay" id="clearmyplay">清空</span>');
                     //   }
                        
                

                if(gp.p > 1){


                        playul.html(gp.allStr.slice(0,gp.pnums).join(""));

                        for(var i = 2;i <= gp.p;i++){

                            others += '<a href="#" target="_self">'+ i +'</a>';

                        }

                        //<div class="pages"><a href="#" class="prevs">&lt;</a><a href="#" class="cur">1</a><a href="#">2</a><a href="#">3</a><a href="#">4</a><a href="#">5</a><a href="#">6</a><a href="#">7</a><a href="#">8</a><span>...</span><a href="#">25</a><a href="#" class="nexts">&gt;</a></div>

                        playbox.append('<div class="pages"><a href="#" class="cur" target="_self">1</a>'+ others +'</div>');


                }else{


                        if(allnums < 21){

                               

                                    i = 0;
								var _length=21 - allnums;
								var descorGameslength=gy_person.playGames.descorGames.length;
								if(_length > descorGameslength){
									var len = descorGameslength;
								}else{
									var len = _length;
								}
                                for(;i < len;i++){
									
                                    gp.allStr.push("<li><a  target='_blank' class='tmya' href='"+gp.descorGames[i][0]+"'><img alt='"+gp.descorGames[i][1]+"' src='"+gp.descorGames[i][2]+"'>"+gp.descorGames[i][1]+"<i class='ticos'></i></a>");
                                }
                        }

                        playul.html(gp.allStr.slice(0).join(""));

                        playbox.append('<div class="pages"><a href="#" class="cur" target="_self">1</a></div>');

                }

                

               
        },

        showGames : function(){

                    gy_person.MyplayedAPI.getPlayedList(gy_person.isUserId,function(data){
                            
                            var gp = gy_person.playGames;

                            gp.allData = data.data;

                            if(!gp.allData.length){

                                gp.noneGames();

                                return;

                            }else{

                                gp.hasGames();

                            }
                    });
        },

        getDatas : function(){

                            var gp = gy_person.playGames;

                            if(gp.indexcur_  >= gp.p)  gp.indexcur_ = gp.p - 1;

                            var curindex = gp.indexcur_ * gp.pnums,

                                alls = gp.allStr.length,

                                curall = curindex + gp.pnums,

                                myplaybox = $('#myplaybox'),

                                uls = myplaybox.find('ul');

                            myplaybox.find('.pages a').eq(gp.indexcur_).addClass('cur').siblings().removeClass('cur');

                            if(curall >= alls){

                                uls.html(gp.allStr.slice(curindex).join(""));

                            }else{

                                uls.html(gp.allStr.slice(curindex,curindex + gp.pnums).join(""));

                            }
        },



        init : function(){
					
                    var gp = gy_person.playGames,

                        myplaybox = $('#myplaybox');


                    gp.showGames();


                   myplaybox.delegate('.pages a','click',function(){

                           
                            gp.indexcur_ = $(this).index();

                            gp.getDatas();
                            return false;

                                      
                    }).delegate('.dele','click',function(){

                            var thens = $(this),

                                gid = thens.attr("v");

                            thens.parent().remove();

                            myplaybox.find('.pages').remove();

                            gy_person.MyplayedAPI.deletePlayedGame(gy_person.isUserId,gid,function(){

                                    var len = gp.allData.length,

                                        i = 0;

                                    for(;i < len;i++){

                                        if(!gp.allData[i]) continue;
                                      
                                        if(gp.allData[i].gid == gid){

                                            gp.allData.splice(i,1);
                                        }

                                    }
                                    gp.hasGames();
                                    gp.getDatas();
                                    //我玩过
                                    var favn = 0;
                                    var favnums = $('#myfavnums').text();
                                    if(favnums)
                                    {
                                       var re =  /\d+/g;
                                       favn = favnums.match(re);
                                    }
                                    $('i.p-nums').text(len-1 + parseInt(favn));
                            });

                    });



                    $(document).delegate("#clearmyplay","click",function(){
                    
                            gy_person.oppWrap.popShow("清空提示",'<div class="ctipfont_more">您确定要清空<span>我玩过的记录</span>吗？<br>为了您帐号安全，游戏记录中的网页游戏不会被清空</div><div class="cleartb"><span id="playctent" class="p-subbtn">清空</span><span id="ctclear" class="p-gay">取消</span></div>',"p-ah160");

                    }).delegate(".p-alertclose","click",function(){

                            gy_person.oppWrap.popHidden();

                    }).delegate("#ctclear","click",function(){

                            gy_person.oppWrap.popHidden();

                    }).delegate("#playctent","click",function(){

                            gy_person.MyplayedAPI.deletePlayedGame(gy_person.isUserId,0,function(){

                                    //gp.noneGames();
                                    myplaybox.find('.pages').remove();
                                    gy_person.playGames.init();//我玩过的游戏

                                    gy_person.oppWrap.popHidden();

                                    $("#clearmyplay").remove();
                                    $('#myplaynums').html('').removeAttr('title');
                                    
                            });

                    });
        }


};




gy_person.favGames = {

        allData : [],//缓存所有数据

        allStr : [],//整理可用后的所有数据

        pnums : 21,//每页分数个数

        p : 0,//总页数

        indexcur_ : 0,//当前页索引
		noneGamesarr : [],
        noneGames : function(){
					var gp=gy_person.favGames.noneGamesarr;
                    if(gp)
                    {
                        var str = "<div class='p-playnone'><p>您还没有收藏过游戏哦，遇到喜欢的游戏一键添加到收藏，不再错过精彩~</p><div class='p-pnsgame'>";
                        for(var i in gp)
                        {
                            str += "<a href='"+gp[i].url+"' target='_blank'><img alt='"+gp[i].title+"' src='"+gp[i].pic+"'>"+gp[i].title+"</a>";
                        }
                        str += "</div>";
                        $('#myfavbox').html(str);
                    }
        },

        hasGames : function(){

                var gf = gy_person.favGames,

                    hscontent = [],

                    data = gf.allData,

                    hsnum = data.length;

                if(!hsnum){

                    gf.noneGames();

                    $('#myfavnums').html('').removeAttr('title');

                    return;

                }


                for(var i = 0; i < hsnum; i++){

                                hscontent.push('<li><a href="'+data[i].link+'" class="tmya" target="_blank"><img alt="'+data[i].title+'" src="'+data[i].pic+'">'+data[i].title+'</a><i v="'+data[i].gid+'" title="删除" class="dele"></i>');

                }

                gf.allStr = hscontent;


                var allnums = gf.allStr.length,

                    playbox = $('#myfavbox'),

                    playul = playbox.find('ul'),

                    others = '';

                gf.p = Math.ceil(allnums/gf.pnums),

                $('#myfavnums').html('('+ allnums +')').attr('title','我收藏的游戏共有'+ allnums +'条');
                   if(allnums){
                        $('#myfavnums').after('<span class="clearplay" id="clearmyfav">清空</span>');
                  }
                

                if(gf.p > 1){


                        playul.html(gf.allStr.slice(0,gf.pnums).join(""));

                        for(var i = 2;i <= gf.p;i++){

                            others += '<a href="#" target="_self">'+ i +'</a>';

                        }

                        //<div class="pages"><a href="#" class="prevs">&lt;</a><a href="#" class="cur">1</a><a href="#">2</a><a href="#">3</a><a href="#">4</a><a href="#">5</a><a href="#">6</a><a href="#">7</a><a href="#">8</a><span>...</span><a href="#">25</a><a href="#" class="nexts">&gt;</a></div>

                        playbox.append('<div class="pages"><a href="#" class="cur" target="_self">1</a>'+ others +'</div>');


                }else{

                        playul.html(gf.allStr.join(""));

                        playbox.append('<div class="pages"><a href="#" class="cur" target="_self">1</a></div>');

                }

                

               
        },

        showGames : function(){

                    gy_person.MyplayedAPI.getAllFavorite(gy_person.isUserId,function(data){
                            
                            var gf = gy_person.favGames;

                            gf.allData = data.data;

                            //gf.allData.reverse();

                            if(!gf.allData.length){

                                gf.noneGames();

                                return;

                            }else{

                                gf.hasGames();

                            }

                    });

                   
        },

        getDatas : function(){

                            var gf = gy_person.favGames;

                            if(gf.indexcur_  >= gf.p)  gf.indexcur_ = gf.p - 1;

                            var curindex = gf.indexcur_ * gf.pnums,

                                alls = gf.allStr.length,

                                curall = curindex + gf.pnums,

                                myfavbox = $('#myfavbox'),

                                uls = myfavbox.find('ul');

                            myfavbox.find('.pages a').eq(gf.indexcur_).addClass('cur').siblings().removeClass('cur');

                            if(curall >= alls){

                                uls.html(gf.allStr.slice(curindex).join(""));

                            }else{

                                uls.html(gf.allStr.slice(curindex,curindex + gf.pnums).join(""));

                            }
        },
        BBsData : function(){
                    var url = U('Api/Forum/GetHot','callback=?');
                    $.getJSON(url,function(data){
                          if(data)
                          {   
                            var bbsObj =  $('.p-bbslist');  
                            var str = "";
                            for(var i in data)
                            {
                               str += '<li><a href = "'+data[i]['url']+'" target="_blank">'+data[i]['info']+'</a></li>';
                            }
                               bbsObj.html(str);
                            }
                        });
                  },
        init : function(){

					
                    var gf = gy_person.favGames,

                        myfavbox = $('#myfavbox');

//                    gf.BBsData();
                    gf.showGames();


                    myfavbox.delegate('.pages a','click',function(){

                            gf.indexcur_ = $(this).index();

                            gf.getDatas();

                            return false;
                                      
                    }).delegate('.dele','click',function(){
                            //收藏删除
                            var thens = $(this),

                                gid = thens.attr("v");

                            thens.parent().remove();

                            myfavbox.find('.pages').remove();

                            gy_person.MyplayedAPI.delFavorite(gy_person.isUserId,gid,function(){

                                    var len = gf.allData.length,

                                        i = 0;



                                    for(;i < len;i++){

                                        if(!gf.allData[i]) continue;
                                      
                                        if(gf.allData[i].gid == gid){

                                            gf.allData.splice(i,1);
                                        }

                                    }


                                    gf.hasGames();

                                    gf.getDatas();
                                    //我玩过
                                    var _playNums = 0;
                                    var playNums = $('#myplaynums').text();
                                    if(playNums)
                                    {
                                       var re =  /\d+/g;
                                       _playNums = playNums.match(re);
                                    }
                                    $('i.p-nums').text(len-1 + parseInt(_playNums));
                            });

                    });


                    $(document).delegate("#clearmyfav","click",function(){
                            //清空
                            gy_person.oppWrap.popShow("清空提示",'<div class="ctipfont">您确定要清空<span>我收藏的记录</span>吗？</div><div class="cleartb"><span id="favctent" class="p-subbtn">清空</span><span id="ctclear" class="p-gay">取消</span></div>',"p-ah160");

                    }).delegate("#favctent","click",function(){

                            gy_person.MyplayedAPI.delAllFavorite(gy_person.isUserId,function(){

                                    gf.noneGames();

                                    gy_person.oppWrap.popHidden();

                                    $("#clearmyfav").remove();
                                    $('#myfavnums').html('').removeAttr('title');
                                    
                            });

                    });


        }


};





gy_person.Login.isLogin(function(data){
        if(data.isGuest == 0){//登录后操作方法
                gy_person.isUserId = data.id;
				$.getJSON(U('Api/game/gameRecommend','callback=?'),'',function(data){
					var gameplay=data.gameplay;
						if(gameplay)
						{
							var gameplay_arr=gy_person.playGames.descorGames;
							for(var i in gameplay)
							{
								gameplay_arr.push(Array(gameplay[i].url,gameplay[i].title,gameplay[i].pic));
							}
						}
					var collects=data.collects;
						if(collects.length!=0 && collects!="")
						{
							var collects_arr=gy_person.favGames.noneGamesarr;
							for(var i in collects)
							{
								collects_arr.push(collects[i]);
							}
						}
					});
                gy_person.playGames.init();//我玩过的游戏
                gy_person.favGames.init();//我收藏的游戏
        }
        gy_person.favGames.BBsData();
});