var getHost = function(url) {
    var host = "null";
    if (typeof url == "undefined" || null == url) {
        url = window.location.href
    }
    var regex = /.*\:\/\/([^\/|:]*).*/;
    var match = url.match(regex);
    if (typeof match != "undefined" && null != match) {
        host = match[1]
    }
    if (typeof host != "undefined" && null != host) {
        var strAry = host.split(".");
        if (strAry.length > 1) {
            host = strAry[strAry.length - 2] + "." + strAry[strAry.length - 1]
        }
    }
    return host
};
document.domain = getHost();
var url = U('Api/User/userapi');
$.getJSON(url,
function(e) {
    if (e) {
        var a = e.level,
        n = e.hy,
        s = e.value,
        t = e.packs,
        l = e.games,
        r = e.xlevel;
        0 == a && (n = 1);
        var o = "";
        o = 0 == n ? "lv_g" + a: "lv" + a,
        $(".level_ico").addClass(o),
        $(".lv_ico").addClass("lv_" + r),
        $("#info").html(0 == n && 0 != a ? "恢复特权": "加速成长"),
        $("#valueShow span").html(s),
        $("#packsShow span").html(t),
        $("#gamesShow span").html(l)
    }
}),
"object" == typeof window.parent.webComObj && window.parent.webComObj.isGuest(1),
$("#band_close").click(function() {
    $("#band-tp").remove()
}),
$.ajax({
    type: "GET",
    url: U('Api/User/userplay','callback=?'),
    dataType: "jsonp",
    success: function(e) {
        var a = 0,
        n = "",
        s = [];
        if (e && e.length) {
            for (s = e.slice(0, 2); a < s.length; a++) n += '<a target="_blank" href="' + s[a].url + '"><em>开始游戏<i>&gt;&gt;</i></em><span>' + s[a].s_name + '</span><img src="' + s[a].icon + '" alt="' + s[a].name + '">' + s[a].name + "</a>";
            $(".ser-con").html(n),
            $(".ser-con").height(47)
        } else $(".ser-con").after('<div class="ser_notp"><span>您暂无玩过的游戏，</span><br>不如到<a href="'+U('Game/index/index')+'">游戏中心</a>挑一款</div>')
    },
    error: function() {}
});