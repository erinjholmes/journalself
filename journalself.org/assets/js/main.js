! function(d, s, e) {
    function i(e, t) {
        this.element = e, this.settings = d.extend({}, n, t), this.settings.duplicate || t.hasOwnProperty("removeIds") || (this.settings.removeIds = !1), this._defaults = n, this._name = o, this.init()
    }
    var n = {
            label: "MENU",
            duplicate: !0,
            duration: 200,
            easingOpen: "swing",
            easingClose: "swing",
            closedSymbol: "&#9658;",
            openedSymbol: "&#9660;",
            prependTo: "body",
            appendTo: "",
            parentTag: "a",
            closeOnClick: !1,
            allowParentLinks: !1,
            nestedParentLinks: !0,
            showChildren: !1,
            removeIds: !0,
            removeClasses: !1,
            removeStyles: !1,
            brand: "",
            animations: "jquery",
            init: function() {},
            beforeOpen: function() {},
            beforeClose: function() {},
            afterOpen: function() {},
            afterClose: function() {}
        },
        o = "slicknav",
        u = "slicknav",
        c = 40,
        p = 13,
        m = 27,
        h = 37,
        v = 39,
        f = 32,
        _ = 38;
    i.prototype.init = function() {
        var e, t, l = this,
            n = d(this.element),
            r = this.settings;
        if (r.duplicate ? l.mobileNav = n.clone() : l.mobileNav = n, r.removeIds && (l.mobileNav.removeAttr("id"), l.mobileNav.find("*").each(function(e, t) {
                d(t).removeAttr("id")
            })), r.removeClasses && (l.mobileNav.removeAttr("class"), l.mobileNav.find("*").each(function(e, t) {
                d(t).removeAttr("class")
            })), r.removeStyles && (l.mobileNav.removeAttr("style"), l.mobileNav.find("*").each(function(e, t) {
                d(t).removeAttr("style")
            })), e = u + "_icon", "" === r.label && (e += " " + u + "_no-text"), "a" == r.parentTag && (r.parentTag = 'a href="#"'), l.mobileNav.attr("class", u + "_nav"), t = d('<div class="' + u + '_menu"></div>'), "" !== r.brand) {
            var a = d('<div class="' + u + '_brand">' + r.brand + "</div>");
            d(t).append(a)
        }
        l.btn = d(["<" + r.parentTag + ' aria-haspopup="true" role="button" tabindex="0" class="' + u + "_btn " + u + '_collapsed">', '<span class="' + u + '_menutxt">' + r.label + "</span>", '<span class="' + e + '">', '<span class="' + u + '_icon-bar"></span>', '<span class="' + u + '_icon-bar"></span>', '<span class="' + u + '_icon-bar"></span>', "</span>", "</" + r.parentTag + ">"].join("")), d(t).append(l.btn), "" !== r.appendTo ? d(r.appendTo).append(t) : d(r.prependTo).prepend(t), t.append(l.mobileNav);
        var i = l.mobileNav.find("li");
        d(i).each(function() {
            var e = d(this),
                t = {};
            if (t.children = e.children("ul").attr("role", "menu"), e.data("menu", t), 0 < t.children.length) {
                var n = e.contents(),
                    a = !1,
                    i = [];
                d(n).each(function() {
                    return !d(this).is("ul") && (i.push(this), void(d(this).is("a") && (a = !0)))
                });
                var s = d("<" + r.parentTag + ' role="menuitem" aria-haspopup="true" tabindex="-1" class="' + u + '_item"/>');
                if (r.allowParentLinks && !r.nestedParentLinks && a) d(i).wrapAll('<span class="' + u + "_parent-link " + u + '_row"/>').parent();
                else d(i).wrapAll(s).parent().addClass(u + "_row");
                r.showChildren ? e.addClass(u + "_open") : e.addClass(u + "_collapsed"), e.addClass(u + "_parent");
                var o = d('<span class="' + u + '_arrow">' + (r.showChildren ? r.openedSymbol : r.closedSymbol) + "</span>");
                r.allowParentLinks && !r.nestedParentLinks && a && (o = o.wrap(s).parent()), d(i).last().after(o)
            } else 0 === e.children().length && e.addClass(u + "_txtnode");
            e.children("a").attr("role", "menuitem").click(function(e) {
                r.closeOnClick && !d(e.target).parent().closest("li").hasClass(u + "_parent") && d(l.btn).click()
            }), r.closeOnClick && r.allowParentLinks && (e.children("a").children("a").click(function(e) {
                d(l.btn).click()
            }), e.find("." + u + "_parent-link a:not(." + u + "_item)").click(function(e) {
                d(l.btn).click()
            }))
        }), d(i).each(function() {
            var e = d(this).data("menu");
            r.showChildren || l._visibilityToggle(e.children, null, !1, null, !0)
        }), l._visibilityToggle(l.mobileNav, null, !1, "init", !0), l.mobileNav.attr("role", "menu"), d(s).mousedown(function() {
            l._outlines(!1)
        }), d(s).keyup(function() {
            l._outlines(!0)
        }), d(l.btn).click(function(e) {
            e.preventDefault(), l._menuToggle()
        }), l.mobileNav.on("click", "." + u + "_item", function(e) {
            e.preventDefault(), l._itemClick(d(this))
        }), d(l.btn).keydown(function(e) {
            var t = e || event;
            switch (t.keyCode) {
                case p:
                case f:
                case c:
                    e.preventDefault(), t.keyCode === c && d(l.btn).hasClass(u + "_open") || l._menuToggle(), d(l.btn).next().find('[role="menuitem"]').first().focus()
            }
        }), l.mobileNav.on("keydown", "." + u + "_item", function(e) {
            switch ((e || event).keyCode) {
                case p:
                    e.preventDefault(), l._itemClick(d(e.target));
                    break;
                case v:
                    e.preventDefault(), d(e.target).parent().hasClass(u + "_collapsed") && l._itemClick(d(e.target)), d(e.target).next().find('[role="menuitem"]').first().focus()
            }
        }), l.mobileNav.on("keydown", '[role="menuitem"]', function(e) {
            switch ((e || event).keyCode) {
                case c:
                    e.preventDefault();
                    var t = (a = (n = d(e.target).parent().parent().children().children('[role="menuitem"]:visible')).index(e.target)) + 1;
                    n.length <= t && (t = 0), n.eq(t).focus();
                    break;
                case _:
                    e.preventDefault();
                    var n, a = (n = d(e.target).parent().parent().children().children('[role="menuitem"]:visible')).index(e.target);
                    n.eq(a - 1).focus();
                    break;
                case h:
                    if (e.preventDefault(), d(e.target).parent().parent().parent().hasClass(u + "_open")) {
                        var i = d(e.target).parent().parent().prev();
                        i.focus(), l._itemClick(i)
                    } else d(e.target).parent().parent().hasClass(u + "_nav") && (l._menuToggle(), d(l.btn).focus());
                    break;
                case m:
                    e.preventDefault(), l._menuToggle(), d(l.btn).focus()
            }
        }), r.allowParentLinks && r.nestedParentLinks && d("." + u + "_item a").click(function(e) {
            e.stopImmediatePropagation()
        })
    }, i.prototype._menuToggle = function(e) {
        var t = this,
            n = t.btn,
            a = t.mobileNav;
        n.hasClass(u + "_collapsed") ? (n.removeClass(u + "_collapsed"), n.addClass(u + "_open")) : (n.removeClass(u + "_open"), n.addClass(u + "_collapsed")), n.addClass(u + "_animating"), t._visibilityToggle(a, n.parent(), !0, n)
    }, i.prototype._itemClick = function(e) {
        var t = this.settings,
            n = e.data("menu");
        n || ((n = {}).arrow = e.children("." + u + "_arrow"), n.ul = e.next("ul"), n.parent = e.parent(), n.parent.hasClass(u + "_parent-link") && (n.parent = e.parent().parent(), n.ul = e.parent().next("ul")), e.data("menu", n)), n.parent.hasClass(u + "_collapsed") ? (n.arrow.html(t.openedSymbol), n.parent.removeClass(u + "_collapsed"), n.parent.addClass(u + "_open")) : (n.arrow.html(t.closedSymbol), n.parent.addClass(u + "_collapsed"), n.parent.removeClass(u + "_open")), n.parent.addClass(u + "_animating"), this._visibilityToggle(n.ul, n.parent, !0, e)
    }, i.prototype._visibilityToggle = function(n, e, t, a, i) {
        function s(e, t) {
            d(e).removeClass(u + "_animating"), d(t).removeClass(u + "_animating"), i || r.afterOpen(e)
        }

        function o(e, t) {
            n.attr("aria-hidden", "true"), c.attr("tabindex", "-1"), l._setVisAttr(n, !0), n.hide(), d(e).removeClass(u + "_animating"), d(t).removeClass(u + "_animating"), i ? "init" == e && r.init() : r.afterClose(e)
        }
        var l = this,
            r = l.settings,
            c = l._getActionItems(n),
            p = 0;
        t && (p = r.duration), n.hasClass(u + "_hidden") ? (n.removeClass(u + "_hidden"), i || r.beforeOpen(a), "jquery" === r.animations ? n.stop(!0, !0).slideDown(p, r.easingOpen, function() {
            s(a, e)
        }) : "velocity" === r.animations && n.velocity("finish").velocity("slideDown", {
            duration: p,
            easing: r.easingOpen,
            complete: function() {
                s(a, e)
            }
        }), n.attr("aria-hidden", "false"), c.attr("tabindex", "0"), l._setVisAttr(n, !1)) : (n.addClass(u + "_hidden"), i || r.beforeClose(a), "jquery" === r.animations ? n.stop(!0, !0).slideUp(p, this.settings.easingClose, function() {
            o(a, e)
        }) : "velocity" === r.animations && n.velocity("finish").velocity("slideUp", {
            duration: p,
            easing: r.easingClose,
            complete: function() {
                o(a, e)
            }
        }))
    }, i.prototype._setVisAttr = function(e, t) {
        var n = this,
            a = e.children("li").children("ul").not("." + u + "_hidden");
        t ? a.each(function() {
            var e = d(this);
            e.attr("aria-hidden", "true"), n._getActionItems(e).attr("tabindex", "-1"), n._setVisAttr(e, t)
        }) : a.each(function() {
            var e = d(this);
            e.attr("aria-hidden", "false"), n._getActionItems(e).attr("tabindex", "0"), n._setVisAttr(e, t)
        })
    }, i.prototype._getActionItems = function(e) {
        var t = e.data("menu");
        if (!t) {
            t = {};
            var n = e.children("li"),
                a = n.find("a");
            t.links = a.add(n.find("." + u + "_item")), e.data("menu", t)
        }
        return t.links
    }, i.prototype._outlines = function(e) {
        e ? d("." + u + "_item, ." + u + "_btn").css("outline", "") : d("." + u + "_item, ." + u + "_btn").css("outline", "none")
    }, i.prototype.toggle = function() {
        this._menuToggle()
    }, i.prototype.open = function() {
        this.btn.hasClass(u + "_collapsed") && this._menuToggle()
    }, i.prototype.close = function() {
        this.btn.hasClass(u + "_open") && this._menuToggle()
    }, d.fn[o] = function(t) {
        var n, a = arguments;
        return void 0 === t || "object" == typeof t ? this.each(function() {
            d.data(this, "plugin_" + o) || d.data(this, "plugin_" + o, new i(this, t))
        }) : "string" == typeof t && "_" !== t[0] && "init" !== t ? (this.each(function() {
            var e = d.data(this, "plugin_" + o);
            e instanceof i && "function" == typeof e[t] && (n = e[t].apply(e, Array.prototype.slice.call(a, 1)))
        }), void 0 !== n ? n : this) : void 0
    }
}(jQuery, document, window);

var html = $("html");

function offCanvas() {
    var e = jQuery(".burger"),
        a = jQuery(".canvas-close");
    jQuery(".nav-list").slicknav({
        label: "",
        prependTo: ".mobile-menu"
    }), e.on("click", function() {
        html.toggleClass("canvas-opened"), html.addClass("canvas-visible"), dimmer("open", "medium")
    }), a.on("click", function() {
        html.hasClass("canvas-opened") && (html.removeClass("canvas-opened"), dimmer("close", "medium"))
    }), jQuery(".dimmer").on("click", function() {
        html.hasClass("canvas-opened") && (html.removeClass("canvas-opened"), dimmer("close", "medium"))
    }), jQuery(document).keyup(function(e) {
        27 == e.keyCode && html.hasClass("canvas-opened") && (html.removeClass("canvas-opened"), dimmer("close", "medium"))
    })
}


function dimmer(e, a) {
    "use strict";
    var t = jQuery(".dimmer");
    switch (e) {
        case "open":
            t.fadeIn(a);
            break;
        case "close":
            t.fadeOut(a)
    }
}
$(function() {
    offCanvas()
});
