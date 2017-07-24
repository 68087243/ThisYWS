function popHidden() {
    $(".kfpopbox,.kfpopbg").remove()
}
$(document).delegate("body", "click",
function(s) {
    var e = $(s.target);
    0 == e.closest("#selbtn,#selsubs,#_selbtn,#_selsubs").length && ($("#selbtn").removeAttr("v"), $("#selsubs").hide(), $("#_selbtn").removeAttr("v"), $("#_selsubs").hide()),
    s.stopPropagation()
}).delegate("#kflogtab li", "click",
function() {
    var s = $(this).index(),
    e = "cur";
    $(this).addClass(e).siblings().removeClass(e),
    $("#kflogcon>ul").eq(s).show().siblings().hide()
}).delegate("#selbtn", "click",
function() {
    var s = $(this),
    e = $("#selsubs");
    s.attr("v") ? (e.hide(), s.removeAttr("v")) : (e.show(), s.attr("v", 1))
}).delegate("#selsubs i", "click",
function() {
    $("#selecteds").text($(this).text()),
    $("#selbtn").removeAttr("v"),
    $("#selsubs").hide()
}).delegate("#_selbtn", "click",
function() {
    var s = $(this),
    e = $("#_selsubs");
    s.attr("v") ? (e.hide(), s.removeAttr("v")) : (e.show(), s.attr("v", 1))
}).delegate("#_selsubs i", "click",
function() {
    $("#_selecteds").text($(this).text()),
    $("#_selbtn").removeAttr("v"),
    $("#_selsubs").hide()
}).delegate(".kfreqtab  li", "click",
function() {
    var s = $(this).index(),
    e = "cur";
    $(this).addClass(e).siblings().removeClass(e),
    $(".kfreqlist > div").eq(s).show().siblings().hide()
}).delegate(".kfpopcol,#noss,#endinput", "click",
function() {
    popHidden()
}).delegate(".fmtabtit li", "click",
function() {
    var s = $(this).index(),
    e = "cur",
    t = $(".fmtabcon > div");
    $(this).addClass(e).siblings().removeClass(e),
    t.eq(s).show().siblings().hide()
}).delegate(".requreturn", "click",
function() {
    var s = $(this).attr("href");
    return $("body").append('<div class="kfpopbox"><div class="kfpoptit"><h4>温馨提示</h4><span class="kfpopcol"></span></div><div class="kfpopcons"><i class="kfenic01"></i><p>若您对申诉结果有疑问，您可以在线联系客服</p></div><div class="kfpopb"><span id="noss" class="kfenter">不联系了</span><a href="' + s + '" class="kfcont">立即联系</a></div></div><div class="kfpopbg" style="height:' + document.body.offsetHeight + 'px"></div>'),
    !1
}),
$(function() {
    var s = $(".level"),
    e = $("#levebox"),
    t = s.find("i"),
    i = +s.attr("v"),
    l = "cur",
    n = ["", "1分&nbsp;失望", "2分&nbsp;不满", "3分&nbsp;一般", "4分&nbsp;满意", "5分&nbsp;惊喜"],
    a = null,
    o = function() {
        i && (a = t.eq(i - 1), t.removeClass(l), a.addClass(l), a.prevAll().addClass(l), e.html('<span class="revgrade">' + n[i] + "</span>"))
    };
    o(),
    t.bind("mouseover",
    function() {
        {
            var s = $(this).index();
            $(this).parent()
        }
        t.removeClass(l),
        $(this).addClass(l),
        $(this).prevAll().addClass(l),
        e.html('<span class="revgrade">' + n[s + 1] + "</span>")
    }),
    t.bind("mouseout",
    function() {
        o()
    }),
    t.bind("click",
    function() {
        var s = $(this).index(),
        e = $(this).parent(); ++s,
        t.unbind().css("cursor", "auto"),
        e.attr("v", s)
    })
});