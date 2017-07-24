(function(e, d, a, b, f) {
    var c = function() {
        return {
            "init":function() {
                this.navTab();
            },
            "navTab":function(o) {
                var k = d(".navtitle li"), l = d(".infonavcon"), n = 300, g = "click", m = "", h = d(".list"), j = 100;
                k.parent().find("li:eq(" + 1 + ") a").addClass(m);
                l.hide();
                l.eq(0).show();
                k.die().live(g, function() {
                    var s = d(this);
                    var r = s.index();
                    var p = h.width();
                    var q = r * p;
                    k.find("a").removeClass(m);
                    s.find("a").addClass(m);
                    l.hide();
                    l.eq(r).fadeIn(n);
                    h.animate({
                        "left":q + "px"
                    }, j);
                });
            }
        };
    }();
    d(function() {
        c.init();
    });
})(this, jQuery || {});