! function(i) { "use strict"; var t = function() { this.$body = i("body"), this.$window = i(window) };
    t.prototype.initMenu = function() { var e = this;
        i(".side_panel_toggle").on("click", function(t) { t.preventDefault(), e.$body.toggleClass("enlarged"), i(".slimscroll-menu").slimscroll({ height: "auto", position: "right", size: "8px", color: "#9ea5ab", wheelStep: 5, touchScrollStep: 50 }) }), i(".navbar-toggle").on("click", function(t) { i(this).toggleClass("open") }), i("#side-menu").metisMenu(), i(".slimscroll-menu").slimscroll({ height: "auto", position: "right", size: "8px", color: "#9ea5ab", wheelStep: 5, touchScrollStep: 50 }), i(".right-bar-toggle").on("click", function(t) { i("body").toggleClass("right-bar-enabled") }), i(document).on("click", "body", function(t) { 0 < i(t.target).closest(".right-bar-toggle, .right-bar").length || i("body").removeClass("right-bar-enabled") }), i("#sidebar-menu a").each(function() { var t = window.location.href.split(/[?#]/)[0];
            this.href == t && (i(this).addClass("active"), i(this).parent().addClass("active"), i(this).parent().parent().addClass("in"), i(this).parent().parent().prev().addClass("active"), i(this).parent().parent().parent().addClass("active"), i(this).parent().parent().parent().parent().addClass("in"), i(this).parent().parent().parent().parent().parent().addClass("active")) }) }, t.prototype.initLayout = function() { var t = this;
        t.$window.width() < 1025 ? t.$body.addClass("enlarged") : 1 != t.$body.data("keep-enlarged") && t.$body.removeClass("enlarged") }, t.prototype.init = function() { var e = this;
        this.initLayout(), this.initMenu(), this.$window.on("resize", function(t) { t.preventDefault(), e.initLayout() }) }, i.App = new t, i.App.Constructor = t }(window.jQuery),
function(t) { "use strict";
    window.jQuery.App.init() }();