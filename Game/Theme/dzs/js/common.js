function hd_Pop() {
    $("#all_a").mouseover(function() {
        $("#hd_pop").show()
    }),
        $("#hd_pop").mouseover(function() {
            $("#hd_pop").show()
        }),
        $("#all_a").mouseout(function() {
            $("#hd_pop").hide()
        }),
        $("#hd_pop").mouseout(function() {
            $("#hd_pop").hide()
        })
}
var focusFun = function(n) {
    var o = $(n),
        i = o.find("li"),
        e = o.find("i"),
        s = i.length - 1,
        t = 5e3,
        u = 0,
        c = 0,
        d = function() {
            i.eq(u).stop().animate({
                    opacity: "hide",
                    "z-index": 0
                },
                500,
                function() {
                    $(this).hide()
                }),
                i.eq(c).stop().animate({
                        opacity: "show",
                        "z-index": 1
                    },
                    500,
                    function() {
                        $(this).show()
                    }),
                e.eq(c).addClass("cur").siblings().removeClass("cur")
        },
        h = function() {
            c = c == s ? 0 : ++c,
                u = c ? c - 1 : s,
                d()
        },
        a = {
            handl: null
        };
    a.handl = setInterval(h, t),
        i.hide().css("z-index", 0),
        i.eq(0).show().css("z-index", 1),
        o.hover(function() {
                clearInterval(a.handl)
            },
            function() {
                a.handl = setInterval(h, t)
            }),
        e.click(function() {
            var n = $(this).index();
            i.hide().css("z-index", 0),
                u = n ? n - 1 : s,
                c = n,
                d()
        })
};
focusFun("#w-focus"),
    focusFun("#w-focusimg"),
    hd_Pop();