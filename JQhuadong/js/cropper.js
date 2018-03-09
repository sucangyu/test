/*!
 * Cropper v0.9.2
 * https://github.com/fengyuanchen/cropper
 *
 * Copyright (c) 2014-2015 Fengyuan Chen and contributors
 * Released under the MIT license
 *
 * Date: 2015-04-18T04:35:01.500Z
 */
!
function(a) {
    "function" == typeof define && define.amd ? define(["jquery"], a) : a("object" == typeof exports ? require("jquery") : jQuery)
} (function(a) {
    "use strict";
    function b(a) {
        return "number" == typeof a
    }
    function c(a) {
        return "undefined" == typeof a
    }
    function d(a, c) {
        var d = [];
        return b(c) && d.push(c),
        d.slice.apply(a, d)
    }
    function e(a, b) {
        var c = d(arguments, 2);
        return function() {
            return a.apply(b, c.concat(d(arguments)))
        }
    }
    function f(a) {
        var b = a.match(/^(https?:)\/\/([^\:\/\?#]+):?(\d*)/i);
        return b && (b[1] !== o.protocol || b[2] !== o.hostname || b[3] !== o.port)
    }
    function g(a) {
        var b = "timestamp=" + (new Date).getTime();
        return a + ( - 1 === a.indexOf("?") ? "?": "&") + b
    }
    function h(a, b) {
        return b.left < 0 && a.width < b.left + b.width && b.top < 0 && a.height < b.top + b.height
    }
    function i(a) {
        return a ? "rotate(" + a + "deg)": "none"
    }
    function j(a, b) {
        var c, d, e = R(a.degree) % 180,
        f = (e > 90 ? 180 - e: e) * Math.PI / 180,
        g = S(f),
        h = T(f),
        i = a.width,
        j = a.height,
        k = a.aspectRatio;
        return b ? (c = i / (h + g / k), d = c / k) : (c = i * h + j * g, d = i * g + j * h),
        {
            width: c,
            height: d
        }
    }
    function k(b, c) {
        var d = a("<canvas>")[0],
        e = d.getContext("2d"),
        f = c.naturalWidth,
        g = c.naturalHeight,
        h = c.rotate,
        i = j({
            width: f,
            height: g,
            degree: h
        });
        return h ? (d.width = i.width, d.height = i.height, e.save(), e.translate(i.width / 2, i.height / 2), e.rotate(h * Math.PI / 180), e.drawImage(b, -f / 2, -g / 2, f, g), e.restore()) : (d.width = f, d.height = g, e.drawImage(b, 0, 0, f, g)),
        d
    }
    function l(b, c) {
        this.$element = a(b),
        this.options = a.extend({},
        l.DEFAULTS, a.isPlainObject(c) && c),
        this.ready = !1,
        this.built = !1,
        this.rotated = !1,
        this.cropped = !1,
        this.disabled = !1,
        this.canvas = null,
        this.cropBox = null,
        this.load()
    }
    var m = a(window),
    n = a(document),
    o = window.location,
    p = ".cropper",
    q = "preview" + p,
    r = /^(e|n|w|s|ne|nw|sw|se|all|crop|move|zoom)$/,
    s = "cropper-modal",
    t = "cropper-hide",
    u = "cropper-hidden",
    v = "cropper-invisible",
    w = "cropper-move",
    x = "cropper-crop",
    y = "cropper-disabled",
    z = "cropper-bg",
    A = "mousedown touchstart",
    B = "mousemove touchmove",
    C = "mouseup mouseleave touchend touchleave touchcancel",
    D = "wheel mousewheel DOMMouseScroll",
    E = "dblclick",
    F = "resize" + p,
    G = "build" + p,
    H = "built" + p,
    I = "dragstart" + p,
    J = "dragmove" + p,
    K = "dragend" + p,
    L = "zoomin" + p,
    M = "zoomout" + p,
    N = a.isFunction(a("<canvas>")[0].getContext),
    O = Math.sqrt,
    P = Math.min,
    Q = Math.max,
    R = Math.abs,
    S = Math.sin,
    T = Math.cos,
    U = parseFloat,
    V = {};
    V.load = function(b) {
        var c, d, e, h, i = this.options,
        j = this.$element;
        if (!b) if (j.is("img")) {
            if (!j.attr("src")) return;
            b = j.prop("src")
        } else j.is("canvas") && N && (b = j[0].toDataURL());
        b && (e = a.Event(G), j.one(G, i.build).trigger(e), e.isDefaultPrevented() || (i.checkImageOrigin && f(b) && (c = "anonymous", j.prop("crossOrigin") || (d = g(b))), this.$clone = h = a("<img>"), h.one("load", a.proxy(function() {
            var a = h.prop("naturalWidth") || h.width(),
            c = h.prop("naturalHeight") || h.height();
            this.image = {
                naturalWidth: a,
                naturalHeight: c,
                aspectRatio: a / c,
                rotate: 0
            },
            this.url = b,
            this.ready = !0,
            this.build()
        },
        this)).one("error",
        function() {
            h.remove()
        }).attr({
            src: d || b,
            crossOrigin: c
        }), h.addClass(t).insertAfter(j)))
    },
    V.build = function() {
        var b, c, d = this.$element,
        e = this.$clone,
        f = this.options;
        this.ready && (this.built && this.unbuild(), this.$cropper = b = a(l.TEMPLATE), d.addClass(u), e.removeClass(t), this.$container = d.parent().append(b), this.$canvas = b.find(".cropper-canvas").append(e), this.$dragBox = b.find(".cropper-drag-box"), this.$cropBox = c = b.find(".cropper-crop-box"), this.$viewBox = b.find(".cropper-view-box"), this.addListeners(), this.initPreview(), f.aspectRatio = U(f.aspectRatio) || 0 / 0, f.autoCrop ? (this.cropped = !0, f.modal && this.$dragBox.addClass(s)) : c.addClass(u), f.background && b.addClass(z), f.highlight || c.find(".cropper-face").addClass(v), f.guides || c.find(".cropper-dashed").addClass(u), f.movable || c.find(".cropper-face").data("drag", "move"), f.resizable || c.find(".cropper-line, .cropper-point").addClass(u), this.setDragMode(f.dragCrop ? "crop": "move"), this.built = !0, this.render(), d.one(H, f.built).trigger(H))
    },
    V.unbuild = function() {
        this.built && (this.built = !1, this.container = null, this.canvas = null, this.cropBox = null, this.removeListeners(), this.resetPreview(), this.$preview = null, this.$viewBox = null, this.$cropBox = null, this.$dragBox = null, this.$canvas = null, this.$container = null, this.$cropper.remove(), this.$cropper = null)
    },
    a.extend(V, {
        render: function() {
            this.initContainer(),
            this.initCanvas(),
            this.initCropBox(),
            this.renderCanvas(),
            this.cropped && this.renderCropBox()
        },
        initContainer: function() {
            var a = this.$element,
            b = this.$container,
            c = this.$cropper,
            d = this.options;
            c.addClass(u),
            a.removeClass(u),
            c.css(this.container = {
                width: Q(b.width(), U(d.minContainerWidth) || 200),
                height: Q(b.height(), U(d.minContainerHeight) || 100)
            }),
            a.addClass(u),
            c.removeClass(u)
        },
        initCanvas: function() {
            var b = this.container,
            c = b.width,
            d = b.height,
            e = this.image,
            f = e.aspectRatio,
            g = {
                aspectRatio: f,
                width: c,
                height: d
            };
            d * f > c ? g.height = c / f: g.width = d * f,
            g.oldLeft = g.left = (c - g.width) / 2,
            g.oldTop = g.top = (d - g.height) / 2,
            this.canvas = g,
            this.limitCanvas(!0, !0),
            this.initialImage = a.extend({},
            e),
            this.initialCanvas = a.extend({},
            g)
        },
        limitCanvas: function(b, c) {
            var d, e, f = this.options,
            g = f.strict,
            h = this.container,
            i = h.width,
            j = h.height,
            k = this.canvas,
            l = k.aspectRatio,
            m = this.cropBox,
            n = this.cropped && m;
            b && (d = U(f.minCanvasWidth) || 0, e = U(f.minCanvasHeight) || 0, d ? (g && (d = Q(n ? m.width: i, d)), e = d / l) : e ? (g && (e = Q(n ? m.height: j, e)), d = e * l) : g && (n ? (d = m.width, e = m.height, e * l > d ? d = e * l: e = d / l) : (d = i, e = j, e * l > d ? e = d / l: d = e * l)), a.extend(k, {
                minWidth: d,
                minHeight: e,
                maxWidth: 1 / 0,
                maxHeight: 1 / 0
            })),
            c && (g ? n ? (k.minLeft = P(m.left, m.left + m.width - k.width), k.minTop = P(m.top, m.top + m.height - k.height), k.maxLeft = m.left, k.maxTop = m.top) : (k.minLeft = P(0, i - k.width), k.minTop = P(0, j - k.height), k.maxLeft = Q(0, i - k.width), k.maxTop = Q(0, j - k.height)) : (k.minLeft = -k.width, k.minTop = -k.height, k.maxLeft = i, k.maxTop = j))
        },
        renderCanvas: function(a) {
            var b, c, d = this.options,
            e = this.canvas,
            f = this.image;
            this.rotated && (this.rotated = !1, c = j({
                width: f.width,
                height: f.height,
                degree: f.rotate
            }), b = c.width / c.height, b !== e.aspectRatio && (e.left -= (c.width - e.width) / 2, e.top -= (c.height - e.height) / 2, e.width = c.width, e.height = c.height, e.aspectRatio = b, this.limitCanvas(!0, !1))),
            (e.width > e.maxWidth || e.width < e.minWidth) && (e.left = e.oldLeft),
            (e.height > e.maxHeight || e.height < e.minHeight) && (e.top = e.oldTop),
            e.width = P(Q(e.width, e.minWidth), e.maxWidth),
            e.height = P(Q(e.height, e.minHeight), e.maxHeight),
            this.limitCanvas(!1, !0),
            e.oldLeft = e.left = P(Q(e.left, e.minLeft), e.maxLeft),
            e.oldTop = e.top = P(Q(e.top, e.minTop), e.maxTop),
            this.$canvas.css({
                width: e.width,
                height: e.height,
                left: e.left,
                top: e.top
            }),
            this.renderImage(),
            this.cropped && d.strict && !h(this.container, e) && this.limitCropBox(!0, !0),
            a && this.output()
        },
        renderImage: function() {
            var b, c = this.canvas,
            d = this.image;
            d.rotate && (b = j({
                width: c.width,
                height: c.height,
                degree: d.rotate,
                aspectRatio: d.aspectRatio
            },
            !0)),
            a.extend(d, b ? {
                width: b.width,
                height: b.height,
                left: (c.width - b.width) / 2,
                top: (c.height - b.height) / 2
            }: {
                width: c.width,
                height: c.height,
                left: 0,
                top: 0
            }),
            this.$clone.css({
                width: d.width,
                height: d.height,
                marginLeft: d.left,
                marginTop: d.top,
                transform: i(d.rotate)
            })
        },
        initCropBox: function() {
            var b = this.options,
            c = this.canvas,
            d = b.aspectRatio,
            e = U(b.autoCropArea) || .8,
            f = {
                width: c.width,
                height: c.height
            };
            d && (c.height * d > c.width ? f.height = f.width / d: f.width = f.height * d),
            this.cropBox = f,
            this.limitCropBox(!0, !0),
            f.width = P(Q(f.width, f.minWidth), f.maxWidth),
            f.height = P(Q(f.height, f.minHeight), f.maxHeight),
            f.width = Q(f.minWidth, f.width * e),
            f.height = Q(f.minHeight, f.height * e),
            f.oldLeft = f.left = c.left + (c.width - f.width) / 2,
            f.oldTop = f.top = c.top + (c.height - f.height) / 2,
            this.initialCropBox = a.extend({},
            f)
        },
        limitCropBox: function(a, b) {
            var c, d, e = this.options,
            f = e.strict,
            g = this.container,
            h = g.width,
            i = g.height,
            j = this.canvas,
            k = this.cropBox,
            l = e.aspectRatio;
            a && (c = U(e.minCropBoxWidth) || 0, d = U(e.minCropBoxHeight) || 0, k.minWidth = P(h, c), k.minHeight = P(i, d), k.maxWidth = P(h, f ? j.width: h), k.maxHeight = P(i, f ? j.height: i), l && (k.maxHeight * l > k.maxWidth ? (k.minHeight = k.minWidth / l, k.maxHeight = k.maxWidth / l) : (k.minWidth = k.minHeight * l, k.maxWidth = k.maxHeight * l)), k.minWidth = P(k.maxWidth, k.minWidth), k.minHeight = P(k.maxHeight, k.minHeight)),
            b && (f ? (k.minLeft = Q(0, j.left), k.minTop = Q(0, j.top), k.maxLeft = P(h, j.left + j.width) - k.width, k.maxTop = P(i, j.top + j.height) - k.height) : (k.minLeft = 0, k.minTop = 0, k.maxLeft = h - k.width, k.maxTop = i - k.height))
        },
        renderCropBox: function() {
            var a = this.options,
            b = this.container,
            c = b.width,
            d = b.height,
            e = this.$cropBox,
            f = this.cropBox; (f.width > f.maxWidth || f.width < f.minWidth) && (f.left = f.oldLeft),
            (f.height > f.maxHeight || f.height < f.minHeight) && (f.top = f.oldTop),
            f.width = P(Q(f.width, f.minWidth), f.maxWidth),
            f.height = P(Q(f.height, f.minHeight), f.maxHeight),
            this.limitCropBox(!1, !0),
            f.oldLeft = f.left = P(Q(f.left, f.minLeft), f.maxLeft),
            f.oldTop = f.top = P(Q(f.top, f.minTop), f.maxTop),
            a.movable && e.find(".cropper-face").data("drag", f.width === c && f.height === d ? "move": "all"),
            e.css({
                width: f.width,
                height: f.height,
                left: f.left,
                top: f.top
            }),
            this.cropped && a.strict && !h(b, this.canvas) && this.limitCanvas(!0, !0),
            this.disabled || this.output()
        },
        output: function() {
            var a = this.options;
            this.preview(),
            a.crop && a.crop.call(this.$element, this.getData())
        }
    }),
    V.initPreview = function() {
        var b = this.url;
        this.$preview = a(this.options.preview),
        this.$viewBox.html('<img src="' + b + '">'),
        this.$preview.each(function() {
            var c = a(this);
            c.data(q, {
                width: c.width(),
                height: c.height(),
                original: c.html()
            }).html('<img src="' + b + '" style="display:block;width:100%;min-width:0!important;min-height:0!important;max-width:none!important;max-height:none!important;image-orientation: 0deg!important">')
        })
    },
    V.resetPreview = function() {
        this.$preview.each(function() {
            var b = a(this);
            b.html(b.data(q).original).removeData(q)
        })
    },
    V.preview = function() {
        var b = this.image,
        c = this.canvas,
        d = this.cropBox,
        e = b.width,
        f = b.height,
        g = d.left - c.left - b.left,
        h = d.top - c.top - b.top,
        j = b.rotate;
        this.cropped && !this.disabled && (this.$viewBox.find("img").css({
            width: e,
            height: f,
            marginLeft: -g,
            marginTop: -h,
            transform: i(j)
        }), this.$preview.each(function() {
            var b = a(this),
            c = b.data(q),
            k = c.width / d.width,
            l = c.width,
            m = d.height * k;
            m > c.height && (k = c.height / d.height, l = d.width * k, m = c.height),
            b.width(l).height(m).find("img").css({
                width: e * k,
                height: f * k,
                marginLeft: -g * k,
                marginTop: -h * k,
                transform: i(j)
            })
        }))
    },
    V.addListeners = function() {
        var b = this.options;
        this.$element.on(I, b.dragstart).on(J, b.dragmove).on(K, b.dragend).on(L, b.zoomin).on(M, b.zoomout),
        this.$cropper.on(A, a.proxy(this.dragstart, this)).on(E, a.proxy(this.dblclick, this)),
        b.zoomable && b.mouseWheelZoom && this.$cropper.on(D, a.proxy(this.wheel, this)),
        n.on(B, this._dragmove = e(this.dragmove, this)).on(C, this._dragend = e(this.dragend, this)),
        b.responsive && m.on(F, this._resize = e(this.resize, this))
    },
    V.removeListeners = function() {
        var a = this.options;
        this.$element.off(I, a.dragstart).off(J, a.dragmove).off(K, a.dragend).off(L, a.zoomin).off(M, a.zoomout),
        this.$cropper.off(A, this.dragstart).off(E, this.dblclick),
        a.zoomable && a.mouseWheelZoom && this.$cropper.off(D, this.wheel),
        n.off(B, this._dragmove).off(C, this._dragend),
        a.responsive && m.off(F, this._resize)
    },
    a.extend(V, {
        resize: function() {
            var b, c, d, e = this.$container,
            f = this.container;
            this.disabled || (d = e.width() / f.width, (1 !== d || e.height() !== f.height) && (b = this.getCanvasData(), c = this.getCropBoxData(), this.render(), this.setCanvasData(a.each(b,
            function(a, c) {
                b[a] = c * d
            })), this.setCropBoxData(a.each(c,
            function(a, b) {
                c[a] = b * d
            }))))
        },
        dblclick: function() {
            this.disabled || this.setDragMode(this.$dragBox.hasClass(x) ? "move": "crop")
        },
        wheel: function(a) {
            var b = a.originalEvent,
            c = 1;
            this.disabled || (a.preventDefault(), b.deltaY ? c = b.deltaY > 0 ? 1 : -1 : b.wheelDelta ? c = -b.wheelDelta / 120 : b.detail && (c = b.detail > 0 ? 1 : -1), this.zoom(.1 * -c))
        },
        dragstart: function(b) {
            var c, d, e, f = this.options,
            g = b.originalEvent,
            h = g && g.touches,
            i = b;
            if (!this.disabled) {
                if (h) {
                    if (e = h.length, e > 1) {
                        if (!f.zoomable || !f.touchDragZoom || 2 !== e) return;
                        i = h[1],
                        this.startX2 = i.pageX,
                        this.startY2 = i.pageY,
                        c = "zoom"
                    }
                    i = h[0]
                }
                if (c = c || a(i.target).data("drag"), r.test(c)) {
                    if (b.preventDefault(), d = a.Event(I, {
                        originalEvent: g,
                        dragType: c
                    }), this.$element.trigger(d), d.isDefaultPrevented()) return;
                    this.dragType = c,
                    this.cropping = !1,
                    this.startX = i.pageX,
                    this.startY = i.pageY,
                    "crop" === c && (this.cropping = !0, this.$dragBox.addClass(s))
                }
            }
        },
        dragmove: function(b) {
            var c, d, e = this.options,
            f = b.originalEvent,
            g = f && f.touches,
            h = b,
            i = this.dragType;
            if (!this.disabled) {
                if (g) {
                    if (d = g.length, d > 1) {
                        if (!e.zoomable || !e.touchDragZoom || 2 !== d) return;
                        h = g[1],
                        this.endX2 = h.pageX,
                        this.endY2 = h.pageY
                    }
                    h = g[0]
                }
                if (i) {
                    if (b.preventDefault(), c = a.Event(J, {
                        originalEvent: f,
                        dragType: i
                    }), this.$element.trigger(c), c.isDefaultPrevented()) return;
                    this.endX = h.pageX,
                    this.endY = h.pageY,
                    this.change()
                }
            }
        },
        dragend: function(b) {
            var c, d = this.dragType;
            if (!this.disabled && d) {
                if (b.preventDefault(), c = a.Event(K, {
                    originalEvent: b.originalEvent,
                    dragType: d
                }), this.$element.trigger(c), c.isDefaultPrevented()) return;
                this.cropping && (this.cropping = !1, this.$dragBox.toggleClass(s, this.cropped && this.options.modal)),
                this.dragType = ""
            }
        }
    }),
    a.extend(V, {
        reset: function() {
            this.built && !this.disabled && (this.image = a.extend({},
            this.initialImage), this.canvas = a.extend({},
            this.initialCanvas), this.renderCanvas(), this.cropped && (this.cropBox = a.extend({},
            this.initialCropBox), this.renderCropBox()))
        },
        clear: function() {
            this.cropped && !this.disabled && (a.extend(this.cropBox, {
                left: 0,
                top: 0,
                width: 0,
                height: 0
            }), this.cropped = !1, this.renderCropBox(), this.limitCanvas(), this.renderCanvas(), this.$dragBox.removeClass(s), this.$cropBox.addClass(u))
        },
        destroy: function() {
            var a = this.$element;
            this.ready ? (this.unbuild(), a.removeClass(u)) : this.$clone.off("load").remove(),
            a.removeData("cropper")
        },
        replace: function(a) { ! this.disabled && a && this.load(a)
        },
        enable: function() {
            this.built && (this.disabled = !1, this.$cropper.removeClass(y))
        },
        disable: function() {
            this.built && (this.disabled = !0, this.$cropper.addClass(y))
        },
        move: function(a, c) {
            var d = this.canvas;
            this.built && !this.disabled && b(a) && b(c) && (d.left += a, d.top += c, this.renderCanvas(!0))
        },
        zoom: function(b) {
            var c, d, e, f = this.canvas;
            if (b = U(b), b && this.built && !this.disabled && this.options.zoomable) {
                if (c = a.Event(b > 0 ? L: M), this.$element.trigger(c), c.isDefaultPrevented()) return;
                b = -1 >= b ? 1 / (1 - b) : 1 >= b ? 1 + b: b,
                d = f.width * b,
                e = f.height * b,
                f.left -= (d - f.width) / 2,
                f.top -= (e - f.height) / 2,
                f.width = d,
                f.height = e,
                this.renderCanvas(!0),
                this.setDragMode("move")
            }
        },
        rotate: function(a) {
            var b = this.image;
            a = U(a),
            a && this.built && !this.disabled && this.options.rotatable && (b.rotate = (b.rotate + a) % 360, this.rotated = !0, this.renderCanvas(!0))
        },
        getData: function() {
            var b, c, d = this.cropBox,
            e = this.canvas,
            f = this.image;
            return this.built && this.cropped ? (c = {
                x: d.left - e.left,
                y: d.top - e.top,
                width: d.width,
                height: d.height
            },
            b = f.width / f.naturalWidth, a.each(c,
            function(a, d) {
                d /= b,
                c[a] = d
            })) : c = {
                x: 0,
                y: 0,
                width: 0,
                height: 0
            },
            c.rotate = f.rotate,
            c
        },
        getContainerData: function() {
            return this.built ? this.container: {}
        },
        getImageData: function() {
            return this.ready ? this.image: {}
        },
        getCanvasData: function() {
            var a, b = this.canvas;
            return this.built && (a = {
                left: b.left,
                top: b.top,
                width: b.width,
                height: b.height
            }),
            a || {}
        },
        setCanvasData: function(c) {
            var d = this.canvas,
            e = d.aspectRatio;
            this.built && !this.disabled && a.isPlainObject(c) && (b(c.left) && (d.left = c.left), b(c.top) && (d.top = c.top), b(c.width) ? (d.width = c.width, d.height = c.width / e) : b(c.height) && (d.height = c.height, d.width = c.height * e), this.renderCanvas(!0))
        },
        getCropBoxData: function() {
            var a, b = this.cropBox;
            return this.built && this.cropped && (a = {
                left: b.left,
                top: b.top,
                width: b.width,
                height: b.height
            }),
            a || {}
        },
        setCropBoxData: function(c) {
            var d = this.cropBox,
            e = this.options.aspectRatio;
            this.built && this.cropped && !this.disabled && a.isPlainObject(c) && (b(c.left) && (d.left = c.left), b(c.top) && (d.top = c.top), e ? b(c.width) ? (d.width = c.width, d.height = d.width / e) : b(c.height) && (d.height = c.height, d.width = d.height * e) : (b(c.width) && (d.width = c.width), b(c.height) && (d.height = c.height)), this.renderCropBox())
        },
        getCroppedCanvas: function(b) {
            var c, d, e, f, g, h, i, j, l, m, n;
            if (this.built && this.cropped && N) return a.isPlainObject(b) || (b = {}),
            n = this.getData(),
            c = n.width,
            d = n.height,
            j = c / d,
            a.isPlainObject(b) && (g = b.width, h = b.height, g ? (h = g / j, i = g / c) : h && (g = h * j, i = h / d)),
            e = g || c,
            f = h || d,
            l = a("<canvas>")[0],
            l.width = e,
            l.height = f,
            m = l.getContext("2d"),
            b.fillColor && (m.fillStyle = b.fillColor, m.fillRect(0, 0, e, f)),
            m.drawImage.apply(m,
            function() {
                var a, b, e, f, g, h, j = k(this.$clone[0], this.image),
                l = j.width,
                m = j.height,
                o = [j],
                p = n.x,
                q = n.y;
                return - c >= p || p > l ? p = a = e = g = 0 : 0 >= p ? (e = -p, p = 0, a = g = P(l, c + p)) : l >= p && (e = 0, a = g = P(c, l - p)),
                0 >= a || -d >= q || q > m ? q = b = f = h = 0 : 0 >= q ? (f = -q, q = 0, b = h = P(m, d + q)) : m >= q && (f = 0, b = h = P(d, m - q)),
                o.push(p, q, a, b),
                i && (e *= i, f *= i, g *= i, h *= i),
                g > 0 && h > 0 && o.push(e, f, g, h),
                o
            }.call(this)),
            l
        },
        setAspectRatio: function(a) {
            var b = this.options;
            this.disabled || c(a) || (b.aspectRatio = U(a) || 0 / 0, this.built && (this.initCropBox(), this.cropped && this.renderCropBox()))
        },
        setDragMode: function(a) {
            var b = this.$dragBox,
            c = !1,
            d = !1;
            if (this.ready && !this.disabled) {
                switch (a) {
                case "crop":
                    this.options.dragCrop ? (c = !0, b.data("drag", a)) : d = !0;
                    break;
                case "move":
                    d = !0,
                    b.data("drag", a);
                    break;
                default:
                    b.removeData("drag")
                }
                b.toggleClass(x, c).toggleClass(w, d)
            }
        }
    }),
    V.change = function() {
        var a, b = this.dragType,
        c = this.options,
        d = this.canvas,
        e = this.container,
        f = this.cropBox,
        g = f.width,
        h = f.height,
        i = f.left,
        j = f.top,
        k = i + g,
        l = j + h,
        m = 0,
        n = 0,
        o = e.width,
        p = e.height,
        q = !0,
        r = c.aspectRatio,
        s = {
            x: this.endX - this.startX,
            y: this.endY - this.startY
        };
        switch (c.strict && (m = f.minLeft, n = f.minTop, o = m + P(e.width, d.width), p = n + P(e.height, d.height)), r && (s.X = s.y * r, s.Y = s.x / r), b) {
        case "all":
            i += s.x,
            j += s.y;
            break;
        case "e":
            if (s.x >= 0 && (k >= o || r && (n >= j || l >= p))) {
                q = !1;
                break
            }
            g += s.x,
            r && (h = g / r, j -= s.Y / 2),
            0 > g && (b = "w", g = 0);
            break;
        case "n":
            if (s.y <= 0 && (n >= j || r && (m >= i || k >= o))) {
                q = !1;
                break
            }
            h -= s.y,
            j += s.y,
            r && (g = h * r, i += s.X / 2),
            0 > h && (b = "s", h = 0);
            break;
        case "w":
            if (s.x <= 0 && (m >= i || r && (n >= j || l >= p))) {
                q = !1;
                break
            }
            g -= s.x,
            i += s.x,
            r && (h = g / r, j += s.Y / 2),
            0 > g && (b = "e", g = 0);
            break;
        case "s":
            if (s.y >= 0 && (l >= p || r && (m >= i || k >= o))) {
                q = !1;
                break
            }
            h += s.y,
            r && (g = h * r, i -= s.X / 2),
            0 > h && (b = "n", h = 0);
            break;
        case "ne":
            if (r) {
                if (s.y <= 0 && (n >= j || k >= o)) {
                    q = !1;
                    break
                }
                h -= s.y,
                j += s.y,
                g = h * r
            } else s.x >= 0 ? o > k ? g += s.x: s.y <= 0 && n >= j && (q = !1) : g += s.x,
            s.y <= 0 ? j > 0 && (h -= s.y, j += s.y) : (h -= s.y, j += s.y);
            0 > g && 0 > h ? (b = "sw", h = 0, g = 0) : 0 > g ? (b = "nw", g = 0) : 0 > h && (b = "se", h = 0);
            break;
        case "nw":
            if (r) {
                if (s.y <= 0 && (n >= j || m >= i)) {
                    q = !1;
                    break
                }
                h -= s.y,
                j += s.y,
                g = h * r,
                i += s.X
            } else s.x <= 0 ? i > 0 ? (g -= s.x, i += s.x) : s.y <= 0 && n >= j && (q = !1) : (g -= s.x, i += s.x),
            s.y <= 0 ? j > 0 && (h -= s.y, j += s.y) : (h -= s.y, j += s.y);
            0 > g && 0 > h ? (b = "se", h = 0, g = 0) : 0 > g ? (b = "ne", g = 0) : 0 > h && (b = "sw", h = 0);
            break;
        case "sw":
            if (r) {
                if (s.x <= 0 && (m >= i || l >= p)) {
                    q = !1;
                    break
                }
                g -= s.x,
                i += s.x,
                h = g / r
            } else s.x <= 0 ? i > 0 ? (g -= s.x, i += s.x) : s.y >= 0 && l >= p && (q = !1) : (g -= s.x, i += s.x),
            s.y >= 0 ? p > l && (h += s.y) : h += s.y;
            0 > g && 0 > h ? (b = "ne", h = 0, g = 0) : 0 > g ? (b = "se", g = 0) : 0 > h && (b = "nw", h = 0);
            break;
        case "se":
            if (r) {
                if (s.x >= 0 && (k >= o || l >= p)) {
                    q = !1;
                    break
                }
                g += s.x,
                h = g / r
            } else s.x >= 0 ? o > k ? g += s.x: s.y >= 0 && l >= p && (q = !1) : g += s.x,
            s.y >= 0 ? p > l && (h += s.y) : h += s.y;
            0 > g && 0 > h ? (b = "nw", h = 0, g = 0) : 0 > g ? (b = "sw", g = 0) : 0 > h && (b = "ne", h = 0);
            break;
        case "move":
            d.left += s.x,
            d.top += s.y,
            this.renderCanvas(!0),
            q = !1;
            break;
        case "zoom":
            this.zoom(function(a, b, c, d) {
                var e = O(a * a + b * b),
                f = O(c * c + d * d);
                return (f - e) / e
            } (R(this.startX - this.startX2), R(this.startY - this.startY2), R(this.endX - this.endX2), R(this.endY - this.endY2))),
            this.startX2 = this.endX2,
            this.startY2 = this.endY2,
            q = !1;
            break;
        case "crop":
            s.x && s.y && (a = this.$cropper.offset(), i = this.startX - a.left, j = this.startY - a.top, g = f.minWidth, h = f.minHeight, s.x > 0 ? s.y > 0 ? b = "se": (b = "ne", j -= h) : s.y > 0 ? (b = "sw", i -= g) : (b = "nw", i -= g, j -= h), this.cropped || (this.cropped = !0, this.$cropBox.removeClass(u)))
        }
        q && (f.width = g, f.height = h, f.left = i, f.top = j, this.dragType = b, this.renderCropBox()),
        this.startX = this.endX,
        this.startY = this.endY
    },
    a.extend(l.prototype, V),
    l.DEFAULTS = {
        aspectRatio: 0 / 0,
        autoCropArea: .8,
        crop: null,
        preview: "",
        strict: !0,
        responsive: !0,
        checkImageOrigin: !0,
        modal: !0,
        guides: !0,
        highlight: !0,
        background: !0,
        autoCrop: !0,
        dragCrop: !0,
        movable: !0,
        resizable: !0,
        rotatable: !0,
        zoomable: !0,
        touchDragZoom: !0,
        mouseWheelZoom: !0,
        minCanvasWidth: 0,
        minCanvasHeight: 0,
        minCropBoxWidth: 0,
        minCropBoxHeight: 0,
        minContainerWidth: 200,
        minContainerHeight: 100,
        build: null,
        built: null,
        dragstart: null,
        dragmove: null,
        dragend: null,
        zoomin: null,
        zoomout: null
    },
    l.setDefaults = function(b) {
        a.extend(l.DEFAULTS, b)
    },
    l.TEMPLATE = function(a, b) {
        return b = b.split(","),
        a.replace(/\d+/g,
        function(a) {
            return b[a]
        })
    } ('<0 6="5-container"><0 6="5-canvas"></0><0 6="5-2-9" 3-2="move"></0><0 6="5-crop-9"><1 6="5-view-9"></1><1 6="5-8 8-h"></1><1 6="5-8 8-v"></1><1 6="5-face" 3-2="all"></1><1 6="5-7 7-e" 3-2="e"></1><1 6="5-7 7-n" 3-2="n"></1><1 6="5-7 7-w" 3-2="w"></1><1 6="5-7 7-s" 3-2="s"></1><1 6="5-4 4-e" 3-2="e"></1><1 6="5-4 4-n" 3-2="n"></1><1 6="5-4 4-w" 3-2="w"></1><1 6="5-4 4-s" 3-2="s"></1><1 6="5-4 4-ne" 3-2="ne"></1><1 6="5-4 4-nw" 3-2="nw"></1><1 6="5-4 4-sw" 3-2="sw"></1><1 6="5-4 4-se" 3-2="se"></1></0></0>', "div,span,drag,data,point,cropper,class,line,dashed,box"),
    l.other = a.fn.cropper,
    a.fn.cropper = function(b) {
        var e, f = d(arguments, 1);
        return this.each(function() {
            var c, d = a(this),
            g = d.data("cropper");
            g || d.data("cropper", g = new l(this, b)),
            "string" == typeof b && a.isFunction(c = g[b]) && (e = c.apply(g, f))
        }),
        c(e) ? this: e
    },
    a.fn.cropper.Constructor = l,
    a.fn.cropper.setDefaults = l.setDefaults,
    a.fn.cropper.noConflict = function() {
        return a.fn.cropper = l.other,
        this
    }
});