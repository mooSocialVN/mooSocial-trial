/*! jQuery UI - v1.10.4 - 2014-01-17
 * http://jqueryui.com
 * Copyright 2014 jQuery Foundation and other contributors; Licensed MIT */
(function (e) {
    var t = !1;
    e(document).mouseup(function () {
        t = !1
    }), e.widget("ui.mouse", {
        version: "1.10.4",
        options: {cancel: "input,textarea,button,select,option", distance: 1, delay: 0},
        _mouseInit: function () {
            var t = this;
            this.element.bind("mousedown." + this.widgetName, function (e) {
                return t._mouseDown(e)
            }).bind("click." + this.widgetName, function (i) {
                return !0 === e.data(i.target, t.widgetName + ".preventClickEvent") ? (e.removeData(i.target, t.widgetName + ".preventClickEvent"), i.stopImmediatePropagation(), !1) : undefined
            }), this.started = !1
        },
        _mouseDestroy: function () {
            this.element.unbind("." + this.widgetName), this._mouseMoveDelegate && e(document).unbind("mousemove." + this.widgetName, this._mouseMoveDelegate).unbind("mouseup." + this.widgetName, this._mouseUpDelegate)
        },
        _mouseDown: function (i) {
            if (!t) {
                this._mouseStarted && this._mouseUp(i), this._mouseDownEvent = i;
                var s = this, n = 1 === i.which, a = "string" == typeof this.options.cancel && i.target.nodeName ? e(i.target).closest(this.options.cancel).length : !1;
                return n && !a && this._mouseCapture(i) ? (this.mouseDelayMet = !this.options.delay, this.mouseDelayMet || (this._mouseDelayTimer = setTimeout(function () {
                    s.mouseDelayMet = !0
                }, this.options.delay)), this._mouseDistanceMet(i) && this._mouseDelayMet(i) && (this._mouseStarted = this._mouseStart(i) !== !1, !this._mouseStarted) ? (i.preventDefault(), !0) : (!0 === e.data(i.target, this.widgetName + ".preventClickEvent") && e.removeData(i.target, this.widgetName + ".preventClickEvent"), this._mouseMoveDelegate = function (e) {
                    return s._mouseMove(e)
                }, this._mouseUpDelegate = function (e) {
                    return s._mouseUp(e)
                }, e(document).bind("mousemove." + this.widgetName, this._mouseMoveDelegate).bind("mouseup." + this.widgetName, this._mouseUpDelegate), i.preventDefault(), t = !0, !0)) : !0
            }
        },
        _mouseMove: function (t) {
            return e.ui.ie && (!document.documentMode || 9 > document.documentMode) && !t.button ? this._mouseUp(t) : this._mouseStarted ? (this._mouseDrag(t), t.preventDefault()) : (this._mouseDistanceMet(t) && this._mouseDelayMet(t) && (this._mouseStarted = this._mouseStart(this._mouseDownEvent, t) !== !1, this._mouseStarted ? this._mouseDrag(t) : this._mouseUp(t)), !this._mouseStarted)
        },
        _mouseUp: function (t) {
            return e(document).unbind("mousemove." + this.widgetName, this._mouseMoveDelegate).unbind("mouseup." + this.widgetName, this._mouseUpDelegate), this._mouseStarted && (this._mouseStarted = !1, t.target === this._mouseDownEvent.target && e.data(t.target, this.widgetName + ".preventClickEvent", !0), this._mouseStop(t)), !1
        },
        _mouseDistanceMet: function (e) {
            return Math.max(Math.abs(this._mouseDownEvent.pageX - e.pageX), Math.abs(this._mouseDownEvent.pageY - e.pageY)) >= this.options.distance
        },
        _mouseDelayMet: function () {
            return this.mouseDelayMet
        },
        _mouseStart: function () {
        },
        _mouseDrag: function () {
        },
        _mouseStop: function () {
        },
        _mouseCapture: function () {
            return !0
        }
    })
})(jQuery);
/*! jQuery UI - v1.10.4 - 2014-01-17
 * http://jqueryui.com
 * Copyright 2014 jQuery Foundation and other contributors; Licensed MIT */
(function (t) {
    function e(t, e, i) {
        return t > e && e + i > t
    }

    function i(t) {
        return /left|right/.test(t.css("float")) || /inline|table-cell/.test(t.css("display"))
    }

    t.widget("ui.sortable", t.ui.mouse, {
        version: "1.10.4",
        widgetEventPrefix: "sort",
        ready: !1,
        options: {
            appendTo: "parent",
            axis: !1,
            connectWith: !1,
            containment: !1,
            cursor: "auto",
            cursorAt: !1,
            dropOnEmpty: !0,
            forcePlaceholderSize: !1,
            forceHelperSize: !1,
            grid: !1,
            handle: !1,
            helper: "original",
            items: "> *",
            opacity: !1,
            placeholder: !1,
            revert: !1,
            scroll: !0,
            scrollSensitivity: 20,
            scrollSpeed: 20,
            scope: "default",
            tolerance: "intersect",
            zIndex: 1e3,
            activate: null,
            beforeStop: null,
            change: null,
            deactivate: null,
            out: null,
            over: null,
            receive: null,
            remove: null,
            sort: null,
            start: null,
            stop: null,
            update: null
        },
        _create: function () {
            var t = this.options;
            this.containerCache = {}, this.element.addClass("ui-sortable"), this.refresh(), this.floating = this.items.length ? "x" === t.axis || i(this.items[0].item) : !1, this.offset = this.element.offset(), this._mouseInit(), this.ready = !0
        },
        _destroy: function () {
            this.element.removeClass("ui-sortable ui-sortable-disabled"), this._mouseDestroy();
            for (var t = this.items.length - 1; t >= 0; t--)this.items[t].item.removeData(this.widgetName + "-item");
            return this
        },
        _setOption: function (e, i) {
            "disabled" === e ? (this.options[e] = i, this.widget().toggleClass("ui-sortable-disabled", !!i)) : t.Widget.prototype._setOption.apply(this, arguments)
        },
        _mouseCapture: function (e, i) {
            var s = null, n = !1, a = this;
            return this.reverting ? !1 : this.options.disabled || "static" === this.options.type ? !1 : (this._refreshItems(e), t(e.target).parents().each(function () {
                return t.data(this, a.widgetName + "-item") === a ? (s = t(this), !1) : undefined
            }), t.data(e.target, a.widgetName + "-item") === a && (s = t(e.target)), s ? !this.options.handle || i || (t(this.options.handle, s).find("*").addBack().each(function () {
                this === e.target && (n = !0)
            }), n) ? (this.currentItem = s, this._removeCurrentsFromItems(), !0) : !1 : !1)
        },
        _mouseStart: function (e, i, s) {
            var n, a, o = this.options;
            if (this.currentContainer = this, this.refreshPositions(), this.helper = this._createHelper(e), this._cacheHelperProportions(), this._cacheMargins(), this.scrollParent = this.helper.scrollParent(), this.offset = this.currentItem.offset(), this.offset = {
                    top: this.offset.top - this.margins.top,
                    left: this.offset.left - this.margins.left
                }, t.extend(this.offset, {
                    click: {left: e.pageX - this.offset.left, top: e.pageY - this.offset.top},
                    parent: this._getParentOffset(),
                    relative: this._getRelativeOffset()
                }), this.helper.css("position", "absolute"), this.cssPosition = this.helper.css("position"), this.originalPosition = this._generatePosition(e), this.originalPageX = e.pageX, this.originalPageY = e.pageY, o.cursorAt && this._adjustOffsetFromHelper(o.cursorAt), this.domPosition = {
                    prev: this.currentItem.prev()[0],
                    parent: this.currentItem.parent()[0]
                }, this.helper[0] !== this.currentItem[0] && this.currentItem.hide(), this._createPlaceholder(), o.containment && this._setContainment(), o.cursor && "auto" !== o.cursor && (a = this.document.find("body"), this.storedCursor = a.css("cursor"), a.css("cursor", o.cursor), this.storedStylesheet = t("<style>*{ cursor: " + o.cursor + " !important; }</style>").appendTo(a)), o.opacity && (this.helper.css("opacity") && (this._storedOpacity = this.helper.css("opacity")), this.helper.css("opacity", o.opacity)), o.zIndex && (this.helper.css("zIndex") && (this._storedZIndex = this.helper.css("zIndex")), this.helper.css("zIndex", o.zIndex)), this.scrollParent[0] !== document && "HTML" !== this.scrollParent[0].tagName && (this.overflowOffset = this.scrollParent.offset()), this._trigger("start", e, this._uiHash()), this._preserveHelperProportions || this._cacheHelperProportions(), !s)for (n = this.containers.length - 1; n >= 0; n--)this.containers[n]._trigger("activate", e, this._uiHash(this));
            return t.ui.ddmanager && (t.ui.ddmanager.current = this), t.ui.ddmanager && !o.dropBehaviour && t.ui.ddmanager.prepareOffsets(this, e), this.dragging = !0, this.helper.addClass("ui-sortable-helper"), this._mouseDrag(e), !0
        },
        _mouseDrag: function (e) {
            var i, s, n, a, o = this.options, r = !1;
            for (this.position = this._generatePosition(e), this.positionAbs = this._convertPositionTo("absolute"), this.lastPositionAbs || (this.lastPositionAbs = this.positionAbs), this.options.scroll && (this.scrollParent[0] !== document && "HTML" !== this.scrollParent[0].tagName ? (this.overflowOffset.top + this.scrollParent[0].offsetHeight - e.pageY < o.scrollSensitivity ? this.scrollParent[0].scrollTop = r = this.scrollParent[0].scrollTop + o.scrollSpeed : e.pageY - this.overflowOffset.top < o.scrollSensitivity && (this.scrollParent[0].scrollTop = r = this.scrollParent[0].scrollTop - o.scrollSpeed), this.overflowOffset.left + this.scrollParent[0].offsetWidth - e.pageX < o.scrollSensitivity ? this.scrollParent[0].scrollLeft = r = this.scrollParent[0].scrollLeft + o.scrollSpeed : e.pageX - this.overflowOffset.left < o.scrollSensitivity && (this.scrollParent[0].scrollLeft = r = this.scrollParent[0].scrollLeft - o.scrollSpeed)) : (e.pageY - t(document).scrollTop() < o.scrollSensitivity ? r = t(document).scrollTop(t(document).scrollTop() - o.scrollSpeed) : t(window).height() - (e.pageY - t(document).scrollTop()) < o.scrollSensitivity && (r = t(document).scrollTop(t(document).scrollTop() + o.scrollSpeed)), e.pageX - t(document).scrollLeft() < o.scrollSensitivity ? r = t(document).scrollLeft(t(document).scrollLeft() - o.scrollSpeed) : t(window).width() - (e.pageX - t(document).scrollLeft()) < o.scrollSensitivity && (r = t(document).scrollLeft(t(document).scrollLeft() + o.scrollSpeed))), r !== !1 && t.ui.ddmanager && !o.dropBehaviour && t.ui.ddmanager.prepareOffsets(this, e)), this.positionAbs = this._convertPositionTo("absolute"), this.options.axis && "y" === this.options.axis || (this.helper[0].style.left = this.position.left + "px"), this.options.axis && "x" === this.options.axis || (this.helper[0].style.top = this.position.top + "px"), i = this.items.length - 1; i >= 0; i--)if (s = this.items[i], n = s.item[0], a = this._intersectsWithPointer(s), a && s.instance === this.currentContainer && n !== this.currentItem[0] && this.placeholder[1 === a ? "next" : "prev"]()[0] !== n && !t.contains(this.placeholder[0], n) && ("semi-dynamic" === this.options.type ? !t.contains(this.element[0], n) : !0)) {
                if (this.direction = 1 === a ? "down" : "up", "pointer" !== this.options.tolerance && !this._intersectsWithSides(s))break;
                this._rearrange(e, s), this._trigger("change", e, this._uiHash());
                break
            }
            return this._contactContainers(e), t.ui.ddmanager && t.ui.ddmanager.drag(this, e), this._trigger("sort", e, this._uiHash()), this.lastPositionAbs = this.positionAbs, !1
        },
        _mouseStop: function (e, i) {
            if (e) {
                if (t.ui.ddmanager && !this.options.dropBehaviour && t.ui.ddmanager.drop(this, e), this.options.revert) {
                    var s = this, n = this.placeholder.offset(), a = this.options.axis, o = {};
                    a && "x" !== a || (o.left = n.left - this.offset.parent.left - this.margins.left + (this.offsetParent[0] === document.body ? 0 : this.offsetParent[0].scrollLeft)), a && "y" !== a || (o.top = n.top - this.offset.parent.top - this.margins.top + (this.offsetParent[0] === document.body ? 0 : this.offsetParent[0].scrollTop)), this.reverting = !0, t(this.helper).animate(o, parseInt(this.options.revert, 10) || 500, function () {
                        s._clear(e)
                    })
                } else this._clear(e, i);
                return !1
            }
        },
        cancel: function () {
            if (this.dragging) {
                this._mouseUp({target: null}), "original" === this.options.helper ? this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper") : this.currentItem.show();
                for (var e = this.containers.length - 1; e >= 0; e--)this.containers[e]._trigger("deactivate", null, this._uiHash(this)), this.containers[e].containerCache.over && (this.containers[e]._trigger("out", null, this._uiHash(this)), this.containers[e].containerCache.over = 0)
            }
            return this.placeholder && (this.placeholder[0].parentNode && this.placeholder[0].parentNode.removeChild(this.placeholder[0]), "original" !== this.options.helper && this.helper && this.helper[0].parentNode && this.helper.remove(), t.extend(this, {
                helper: null,
                dragging: !1,
                reverting: !1,
                _noFinalSort: null
            }), this.domPosition.prev ? t(this.domPosition.prev).after(this.currentItem) : t(this.domPosition.parent).prepend(this.currentItem)), this
        },
        serialize: function (e) {
            var i = this._getItemsAsjQuery(e && e.connected), s = [];
            return e = e || {}, t(i).each(function () {
                var i = (t(e.item || this).attr(e.attribute || "id") || "").match(e.expression || /(.+)[\-=_](.+)/);
                i && s.push((e.key || i[1] + "[]") + "=" + (e.key && e.expression ? i[1] : i[2]))
            }), !s.length && e.key && s.push(e.key + "="), s.join("&")
        },
        toArray: function (e) {
            var i = this._getItemsAsjQuery(e && e.connected), s = [];
            return e = e || {}, i.each(function () {
                s.push(t(e.item || this).attr(e.attribute || "id") || "")
            }), s
        },
        _intersectsWith: function (t) {
            var e = this.positionAbs.left, i = e + this.helperProportions.width, s = this.positionAbs.top, n = s + this.helperProportions.height, a = t.left, o = a + t.width, r = t.top, h = r + t.height, l = this.offset.click.top, c = this.offset.click.left, u = "x" === this.options.axis || s + l > r && h > s + l, d = "y" === this.options.axis || e + c > a && o > e + c, p = u && d;
            return "pointer" === this.options.tolerance || this.options.forcePointerForContainers || "pointer" !== this.options.tolerance && this.helperProportions[this.floating ? "width" : "height"] > t[this.floating ? "width" : "height"] ? p : e + this.helperProportions.width / 2 > a && o > i - this.helperProportions.width / 2 && s + this.helperProportions.height / 2 > r && h > n - this.helperProportions.height / 2
        },
        _intersectsWithPointer: function (t) {
            var i = "x" === this.options.axis || e(this.positionAbs.top + this.offset.click.top, t.top, t.height), s = "y" === this.options.axis || e(this.positionAbs.left + this.offset.click.left, t.left, t.width), n = i && s, a = this._getDragVerticalDirection(), o = this._getDragHorizontalDirection();
            return n ? this.floating ? o && "right" === o || "down" === a ? 2 : 1 : a && ("down" === a ? 2 : 1) : !1
        },
        _intersectsWithSides: function (t) {
            var i = e(this.positionAbs.top + this.offset.click.top, t.top + t.height / 2, t.height), s = e(this.positionAbs.left + this.offset.click.left, t.left + t.width / 2, t.width), n = this._getDragVerticalDirection(), a = this._getDragHorizontalDirection();
            return this.floating && a ? "right" === a && s || "left" === a && !s : n && ("down" === n && i || "up" === n && !i)
        },
        _getDragVerticalDirection: function () {
            var t = this.positionAbs.top - this.lastPositionAbs.top;
            return 0 !== t && (t > 0 ? "down" : "up")
        },
        _getDragHorizontalDirection: function () {
            var t = this.positionAbs.left - this.lastPositionAbs.left;
            return 0 !== t && (t > 0 ? "right" : "left")
        },
        refresh: function (t) {
            return this._refreshItems(t), this.refreshPositions(), this
        },
        _connectWith: function () {
            var t = this.options;
            return t.connectWith.constructor === String ? [t.connectWith] : t.connectWith
        },
        _getItemsAsjQuery: function (e) {
            function i() {
                r.push(this)
            }

            var s, n, a, o, r = [], h = [], l = this._connectWith();
            if (l && e)for (s = l.length - 1; s >= 0; s--)for (a = t(l[s]), n = a.length - 1; n >= 0; n--)o = t.data(a[n], this.widgetFullName), o && o !== this && !o.options.disabled && h.push([t.isFunction(o.options.items) ? o.options.items.call(o.element) : t(o.options.items, o.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"), o]);
            for (h.push([t.isFunction(this.options.items) ? this.options.items.call(this.element, null, {
                options: this.options,
                item: this.currentItem
            }) : t(this.options.items, this.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"), this]), s = h.length - 1; s >= 0; s--)h[s][0].each(i);
            return t(r)
        },
        _removeCurrentsFromItems: function () {
            var e = this.currentItem.find(":data(" + this.widgetName + "-item)");
            this.items = t.grep(this.items, function (t) {
                for (var i = 0; e.length > i; i++)if (e[i] === t.item[0])return !1;
                return !0
            })
        },
        _refreshItems: function (e) {
            this.items = [], this.containers = [this];
            var i, s, n, a, o, r, h, l, c = this.items, u = [[t.isFunction(this.options.items) ? this.options.items.call(this.element[0], e, {item: this.currentItem}) : t(this.options.items, this.element), this]], d = this._connectWith();
            if (d && this.ready)for (i = d.length - 1; i >= 0; i--)for (n = t(d[i]), s = n.length - 1; s >= 0; s--)a = t.data(n[s], this.widgetFullName), a && a !== this && !a.options.disabled && (u.push([t.isFunction(a.options.items) ? a.options.items.call(a.element[0], e, {item: this.currentItem}) : t(a.options.items, a.element), a]), this.containers.push(a));
            for (i = u.length - 1; i >= 0; i--)for (o = u[i][1], r = u[i][0], s = 0, l = r.length; l > s; s++)h = t(r[s]), h.data(this.widgetName + "-item", o), c.push({
                item: h,
                instance: o,
                width: 0,
                height: 0,
                left: 0,
                top: 0
            })
        },
        refreshPositions: function (e) {
            this.offsetParent && this.helper && (this.offset.parent = this._getParentOffset());
            var i, s, n, a;
            for (i = this.items.length - 1; i >= 0; i--)s = this.items[i], s.instance !== this.currentContainer && this.currentContainer && s.item[0] !== this.currentItem[0] || (n = this.options.toleranceElement ? t(this.options.toleranceElement, s.item) : s.item, e || (s.width = n.outerWidth(), s.height = n.outerHeight()), a = n.offset(), s.left = a.left, s.top = a.top);
            if (this.options.custom && this.options.custom.refreshContainers)this.options.custom.refreshContainers.call(this); else for (i = this.containers.length - 1; i >= 0; i--)a = this.containers[i].element.offset(), this.containers[i].containerCache.left = a.left, this.containers[i].containerCache.top = a.top, this.containers[i].containerCache.width = this.containers[i].element.outerWidth(), this.containers[i].containerCache.height = this.containers[i].element.outerHeight();
            return this
        },
        _createPlaceholder: function (e) {
            e = e || this;
            var i, s = e.options;
            s.placeholder && s.placeholder.constructor !== String || (i = s.placeholder, s.placeholder = {
                element: function () {
                    var s = e.currentItem[0].nodeName.toLowerCase(), n = t("<" + s + ">", e.document[0]).addClass(i || e.currentItem[0].className + " ui-sortable-placeholder").removeClass("ui-sortable-helper");
                    return "tr" === s ? e.currentItem.children().each(function () {
                        t("<td>&#160;</td>", e.document[0]).attr("colspan", t(this).attr("colspan") || 1).appendTo(n)
                    }) : "img" === s && n.attr("src", e.currentItem.attr("src")), i || n.css("visibility", "hidden"), n
                }, update: function (t, n) {
                    (!i || s.forcePlaceholderSize) && (n.height() || n.height(e.currentItem.innerHeight() - parseInt(e.currentItem.css("paddingTop") || 0, 10) - parseInt(e.currentItem.css("paddingBottom") || 0, 10)), n.width() || n.width(e.currentItem.innerWidth() - parseInt(e.currentItem.css("paddingLeft") || 0, 10) - parseInt(e.currentItem.css("paddingRight") || 0, 10)))
                }
            }), e.placeholder = t(s.placeholder.element.call(e.element, e.currentItem)), e.currentItem.after(e.placeholder), s.placeholder.update(e, e.placeholder)
        },
        _contactContainers: function (s) {
            var n, a, o, r, h, l, c, u, d, p, f = null, m = null;
            for (n = this.containers.length - 1; n >= 0; n--)if (!t.contains(this.currentItem[0], this.containers[n].element[0]))if (this._intersectsWith(this.containers[n].containerCache)) {
                if (f && t.contains(this.containers[n].element[0], f.element[0]))continue;
                f = this.containers[n], m = n
            } else this.containers[n].containerCache.over && (this.containers[n]._trigger("out", s, this._uiHash(this)), this.containers[n].containerCache.over = 0);
            if (f)if (1 === this.containers.length)this.containers[m].containerCache.over || (this.containers[m]._trigger("over", s, this._uiHash(this)), this.containers[m].containerCache.over = 1); else {
                for (o = 1e4, r = null, p = f.floating || i(this.currentItem), h = p ? "left" : "top", l = p ? "width" : "height", c = this.positionAbs[h] + this.offset.click[h], a = this.items.length - 1; a >= 0; a--)t.contains(this.containers[m].element[0], this.items[a].item[0]) && this.items[a].item[0] !== this.currentItem[0] && (!p || e(this.positionAbs.top + this.offset.click.top, this.items[a].top, this.items[a].height)) && (u = this.items[a].item.offset()[h], d = !1, Math.abs(u - c) > Math.abs(u + this.items[a][l] - c) && (d = !0, u += this.items[a][l]), o > Math.abs(u - c) && (o = Math.abs(u - c), r = this.items[a], this.direction = d ? "up" : "down"));
                if (!r && !this.options.dropOnEmpty)return;
                if (this.currentContainer === this.containers[m])return;
                r ? this._rearrange(s, r, null, !0) : this._rearrange(s, null, this.containers[m].element, !0), this._trigger("change", s, this._uiHash()), this.containers[m]._trigger("change", s, this._uiHash(this)), this.currentContainer = this.containers[m], this.options.placeholder.update(this.currentContainer, this.placeholder), this.containers[m]._trigger("over", s, this._uiHash(this)), this.containers[m].containerCache.over = 1
            }
        },
        _createHelper: function (e) {
            var i = this.options, s = t.isFunction(i.helper) ? t(i.helper.apply(this.element[0], [e, this.currentItem])) : "clone" === i.helper ? this.currentItem.clone() : this.currentItem;
            return s.parents("body").length || t("parent" !== i.appendTo ? i.appendTo : this.currentItem[0].parentNode)[0].appendChild(s[0]), s[0] === this.currentItem[0] && (this._storedCSS = {
                width: this.currentItem[0].style.width,
                height: this.currentItem[0].style.height,
                position: this.currentItem.css("position"),
                top: this.currentItem.css("top"),
                left: this.currentItem.css("left")
            }), (!s[0].style.width || i.forceHelperSize) && s.width(this.currentItem.width()), (!s[0].style.height || i.forceHelperSize) && s.height(this.currentItem.height()), s
        },
        _adjustOffsetFromHelper: function (e) {
            "string" == typeof e && (e = e.split(" ")), t.isArray(e) && (e = {
                left: +e[0],
                top: +e[1] || 0
            }), "left"in e && (this.offset.click.left = e.left + this.margins.left), "right"in e && (this.offset.click.left = this.helperProportions.width - e.right + this.margins.left), "top"in e && (this.offset.click.top = e.top + this.margins.top), "bottom"in e && (this.offset.click.top = this.helperProportions.height - e.bottom + this.margins.top)
        },
        _getParentOffset: function () {
            this.offsetParent = this.helper.offsetParent();
            var e = this.offsetParent.offset();
            return "absolute" === this.cssPosition && this.scrollParent[0] !== document && t.contains(this.scrollParent[0], this.offsetParent[0]) && (e.left += this.scrollParent.scrollLeft(), e.top += this.scrollParent.scrollTop()), (this.offsetParent[0] === document.body || this.offsetParent[0].tagName && "html" === this.offsetParent[0].tagName.toLowerCase() && t.ui.ie) && (e = {
                top: 0,
                left: 0
            }), {
                top: e.top + (parseInt(this.offsetParent.css("borderTopWidth"), 10) || 0),
                left: e.left + (parseInt(this.offsetParent.css("borderLeftWidth"), 10) || 0)
            }
        },
        _getRelativeOffset: function () {
            if ("relative" === this.cssPosition) {
                var t = this.currentItem.position();
                return {
                    top: t.top - (parseInt(this.helper.css("top"), 10) || 0) + this.scrollParent.scrollTop(),
                    left: t.left - (parseInt(this.helper.css("left"), 10) || 0) + this.scrollParent.scrollLeft()
                }
            }
            return {top: 0, left: 0}
        },
        _cacheMargins: function () {
            this.margins = {
                left: parseInt(this.currentItem.css("marginLeft"), 10) || 0,
                top: parseInt(this.currentItem.css("marginTop"), 10) || 0
            }
        },
        _cacheHelperProportions: function () {
            this.helperProportions = {width: this.helper.outerWidth(), height: this.helper.outerHeight()}
        },
        _setContainment: function () {
            var e, i, s, n = this.options;
            "parent" === n.containment && (n.containment = this.helper[0].parentNode), ("document" === n.containment || "window" === n.containment) && (this.containment = [0 - this.offset.relative.left - this.offset.parent.left, 0 - this.offset.relative.top - this.offset.parent.top, t("document" === n.containment ? document : window).width() - this.helperProportions.width - this.margins.left, (t("document" === n.containment ? document : window).height() || document.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top]), /^(document|window|parent)$/.test(n.containment) || (e = t(n.containment)[0], i = t(n.containment).offset(), s = "hidden" !== t(e).css("overflow"), this.containment = [i.left + (parseInt(t(e).css("borderLeftWidth"), 10) || 0) + (parseInt(t(e).css("paddingLeft"), 10) || 0) - this.margins.left, i.top + (parseInt(t(e).css("borderTopWidth"), 10) || 0) + (parseInt(t(e).css("paddingTop"), 10) || 0) - this.margins.top, i.left + (s ? Math.max(e.scrollWidth, e.offsetWidth) : e.offsetWidth) - (parseInt(t(e).css("borderLeftWidth"), 10) || 0) - (parseInt(t(e).css("paddingRight"), 10) || 0) - this.helperProportions.width - this.margins.left, i.top + (s ? Math.max(e.scrollHeight, e.offsetHeight) : e.offsetHeight) - (parseInt(t(e).css("borderTopWidth"), 10) || 0) - (parseInt(t(e).css("paddingBottom"), 10) || 0) - this.helperProportions.height - this.margins.top])
        },
        _convertPositionTo: function (e, i) {
            i || (i = this.position);
            var s = "absolute" === e ? 1 : -1, n = "absolute" !== this.cssPosition || this.scrollParent[0] !== document && t.contains(this.scrollParent[0], this.offsetParent[0]) ? this.scrollParent : this.offsetParent, a = /(html|body)/i.test(n[0].tagName);
            return {
                top: i.top + this.offset.relative.top * s + this.offset.parent.top * s - ("fixed" === this.cssPosition ? -this.scrollParent.scrollTop() : a ? 0 : n.scrollTop()) * s,
                left: i.left + this.offset.relative.left * s + this.offset.parent.left * s - ("fixed" === this.cssPosition ? -this.scrollParent.scrollLeft() : a ? 0 : n.scrollLeft()) * s
            }
        },
        _generatePosition: function (e) {
            var i, s, n = this.options, a = e.pageX, o = e.pageY, r = "absolute" !== this.cssPosition || this.scrollParent[0] !== document && t.contains(this.scrollParent[0], this.offsetParent[0]) ? this.scrollParent : this.offsetParent, h = /(html|body)/i.test(r[0].tagName);
            return "relative" !== this.cssPosition || this.scrollParent[0] !== document && this.scrollParent[0] !== this.offsetParent[0] || (this.offset.relative = this._getRelativeOffset()), this.originalPosition && (this.containment && (e.pageX - this.offset.click.left < this.containment[0] && (a = this.containment[0] + this.offset.click.left), e.pageY - this.offset.click.top < this.containment[1] && (o = this.containment[1] + this.offset.click.top), e.pageX - this.offset.click.left > this.containment[2] && (a = this.containment[2] + this.offset.click.left), e.pageY - this.offset.click.top > this.containment[3] && (o = this.containment[3] + this.offset.click.top)), n.grid && (i = this.originalPageY + Math.round((o - this.originalPageY) / n.grid[1]) * n.grid[1], o = this.containment ? i - this.offset.click.top >= this.containment[1] && i - this.offset.click.top <= this.containment[3] ? i : i - this.offset.click.top >= this.containment[1] ? i - n.grid[1] : i + n.grid[1] : i, s = this.originalPageX + Math.round((a - this.originalPageX) / n.grid[0]) * n.grid[0], a = this.containment ? s - this.offset.click.left >= this.containment[0] && s - this.offset.click.left <= this.containment[2] ? s : s - this.offset.click.left >= this.containment[0] ? s - n.grid[0] : s + n.grid[0] : s)), {
                top: o - this.offset.click.top - this.offset.relative.top - this.offset.parent.top + ("fixed" === this.cssPosition ? -this.scrollParent.scrollTop() : h ? 0 : r.scrollTop()),
                left: a - this.offset.click.left - this.offset.relative.left - this.offset.parent.left + ("fixed" === this.cssPosition ? -this.scrollParent.scrollLeft() : h ? 0 : r.scrollLeft())
            }
        },
        _rearrange: function (t, e, i, s) {
            i ? i[0].appendChild(this.placeholder[0]) : e.item[0].parentNode.insertBefore(this.placeholder[0], "down" === this.direction ? e.item[0] : e.item[0].nextSibling), this.counter = this.counter ? ++this.counter : 1;
            var n = this.counter;
            this._delay(function () {
                n === this.counter && this.refreshPositions(!s)
            })
        },
        _clear: function (t, e) {
            function i(t, e, i) {
                return function (s) {
                    i._trigger(t, s, e._uiHash(e))
                }
            }

            this.reverting = !1;
            var s, n = [];
            if (!this._noFinalSort && this.currentItem.parent().length && this.placeholder.before(this.currentItem), this._noFinalSort = null, this.helper[0] === this.currentItem[0]) {
                for (s in this._storedCSS)("auto" === this._storedCSS[s] || "static" === this._storedCSS[s]) && (this._storedCSS[s] = "");
                this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper")
            } else this.currentItem.show();
            for (this.fromOutside && !e && n.push(function (t) {
                this._trigger("receive", t, this._uiHash(this.fromOutside))
            }), !this.fromOutside && this.domPosition.prev === this.currentItem.prev().not(".ui-sortable-helper")[0] && this.domPosition.parent === this.currentItem.parent()[0] || e || n.push(function (t) {
                this._trigger("update", t, this._uiHash())
            }), this !== this.currentContainer && (e || (n.push(function (t) {
                this._trigger("remove", t, this._uiHash())
            }), n.push(function (t) {
                return function (e) {
                    t._trigger("receive", e, this._uiHash(this))
                }
            }.call(this, this.currentContainer)), n.push(function (t) {
                return function (e) {
                    t._trigger("update", e, this._uiHash(this))
                }
            }.call(this, this.currentContainer)))), s = this.containers.length - 1; s >= 0; s--)e || n.push(i("deactivate", this, this.containers[s])), this.containers[s].containerCache.over && (n.push(i("out", this, this.containers[s])), this.containers[s].containerCache.over = 0);
            if (this.storedCursor && (this.document.find("body").css("cursor", this.storedCursor), this.storedStylesheet.remove()), this._storedOpacity && this.helper.css("opacity", this._storedOpacity), this._storedZIndex && this.helper.css("zIndex", "auto" === this._storedZIndex ? "" : this._storedZIndex), this.dragging = !1, this.cancelHelperRemoval) {
                if (!e) {
                    for (this._trigger("beforeStop", t, this._uiHash()), s = 0; n.length > s; s++)n[s].call(this, t);
                    this._trigger("stop", t, this._uiHash())
                }
                return this.fromOutside = !1, !1
            }
            if (e || this._trigger("beforeStop", t, this._uiHash()), this.placeholder[0].parentNode.removeChild(this.placeholder[0]), this.helper[0] !== this.currentItem[0] && this.helper.remove(), this.helper = null, !e) {
                for (s = 0; n.length > s; s++)n[s].call(this, t);
                this._trigger("stop", t, this._uiHash())
            }
            return this.fromOutside = !1, !0
        },
        _trigger: function () {
            t.Widget.prototype._trigger.apply(this, arguments) === !1 && this.cancel()
        },
        _uiHash: function (e) {
            var i = e || this;
            return {
                helper: i.helper,
                placeholder: i.placeholder || t([]),
                position: i.position,
                originalPosition: i.originalPosition,
                offset: i.positionAbs,
                item: i.currentItem,
                sender: e ? e.element : null
            }
        }
    })
})(jQuery);
var postboxes;
!function (a) {
    var b = a(document);
    postboxes = {
        add_postbox_toggles: function (c, d) {
            var e = this;
            e.init(c, d), a(".postbox .hndle, .postbox .handlediv").bind("click.postboxes", function () {
                var d = a(this).parent(".postbox"), f = d.attr("id");
                "dashboard_browser_nag" != f && (d.toggleClass("closed"), "press-this" != c && e.save_state(c), f && (!d.hasClass("closed") && a.isFunction(postboxes.pbshow) ? e.pbshow(f) : d.hasClass("closed") && a.isFunction(postboxes.pbhide) && e.pbhide(f)), b.trigger("postbox-toggled", d))
            }), a(".postbox .hndle a").click(function (a) {
                a.stopPropagation()
            }), a(".postbox a.dismiss").bind("click.postboxes", function () {
                var b = a(this).parents(".postbox").attr("id") + "-hide";
                return a("#" + b).prop("checked", !1).triggerHandler("click"), !1
            }), a(".hide-postbox-tog").bind("click.postboxes", function () {
                var d = a(this).val(), f = a("#" + d);
                a(this).prop("checked") ? (f.show(), a.isFunction(postboxes.pbshow) && e.pbshow(d)) : (f.hide(), a.isFunction(postboxes.pbhide) && e.pbhide(d)), e.save_state(c), e._mark_area(), b.trigger("postbox-toggled", f)
            }), a('.columns-prefs input[type="radio"]').bind("click.postboxes", function () {
                var b = parseInt(a(this).val(), 10);
                b && (e._pb_edit(b), e.save_order(c))
            })
        }, init: function (b, c) {
            var d = a(document.body).hasClass("mobile");
            a.extend(this, c || {}), a("#wpbody-content").css("overflow", "hidden"), a(".meta-box-sortables").sortable({
                placeholder: "sortable-placeholder",
                connectWith: ".meta-box-sortables",
                items: ".postbox",
                handle: ".hndle",
                cursor: "move",
                delay: d ? 200 : 0,
                distance: 2,
                tolerance: "pointer",
                forcePlaceholderSize: !0,
                helper: "clone",
                opacity: .65,
                stop: function () {
                    return a(this).find("#dashboard_browser_nag").is(":visible") && "dashboard_browser_nag" != this.firstChild.id ? void a(this).sortable("cancel") : void postboxes.save_order(b)
                },
                receive: function (b, c) {
                    "dashboard_browser_nag" == c.item[0].id && a(c.sender).sortable("cancel"), postboxes._mark_area()
                }
            }), d && (a(document.body).bind("orientationchange.postboxes", function () {
                postboxes._pb_change()
            }), this._pb_change()), this._mark_area()
        }, save_state: function (b) {
            var c = a(".postbox").filter(".closed").map(function () {
                return this.id
            }).get().join(","), d = a(".postbox").filter(":hidden").map(function () {
                return this.id
            }).get().join(",");
            a.post(ajaxurl, {
                action: "closed-postboxes",
                closed: c,
                hidden: d,
                closedpostboxesnonce: jQuery("#closedpostboxesnonce").val(),
                page: b
            })
        }, save_order: function (b) {
            var c, d = a(".columns-prefs input:checked").val() || 0;
            c = {
                action: "meta-box-order",
                _ajax_nonce: a("#meta-box-order-nonce").val(),
                page_columns: d,
                page: b
            }, a(".meta-box-sortables").each(function () {
                c["order[" + this.id.split("-")[0] + "]"] = a(this).sortable("toArray").join(",")
            }), a.post(ajaxurl, c)
        }, _mark_area: function () {
            var b = a("div.postbox:visible").length, c = a("#post-body #side-sortables");
            a("#dashboard-widgets .meta-box-sortables:visible").each(function () {
                var c = a(this);
                1 == b || c.children(".postbox:visible").length ? c.removeClass("empty-container") : c.addClass("empty-container")
            }), c.length && (c.children(".postbox:visible").length ? c.removeClass("empty-container") : "280px" == a("#postbox-container-1").css("width") && c.addClass("empty-container"))
        }, _pb_edit: function (b) {
            var c = a(".metabox-holder").get(0);
            c && (c.className = c.className.replace(/columns-\d+/, "columns-" + b)), a(document).trigger("postboxes-columnchange")
        }, _pb_change: function () {
            var b = a('label.columns-prefs-1 input[type="radio"]');
            switch (window.orientation) {
                case 90:
                case-90:
                    b.length && b.is(":checked") || this._pb_edit(2);
                    break;
                case 0:
                case 180:
                    a("#poststuff").length ? this._pb_edit(1) : b.length && b.is(":checked") || this._pb_edit(2)
            }
        }, pbshow: !1, pbhide: !1
    }
}(jQuery);
var mooNavMenu;
!function (a) {
    var b;
    b = mooNavMenu = {
        options: {menuItemDepthPerLevel: 30, globalMaxDepth: 11},
        menuList: void 0,
        targetList: void 0,
        menusChanged: !1,
        isRTL: !("undefined" == typeof isRtl || !isRtl),
        negateIfRTL: "undefined" != typeof isRtl && isRtl ? -1 : 1,
        init: function () {
            b.menuList = a("#menu-to-edit"), b.targetList = b.menuList, this.jQueryExtensions(), this.attachMenuEditListeners(), this.setupInputWithDefaultTitle(), this.attachQuickSearchListeners(), this.attachThemeLocationsListeners(), this.attachTabsPanelListeners(), this.attachUnsavedChangesListener(), b.menuList.length && this.initSortables(), menus.oneThemeLocationNoMenus && a("#posttype-page").addSelectedToMenu(b.addMenuItemToBottom), this.initManageLocations(), this.initAccessibility(), this.initToggles(), this.initPreviewing()
        },
        jQueryExtensions: function () {
            a.fn.extend({
                menuItemDepth: function () {
                    var a = this.eq(0).css(b.isRTL ? "margin-right" : "margin-left");
                    return b.pxToDepth(a && -1 != a.indexOf("px") ? a.slice(0, -2) : 0)
                }, updateDepthClass: function (b, c) {
                    return this.each(function () {
                        var d = a(this);
                        c = c || d.menuItemDepth(), a(this).removeClass("menu-item-depth-" + c).addClass("menu-item-depth-" + b)
                    })
                }, shiftDepthClass: function (b) {
                    return this.each(function () {
                        var c = a(this), d = c.menuItemDepth();
                        a(this).removeClass("menu-item-depth-" + d).addClass("menu-item-depth-" + (d + b))
                    })
                }, childMenuItems: function () {
                    var b = a();
                    return this.each(function () {
                        for (var c = a(this), d = c.menuItemDepth(), e = c.next(); e.length && e.menuItemDepth() > d;)b = b.add(e), e = e.next()
                    }), b
                }, shiftHorizontally: function (b) {
                    return this.each(function () {
                        var c = a(this), d = c.menuItemDepth(), e = d + b;
                        c.moveHorizontally(e, d)
                    })
                }, moveHorizontally: function (b, c) {
                    return this.each(function () {
                        var d = a(this), e = d.childMenuItems(), f = b - c, g = d.find(".is-submenu");
                        d.updateDepthClass(b, c).updateParentMenuItemDBId(), e && e.each(function () {
                            var b = a(this), c = b.menuItemDepth(), d = c + f;
                            b.updateDepthClass(d, c).updateParentMenuItemDBId()
                        }), 0 === b ? g.hide() : g.show()
                    })
                }, updateParentMenuItemDBId: function () {
                    return this.each(function () {
                        var b = a(this), c = b.find(".menu-item-data-parent-id"), d = parseInt(b.menuItemDepth(), 10), e = d - 1, f = b.prevAll(".menu-item-depth-" + e).first();
                        c.val(0 === d ? 0 : f.find(".menu-item-data-db-id").val())
                    })
                }, hideAdvancedMenuItemFields: function () {
                    return this.each(function () {
                        var b = a(this);
                        a(".hide-column-tog").not(":checked").each(function () {
                            b.find(".field-" + a(this).val()).addClass("hidden-field")
                        })
                    })
                }, addSelectedToMenu: function (c) {
                    return 0 === a("#menu-to-edit").length ? !1 : this.each(function () {
                        var d = a(this), e = {}, f = d.find(menus.oneThemeLocationNoMenus && 0 === d.find(".tabs-panel-active .categorychecklist li input:checked").length ? '#page-all li input[type="checkbox"]' : ".tabs-panel-active .categorychecklist li input:checked"), g = /menu-item\[([^\]]*)/;
                        return c = c || b.addMenuItemToBottom, f.length ? (d.find(".spinner").show(), a(f).each(function () {
                            var d = a(this), f = g.exec(d.attr("name")), h = "undefined" == typeof f[1] ? 0 : parseInt(f[1], 10);
                            this.className && -1 != this.className.indexOf("add-to-top") && (c = b.addMenuItemToTop), e[h] = d.closest("li").getItemData("add-menu-item", h)
                        }), void b.addItemToMenu(e, c, function () {
                            f.removeAttr("checked"), d.find(".spinner").hide()
                        })) : !1
                    })
                }, getItemData: function (a, b) {
                    a = a || "menu-item";
                    var c, d = {}, e = ["menu-item-db-id", "menu-item-parent-id", "menu-item-position", "menu-item-type", "menu-item-title", "menu-item-url", "menu-item-description", "menu-item-attr-title", "menu-item-target", "menu-item-classes"];
                    return b || "menu-item" != a || (b = this.find(".menu-item-data-db-id").val()), b ? (this.find("input").each(function () {
                        var f;
                        for (c = e.length; c--;)"menu-item" == a ? f = e[c] + "[" + b + "]" : "add-menu-item" == a && (f = "menu-item[" + b + "][" + e[c] + "]"), this.name && f == this.name && (d[e[c]] = this.value)
                    }), d) : d
                }, setItemData: function (b, c, d) {
                    return c = c || "menu-item", d || "menu-item" != c || (d = a(".menu-item-data-db-id", this).val()), d ? (this.find("input").each(function () {
                        var e, f = a(this);
                        a.each(b, function (a, b) {
                            "menu-item" == c ? e = a + "[" + d + "]" : "add-menu-item" == c && (e = "menu-item[" + d + "][" + a + "]"), e == f.attr("name") && f.val(b)
                        })
                    }), this) : this
                }
            })
        },
        countMenuItems: function (b) {
            return a(".menu-item-depth-" + b).length
        },
        moveMenuItem: function (c, d) {
            var e, f, g, h = a("#menu-to-edit li"), i = h.length, j = c.parents("li.menu-item"), k = j.childMenuItems(), l = j.getItemData(), m = parseInt(j.menuItemDepth(), 10), n = parseInt(j.index(), 10), o = j.next(), p = o.childMenuItems(), q = parseInt(o.menuItemDepth(), 10) + 1, r = j.prev(), s = parseInt(r.menuItemDepth(), 10), t = r.getItemData()["menu-item-db-id"];
            switch (d) {
                case"up":
                    if (f = n - 1, 0 === n)break;
                    0 === f && 0 !== m && j.moveHorizontally(0, m), 0 !== s && j.moveHorizontally(s, m), k ? (e = j.add(k), e.detach().insertBefore(h.eq(f)).updateParentMenuItemDBId()) : j.detach().insertBefore(h.eq(f)).updateParentMenuItemDBId();
                    break;
                case"down":
                    if (k) {
                        if (e = j.add(k), o = h.eq(e.length + n), p = 0 !== o.childMenuItems().length, p && (g = parseInt(o.menuItemDepth(), 10) + 1, j.moveHorizontally(g, m)), i === n + e.length)break;
                        e.detach().insertAfter(h.eq(n + e.length)).updateParentMenuItemDBId()
                    } else {
                        if (0 !== p.length && j.moveHorizontally(q, m), i === n + 1)break;
                        j.detach().insertAfter(h.eq(n + 1)).updateParentMenuItemDBId()
                    }
                    break;
                case"top":
                    if (0 === n)break;
                    k ? (e = j.add(k), e.detach().insertBefore(h.eq(0)).updateParentMenuItemDBId()) : j.detach().insertBefore(h.eq(0)).updateParentMenuItemDBId();
                    break;
                case"left":
                    if (0 === m)break;
                    j.shiftHorizontally(-1);
                    break;
                case"right":
                    if (0 === n)break;
                    if (l["menu-item-parent-id"] === t)break;
                    j.shiftHorizontally(1)
            }
            c.focus(), b.registerChange(), b.refreshKeyboardAccessibility(), b.refreshAdvancedAccessibility()
        },
        initAccessibility: function () {
            var c = a("#menu-to-edit");
            b.refreshKeyboardAccessibility(), b.refreshAdvancedAccessibility(), c.on("click", ".menus-move-up", function (c) {
                b.moveMenuItem(a(this).parents("li.menu-item").find("a.item-edit"), "up"), c.preventDefault()
            }), c.on("click", ".menus-move-down", function (c) {
                b.moveMenuItem(a(this).parents("li.menu-item").find("a.item-edit"), "down"), c.preventDefault()
            }), c.on("click", ".menus-move-top", function (c) {
                b.moveMenuItem(a(this).parents("li.menu-item").find("a.item-edit"), "top"), c.preventDefault()
            }), c.on("click", ".menus-move-left", function (c) {
                b.moveMenuItem(a(this).parents("li.menu-item").find("a.item-edit"), "left"), c.preventDefault()
            }), c.on("click", ".menus-move-right", function (c) {
                b.moveMenuItem(a(this).parents("li.menu-item").find("a.item-edit"), "right"), c.preventDefault()
            })
        },
        refreshAdvancedAccessibility: function () {
            a(".menu-item-settings .field-move a").css("display", "none"), a(".item-edit").each(function () {
                var b, c, d, e, f, g, h, i, j, k = a(this), l = k.closest("li.menu-item").first(), m = l.menuItemDepth(), n = 0 === m, o = k.closest(".menu-item-handle").find(".menu-item-title").text(), p = parseInt(l.index(), 10), q = n ? m : parseInt(m - 1, 10), r = l.prevAll(".menu-item-depth-" + q).first().find(".menu-item-title").text(), s = l.prevAll(".menu-item-depth-" + m).first().find(".menu-item-title").text(), t = a("#menu-to-edit li").length, u = l.nextAll(".menu-item-depth-" + m).length;
                0 !== p && (b = l.find(".menus-move-up"), b.prop("title", menus.moveUp).css("display", "inline")), 0 !== p && n && (b = l.find(".menus-move-top"), b.prop("title", menus.moveToTop).css("display", "inline")), p + 1 !== t && 0 !== p && (b = l.find(".menus-move-down"), b.prop("title", menus.moveDown).css("display", "inline")), 0 === p && 0 !== u && (b = l.find(".menus-move-down"), b.prop("title", menus.moveDown).css("display", "inline")), n || (b = l.find(".menus-move-left"), c = menus.outFrom.replace("%s", r), b.prop("title", menus.moveOutFrom.replace("%s", r)).html(c).css("display", "inline")), 0 !== p && l.find(".menu-item-data-parent-id").val() !== l.prev().find(".menu-item-data-db-id").val() && (b = l.find(".menus-move-right"), c = menus.under.replace("%s", s), b.prop("title", menus.moveUnder.replace("%s", s)).html(c).css("display", "inline")), n ? (d = a(".menu-item-depth-0"), e = d.index(l) + 1, t = d.length, f = menus.menuFocus.replace("%1$s", o).replace("%2$d", e).replace("%3$d", t)) : (g = l.prevAll(".menu-item-depth-" + parseInt(m - 1, 10)).first(), h = g.find(".menu-item-data-db-id").val(), i = g.find(".menu-item-title").text(), j = a('.menu-item .menu-item-data-parent-id[value="' + h + '"]'), e = a(j.parents(".menu-item").get().reverse()).index(l) + 1, f = menus.subMenuFocus.replace("%1$s", o).replace("%2$d", e).replace("%3$s", i)), k.prop("title", f).html(f)
            })
        },
        refreshKeyboardAccessibility: function () {
            a(".item-edit").off("focus").on("focus", function () {
                a(this).off("keydown").on("keydown", function (c) {
                    var d, e = a(this), f = e.parents("li.menu-item"), g = f.getItemData();
                    if ((37 == c.which || 38 == c.which || 39 == c.which || 40 == c.which) && (e.off("keydown"), 1 !== a("#menu-to-edit li").length)) {
                        switch (d = {
                            38: "up",
                            40: "down",
                            37: "left",
                            39: "right"
                        }, a("body").hasClass("rtl") && (d = {
                            38: "up",
                            40: "down",
                            39: "left",
                            37: "right"
                        }), d[c.which]) {
                            case"up":
                                b.moveMenuItem(e, "up");
                                break;
                            case"down":
                                b.moveMenuItem(e, "down");
                                break;
                            case"left":
                                b.moveMenuItem(e, "left");
                                break;
                            case"right":
                                b.moveMenuItem(e, "right")
                        }
                        return a("#edit-" + g["menu-item-db-id"]).focus(), !1
                    }
                })
            })
        },
        initPreviewing: function () {
            a("#menu-to-edit").on("change input", ".edit-menu-item-title", function (b) {
                var c, d, e = a(b.currentTarget);
                c = e.val(), d = e.closest(".menu-item").find(".menu-item-title"), c ? d.text(c).removeClass("no-title") : d.text(navMenuL10n.untitled).addClass("no-title")
            })
        },
        initToggles: function () {
            postboxes.add_postbox_toggles("nav-menus"), columns.useCheckboxesForHidden(), columns.checked = function (b) {
                a(".field-" + b).removeClass("hidden-field")
            }, columns.unchecked = function (b) {
                a(".field-" + b).addClass("hidden-field")
            }, b.menuList.hideAdvancedMenuItemFields(), a(".hide-postbox-tog").click(function () {
                var b = a(".accordion-container li.accordion-section").filter(":hidden").map(function () {
                    return this.id
                }).get().join(",");
                a.post(ajaxurl, {
                    action: "closed-postboxes",
                    hidden: b,
                    closedpostboxesnonce: jQuery("#closedpostboxesnonce").val(),
                    page: "nav-menus"
                })
            })
        },
        initSortables: function () {
            function c(a) {
                var c;
                j = a.placeholder.prev(), k = a.placeholder.next(), j[0] == a.item[0] && (j = j.prev()), k[0] == a.item[0] && (k = k.next()), l = j.length ? j.offset().top + j.height() : 0, m = k.length ? k.offset().top + k.height() / 3 : 0, h = k.length ? k.menuItemDepth() : 0, i = j.length ? (c = j.menuItemDepth() + 1) > b.options.globalMaxDepth ? b.options.globalMaxDepth : c : 0
            }

            function d(a, b) {
                a.placeholder.updateDepthClass(b, q), q = b
            }

            function e() {
                if (!s[0].className)return 0;
                var a = s[0].className.match(/menu-max-depth-(\d+)/);
                return a && a[1] ? parseInt(a[1], 10) : 0
            }

            function f(c) {
                var d, e = t;
                if (0 !== c) {
                    if (c > 0)d = p + c, d > t && (e = d); else if (0 > c && p == t)for (; !a(".menu-item-depth-" + e, b.menuList).length && e > 0;)e--;
                    s.removeClass("menu-max-depth-" + t).addClass("menu-max-depth-" + e), t = e
                }
            }

            var g, h, i, j, k, l, m, n, o, p, q = 0, r = b.menuList.offset().left, s = a("body"), t = e();
            0 !== a("#menu-to-edit li").length && a(".drag-instructions").show(), r += b.isRTL ? b.menuList.width() : 0, b.menuList.sortable({
                handle: ".menu-item-handle",
                placeholder: "sortable-placeholder",
                start: function (e, f) {
                    var h, i, j, k, l;
                    b.isRTL && (f.item[0].style.right = "auto"), o = f.item.children(".menu-item-transport"), g = f.item.menuItemDepth(), d(f, g), j = f.item.next()[0] == f.placeholder[0] ? f.item.next() : f.item, k = j.childMenuItems(), o.append(k), h = o.outerHeight(), h += h > 0 ? 1 * f.placeholder.css("margin-top").slice(0, -2) : 0, h += f.helper.outerHeight(), n = h, h -= 2, f.placeholder.height(h), p = g, k.each(function () {
                        var b = a(this).menuItemDepth();
                        p = b > p ? b : p
                    }), i = f.helper.find(".menu-item-handle").outerWidth(), i += b.depthToPx(p - g), i -= 2, f.placeholder.width(i), l = f.placeholder.next(), l.css("margin-top", n + "px"), f.placeholder.detach(), a(this).sortable("refresh"), f.item.after(f.placeholder), l.css("margin-top", 0), c(f)
                },
                stop: function (a, c) {
                    var d, e, h = q - g;
                    d = o.children().insertAfter(c.item), e = c.item.find(".item-title .is-submenu"), q > 0 ? e.show() : e.hide(), 0 !== h && (c.item.updateDepthClass(q), d.shiftDepthClass(h), f(h)), b.registerChange(), c.item.updateParentMenuItemDBId(), c.item[0].style.top = 0, b.isRTL && (c.item[0].style.left = "auto", c.item[0].style.right = 0), b.refreshKeyboardAccessibility(), b.refreshAdvancedAccessibility()
                },
                change: function (a, d) {
                    d.placeholder.parent().hasClass("menu") || (j.length ? j.after(d.placeholder) : b.menuList.prepend(d.placeholder)), c(d)
                },
                sort: function (e, f) {
                    var g = f.helper.offset(), j = b.isRTL ? g.left + f.helper.width() : g.left, o = b.negateIfRTL * b.pxToDepth(j - r);
                    o > i || g.top < l ? o = i : h > o && (o = h), o != q && d(f, o), m && g.top + n > m && (k.after(f.placeholder), c(f), a(this).sortable("refreshPositions"))
                }
            })
        },
        initManageLocations: function () {
            a("#menu-locations-wrap form").submit(function () {
                window.onbeforeunload = null
            }), a(".menu-location-menus select").on("change", function () {
                var b = a(this).closest("tr").find(".locations-edit-menu-link");
                a(this).find("option:selected").data("orig") ? b.show() : b.hide()
            })
        },
        attachMenuEditListeners: function () {
            var b = this;
            a("#update-nav-menu").bind("click", function (a) {
                if (a.target && a.target.className) {
                    if (-1 != a.target.className.indexOf("item-edit"))return b.eventOnClickEditLink(a.target);
                    if (-1 != a.target.className.indexOf("menu-save"))return b.eventOnClickMenuSave(a.target);
                    if (-1 != a.target.className.indexOf("menu-delete"))return b.eventOnClickMenuDelete(a.target);
                    if (-1 != a.target.className.indexOf("item-delete"))return b.eventOnClickMenuItemDelete(a.target);
                    if (-1 != a.target.className.indexOf("item-cancel"))return b.eventOnClickCancelLink(a.target)
                }
            }), a('#add-custom-links input[type="text"]').keypress(function (b) {
                13 === b.keyCode && (b.preventDefault(), a("#submit-customlinkdiv").click())
            })
        },
        setupInputWithDefaultTitle: function () {
            var b = "input-with-default-title";
            a("." + b).each(function () {
                var c = a(this), d = c.attr("title"), e = c.val();
                if (c.data(b, d), "" === e)c.val(d); else {
                    if (d == e)return;
                    c.removeClass(b)
                }
            }).focus(function () {
                var c = a(this);
                c.val() == c.data(b) && c.val("").removeClass(b)
            }).blur(function () {
                var c = a(this);
                "" === c.val() && c.addClass(b).val(c.data(b))
            }), a(".blank-slate .input-with-default-title").focus()
        },
        attachThemeLocationsListeners: function () {
            var b = a("#nav-menu-theme-locations"), c = {};
            c.action = "menu-locations-save", c["menu-settings-column-nonce"] = a("#menu-settings-column-nonce").val(), b.find('input[type="submit"]').click(function () {
                return b.find("select").each(function () {
                    c[this.name] = a(this).val()
                }), b.find(".spinner").show(), a.post(ajaxurl, c, function () {
                    b.find(".spinner").hide()
                }), !1
            })
        },
        attachQuickSearchListeners: function () {
            var c;
            a(".quick-search").keypress(function (d) {
                var e = a(this);
                return 13 == d.which ? (b.updateQuickSearchResults(e), !1) : (c && clearTimeout(c), void(c = setTimeout(function () {
                    b.updateQuickSearchResults(e)
                }, 400)))
            }).attr("autocomplete", "off")
        },
        updateQuickSearchResults: function (c) {
            var d, e, f = 2, g = c.val();
            g.length < f || (d = c.parents(".tabs-panel"), e = {
                action: "menu-quick-search",
                "response-format": "markup",
                menu: a("#menu").val(),
                "menu-settings-column-nonce": a("#menu-settings-column-nonce").val(),
                q: g,
                type: c.attr("name")
            }, a(".spinner", d).show(), a.post(ajaxurl, e, function (a) {
                b.processQuickSearchQueryResponse(a, e, d)
            }))
        },
        addCustomLink: function (c) {
            var d = a("#custom-menu-item-url").val(), e = a("#custom-menu-item-name").val();
            return c = c || b.addMenuItemToBottom, "" === d || "http://" == d ? !1 : (a(".customlinkdiv .spinner").show(), void this.addLinkToMenu(d, e, c, function () {
                a(".customlinkdiv .spinner").hide(), a("#custom-menu-item-name").val("").blur(), a("#custom-menu-item-url").val("http://")
            }))
        },
        addCustomHeader: function (c) {
            var e = a("#header-menu-item-name").val();
            return c = c || b.addMenuItemToBottom, (a(".customlinkdiv .spinner").show(), void this.addHeaderToMenu(e, c, function () {
                a(".customlinkdiv .spinner").hide(), a("#custom-menu-item-name").val("").blur(), a("#custom-menu-item-url").val("http://")
            }))
        },
        addHeaderToMenu: function (c, d, e) {
            d = d || b.addMenuItemToBottom, e = e || function () {
            }, b.addItemToMenu({"-1": {"menu-item-type": "header", "menu-item-title": c}}, d, e)
        },
        addLinkToMenu: function (a, c, d, e) {
            d = d || b.addMenuItemToBottom, e = e || function () {
            }, b.addItemToMenu({"-1": {"menu-item-type": "link", "menu-item-url": a, "menu-item-title": c}}, d, e)
        },
        addItemToMenu: function (b, c, d) {
            var e, f = a("#menu").val(), g = a("#menu-settings-column-nonce").val();
            c = c || function () {
            }, d = d || function () {
            }, e = {
                action: "add-menu-item",
                menu: f,
                "menu-settings-column-nonce": g,
                "menu-item": b
            }, a.post(ajaxurl, e, function (b) {
                var f = a("#menu-instructions");
                b = a.trim(b), c(b, e), a("li.pending").hide().fadeIn("slow"), a(".drag-instructions").show(), !f.hasClass("menu-instructions-inactive") && f.siblings().length && f.addClass("menu-instructions-inactive"), d()
                location.reload();
            })
        },
        addMenuItemToBottom: function (c) {
            a(c).hideAdvancedMenuItemFields().appendTo(b.targetList), b.refreshKeyboardAccessibility(), b.refreshAdvancedAccessibility()
        },
        addMenuItemToTop: function (c) {
            a(c).hideAdvancedMenuItemFields().prependTo(b.targetList), b.refreshKeyboardAccessibility(), b.refreshAdvancedAccessibility()
        },
        attachUnsavedChangesListener: function () {
            a("#menu-management input, #menu-management select, #menu-management, #menu-management textarea, .menu-location-menus select").change(function () {
                b.registerChange()
            }), 0 !== a("#menu-to-edit").length || 0 !== a(".menu-location-menus select").length ? window.onbeforeunload = function () {
                return b.menusChanged ? void 0 : void 0
            } : a("#menu-settings-column").find("input,select").end().find("a").attr("href", "#").unbind("click")
        },
        registerChange: function () {
            b.menusChanged = !0
        },
        attachTabsPanelListeners: function () {
            a("#menu-settings-column").bind("click", function (c) {
                var d, e, f, g, h = a(c.target);
                if (h.hasClass("nav-tab-link"))e = h.data("type"), f = h.parents(".accordion-section-content").first(), a("input", f).removeAttr("checked"), a(".tabs-panel-active", f).removeClass("tabs-panel-active").addClass("tabs-panel-inactive"), a("#" + e, f).removeClass("tabs-panel-inactive").addClass("tabs-panel-active"), a(".tabs", f).removeClass("tabs"), h.parent().addClass("tabs"), a(".quick-search", f).focus(), c.preventDefault(); else if (h.hasClass("select-all")) {
                    if (d = /#(.*)$/.exec(c.target.href), d && d[1])return g = a("#" + d[1] + " .tabs-panel-active .menu-item-title input"), g.length === g.filter(":checked").length ? g.removeAttr("checked") : g.prop("checked", !0), !1
                } else {
                    if (h.hasClass("submit-add-header-to-menu"))return b.registerChange(), c.target.id && "submit-headerdiv" == c.target.id ? b.addCustomHeader(b.addMenuItemToBottom) : c.target.id && -1 != c.target.id.indexOf("submit-") && a("#" + c.target.id.replace(/submit-/, "")).addSelectedToMenu(b.addMenuItemToBottom), !1;
                    if (h.hasClass("submit-add-to-menu"))return b.registerChange(), c.target.id && "submit-customlinkdiv" == c.target.id ? b.addCustomLink(b.addMenuItemToBottom) : c.target.id && -1 != c.target.id.indexOf("submit-") && a("#" + c.target.id.replace(/submit-/, "")).addSelectedToMenu(b.addMenuItemToBottom), !1;
                    if (h.hasClass("page-numbers"))return a.post(ajaxurl, c.target.href.replace(/.*\?/, "").replace(/action=([^&]*)/, "") + "&action=menu-get-metabox", function (b) {
                        if (-1 != b.indexOf("replace-id")) {
                            var c = a.parseJSON(b), d = document.getElementById(c["replace-id"]), e = document.createElement("div"), f = document.createElement("div");
                            c.markup && d && (f.innerHTML = c.markup ? c.markup : "", d.parentNode.insertBefore(e, d), e.parentNode.removeChild(d), e.parentNode.insertBefore(f, e), e.parentNode.removeChild(e))
                        }
                    }), !1
                }
            })
        },
        eventOnClickEditLink: function (b) {
            var c, d, e = /#(.*)$/.exec(b.href);
            return e && e[1] && (c = a("#" + e[1]), d = c.parent(), 0 !== d.length) ? (d.hasClass("menu-item-edit-inactive") ? (c.data("menu-item-data") || c.data("menu-item-data", c.getItemData()), c.slideDown("fast"), d.removeClass("menu-item-edit-inactive").addClass("menu-item-edit-active")) : (c.slideUp("fast"), d.removeClass("menu-item-edit-active").addClass("menu-item-edit-inactive")), !1) : void 0
        },
        eventOnClickCancelLink: function (b) {
            var c = a(b).closest(".menu-item-settings"), d = a(b).closest(".menu-item");
            return d.removeClass("menu-item-edit-active").addClass("menu-item-edit-inactive"), c.setItemData(c.data("menu-item-data")).hide(), !1
        },
        eventOnClickMenuSave: function () {
            var c = "", d = a("#menu-name"), e = d.val();
            return e && e != d.attr("title") && e.replace(/\s+/, "") ? (a("#nav-menu-theme-locations select").each(function () {
                c += '<input type="hidden" name="' + this.name + '" value="' + a(this).val() + '" />'
            }), a("#update-nav-menu").append(c), b.menuList.find(".menu-item-data-position").val(function (a) {
                return a + 1
            }), window.onbeforeunload = null, !0) : (d.parent().addClass("form-invalid"), !1)
        },
        eventOnClickMenuDelete: function () {
            return window.confirm(navMenuL10n.warnDeleteMenu) ? (window.onbeforeunload = null, !0) : !1
        },
        eventOnClickMenuItemDelete: function (c) {
            var d = parseInt(c.id.replace("delete-", ""), 10);
            return b.removeMenuItem(a("#menu-item-" + d)), b.registerChange(), !1
        },
        processQuickSearchQueryResponse: function (b, c, d) {
            var e, f, g, h = {}, i = document.getElementById("nav-menu-meta"), j = /menu-item[(\[^]\]*/, k = a("<div>").html(b).find("li");
            return k.length ? (k.each(function () {
                if (g = a(this), e = j.exec(g.html()), e && e[1]) {
                    for (f = e[1]; i.elements["menu-item[" + f + "][menu-item-type]"] || h[f];)f--;
                    h[f] = !0, f != e[1] && g.html(g.html().replace(new RegExp("menu-item\\[" + e[1] + "\\]", "g"), "menu-item[" + f + "]"))
                }
            }), a(".categorychecklist", d).html(k), void a(".spinner", d).hide()) : (a(".categorychecklist", d).html("<li><p>" + navMenuL10n.noResultsFound + "</p></li>"), void a(".spinner", d).hide())
        },
        removeMenuItem: function (b) {
            var c = b.childMenuItems();
            b.addClass("deleting").animate({opacity: 0, height: 0}, 350, function () {
                var d = a("#menu-instructions");
                b.remove(), c.shiftDepthClass(-1).updateParentMenuItemDBId(), 0 === a("#menu-to-edit li").length && (a(".drag-instructions").hide(), d.removeClass("menu-instructions-inactive"))
            })
        },
        depthToPx: function (a) {
            return a * b.options.menuItemDepthPerLevel
        },
        pxToDepth: function (a) {
            return Math.floor(a / b.options.menuItemDepthPerLevel)
        }
    }, a(document).ready(function () {
        mooNavMenu.init()
    })
}(jQuery);

!function (a) {
    a.fn.hoverIntent = function (b, c, d) {
        var e = {interval: 100, sensitivity: 7, timeout: 0};
        e = "object" == typeof b ? a.extend(e, b) : a.isFunction(c) ? a.extend(e, {
            over: b,
            out: c,
            selector: d
        }) : a.extend(e, {over: b, out: b, selector: c});
        var f, g, h, i, j = function (a) {
            f = a.pageX, g = a.pageY
        }, k = function (b, c) {
            return c.hoverIntent_t = clearTimeout(c.hoverIntent_t), Math.abs(h - f) + Math.abs(i - g) < e.sensitivity ? (a(c).off("mousemove.hoverIntent", j), c.hoverIntent_s = 1, e.over.apply(c, [b])) : (h = f, i = g, c.hoverIntent_t = setTimeout(function () {
                k(b, c)
            }, e.interval), void 0)
        }, l = function (a, b) {
            return b.hoverIntent_t = clearTimeout(b.hoverIntent_t), b.hoverIntent_s = 0, e.out.apply(b, [a])
        }, m = function (b) {
            var c = jQuery.extend({}, b), d = this;
            d.hoverIntent_t && (d.hoverIntent_t = clearTimeout(d.hoverIntent_t)), "mouseenter" == b.type ? (h = c.pageX, i = c.pageY, a(d).on("mousemove.hoverIntent", j), 1 != d.hoverIntent_s && (d.hoverIntent_t = setTimeout(function () {
                k(c, d)
            }, e.interval))) : (a(d).off("mousemove.hoverIntent", j), 1 == d.hoverIntent_s && (d.hoverIntent_t = setTimeout(function () {
                l(c, d)
            }, e.timeout)))
        };
        return this.on({"mouseenter.hoverIntent": m, "mouseleave.hoverIntent": m}, e.selector)
    }
}(jQuery);

var showNotice, adminMenu, columns, validateForm, screenMeta;
!function (a, b) {
    adminMenu = {
        init: function () {
        }, fold: function () {
        }, restoreMenuState: function () {
        }, toggle: function () {
        }, favorites: function () {
        }
    }, columns = {
        init: function () {
            var b = this;
            a(".hide-column-tog", "#adv-settings").click(function () {
                var c = a(this), d = c.val();
                c.prop("checked") ? b.checked(d) : b.unchecked(d), columns.saveManageColumnsState()
            })
        }, saveManageColumnsState: function () {
            var b = this.hidden();
            a.post(ajaxurl, {
                action: "hidden-columns",
                hidden: b,
                screenoptionnonce: a("#screenoptionnonce").val(),
                page: pagenow
            })
        }, checked: function (b) {
            a(".column-" + b).show(), this.colSpanChange(1)
        }, unchecked: function (b) {
            a(".column-" + b).hide(), this.colSpanChange(-1)
        }, hidden: function () {
            return a(".manage-column").filter(":hidden").map(function () {
                return this.id
            }).get().join(",")
        }, useCheckboxesForHidden: function () {
            this.hidden = function () {
                return a(".hide-column-tog").not(":checked").map(function () {
                    var a = this.id;
                    return a.substring(a, a.length - 5)
                }).get().join(",")
            }
        }, colSpanChange: function (b) {
            var c, d = a("table").find(".colspanchange");
            d.length && (c = parseInt(d.attr("colspan"), 10) + b, d.attr("colspan", c.toString()))
        }
    }, a(document).ready(function () {
        columns.init()
    }), validateForm = function (b) {
        return !a(b).find(".form-required").filter(function () {
            return "" === a("input:visible", this).val()
        }).addClass("form-invalid").find("input:visible").change(function () {
            a(this).closest(".form-invalid").removeClass("form-invalid")
        }).size()
    }, showNotice = {
        warn: function () {
            var a = commonL10n.warnDelete || "";
            return confirm(a) ? !0 : !1
        }, note: function (a) {
            alert(a)
        }
    }, screenMeta = {
        element: null, toggles: null, page: null, init: function () {
            this.element = a("#screen-meta"), this.toggles = a(".screen-meta-toggle a"), this.page = a("#wpcontent"), this.toggles.click(this.toggleEvent)
        }, toggleEvent: function (b) {
            var c = a(this.href.replace(/.+#/, "#"));
            b.preventDefault(), c.length && (c.is(":visible") ? screenMeta.close(c, a(this)) : screenMeta.open(c, a(this)))
        }, open: function (b, c) {
            a(".screen-meta-toggle").not(c.parent()).css("visibility", "hidden"), b.parent().show(), b.slideDown("fast", function () {
                b.focus(), c.addClass("screen-meta-active").attr("aria-expanded", !0)
            }), a(document).trigger("screen:options:open")
        }, close: function (b, c) {
            b.slideUp("fast", function () {
                c.removeClass("screen-meta-active").attr("aria-expanded", !1), a(".screen-meta-toggle").css("visibility", ""), b.parent().hide()
            }), a(document).trigger("screen:options:close")
        }
    }, a(".contextual-help-tabs").delegate("a", "click", function (b) {
        var c, d = a(this);
        return b.preventDefault(), d.is(".active a") ? !1 : (a(".contextual-help-tabs .active").removeClass("active"), d.parent("li").addClass("active"), c = a(d.attr("href")), a(".help-tab-content").not(c).removeClass("active").hide(), void c.addClass("active").show())
    }), a(document).ready(function () {
        var c, d, e, f, g, h, i, j, k = !1, l = a("#adminmenu"), m = a("input.current-page"), n = m.val();
        l.on("click.wp-submenu-head", ".wp-submenu-head", function (b) {
            a(b.target).parent().siblings("a").get(0).click()
        }), a("#collapse-menu").on("click.collapse-menu", function () {
            var c, d, e = a(document.body);
            a("#adminmenu div.wp-submenu").css("margin-top", ""), c = b.innerWidth ? Math.max(b.innerWidth, document.documentElement.clientWidth) : 961, c && 960 > c ? e.hasClass("auto-fold") ? (e.removeClass("auto-fold").removeClass("folded"), setUserSetting("unfold", 1), setUserSetting("mfold", "o"), d = "open") : (e.addClass("auto-fold"), setUserSetting("unfold", 0), d = "folded") : e.hasClass("folded") ? (e.removeClass("folded"), setUserSetting("mfold", "o"), d = "open") : (e.addClass("folded"), setUserSetting("mfold", "f"), d = "folded"), a(document).trigger("wp-collapse-menu", {state: d})
        }), ("ontouchstart"in b || /IEMobile\/[1-9]/.test(navigator.userAgent)) && (h = /Mobile\/.+Safari/.test(navigator.userAgent) ? "touchstart" : "click", a(document.body).on(h + ".wp-mobile-hover", function (b) {
            l.data("wp-responsive") || a(b.target).closest("#adminmenu").length || l.find("li.wp-has-submenu.opensub").removeClass("opensub")
        }), l.find("a.wp-has-submenu").on(h + ".wp-mobile-hover", function (c) {
            var d, e, f, g, h, i, j, k = a(this), m = k.parent(), n = m.find(".wp-submenu");
            l.data("wp-responsive") || m.hasClass("opensub") || m.hasClass("wp-menu-open") && !(m.width() < 40) || (c.preventDefault(), h = m.offset().top, i = a(b).scrollTop(), j = h - i - 30, d = h + n.height() + 1, e = a("#wpwrap").height(), f = 60 + d - e, g = a(b).height() + i - 50, d - f > g && (f = d - g), f > j && (f = j), f > 1 ? n.css("margin-top", "-" + f + "px") : n.css("margin-top", ""), l.find("li.opensub").removeClass("opensub"), m.addClass("opensub"))
        })), l.find("li.wp-has-submenu").hoverIntent({
            over: function () {
                var c, d, e, f, g, h, i, j = a(this).find(".wp-submenu"), k = parseInt(j.css("top"), 10);
                isNaN(k) || k > -5 || l.data("wp-responsive") || (g = a(this).offset().top, h = a(b).scrollTop(), i = g - h - 30, c = g + j.height() + 1, d = a("#wpwrap").height(), e = 60 + c - d, f = a(b).height() + h - 15, c - e > f && (e = c - f), e > i && (e = i), e > 1 ? j.css("margin-top", "-" + e + "px") : j.css("margin-top", ""), l.find("li.menu-top").removeClass("opensub"), a(this).addClass("opensub"))
            }, out: function () {
                l.data("wp-responsive") || a(this).removeClass("opensub").find(".wp-submenu").css("margin-top", "")
            }, timeout: 200, sensitivity: 7, interval: 90
        }), l.on("focus.adminmenu", ".wp-submenu a", function (b) {
            l.data("wp-responsive") || a(b.target).closest("li.menu-top").addClass("opensub")
        }).on("blur.adminmenu", ".wp-submenu a", function (b) {
            l.data("wp-responsive") || a(b.target).closest("li.menu-top").removeClass("opensub")
        }), a("div.wrap h2:first").nextAll("div.updated, div.error").addClass("below-h2"), a("div.updated, div.error").not(".below-h2, .inline").insertAfter(a("div.wrap h2:first")), screenMeta.init(), a("tbody").children().children(".check-column").find(":checkbox").click(function (b) {
            if ("undefined" == b.shiftKey)return !0;
            if (b.shiftKey) {
                if (!k)return !0;
                c = a(k).closest("form").find(":checkbox"), d = c.index(k), e = c.index(this), f = a(this).prop("checked"), d > 0 && e > 0 && d != e && (g = e > d ? c.slice(d, e) : c.slice(e, d), g.prop("checked", function () {
                    return a(this).closest("tr").is(":visible") ? f : !1
                }))
            }
            k = this;
            var h = a(this).closest("tbody").find(":checkbox").filter(":visible").not(":checked");
            return a(this).closest("table").children("thead, tfoot").find(":checkbox").prop("checked", function () {
                return 0 === h.length
            }), !0
        }), a("thead, tfoot").find(".check-column :checkbox").on("click.wp-toggle-checkboxes", function (b) {
            var c = a(this), d = c.closest("table"), e = c.prop("checked"), f = b.shiftKey || c.data("wp-toggle");
            d.children("tbody").filter(":visible").children().children(".check-column").find(":checkbox").prop("checked", function () {
                return a(this).is(":hidden") ? !1 : f ? !a(this).prop("checked") : e ? !0 : !1
            }), d.children("thead,  tfoot").filter(":visible").children().children(".check-column").find(":checkbox").prop("checked", function () {
                return f ? !1 : e ? !0 : !1
            })
        }), a("td.post-title, td.title, td.comment, .bookmarks td.column-name, td.blogname, td.username, .dashboard-comment-wrap").focusin(function () {
            clearTimeout(i), j = a(this).find(".row-actions"), j.addClass("visible")
        }).focusout(function () {
            i = setTimeout(function () {
                j.removeClass("visible")
            }, 30)
        }), a("#default-password-nag-no").click(function () {
            return setUserSetting("default_password_nag", "hide"), a("div.default-password-nag").hide(), !1
        }), a("#newcontent").bind("keydown.wpevent_InsertTab", function (b) {
            var c, d, e, f, g, h = b.target;
            if (27 == b.keyCode)return void a(h).data("tab-out", !0);
            if (!(9 != b.keyCode || b.ctrlKey || b.altKey || b.shiftKey)) {
                if (a(h).data("tab-out"))return void a(h).data("tab-out", !1);
                c = h.selectionStart, d = h.selectionEnd, e = h.value;
                try {
                    this.lastKey = 9
                } catch (i) {
                }
                document.selection ? (h.focus(), g = document.selection.createRange(), g.text = "	") : c >= 0 && (f = this.scrollTop, h.value = e.substring(0, c).concat("	", e.substring(d)), h.selectionStart = h.selectionEnd = c + 1, this.scrollTop = f), b.stopPropagation && b.stopPropagation(), b.preventDefault && b.preventDefault()
            }
        }), a("#newcontent").bind("blur.wpevent_InsertTab", function () {
            this.lastKey && 9 == this.lastKey && this.focus()
        }), m.length && m.closest("form").submit(function () {
            -1 == a('select[name="action"]').val() && -1 == a('select[name="action2"]').val() && m.val() == n && m.val("1")
        }), a('.search-box input[type="search"], .search-box input[type="submit"]').mousedown(function () {
            a('select[name^="action"]').val("-1")
        }), a("#contextual-help-link, #show-settings-link").on("focus.scroll-into-view", function (a) {
            a.target.scrollIntoView && a.target.scrollIntoView(!1)
        }), function () {
            function b() {
                c.prop("disabled", "" === d.map(function () {
                    return a(this).val()
                }).get().join(""))
            }

            var c, d, e = a("form.wp-upload-form");
            e.length && (c = e.find('input[type="submit"]'), d = e.find('input[type="file"]'), b(), d.on("change", b))
        }()
    }), function () {
        function c() {
            a(document).trigger("wp-window-resized")
        }

        function d() {
            b.clearTimeout(e), e = b.setTimeout(c, 200)
        }

        var e;
        a(b).on("resize.wp-fire-once", d)
    }(), a(document).ready(function () {
        var c = a(document), d = a(b), e = a(document.body), f = a("#adminmenuwrap"), g = a("#collapse-menu"), h = a("#wpwrap"), i = a("#adminmenu"), j = a("#wp-responsive-overlay"), k = a("#wp-toolbar"), l = k.find('a[aria-haspopup="true"]'), m = a(".meta-box-sortables"), n = !1, o = !1;
        b.stickyMenu = {
            enable: function () {
                n || (c.on("wp-window-resized.sticky-menu", a.proxy(this.update, this)), g.on("click.sticky-menu", a.proxy(this.update, this)), this.update(), n = !0)
            }, disable: function () {
                n && (d.off("resize.sticky-menu"), g.off("click.sticky-menu"), e.removeClass("sticky-menu"), n = !1)
            }, update: function () {
                d.height() > f.height() + 32 ? e.hasClass("sticky-menu") || e.addClass("sticky-menu") : e.hasClass("sticky-menu") && e.removeClass("sticky-menu")
            }
        }, b.wpResponsive = {
            init: function () {
                var e = this;
                c.on("wp-responsive-activate.wp-responsive", function () {
                    e.activate()
                }).on("wp-responsive-deactivate.wp-responsive", function () {
                    e.deactivate()
                }), a("#wp-admin-bar-menu-toggle a").attr("aria-expanded", "false"), a("#wp-admin-bar-menu-toggle").on("click.wp-responsive", function (b) {
                    b.preventDefault(), h.toggleClass("wp-responsive-open"), h.hasClass("wp-responsive-open") ? (a(this).find("a").attr("aria-expanded", "true"), a("#adminmenu a:first").focus()) : a(this).find("a").attr("aria-expanded", "false")
                }), i.on("click.wp-responsive", "li.wp-has-submenu > a", function (b) {
                    i.data("wp-responsive") && (a(this).parent("li").toggleClass("selected"), b.preventDefault())
                }), e.trigger(), c.on("wp-window-resized.wp-responsive", a.proxy(this.trigger, this)), d.on("load.wp-responsive", function () {
                    var a = navigator.userAgent.indexOf("AppleWebKit/") > -1 ? d.width() : b.innerWidth;
                    782 >= a && e.disableSortables()
                })
            }, activate: function () {
                b.stickyMenu.disable(), e.hasClass("auto-fold") || e.addClass("auto-fold"), i.data("wp-responsive", 1), this.disableSortables()
            }, deactivate: function () {
                b.stickyMenu.enable(), i.removeData("wp-responsive"), this.enableSortables()
            }, trigger: function () {
                var a;
                b.innerWidth && (a = Math.max(b.innerWidth, document.documentElement.clientWidth), 782 >= a ? o || (c.trigger("wp-responsive-activate"), o = !0) : o && (c.trigger("wp-responsive-deactivate"), o = !1), 480 >= a ? this.enableOverlay() : this.disableOverlay())
            }, enableOverlay: function () {
                0 === j.length && (j = a('<div id="wp-responsive-overlay"></div>').insertAfter("#wpcontent").hide().on("click.wp-responsive", function () {
                    k.find(".menupop.hover").removeClass("hover"), a(this).hide()
                })), l.on("click.wp-responsive", function () {
                    j.show()
                })
            }, disableOverlay: function () {
                l.off("click.wp-responsive"), j.hide()
            }, disableSortables: function () {
                if (m.length)try {
                    m.sortable("disable")
                } catch (a) {
                }
            }, enableSortables: function () {
                if (m.length)try {
                    m.sortable("enable")
                } catch (a) {
                }
            }
        }, b.stickyMenu.enable(), b.wpResponsive.init()
    }), function () {
        if ("-ms-user-select"in document.documentElement.style && navigator.userAgent.match(/IEMobile\/10\.0/)) {
            var a = document.createElement("style");
            a.appendChild(document.createTextNode("@-ms-viewport{width:auto!important}")), document.getElementsByTagName("head")[0].appendChild(a)
        }
    }()
}(jQuery, window);
!function (a) {
    function b(a) {
        var b = a.closest(".accordion-section"), e = b.closest(".accordion-container").find(".open"), f = b.find(d);
        if (!b.hasClass("cannot-expand"))return b.hasClass("control-panel") ? void c(b) : void(b.hasClass("open") ? (b.toggleClass("open"), f.toggle(!0).slideToggle(150)) : (e.removeClass("open"), e.find(d).show().slideUp(150), f.toggle(!1).slideToggle(150), b.toggleClass("open")))
    }

    function c(a) {
        var b, c, e = a.closest(".accordion-section"), f = e.closest(".wp-full-overlay"), g = e.closest(".accordion-container"), h = g.find(".open"), i = f.find("#customize-theme-controls > ul > .accordion-section > .accordion-section-title").add("#customize-info > .accordion-section-title"), j = f.find(".control-panel-back"), k = e.find(".accordion-section-title").first(), l = e.find(".control-panel-content");
        e.hasClass("current-panel") ? (e.toggleClass("current-panel"), f.toggleClass("in-sub-panel"), l.delay(180).hide(0, function () {
            l.css("margin-top", "inherit")
        }), i.attr("tabindex", "0"), j.attr("tabindex", "-1"), k.focus(), g.scrollTop(0)) : (h.removeClass("open"), h.find(d).show().slideUp(0), l.show(0, function () {
            b = l.offset().top, c = g.scrollTop(), l.css("margin-top", 45 - b - c), e.toggleClass("current-panel"), f.toggleClass("in-sub-panel"), g.scrollTop(0)
        }), i.attr("tabindex", "-1"), j.attr("tabindex", "0"), j.focus())
    }

    a(document).ready(function () {
        a(".accordion-container").on("click keydown", ".accordion-section-title", function (c) {
            ("keydown" !== c.type || 13 === c.which) && (c.preventDefault(), b(a(this)))
        }), a("#customize-header-actions").on("click keydown", ".control-panel-back", function (b) {
            ("keydown" !== b.type || 13 === b.which) && (b.preventDefault(), c(a(".current-panel")))
        })
    });
    var d = a(".accordion-section-content")
}(jQuery);