! function(a) {
    function b() {
            var a, c;
            for (c = arguments[0] || {}, this.config = {}, this.config.elements = c.elements ? c.elements : [], this.config.attributes = c.attributes ? c.attributes : {}, this.config.attributes[b.ALL] = this.config.attributes[b.ALL] ? this.config.attributes[b.ALL] : [], this.config.allow_comments = c.allow_comments ? c.allow_comments : !1, this.allowed_elements = {}, this.config.protocols = c.protocols ? c.protocols : {}, this.config.add_attributes = c.add_attributes ? c.add_attributes : {}, this.dom = c.dom ? c.dom : document, a = 0; a < this.config.elements.length; a++) this.allowed_elements[this.config.elements[a]] = !0;
            if (this.config.remove_element_contents = {}, this.config.remove_all_contents = !1, c.remove_contents)
                if (c.remove_contents instanceof Array)
                    for (a = 0; a < c.remove_contents.length; a++) this.config.remove_element_contents[c.remove_contents[a]] = !0;
                else this.config.remove_all_contents = !0;
            this.transformers = c.transformers ? c.transformers : []
        }! function(b) {
            "function" == typeof define && define.amd ? define(["jquery"], b) : b("undefined" != typeof jQuery ? jQuery : a.Zepto)
        }(function(b) {
            "use strict";

            function c(a) {
                var c = a.data;
                a.isDefaultPrevented() || (a.preventDefault(), b(a.target).ajaxSubmit(c))
            }

            function d(a) {
                var c = a.target,
                    d = b(c);
                if (!d.is("[type=submit],[type=image]")) {
                    var e = d.closest("[type=submit]");
                    if (0 === e.length) return;
                    c = e[0]
                }
                var f = this;
                if (f.clk = c, "image" == c.type)
                    if (void 0 !== a.offsetX) f.clk_x = a.offsetX, f.clk_y = a.offsetY;
                    else if ("function" == typeof b.fn.offset) {
                    var g = d.offset();
                    f.clk_x = a.pageX - g.left, f.clk_y = a.pageY - g.top
                } else f.clk_x = a.pageX - c.offsetLeft, f.clk_y = a.pageY - c.offsetTop;
                setTimeout(function() {
                    f.clk = f.clk_x = f.clk_y = null
                }, 100)
            }

            function e() {
                if (b.fn.ajaxSubmit.debug) {
                    var c = "[jquery.form] " + Array.prototype.join.call(arguments, "");
                    a.console && a.console.log ? a.console.log(c) : a.opera && a.opera.postError && a.opera.postError(c)
                }
            }
            var f = {};
            f.fileapi = void 0 !== b("<input type='file'/>").get(0).files, f.formdata = void 0 !== a.FormData;
            var g = !!b.fn.prop;
            b.fn.attr2 = function() {
                if (!g) return this.attr.apply(this, arguments);
                var a = this.prop.apply(this, arguments);
                return a && a.jquery || "string" == typeof a ? a : this.attr.apply(this, arguments)
            }, b.fn.ajaxSubmit = function(c) {
                function d(a) {
                    var d, e, f = b.param(a, c.traditional).split("&"),
                        g = f.length,
                        h = [];
                    for (d = 0; g > d; d++) f[d] = f[d].replace(/\+/g, " "), e = f[d].split("="), h.push([decodeURIComponent(e[0]), decodeURIComponent(e[1])]);
                    return h
                }

                function h(a) {
                    for (var e = new FormData, f = 0; f < a.length; f++) e.append(a[f].name, a[f].value);
                    if (c.extraData) {
                        var g = d(c.extraData);
                        for (f = 0; f < g.length; f++) g[f] && e.append(g[f][0], g[f][1])
                    }
                    c.data = null;
                    var h = b.extend(!0, {}, b.ajaxSettings, c, {
                        contentType: !1,
                        processData: !1,
                        cache: !1,
                        type: j || "POST"
                    });
                    c.uploadProgress && (h.xhr = function() {
                        var a = b.ajaxSettings.xhr();
                        return a.upload && a.upload.addEventListener("progress", function(a) {
                            var b = 0,
                                d = a.loaded || a.position,
                                e = a.total;
                            a.lengthComputable && (b = Math.ceil(d / e * 100)), c.uploadProgress(a, d, e, b)
                        }, !1), a
                    }), h.data = null;
                    var i = h.beforeSend;
                    return h.beforeSend = function(a, b) {
                        b.data = c.formData ? c.formData : e, i && i.call(this, a, b)
                    }, b.ajax(h)
                }

                function i(d) {
                    function f(a) {
                        var b = null;
                        try {
                            a.contentWindow && (b = a.contentWindow.document)
                        } catch (c) {
                            e("cannot get iframe.contentWindow document: " + c)
                        }
                        if (b) return b;
                        try {
                            b = a.contentDocument ? a.contentDocument : a.document
                        } catch (c) {
                            e("cannot get iframe.contentDocument: " + c), b = a.document
                        }
                        return b
                    }

                    function h() {
                        function a() {
                            try {
                                var b = f(s).readyState;
                                e("state = " + b), b && "uninitialized" == b.toLowerCase() && setTimeout(a, 50)
                            } catch (c) {
                                e("Server abort: ", c, " (", c.name, ")"), i(B), x && clearTimeout(x), x = void 0
                            }
                        }
                        var c = m.attr2("target"),
                            d = m.attr2("action");
                        y.setAttribute("target", p), (!j || /post/i.test(j)) && y.setAttribute("method", "POST"), d != n.url && y.setAttribute("action", n.url), n.skipEncodingOverride || j && !/post/i.test(j) || m.attr({
                            encoding: "multipart/form-data",
                            enctype: "multipart/form-data"
                        }), n.timeout && (x = setTimeout(function() {
                            w = !0, i(A)
                        }, n.timeout));
                        var g = [];
                        try {
                            if (n.extraData)
                                for (var h in n.extraData) n.extraData.hasOwnProperty(h) && g.push(b.isPlainObject(n.extraData[h]) && n.extraData[h].hasOwnProperty("name") && n.extraData[h].hasOwnProperty("value") ? b('<input type="hidden" name="' + n.extraData[h].name + '">').val(n.extraData[h].value).appendTo(y)[0] : b('<input type="hidden" name="' + h + '">').val(n.extraData[h]).appendTo(y)[0]);
                            n.iframeTarget || r.appendTo("body"), s.attachEvent ? s.attachEvent("onload", i) : s.addEventListener("load", i, !1), setTimeout(a, 15);
                            try {
                                y.submit()
                            } catch (k) {
                                var l = document.createElement("form").submit;
                                l.apply(y)
                            }
                        } finally {
                            y.setAttribute("action", d), c ? y.setAttribute("target", c) : m.removeAttr("target"), b(g).remove()
                        }
                    }

                    function i(c) {
                        if (!t.aborted && !G) {
                            if (F = f(s), F || (e("cannot access response document"), c = B), c === A && t) return t.abort("timeout"), void z.reject(t, "timeout");
                            if (c == B && t) return t.abort("server abort"), void z.reject(t, "error", "server abort");
                            if (F && F.location.href != n.iframeSrc || w) {
                                s.detachEvent ? s.detachEvent("onload", i) : s.removeEventListener("load", i, !1);
                                var d, g = "success";
                                try {
                                    if (w) throw "timeout";
                                    var h = "xml" == n.dataType || F.XMLDocument || b.isXMLDoc(F);
                                    if (e("isXml=" + h), !h && a.opera && (null === F.body || !F.body.innerHTML) && --H) return e("requeing onLoad callback, DOM not available"), void setTimeout(i, 250);
                                    var j = F.body ? F.body : F.documentElement;
                                    t.responseText = j ? j.innerHTML : null, t.responseXML = F.XMLDocument ? F.XMLDocument : F, h && (n.dataType = "xml"), t.getResponseHeader = function(a) {
                                        var b = {
                                            "content-type": n.dataType
                                        };
                                        return b[a.toLowerCase()]
                                    }, j && (t.status = Number(j.getAttribute("status")) || t.status, t.statusText = j.getAttribute("statusText") || t.statusText);
                                    var k = (n.dataType || "").toLowerCase(),
                                        l = /(json|script|text)/.test(k);
                                    if (l || n.textarea) {
                                        var m = F.getElementsByTagName("textarea")[0];
                                        if (m) t.responseText = m.value, t.status = Number(m.getAttribute("status")) || t.status, t.statusText = m.getAttribute("statusText") || t.statusText;
                                        else if (l) {
                                            var p = F.getElementsByTagName("pre")[0],
                                                q = F.getElementsByTagName("body")[0];
                                            p ? t.responseText = p.textContent ? p.textContent : p.innerText : q && (t.responseText = q.textContent ? q.textContent : q.innerText)
                                        }
                                    } else "xml" == k && !t.responseXML && t.responseText && (t.responseXML = I(t.responseText));
                                    try {
                                        E = K(t, k, n)
                                    } catch (u) {
                                        g = "parsererror", t.error = d = u || g
                                    }
                                } catch (u) {
                                    e("error caught: ", u), g = "error", t.error = d = u || g
                                }
                                t.aborted && (e("upload aborted"), g = null), t.status && (g = t.status >= 200 && t.status < 300 || 304 === t.status ? "success" : "error"), "success" === g ? (n.success && n.success.call(n.context, E, "success", t), z.resolve(t.responseText, "success", t), o && b.event.trigger("ajaxSuccess", [t, n])) : g && (void 0 === d && (d = t.statusText), n.error && n.error.call(n.context, t, g, d), z.reject(t, "error", d), o && b.event.trigger("ajaxError", [t, n, d])), o && b.event.trigger("ajaxComplete", [t, n]), o && !--b.active && b.event.trigger("ajaxStop"), n.complete && n.complete.call(n.context, t, g), G = !0, n.timeout && clearTimeout(x), setTimeout(function() {
                                    n.iframeTarget ? r.attr("src", n.iframeSrc) : r.remove(), t.responseXML = null
                                }, 100)
                            }
                        }
                    }
                    var k, l, n, o, p, r, s, t, u, v, w, x, y = m[0],
                        z = b.Deferred();
                    if (z.abort = function(a) {
                            t.abort(a)
                        }, d)
                        for (l = 0; l < q.length; l++) k = b(q[l]), g ? k.prop("disabled", !1) : k.removeAttr("disabled");
                    if (n = b.extend(!0, {}, b.ajaxSettings, c), n.context = n.context || n, p = "jqFormIO" + (new Date).getTime(), n.iframeTarget ? (r = b(n.iframeTarget), v = r.attr2("name"), v ? p = v : r.attr2("name", p)) : (r = b('<iframe name="' + p + '" src="' + n.iframeSrc + '" />'), r.css({
                            position: "absolute",
                            top: "-1000px",
                            left: "-1000px"
                        })), s = r[0], t = {
                            aborted: 0,
                            responseText: null,
                            responseXML: null,
                            status: 0,
                            statusText: "n/a",
                            getAllResponseHeaders: function() {},
                            getResponseHeader: function() {},
                            setRequestHeader: function() {},
                            abort: function(a) {
                                var c = "timeout" === a ? "timeout" : "aborted";
                                e("aborting upload... " + c), this.aborted = 1;
                                try {
                                    s.contentWindow.document.execCommand && s.contentWindow.document.execCommand("Stop")
                                } catch (d) {}
                                r.attr("src", n.iframeSrc), t.error = c, n.error && n.error.call(n.context, t, c, a), o && b.event.trigger("ajaxError", [t, n, c]), n.complete && n.complete.call(n.context, t, c)
                            }
                        }, o = n.global, o && 0 === b.active++ && b.event.trigger("ajaxStart"), o && b.event.trigger("ajaxSend", [t, n]), n.beforeSend && n.beforeSend.call(n.context, t, n) === !1) return n.global && b.active--, z.reject(), z;
                    if (t.aborted) return z.reject(), z;
                    u = y.clk, u && (v = u.name, v && !u.disabled && (n.extraData = n.extraData || {}, n.extraData[v] = u.value, "image" == u.type && (n.extraData[v + ".x"] = y.clk_x, n.extraData[v + ".y"] = y.clk_y)));
                    var A = 1,
                        B = 2,
                        C = b("meta[name=csrf-token]").attr("content"),
                        D = b("meta[name=csrf-param]").attr("content");
                    D && C && (n.extraData = n.extraData || {}, n.extraData[D] = C), n.forceSync ? h() : setTimeout(h, 10);
                    var E, F, G, H = 50,
                        I = b.parseXML || function(b, c) {
                            return a.ActiveXObject ? (c = new ActiveXObject("Microsoft.XMLDOM"), c.async = "false", c.loadXML(b)) : c = (new DOMParser).parseFromString(b, "text/xml"), c && c.documentElement && "parsererror" != c.documentElement.nodeName ? c : null
                        },
                        J = b.parseJSON || function(b) {
                            return a.eval("(" + b + ")")
                        },
                        K = function(a, c, d) {
                            var e = a.getResponseHeader("content-type") || "",
                                f = "xml" === c || !c && e.indexOf("xml") >= 0,
                                g = f ? a.responseXML : a.responseText;
                            return f && "parsererror" === g.documentElement.nodeName && b.error && b.error("parsererror"), d && d.dataFilter && (g = d.dataFilter(g, c)), "string" == typeof g && ("json" === c || !c && e.indexOf("json") >= 0 ? g = J(g) : ("script" === c || !c && e.indexOf("javascript") >= 0) && b.globalEval(g)), g
                        };
                    return z
                }
                if (!this.length) return e("ajaxSubmit: skipping submit process - no element selected"), this;
                var j, k, l, m = this;
                "function" == typeof c ? c = {
                    success: c
                } : void 0 === c && (c = {}), j = c.type || this.attr2("method"), k = c.url || this.attr2("action"), l = "string" == typeof k ? b.trim(k) : "", l = l || a.location.href || "", l && (l = (l.match(/^([^#]+)/) || [])[1]), c = b.extend(!0, {
                    url: l,
                    success: b.ajaxSettings.success,
                    type: j || b.ajaxSettings.type,
                    iframeSrc: /^https/i.test(a.location.href || "") ? "javascript:false" : "about:blank"
                }, c);
                var n = {};
                if (this.trigger("form-pre-serialize", [this, c, n]), n.veto) return e("ajaxSubmit: submit vetoed via form-pre-serialize trigger"), this;
                if (c.beforeSerialize && c.beforeSerialize(this, c) === !1) return e("ajaxSubmit: submit aborted via beforeSerialize callback"), this;
                var o = c.traditional;
                void 0 === o && (o = b.ajaxSettings.traditional);
                var p, q = [],
                    r = this.formToArray(c.semantic, q);
                if (c.data && (c.extraData = c.data, p = b.param(c.data, o)), c.beforeSubmit && c.beforeSubmit(r, this, c) === !1) return e("ajaxSubmit: submit aborted via beforeSubmit callback"), this;
                if (this.trigger("form-submit-validate", [r, this, c, n]), n.veto) return e("ajaxSubmit: submit vetoed via form-submit-validate trigger"), this;
                var s = b.param(r, o);
                p && (s = s ? s + "&" + p : p), "GET" == c.type.toUpperCase() ? (c.url += (c.url.indexOf("?") >= 0 ? "&" : "?") + s, c.data = null) : c.data = s;
                var t = [];
                if (c.resetForm && t.push(function() {
                        m.resetForm()
                    }), c.clearForm && t.push(function() {
                        m.clearForm(c.includeHidden)
                    }), !c.dataType && c.target) {
                    var u = c.success || function() {};
                    t.push(function(a) {
                        var d = c.replaceTarget ? "replaceWith" : "html";
                        b(c.target)[d](a).each(u, arguments)
                    })
                } else c.success && t.push(c.success);
                if (c.success = function(a, b, d) {
                        for (var e = c.context || this, f = 0, g = t.length; g > f; f++) t[f].apply(e, [a, b, d || m, m])
                    }, c.error) {
                    var v = c.error;
                    c.error = function(a, b, d) {
                        var e = c.context || this;
                        v.apply(e, [a, b, d, m])
                    }
                }
                if (c.complete) {
                    var w = c.complete;
                    c.complete = function(a, b) {
                        var d = c.context || this;
                        w.apply(d, [a, b, m])
                    }
                }
                var x = b("input[type=file]:enabled", this).filter(function() {
                        return "" !== b(this).val()
                    }),
                    y = x.length > 0,
                    z = "multipart/form-data",
                    A = m.attr("enctype") == z || m.attr("encoding") == z,
                    B = f.fileapi && f.formdata;
                e("fileAPI :" + B);
                var C, D = (y || A) && !B;
                c.iframe !== !1 && (c.iframe || D) ? c.closeKeepAlive ? b.get(c.closeKeepAlive, function() {
                    C = i(r)
                }) : C = i(r) : C = (y || A) && B ? h(r) : b.ajax(c), m.removeData("jqxhr").data("jqxhr", C);
                for (var E = 0; E < q.length; E++) q[E] = null;
                return this.trigger("form-submit-notify", [this, c]), this
            }, b.fn.ajaxForm = function(a) {
                if (a = a || {}, a.delegation = a.delegation && b.isFunction(b.fn.on), !a.delegation && 0 === this.length) {
                    var f = {
                        s: this.selector,
                        c: this.context
                    };
                    return !b.isReady && f.s ? (e("DOM not ready, queuing ajaxForm"), b(function() {
                        b(f.s, f.c).ajaxForm(a)
                    }), this) : (e("terminating; zero elements found by selector" + (b.isReady ? "" : " (DOM not ready)")), this)
                }
                return a.delegation ? (b(document).off("submit.form-plugin", this.selector, c).off("click.form-plugin", this.selector, d).on("submit.form-plugin", this.selector, a, c).on("click.form-plugin", this.selector, a, d), this) : this.ajaxFormUnbind().bind("submit.form-plugin", a, c).bind("click.form-plugin", a, d)
            }, b.fn.ajaxFormUnbind = function() {
                return this.unbind("submit.form-plugin click.form-plugin")
            }, b.fn.formToArray = function(a, c) {
                var d = [];
                if (0 === this.length) return d;
                var e = this[0],
                    g = a ? e.getElementsByTagName("*") : e.elements;
                if (!g) return d;
                var h, i, j, k, l, m, n;
                for (h = 0, m = g.length; m > h; h++)
                    if (l = g[h], j = l.name, j && !l.disabled)
                        if (a && e.clk && "image" == l.type) e.clk == l && (d.push({
                            name: j,
                            value: b(l).val(),
                            type: l.type
                        }), d.push({
                            name: j + ".x",
                            value: e.clk_x
                        }, {
                            name: j + ".y",
                            value: e.clk_y
                        }));
                        else if (k = b.fieldValue(l, !0), k && k.constructor == Array)
                    for (c && c.push(l), i = 0, n = k.length; n > i; i++) d.push({
                        name: j,
                        value: k[i]
                    });
                else if (f.fileapi && "file" == l.type) {
                    c && c.push(l);
                    var o = l.files;
                    if (o.length)
                        for (i = 0; i < o.length; i++) d.push({
                            name: j,
                            value: o[i],
                            type: l.type
                        });
                    else d.push({
                        name: j,
                        value: "",
                        type: l.type
                    })
                } else null !== k && "undefined" != typeof k && (c && c.push(l), d.push({
                    name: j,
                    value: k,
                    type: l.type,
                    required: l.required
                }));
                if (!a && e.clk) {
                    var p = b(e.clk),
                        q = p[0];
                    j = q.name, j && !q.disabled && "image" == q.type && (d.push({
                        name: j,
                        value: p.val()
                    }), d.push({
                        name: j + ".x",
                        value: e.clk_x
                    }, {
                        name: j + ".y",
                        value: e.clk_y
                    }))
                }
                return d
            }, b.fn.formSerialize = function(a) {
                return b.param(this.formToArray(a))
            }, b.fn.fieldSerialize = function(a) {
                var c = [];
                return this.each(function() {
                    var d = this.name;
                    if (d) {
                        var e = b.fieldValue(this, a);
                        if (e && e.constructor == Array)
                            for (var f = 0, g = e.length; g > f; f++) c.push({
                                name: d,
                                value: e[f]
                            });
                        else null !== e && "undefined" != typeof e && c.push({
                            name: this.name,
                            value: e
                        })
                    }
                }), b.param(c)
            }, b.fn.fieldValue = function(a) {
                for (var c = [], d = 0, e = this.length; e > d; d++) {
                    var f = this[d],
                        g = b.fieldValue(f, a);
                    null === g || "undefined" == typeof g || g.constructor == Array && !g.length || (g.constructor == Array ? b.merge(c, g) : c.push(g))
                }
                return c
            }, b.fieldValue = function(a, c) {
                var d = a.name,
                    e = a.type,
                    f = a.tagName.toLowerCase();
                if (void 0 === c && (c = !0), c && (!d || a.disabled || "reset" == e || "button" == e || ("checkbox" == e || "radio" == e) && !a.checked || ("submit" == e || "image" == e) && a.form && a.form.clk != a || "select" == f && -1 == a.selectedIndex)) return null;
                if ("select" == f) {
                    var g = a.selectedIndex;
                    if (0 > g) return null;
                    for (var h = [], i = a.options, j = "select-one" == e, k = j ? g + 1 : i.length, l = j ? g : 0; k > l; l++) {
                        var m = i[l];
                        if (m.selected) {
                            var n = m.value;
                            if (n || (n = m.attributes && m.attributes.value && !m.attributes.value.specified ? m.text : m.value), j) return n;
                            h.push(n)
                        }
                    }
                    return h
                }
                return b(a).val()
            }, b.fn.clearForm = function(a) {
                return this.each(function() {
                    b("input,select,textarea", this).clearFields(a)
                })
            }, b.fn.clearFields = b.fn.clearInputs = function(a) {
                var c = /^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i;
                return this.each(function() {
                    var d = this.type,
                        e = this.tagName.toLowerCase();
                    c.test(d) || "textarea" == e ? this.value = "" : "checkbox" == d || "radio" == d ? this.checked = !1 : "select" == e ? this.selectedIndex = -1 : "file" == d ? /MSIE/.test(navigator.userAgent) ? b(this).replaceWith(b(this).clone(!0)) : b(this).val("") : a && (a === !0 && /hidden/.test(d) || "string" == typeof a && b(this).is(a)) && (this.value = "")
                })
            }, b.fn.resetForm = function() {
                return this.each(function() {
                    ("function" == typeof this.reset || "object" == typeof this.reset && !this.reset.nodeType) && this.reset()
                })
            }, b.fn.enable = function(a) {
                return void 0 === a && (a = !0), this.each(function() {
                    this.disabled = !a
                })
            }, b.fn.selected = function(a) {
                return void 0 === a && (a = !0), this.each(function() {
                    var c = this.type;
                    if ("checkbox" == c || "radio" == c) this.checked = a;
                    else if ("option" == this.tagName.toLowerCase()) {
                        var d = b(this).parent("select");
                        a && d[0] && "select-one" == d[0].type && d.find("option").selected(!1), this.selected = a
                    }
                })
            }, b.fn.ajaxSubmit.debug = !1
        }),
        function(a) {
            function b() {
                try {
                    return h in a && a[h]
                } catch (b) {
                    return !1
                }
            }

            function c(a) {
                return function() {
                    var b = Array.prototype.slice.call(arguments, 0);
                    b.unshift(e), j.appendChild(e), e.addBehavior("#default#userData"), e.load(h);
                    var c = a.apply(f, b);
                    return j.removeChild(e), c
                }
            }

            function d(a) {
                return a.replace(/^d/, "___$&").replace(m, "___")
            }
            var e, f = {},
                g = a.document,
                h = "localStorage",
                i = "script";
            if (f.disabled = !1, f.set = function() {}, f.get = function() {}, f.remove = function() {}, f.clear = function() {}, f.transact = function(a, b, c) {
                    var d = f.get(a);
                    null == c && (c = b, b = null), "undefined" == typeof d && (d = b || {}), c(d), f.set(a, d)
                }, f.getAll = function() {}, f.forEach = function() {}, f.serialize = function(a) {
                    return JSON.stringify(a)
                }, f.deserialize = function(a) {
                    if ("string" != typeof a) return void 0;
                    try {
                        return JSON.parse(a)
                    } catch (b) {
                        return a || void 0
                    }
                }, b()) e = a[h], f.set = function(a, b) {
                return void 0 === b ? f.remove(a) : (e.setItem(a, f.serialize(b)), b)
            }, f.get = function(a) {
                return f.deserialize(e.getItem(a))
            }, f.remove = function(a) {
                e.removeItem(a)
            }, f.clear = function() {
                e.clear()
            }, f.getAll = function() {
                var a = {};
                return f.forEach(function(b, c) {
                    a[b] = c
                }), a
            }, f.forEach = function(a) {
                for (var b = 0; b < e.length; b++) {
                    var c = e.key(b);
                    a(c, f.get(c))
                }
            };
            else if (g.documentElement.addBehavior) {
                var j, k;
                try {
                    k = new ActiveXObject("htmlfile"), k.open(), k.write("<" + i + ">document.w=window</" + i + '><iframe src="/favicon.ico"></iframe>'), k.close(), j = k.w.frames[0].document, e = j.createElement("div")
                } catch (l) {
                    e = g.createElement("div"), j = g.body
                }
                var m = new RegExp("[!\"#$%&'()*+,/\\\\:;<=>?@[\\]^`{|}~]", "g");
                f.set = c(function(a, b, c) {
                    return b = d(b), void 0 === c ? f.remove(b) : (a.setAttribute(b, f.serialize(c)), a.save(h), c)
                }), f.get = c(function(a, b) {
                    return b = d(b), f.deserialize(a.getAttribute(b))
                }), f.remove = c(function(a, b) {
                    b = d(b), a.removeAttribute(b), a.save(h)
                }), f.clear = c(function(a) {
                    var b = a.XMLDocument.documentElement.attributes;
                    a.load(h);
                    for (var c, d = 0; c = b[d]; d++) a.removeAttribute(c.name);
                    a.save(h)
                }), f.getAll = function() {
                    var a = {};
                    return f.forEach(function(b, c) {
                        a[b] = c
                    }), a
                }, f.forEach = c(function(a, b) {
                    for (var c, d = a.XMLDocument.documentElement.attributes, e = 0; c = d[e]; ++e) b(c.name, f.deserialize(a.getAttribute(c.name)))
                })
            }
            try {
                var n = "__storejs__";
                f.set(n, n), f.get(n) != n && (f.disabled = !0), f.remove(n)
            } catch (l) {
                f.disabled = !0
            }
            f.enabled = !f.disabled, "undefined" != typeof module && module.exports && this.module !== module ? module.exports = f : "function" == typeof define && define.amd ? define(f) : a.store = f
        }(Function("return this")()),
        function() {
            var a = this,
                b = a._,
                c = {},
                d = Array.prototype,
                e = Object.prototype,
                f = Function.prototype,
                g = d.push,
                h = d.slice,
                i = d.concat,
                j = e.toString,
                k = e.hasOwnProperty,
                l = d.forEach,
                m = d.map,
                n = d.reduce,
                o = d.reduceRight,
                p = d.filter,
                q = d.every,
                r = d.some,
                s = d.indexOf,
                t = d.lastIndexOf,
                u = Array.isArray,
                v = Object.keys,
                w = f.bind,
                x = function(a) {
                    return a instanceof x ? a : this instanceof x ? void(this._wrapped = a) : new x(a)
                };
            "undefined" != typeof exports ? ("undefined" != typeof module && module.exports && (exports = module.exports = x), exports._ = x) : a._ = x, x.VERSION = "1.6.0";
            var y = x.each = x.forEach = function(a, b, d) {
                if (null == a) return a;
                if (l && a.forEach === l) a.forEach(b, d);
                else if (a.length === +a.length) {
                    for (var e = 0, f = a.length; f > e; e++)
                        if (b.call(d, a[e], e, a) === c) return
                } else
                    for (var g = x.keys(a), e = 0, f = g.length; f > e; e++)
                        if (b.call(d, a[g[e]], g[e], a) === c) return; return a
            };
            x.map = x.collect = function(a, b, c) {
                var d = [];
                return null == a ? d : m && a.map === m ? a.map(b, c) : (y(a, function(a, e, f) {
                    d.push(b.call(c, a, e, f))
                }), d)
            };
            var z = "Reduce of empty array with no initial value";
            x.reduce = x.foldl = x.inject = function(a, b, c, d) {
                var e = arguments.length > 2;
                if (null == a && (a = []), n && a.reduce === n) return d && (b = x.bind(b, d)), e ? a.reduce(b, c) : a.reduce(b);
                if (y(a, function(a, f, g) {
                        e ? c = b.call(d, c, a, f, g) : (c = a, e = !0)
                    }), !e) throw new TypeError(z);
                return c
            }, x.reduceRight = x.foldr = function(a, b, c, d) {
                var e = arguments.length > 2;
                if (null == a && (a = []), o && a.reduceRight === o) return d && (b = x.bind(b, d)), e ? a.reduceRight(b, c) : a.reduceRight(b);
                var f = a.length;
                if (f !== +f) {
                    var g = x.keys(a);
                    f = g.length
                }
                if (y(a, function(h, i, j) {
                        i = g ? g[--f] : --f, e ? c = b.call(d, c, a[i], i, j) : (c = a[i], e = !0)
                    }), !e) throw new TypeError(z);
                return c
            }, x.find = x.detect = function(a, b, c) {
                var d;
                return A(a, function(a, e, f) {
                    return b.call(c, a, e, f) ? (d = a, !0) : void 0
                }), d
            }, x.filter = x.select = function(a, b, c) {
                var d = [];
                return null == a ? d : p && a.filter === p ? a.filter(b, c) : (y(a, function(a, e, f) {
                    b.call(c, a, e, f) && d.push(a)
                }), d)
            }, x.reject = function(a, b, c) {
                return x.filter(a, function(a, d, e) {
                    return !b.call(c, a, d, e)
                }, c)
            }, x.every = x.all = function(a, b, d) {
                b || (b = x.identity);
                var e = !0;
                return null == a ? e : q && a.every === q ? a.every(b, d) : (y(a, function(a, f, g) {
                    return (e = e && b.call(d, a, f, g)) ? void 0 : c
                }), !!e)
            };
            var A = x.some = x.any = function(a, b, d) {
                b || (b = x.identity);
                var e = !1;
                return null == a ? e : r && a.some === r ? a.some(b, d) : (y(a, function(a, f, g) {
                    return e || (e = b.call(d, a, f, g)) ? c : void 0
                }), !!e)
            };
            x.contains = x.include = function(a, b) {
                return null == a ? !1 : s && a.indexOf === s ? -1 != a.indexOf(b) : A(a, function(a) {
                    return a === b
                })
            }, x.invoke = function(a, b) {
                var c = h.call(arguments, 2),
                    d = x.isFunction(b);
                return x.map(a, function(a) {
                    return (d ? b : a[b]).apply(a, c)
                })
            }, x.pluck = function(a, b) {
                return x.map(a, x.property(b))
            }, x.where = function(a, b) {
                return x.filter(a, x.matches(b))
            }, x.findWhere = function(a, b) {
                return x.find(a, x.matches(b))
            }, x.max = function(a, b, c) {
                if (!b && x.isArray(a) && a[0] === +a[0] && a.length < 65535) return Math.max.apply(Math, a);
                var d = -1 / 0,
                    e = -1 / 0;
                return y(a, function(a, f, g) {
                    var h = b ? b.call(c, a, f, g) : a;
                    h > e && (d = a, e = h)
                }), d
            }, x.min = function(a, b, c) {
                if (!b && x.isArray(a) && a[0] === +a[0] && a.length < 65535) return Math.min.apply(Math, a);
                var d = 1 / 0,
                    e = 1 / 0;
                return y(a, function(a, f, g) {
                    var h = b ? b.call(c, a, f, g) : a;
                    e > h && (d = a, e = h)
                }), d
            }, x.shuffle = function(a) {
                var b, c = 0,
                    d = [];
                return y(a, function(a) {
                    b = x.random(c++), d[c - 1] = d[b], d[b] = a
                }), d
            }, x.sample = function(a, b, c) {
                return null == b || c ? (a.length !== +a.length && (a = x.values(a)), a[x.random(a.length - 1)]) : x.shuffle(a).slice(0, Math.max(0, b))
            };
            var B = function(a) {
                return null == a ? x.identity : x.isFunction(a) ? a : x.property(a)
            };
            x.sortBy = function(a, b, c) {
                return b = B(b), x.pluck(x.map(a, function(a, d, e) {
                    return {
                        value: a,
                        index: d,
                        criteria: b.call(c, a, d, e)
                    }
                }).sort(function(a, b) {
                    var c = a.criteria,
                        d = b.criteria;
                    if (c !== d) {
                        if (c > d || void 0 === c) return 1;
                        if (d > c || void 0 === d) return -1
                    }
                    return a.index - b.index
                }), "value")
            };
            var C = function(a) {
                return function(b, c, d) {
                    var e = {};
                    return c = B(c), y(b, function(f, g) {
                        var h = c.call(d, f, g, b);
                        a(e, h, f)
                    }), e
                }
            };
            x.groupBy = C(function(a, b, c) {
                x.has(a, b) ? a[b].push(c) : a[b] = [c]
            }), x.indexBy = C(function(a, b, c) {
                a[b] = c
            }), x.countBy = C(function(a, b) {
                x.has(a, b) ? a[b]++ : a[b] = 1
            }), x.sortedIndex = function(a, b, c, d) {
                c = B(c);
                for (var e = c.call(d, b), f = 0, g = a.length; g > f;) {
                    var h = f + g >>> 1;
                    c.call(d, a[h]) < e ? f = h + 1 : g = h
                }
                return f
            }, x.toArray = function(a) {
                return a ? x.isArray(a) ? h.call(a) : a.length === +a.length ? x.map(a, x.identity) : x.values(a) : []
            }, x.size = function(a) {
                return null == a ? 0 : a.length === +a.length ? a.length : x.keys(a).length
            }, x.first = x.head = x.take = function(a, b, c) {
                return null == a ? void 0 : null == b || c ? a[0] : 0 > b ? [] : h.call(a, 0, b)
            }, x.initial = function(a, b, c) {
                return h.call(a, 0, a.length - (null == b || c ? 1 : b))
            }, x.last = function(a, b, c) {
                return null == a ? void 0 : null == b || c ? a[a.length - 1] : h.call(a, Math.max(a.length - b, 0))
            }, x.rest = x.tail = x.drop = function(a, b, c) {
                return h.call(a, null == b || c ? 1 : b)
            }, x.compact = function(a) {
                return x.filter(a, x.identity)
            };
            var D = function(a, b, c) {
                return b && x.every(a, x.isArray) ? i.apply(c, a) : (y(a, function(a) {
                    x.isArray(a) || x.isArguments(a) ? b ? g.apply(c, a) : D(a, b, c) : c.push(a)
                }), c)
            };
            x.flatten = function(a, b) {
                return D(a, b, [])
            }, x.without = function(a) {
                return x.difference(a, h.call(arguments, 1))
            }, x.partition = function(a, b) {
                var c = [],
                    d = [];
                return y(a, function(a) {
                    (b(a) ? c : d).push(a)
                }), [c, d]
            }, x.uniq = x.unique = function(a, b, c, d) {
                x.isFunction(b) && (d = c, c = b, b = !1);
                var e = c ? x.map(a, c, d) : a,
                    f = [],
                    g = [];
                return y(e, function(c, d) {
                    (b ? d && g[g.length - 1] === c : x.contains(g, c)) || (g.push(c), f.push(a[d]))
                }), f
            }, x.union = function() {
                return x.uniq(x.flatten(arguments, !0))
            }, x.intersection = function(a) {
                var b = h.call(arguments, 1);
                return x.filter(x.uniq(a), function(a) {
                    return x.every(b, function(b) {
                        return x.contains(b, a)
                    })
                })
            }, x.difference = function(a) {
                var b = i.apply(d, h.call(arguments, 1));
                return x.filter(a, function(a) {
                    return !x.contains(b, a)
                })
            }, x.zip = function() {
                for (var a = x.max(x.pluck(arguments, "length").concat(0)), b = new Array(a), c = 0; a > c; c++) b[c] = x.pluck(arguments, "" + c);
                return b
            }, x.object = function(a, b) {
                if (null == a) return {};
                for (var c = {}, d = 0, e = a.length; e > d; d++) b ? c[a[d]] = b[d] : c[a[d][0]] = a[d][1];
                return c
            }, x.indexOf = function(a, b, c) {
                if (null == a) return -1;
                var d = 0,
                    e = a.length;
                if (c) {
                    if ("number" != typeof c) return d = x.sortedIndex(a, b), a[d] === b ? d : -1;
                    d = 0 > c ? Math.max(0, e + c) : c
                }
                if (s && a.indexOf === s) return a.indexOf(b, c);
                for (; e > d; d++)
                    if (a[d] === b) return d;
                return -1
            }, x.lastIndexOf = function(a, b, c) {
                if (null == a) return -1;
                var d = null != c;
                if (t && a.lastIndexOf === t) return d ? a.lastIndexOf(b, c) : a.lastIndexOf(b);
                for (var e = d ? c : a.length; e--;)
                    if (a[e] === b) return e;
                return -1
            }, x.range = function(a, b, c) {
                arguments.length <= 1 && (b = a || 0, a = 0), c = arguments[2] || 1;
                for (var d = Math.max(Math.ceil((b - a) / c), 0), e = 0, f = new Array(d); d > e;) f[e++] = a, a += c;
                return f
            };
            var E = function() {};
            x.bind = function(a, b) {
                var c, d;
                if (w && a.bind === w) return w.apply(a, h.call(arguments, 1));
                if (!x.isFunction(a)) throw new TypeError;
                return c = h.call(arguments, 2), d = function() {
                    if (!(this instanceof d)) return a.apply(b, c.concat(h.call(arguments)));
                    E.prototype = a.prototype;
                    var e = new E;
                    E.prototype = null;
                    var f = a.apply(e, c.concat(h.call(arguments)));
                    return Object(f) === f ? f : e
                }
            }, x.partial = function(a) {
                var b = h.call(arguments, 1);
                return function() {
                    for (var c = 0, d = b.slice(), e = 0, f = d.length; f > e; e++) d[e] === x && (d[e] = arguments[c++]);
                    for (; c < arguments.length;) d.push(arguments[c++]);
                    return a.apply(this, d)
                }
            }, x.bindAll = function(a) {
                var b = h.call(arguments, 1);
                if (0 === b.length) throw new Error("bindAll must be passed function names");
                return y(b, function(b) {
                    a[b] = x.bind(a[b], a)
                }), a
            }, x.memoize = function(a, b) {
                var c = {};
                return b || (b = x.identity),
                    function() {
                        var d = b.apply(this, arguments);
                        return x.has(c, d) ? c[d] : c[d] = a.apply(this, arguments)
                    }
            }, x.delay = function(a, b) {
                var c = h.call(arguments, 2);
                return setTimeout(function() {
                    return a.apply(null, c)
                }, b)
            }, x.defer = function(a) {
                return x.delay.apply(x, [a, 1].concat(h.call(arguments, 1)))
            }, x.throttle = function(a, b, c) {
                var d, e, f, g = null,
                    h = 0;
                c || (c = {});
                var i = function() {
                    h = c.leading === !1 ? 0 : x.now(), g = null, f = a.apply(d, e), d = e = null
                };
                return function() {
                    var j = x.now();
                    h || c.leading !== !1 || (h = j);
                    var k = b - (j - h);
                    return d = this, e = arguments, 0 >= k ? (clearTimeout(g), g = null, h = j, f = a.apply(d, e), d = e = null) : g || c.trailing === !1 || (g = setTimeout(i, k)), f
                }
            }, x.debounce = function(a, b, c) {
                var d, e, f, g, h, i = function() {
                    var j = x.now() - g;
                    b > j ? d = setTimeout(i, b - j) : (d = null, c || (h = a.apply(f, e), f = e = null))
                };
                return function() {
                    f = this, e = arguments, g = x.now();
                    var j = c && !d;
                    return d || (d = setTimeout(i, b)), j && (h = a.apply(f, e), f = e = null), h
                }
            }, x.once = function(a) {
                var b, c = !1;
                return function() {
                    return c ? b : (c = !0, b = a.apply(this, arguments), a = null, b)
                }
            }, x.wrap = function(a, b) {
                return x.partial(b, a)
            }, x.compose = function() {
                var a = arguments;
                return function() {
                    for (var b = arguments, c = a.length - 1; c >= 0; c--) b = [a[c].apply(this, b)];
                    return b[0]
                }
            }, x.after = function(a, b) {
                return function() {
                    return --a < 1 ? b.apply(this, arguments) : void 0
                }
            }, x.keys = function(a) {
                if (!x.isObject(a)) return [];
                if (v) return v(a);
                var b = [];
                for (var c in a) x.has(a, c) && b.push(c);
                return b
            }, x.values = function(a) {
                for (var b = x.keys(a), c = b.length, d = new Array(c), e = 0; c > e; e++) d[e] = a[b[e]];
                return d
            }, x.pairs = function(a) {
                for (var b = x.keys(a), c = b.length, d = new Array(c), e = 0; c > e; e++) d[e] = [b[e], a[b[e]]];
                return d
            }, x.invert = function(a) {
                for (var b = {}, c = x.keys(a), d = 0, e = c.length; e > d; d++) b[a[c[d]]] = c[d];
                return b
            }, x.functions = x.methods = function(a) {
                var b = [];
                for (var c in a) x.isFunction(a[c]) && b.push(c);
                return b.sort()
            }, x.extend = function(a) {
                return y(h.call(arguments, 1), function(b) {
                    if (b)
                        for (var c in b) a[c] = b[c]
                }), a
            }, x.pick = function(a) {
                var b = {},
                    c = i.apply(d, h.call(arguments, 1));
                return y(c, function(c) {
                    c in a && (b[c] = a[c])
                }), b
            }, x.omit = function(a) {
                var b = {},
                    c = i.apply(d, h.call(arguments, 1));
                for (var e in a) x.contains(c, e) || (b[e] = a[e]);
                return b
            }, x.defaults = function(a) {
                return y(h.call(arguments, 1), function(b) {
                    if (b)
                        for (var c in b) void 0 === a[c] && (a[c] = b[c])
                }), a
            }, x.clone = function(a) {
                return x.isObject(a) ? x.isArray(a) ? a.slice() : x.extend({}, a) : a
            }, x.tap = function(a, b) {
                return b(a), a
            };
            var F = function(a, b, c, d) {
                if (a === b) return 0 !== a || 1 / a == 1 / b;
                if (null == a || null == b) return a === b;
                a instanceof x && (a = a._wrapped), b instanceof x && (b = b._wrapped);
                var e = j.call(a);
                if (e != j.call(b)) return !1;
                switch (e) {
                    case "[object String]":
                        return a == String(b);
                    case "[object Number]":
                        return a != +a ? b != +b : 0 == a ? 1 / a == 1 / b : a == +b;
                    case "[object Date]":
                    case "[object Boolean]":
                        return +a == +b;
                    case "[object RegExp]":
                        return a.source == b.source && a.global == b.global && a.multiline == b.multiline && a.ignoreCase == b.ignoreCase
                }
                if ("object" != typeof a || "object" != typeof b) return !1;
                for (var f = c.length; f--;)
                    if (c[f] == a) return d[f] == b;
                var g = a.constructor,
                    h = b.constructor;
                if (g !== h && !(x.isFunction(g) && g instanceof g && x.isFunction(h) && h instanceof h) && "constructor" in a && "constructor" in b) return !1;
                c.push(a), d.push(b);
                var i = 0,
                    k = !0;
                if ("[object Array]" == e) {
                    if (i = a.length, k = i == b.length)
                        for (; i-- && (k = F(a[i], b[i], c, d)););
                } else {
                    for (var l in a)
                        if (x.has(a, l) && (i++, !(k = x.has(b, l) && F(a[l], b[l], c, d)))) break;
                    if (k) {
                        for (l in b)
                            if (x.has(b, l) && !i--) break;
                        k = !i
                    }
                }
                return c.pop(), d.pop(), k
            };
            x.isEqual = function(a, b) {
                return F(a, b, [], [])
            }, x.isEmpty = function(a) {
                if (null == a) return !0;
                if (x.isArray(a) || x.isString(a)) return 0 === a.length;
                for (var b in a)
                    if (x.has(a, b)) return !1;
                return !0
            }, x.isElement = function(a) {
                return !(!a || 1 !== a.nodeType)
            }, x.isArray = u || function(a) {
                return "[object Array]" == j.call(a)
            }, x.isObject = function(a) {
                return a === Object(a)
            }, y(["Arguments", "Function", "String", "Number", "Date", "RegExp"], function(a) {
                x["is" + a] = function(b) {
                    return j.call(b) == "[object " + a + "]"
                }
            }), x.isArguments(arguments) || (x.isArguments = function(a) {
                return !(!a || !x.has(a, "callee"))
            }), "function" != typeof /./ && (x.isFunction = function(a) {
                return "function" == typeof a
            }), x.isFinite = function(a) {
                return isFinite(a) && !isNaN(parseFloat(a))
            }, x.isNaN = function(a) {
                return x.isNumber(a) && a != +a
            }, x.isBoolean = function(a) {
                return a === !0 || a === !1 || "[object Boolean]" == j.call(a)
            }, x.isNull = function(a) {
                return null === a
            }, x.isUndefined = function(a) {
                return void 0 === a
            }, x.has = function(a, b) {
                return k.call(a, b)
            }, x.noConflict = function() {
                return a._ = b, this
            }, x.identity = function(a) {
                return a
            }, x.constant = function(a) {
                return function() {
                    return a
                }
            }, x.property = function(a) {
                return function(b) {
                    return b[a]
                }
            }, x.matches = function(a) {
                return function(b) {
                    if (b === a) return !0;
                    for (var c in a)
                        if (a[c] !== b[c]) return !1;
                    return !0
                }
            }, x.times = function(a, b, c) {
                for (var d = Array(Math.max(0, a)), e = 0; a > e; e++) d[e] = b.call(c, e);
                return d
            }, x.random = function(a, b) {
                return null == b && (b = a, a = 0), a + Math.floor(Math.random() * (b - a + 1))
            }, x.now = Date.now || function() {
                return (new Date).getTime()
            };
            var G = {
                escape: {
                    "&": "&amp;",
                    "<": "&lt;",
                    ">": "&gt;",
                    '"': "&quot;",
                    "'": "&#x27;"
                }
            };
            G.unescape = x.invert(G.escape);
            var H = {
                escape: new RegExp("[" + x.keys(G.escape).join("") + "]", "g"),
                unescape: new RegExp("(" + x.keys(G.unescape).join("|") + ")", "g")
            };
            x.each(["escape", "unescape"], function(a) {
                x[a] = function(b) {
                    return null == b ? "" : ("" + b).replace(H[a], function(b) {
                        return G[a][b]
                    })
                }
            }), x.result = function(a, b) {
                if (null == a) return void 0;
                var c = a[b];
                return x.isFunction(c) ? c.call(a) : c
            }, x.mixin = function(a) {
                y(x.functions(a), function(b) {
                    var c = x[b] = a[b];
                    x.prototype[b] = function() {
                        var a = [this._wrapped];
                        return g.apply(a, arguments), M.call(this, c.apply(x, a))
                    }
                })
            };
            var I = 0;
            x.uniqueId = function(a) {
                var b = ++I + "";
                return a ? a + b : b
            }, x.templateSettings = {
                evaluate: /<%([\s\S]+?)%>/g,
                interpolate: /<%=([\s\S]+?)%>/g,
                escape: /<%-([\s\S]+?)%>/g
            };
            var J = /(.)^/,
                K = {
                    "'": "'",
                    "\\": "\\",
                    "\r": "r",
                    "\n": "n",
                    "	": "t",
                    "\u2028": "u2028",
                    "\u2029": "u2029"
                },
                L = /\\|'|\r|\n|\t|\u2028|\u2029/g;
            x.template = function(a, b, c) {
                var d;
                c = x.defaults({}, c, x.templateSettings);
                var e = new RegExp([(c.escape || J).source, (c.interpolate || J).source, (c.evaluate || J).source].join("|") + "|$", "g"),
                    f = 0,
                    g = "__p+='";
                a.replace(e, function(b, c, d, e, h) {
                    return g += a.slice(f, h).replace(L, function(a) {
                        return "\\" + K[a]
                    }), c && (g += "'+\n((__t=(" + c + "))==null?'':_.escape(__t))+\n'"), d && (g += "'+\n((__t=(" + d + "))==null?'':__t)+\n'"), e && (g += "';\n" + e + "\n__p+='"), f = h + b.length, b
                }), g += "';\n", c.variable || (g = "with(obj||{}){\n" + g + "}\n"), g = "var __t,__p='',__j=Array.prototype.join,print=function(){__p+=__j.call(arguments,'');};\n" + g + "return __p;\n";
                try {
                    d = new Function(c.variable || "obj", "_", g)
                } catch (h) {
                    throw h.source = g, h
                }
                if (b) return d(b, x);
                var i = function(a) {
                    return d.call(this, a, x)
                };
                return i.source = "function(" + (c.variable || "obj") + "){\n" + g + "}", i
            }, x.chain = function(a) {
                return x(a).chain()
            };
            var M = function(a) {
                return this._chain ? x(a).chain() : a
            };
            x.mixin(x), y(["pop", "push", "reverse", "shift", "sort", "splice", "unshift"], function(a) {
                var b = d[a];
                x.prototype[a] = function() {
                    var c = this._wrapped;
                    return b.apply(c, arguments), "shift" != a && "splice" != a || 0 !== c.length || delete c[0], M.call(this, c)
                }
            }), y(["concat", "join", "slice"], function(a) {
                var b = d[a];
                x.prototype[a] = function() {
                    return M.call(this, b.apply(this._wrapped, arguments))
                }
            }), x.extend(x.prototype, {
                chain: function() {
                    return this._chain = !0, this
                },
                value: function() {
                    return this._wrapped
                }
            }), "function" == typeof define && define.amd && define("underscore", [], function() {
                return x
            })
        }.call(this),
        function(a, b) {
            if ("function" == typeof define && define.amd) define(["underscore", "jquery", "exports"], function(c, d, e) {
                a.Backbone = b(a, e, c, d)
            });
            else if ("undefined" != typeof exports) {
                var c = require("underscore");
                b(a, exports, c)
            } else a.Backbone = b(a, {}, a._, a.jQuery || a.Zepto || a.ender || a.$)
        }(this, function(b, c, d, e) {
            {
                var f = b.Backbone,
                    g = [],
                    h = (g.push, g.slice);
                g.splice
            }
            c.VERSION = "1.1.2", c.$ = e, c.noConflict = function() {
                return b.Backbone = f, this
            }, c.emulateHTTP = !1, c.emulateJSON = !1;
            var i = c.Events = {
                    on: function(a, b, c) {
                        if (!k(this, "on", a, [b, c]) || !b) return this;
                        this._events || (this._events = {});
                        var d = this._events[a] || (this._events[a] = []);
                        return d.push({
                            callback: b,
                            context: c,
                            ctx: c || this
                        }), this
                    },
                    once: function(a, b, c) {
                        if (!k(this, "once", a, [b, c]) || !b) return this;
                        var e = this,
                            f = d.once(function() {
                                e.off(a, f), b.apply(this, arguments)
                            });
                        return f._callback = b, this.on(a, f, c)
                    },
                    off: function(a, b, c) {
                        var e, f, g, h, i, j, l, m;
                        if (!this._events || !k(this, "off", a, [b, c])) return this;
                        if (!a && !b && !c) return this._events = void 0, this;
                        for (h = a ? [a] : d.keys(this._events), i = 0, j = h.length; j > i; i++)
                            if (a = h[i], g = this._events[a]) {
                                if (this._events[a] = e = [], b || c)
                                    for (l = 0, m = g.length; m > l; l++) f = g[l], (b && b !== f.callback && b !== f.callback._callback || c && c !== f.context) && e.push(f);
                                e.length || delete this._events[a]
                            }
                        return this
                    },
                    trigger: function(a) {
                        if (!this._events) return this;
                        var b = h.call(arguments, 1);
                        if (!k(this, "trigger", a, b)) return this;
                        var c = this._events[a],
                            d = this._events.all;
                        return c && l(c, b), d && l(d, arguments), this
                    },
                    stopListening: function(a, b, c) {
                        var e = this._listeningTo;
                        if (!e) return this;
                        var f = !b && !c;
                        c || "object" != typeof b || (c = this), a && ((e = {})[a._listenId] = a);
                        for (var g in e) a = e[g], a.off(b, c, this), (f || d.isEmpty(a._events)) && delete this._listeningTo[g];
                        return this
                    }
                },
                j = /\s+/,
                k = function(a, b, c, d) {
                    if (!c) return !0;
                    if ("object" == typeof c) {
                        for (var e in c) a[b].apply(a, [e, c[e]].concat(d));
                        return !1
                    }
                    if (j.test(c)) {
                        for (var f = c.split(j), g = 0, h = f.length; h > g; g++) a[b].apply(a, [f[g]].concat(d));
                        return !1
                    }
                    return !0
                },
                l = function(a, b) {
                    var c, d = -1,
                        e = a.length,
                        f = b[0],
                        g = b[1],
                        h = b[2];
                    switch (b.length) {
                        case 0:
                            for (; ++d < e;)(c = a[d]).callback.call(c.ctx);
                            return;
                        case 1:
                            for (; ++d < e;)(c = a[d]).callback.call(c.ctx, f);
                            return;
                        case 2:
                            for (; ++d < e;)(c = a[d]).callback.call(c.ctx, f, g);
                            return;
                        case 3:
                            for (; ++d < e;)(c = a[d]).callback.call(c.ctx, f, g, h);
                            return;
                        default:
                            for (; ++d < e;)(c = a[d]).callback.apply(c.ctx, b);
                            return
                    }
                },
                m = {
                    listenTo: "on",
                    listenToOnce: "once"
                };
            d.each(m, function(a, b) {
                i[b] = function(b, c, e) {
                    var f = this._listeningTo || (this._listeningTo = {}),
                        g = b._listenId || (b._listenId = d.uniqueId("l"));
                    return f[g] = b, e || "object" != typeof c || (e = this), b[a](c, e, this), this
                }
            }), i.bind = i.on, i.unbind = i.off, d.extend(c, i);
            var n = c.Model = function(a, b) {
                var c = a || {};
                b || (b = {}), this.cid = d.uniqueId("c"), this.attributes = {}, b.collection && (this.collection = b.collection), b.parse && (c = this.parse(c, b) || {}), c = d.defaults({}, c, d.result(this, "defaults")), this.set(c, b), this.changed = {}, this.initialize.apply(this, arguments)
            };
            d.extend(n.prototype, i, {
                changed: null,
                validationError: null,
                idAttribute: "id",
                initialize: function() {},
                toJSON: function() {
                    return d.clone(this.attributes)
                },
                sync: function() {
                    return c.sync.apply(this, arguments)
                },
                get: function(a) {
                    return this.attributes[a]
                },
                escape: function(a) {
                    return d.escape(this.get(a))
                },
                has: function(a) {
                    return null != this.get(a)
                },
                set: function(a, b, c) {
                    var e, f, g, h, i, j, k, l;
                    if (null == a) return this;
                    if ("object" == typeof a ? (f = a, c = b) : (f = {})[a] = b, c || (c = {}), !this._validate(f, c)) return !1;
                    g = c.unset, i = c.silent, h = [], j = this._changing, this._changing = !0, j || (this._previousAttributes = d.clone(this.attributes), this.changed = {}), l = this.attributes, k = this._previousAttributes, this.idAttribute in f && (this.id = f[this.idAttribute]);
                    for (e in f) b = f[e], d.isEqual(l[e], b) || h.push(e), d.isEqual(k[e], b) ? delete this.changed[e] : this.changed[e] = b, g ? delete l[e] : l[e] = b;
                    if (!i) {
                        h.length && (this._pending = c);
                        for (var m = 0, n = h.length; n > m; m++) this.trigger("change:" + h[m], this, l[h[m]], c)
                    }
                    if (j) return this;
                    if (!i)
                        for (; this._pending;) c = this._pending, this._pending = !1, this.trigger("change", this, c);
                    return this._pending = !1, this._changing = !1, this
                },
                unset: function(a, b) {
                    return this.set(a, void 0, d.extend({}, b, {
                        unset: !0
                    }))
                },
                clear: function(a) {
                    var b = {};
                    for (var c in this.attributes) b[c] = void 0;
                    return this.set(b, d.extend({}, a, {
                        unset: !0
                    }))
                },
                hasChanged: function(a) {
                    return null == a ? !d.isEmpty(this.changed) : d.has(this.changed, a)
                },
                changedAttributes: function(a) {
                    if (!a) return this.hasChanged() ? d.clone(this.changed) : !1;
                    var b, c = !1,
                        e = this._changing ? this._previousAttributes : this.attributes;
                    for (var f in a) d.isEqual(e[f], b = a[f]) || ((c || (c = {}))[f] = b);
                    return c
                },
                previous: function(a) {
                    return null != a && this._previousAttributes ? this._previousAttributes[a] : null
                },
                previousAttributes: function() {
                    return d.clone(this._previousAttributes)
                },
                fetch: function(a) {
                    a = a ? d.clone(a) : {}, void 0 === a.parse && (a.parse = !0);
                    var b = this,
                        c = a.success;
                    return a.success = function(d) {
                        return b.set(b.parse(d, a), a) ? (c && c(b, d, a), void b.trigger("sync", b, d, a)) : !1
                    }, M(this, a), this.sync("read", this, a)
                },
                save: function(a, b, c) {
                    var e, f, g, h = this.attributes;
                    if (null == a || "object" == typeof a ? (e = a, c = b) : (e = {})[a] = b, c = d.extend({
                            validate: !0
                        }, c), e && !c.wait) {
                        if (!this.set(e, c)) return !1
                    } else if (!this._validate(e, c)) return !1;
                    e && c.wait && (this.attributes = d.extend({}, h, e)), void 0 === c.parse && (c.parse = !0);
                    var i = this,
                        j = c.success;
                    return c.success = function(a) {
                        i.attributes = h;
                        var b = i.parse(a, c);
                        return c.wait && (b = d.extend(e || {}, b)), d.isObject(b) && !i.set(b, c) ? !1 : (j && j(i, a, c), void i.trigger("sync", i, a, c))
                    }, M(this, c), f = this.isNew() ? "create" : c.patch ? "patch" : "update", "patch" === f && (c.attrs = e), g = this.sync(f, this, c), e && c.wait && (this.attributes = h), g
                },
                destroy: function(a) {
                    a = a ? d.clone(a) : {};
                    var b = this,
                        c = a.success,
                        e = function() {
                            b.trigger("destroy", b, b.collection, a)
                        };
                    if (a.success = function(d) {
                            (a.wait || b.isNew()) && e(), c && c(b, d, a), b.isNew() || b.trigger("sync", b, d, a)
                        }, this.isNew()) return a.success(), !1;
                    M(this, a);
                    var f = this.sync("delete", this, a);
                    return a.wait || e(), f
                },
                url: function() {
                    var a = d.result(this, "urlRoot") || d.result(this.collection, "url") || L();
                    return this.isNew() ? a : a.replace(/([^\/])$/, "$1/") + encodeURIComponent(this.id)
                },
                parse: function(a) {
                    return a
                },
                clone: function() {
                    return new this.constructor(this.attributes)
                },
                isNew: function() {
                    return !this.has(this.idAttribute)
                },
                isValid: function(a) {
                    return this._validate({}, d.extend(a || {}, {
                        validate: !0
                    }))
                },
                _validate: function(a, b) {
                    if (!b.validate || !this.validate) return !0;
                    a = d.extend({}, this.attributes, a);
                    var c = this.validationError = this.validate(a, b) || null;
                    return c ? (this.trigger("invalid", this, c, d.extend(b, {
                        validationError: c
                    })), !1) : !0
                }
            });
            var o = ["keys", "values", "pairs", "invert", "pick", "omit"];
            d.each(o, function(a) {
                n.prototype[a] = function() {
                    var b = h.call(arguments);
                    return b.unshift(this.attributes), d[a].apply(d, b)
                }
            });
            var p = c.Collection = function(a, b) {
                    b || (b = {}), b.model && (this.model = b.model), void 0 !== b.comparator && (this.comparator = b.comparator), this._reset(), this.initialize.apply(this, arguments), a && this.reset(a, d.extend({
                        silent: !0
                    }, b))
                },
                q = {
                    add: !0,
                    remove: !0,
                    merge: !0
                },
                r = {
                    add: !0,
                    remove: !1
                };
            d.extend(p.prototype, i, {
                model: n,
                initialize: function() {},
                toJSON: function(a) {
                    return this.map(function(b) {
                        return b.toJSON(a)
                    })
                },
                sync: function() {
                    return c.sync.apply(this, arguments)
                },
                add: function(a, b) {
                    return this.set(a, d.extend({
                        merge: !1
                    }, b, r))
                },
                remove: function(a, b) {
                    var c = !d.isArray(a);
                    a = c ? [a] : d.clone(a), b || (b = {});
                    var e, f, g, h;
                    for (e = 0, f = a.length; f > e; e++) h = a[e] = this.get(a[e]), h && (delete this._byId[h.id], delete this._byId[h.cid], g = this.indexOf(h), this.models.splice(g, 1), this.length--, b.silent || (b.index = g, h.trigger("remove", h, this, b)), this._removeReference(h, b));
                    return c ? a[0] : a
                },
                set: function(a, b) {
                    b = d.defaults({}, b, q), b.parse && (a = this.parse(a, b));
                    var c = !d.isArray(a);
                    a = c ? a ? [a] : [] : d.clone(a);
                    var e, f, g, h, i, j, k, l = b.at,
                        m = this.model,
                        o = this.comparator && null == l && b.sort !== !1,
                        p = d.isString(this.comparator) ? this.comparator : null,
                        r = [],
                        s = [],
                        t = {},
                        u = b.add,
                        v = b.merge,
                        w = b.remove,
                        x = !o && u && w ? [] : !1;
                    for (e = 0, f = a.length; f > e; e++) {
                        if (i = a[e] || {}, g = i instanceof n ? h = i : i[m.prototype.idAttribute || "id"], j = this.get(g)) w && (t[j.cid] = !0), v && (i = i === h ? h.attributes : i, b.parse && (i = j.parse(i, b)), j.set(i, b), o && !k && j.hasChanged(p) && (k = !0)), a[e] = j;
                        else if (u) {
                            if (h = a[e] = this._prepareModel(i, b), !h) continue;
                            r.push(h), this._addReference(h, b)
                        }
                        h = j || h, !x || !h.isNew() && t[h.id] || x.push(h), t[h.id] = !0
                    }
                    if (w) {
                        for (e = 0, f = this.length; f > e; ++e) t[(h = this.models[e]).cid] || s.push(h);
                        s.length && this.remove(s, b)
                    }
                    if (r.length || x && x.length)
                        if (o && (k = !0), this.length += r.length, null != l)
                            for (e = 0, f = r.length; f > e; e++) this.models.splice(l + e, 0, r[e]);
                        else {
                            x && (this.models.length = 0);
                            var y = x || r;
                            for (e = 0, f = y.length; f > e; e++) this.models.push(y[e])
                        }
                    if (k && this.sort({
                            silent: !0
                        }), !b.silent) {
                        for (e = 0, f = r.length; f > e; e++)(h = r[e]).trigger("add", h, this, b);
                        (k || x && x.length) && this.trigger("sort", this, b)
                    }
                    return c ? a[0] : a
                },
                reset: function(a, b) {
                    b || (b = {});
                    for (var c = 0, e = this.models.length; e > c; c++) this._removeReference(this.models[c], b);
                    return b.previousModels = this.models, this._reset(), a = this.add(a, d.extend({
                        silent: !0
                    }, b)), b.silent || this.trigger("reset", this, b), a
                },
                push: function(a, b) {
                    return this.add(a, d.extend({
                        at: this.length
                    }, b))
                },
                pop: function(a) {
                    var b = this.at(this.length - 1);
                    return this.remove(b, a), b
                },
                unshift: function(a, b) {
                    return this.add(a, d.extend({
                        at: 0
                    }, b))
                },
                shift: function(a) {
                    var b = this.at(0);
                    return this.remove(b, a), b
                },
                slice: function() {
                    return h.apply(this.models, arguments)
                },
                get: function(a) {
                    return null == a ? void 0 : this._byId[a] || this._byId[a.id] || this._byId[a.cid]
                },
                at: function(a) {
                    return this.models[a]
                },
                where: function(a, b) {
                    return d.isEmpty(a) ? b ? void 0 : [] : this[b ? "find" : "filter"](function(b) {
                        for (var c in a)
                            if (a[c] !== b.get(c)) return !1;
                        return !0
                    })
                },
                findWhere: function(a) {
                    return this.where(a, !0)
                },
                sort: function(a) {
                    if (!this.comparator) throw new Error("Cannot sort a set without a comparator");
                    return a || (a = {}), d.isString(this.comparator) || 1 === this.comparator.length ? this.models = this.sortBy(this.comparator, this) : this.models.sort(d.bind(this.comparator, this)), a.silent || this.trigger("sort", this, a), this
                },
                pluck: function(a) {
                    return d.invoke(this.models, "get", a)
                },
                fetch: function(a) {
                    a = a ? d.clone(a) : {}, void 0 === a.parse && (a.parse = !0);
                    var b = a.success,
                        c = this;
                    return a.success = function(d) {
                        var e = a.reset ? "reset" : "set";
                        c[e](d, a), b && b(c, d, a), c.trigger("sync", c, d, a)
                    }, M(this, a), this.sync("read", this, a)
                },
                create: function(a, b) {
                    if (b = b ? d.clone(b) : {}, !(a = this._prepareModel(a, b))) return !1;
                    b.wait || this.add(a, b);
                    var c = this,
                        e = b.success;
                    return b.success = function(a, d) {
                        b.wait && c.add(a, b), e && e(a, d, b)
                    }, a.save(null, b), a
                },
                parse: function(a) {
                    return a
                },
                clone: function() {
                    return new this.constructor(this.models)
                },
                _reset: function() {
                    this.length = 0, this.models = [], this._byId = {}
                },
                _prepareModel: function(a, b) {
                    if (a instanceof n) return a;
                    b = b ? d.clone(b) : {}, b.collection = this;
                    var c = new this.model(a, b);
                    return c.validationError ? (this.trigger("invalid", this, c.validationError, b), !1) : c
                },
                _addReference: function(a) {
                    this._byId[a.cid] = a, null != a.id && (this._byId[a.id] = a), a.collection || (a.collection = this), a.on("all", this._onModelEvent, this)
                },
                _removeReference: function(a) {
                    this === a.collection && delete a.collection, a.off("all", this._onModelEvent, this)
                },
                _onModelEvent: function(a, b, c, d) {
                    ("add" !== a && "remove" !== a || c === this) && ("destroy" === a && this.remove(b, d), b && a === "change:" + b.idAttribute && (delete this._byId[b.previous(b.idAttribute)], null != b.id && (this._byId[b.id] = b)), this.trigger.apply(this, arguments))
                }
            });
            var s = ["forEach", "each", "map", "collect", "reduce", "foldl", "inject", "reduceRight", "foldr", "find", "detect", "filter", "select", "reject", "every", "all", "some", "any", "include", "contains", "invoke", "max", "min", "toArray", "size", "first", "head", "take", "initial", "rest", "tail", "drop", "last", "without", "difference", "indexOf", "shuffle", "lastIndexOf", "isEmpty", "chain", "sample"];
            d.each(s, function(a) {
                p.prototype[a] = function() {
                    var b = h.call(arguments);
                    return b.unshift(this.models), d[a].apply(d, b)
                }
            });
            var t = ["groupBy", "countBy", "sortBy", "indexBy"];
            d.each(t, function(a) {
                p.prototype[a] = function(b, c) {
                    var e = d.isFunction(b) ? b : function(a) {
                        return a.get(b)
                    };
                    return d[a](this.models, e, c)
                }
            });
            var u = c.View = function(a) {
                    this.cid = d.uniqueId("view"), a || (a = {}), d.extend(this, d.pick(a, w)), this._ensureElement(), this.initialize.apply(this, arguments), this.delegateEvents()
                },
                v = /^(\S+)\s*(.*)$/,
                w = ["model", "collection", "el", "id", "attributes", "className", "tagName", "events"];
            d.extend(u.prototype, i, {
                tagName: "div",
                $: function(a) {
                    return this.$el.find(a)
                },
                initialize: function() {},
                render: function() {
                    return this
                },
                remove: function() {
                    return this.$el.remove(), this.stopListening(), this
                },
                setElement: function(a, b) {
                    return this.$el && this.undelegateEvents(), this.$el = a instanceof c.$ ? a : c.$(a), this.el = this.$el[0], b !== !1 && this.delegateEvents(), this
                },
                delegateEvents: function(a) {
                    if (!a && !(a = d.result(this, "events"))) return this;
                    this.undelegateEvents();
                    for (var b in a) {
                        var c = a[b];
                        if (d.isFunction(c) || (c = this[a[b]]), c) {
                            var e = b.match(v),
                                f = e[1],
                                g = e[2];
                            c = d.bind(c, this), f += ".delegateEvents" + this.cid, "" === g ? this.$el.on(f, c) : this.$el.on(f, g, c)
                        }
                    }
                    return this
                },
                undelegateEvents: function() {
                    return this.$el.off(".delegateEvents" + this.cid), this
                },
                _ensureElement: function() {
                    if (this.el) this.setElement(d.result(this, "el"), !1);
                    else {
                        var a = d.extend({}, d.result(this, "attributes"));
                        this.id && (a.id = d.result(this, "id")), this.className && (a["class"] = d.result(this, "className"));
                        var b = c.$("<" + d.result(this, "tagName") + ">").attr(a);
                        this.setElement(b, !1)
                    }
                }
            }), c.sync = function(a, b, e) {
                var f = y[a];
                d.defaults(e || (e = {}), {
                    emulateHTTP: c.emulateHTTP,
                    emulateJSON: c.emulateJSON
                });
                var g = {
                    type: f,
                    dataType: "json"
                };
                if (e.url || (g.url = d.result(b, "url") || L()), null != e.data || !b || "create" !== a && "update" !== a && "patch" !== a || (g.contentType = "application/json", g.data = JSON.stringify(e.attrs || b.toJSON(e))), e.emulateJSON && (g.contentType = "application/x-www-form-urlencoded", g.data = g.data ? {
                        model: g.data
                    } : {}), e.emulateHTTP && ("PUT" === f || "DELETE" === f || "PATCH" === f)) {
                    g.type = "POST", e.emulateJSON && (g.data._method = f);
                    var h = e.beforeSend;
                    e.beforeSend = function(a) {
                        return a.setRequestHeader("X-HTTP-Method-Override", f), h ? h.apply(this, arguments) : void 0
                    }
                }
                "GET" === g.type || e.emulateJSON || (g.processData = !1), "PATCH" === g.type && x && (g.xhr = function() {
                    return new ActiveXObject("Microsoft.XMLHTTP")
                });
                var i = e.xhr = c.ajax(d.extend(g, e));
                return b.trigger("request", b, i, e), i
            };
            var x = !("undefined" == typeof a || !a.ActiveXObject || a.XMLHttpRequest && (new XMLHttpRequest).dispatchEvent),
                y = {
                    create: "POST",
                    update: "PUT",
                    patch: "PATCH",
                    "delete": "DELETE",
                    read: "GET"
                };
            c.ajax = function() {
                return c.$.ajax.apply(c.$, arguments)
            };
            var z = c.Router = function(a) {
                    a || (a = {}), a.routes && (this.routes = a.routes), this._bindRoutes(), this.initialize.apply(this, arguments)
                },
                A = /\((.*?)\)/g,
                B = /(\(\?)?:\w+/g,
                C = /\*\w+/g,
                D = /[\-{}\[\]+?.,\\\^$|#\s]/g;
            d.extend(z.prototype, i, {
                initialize: function() {},
                route: function(a, b, e) {
                    d.isRegExp(a) || (a = this._routeToRegExp(a)), d.isFunction(b) && (e = b, b = ""), e || (e = this[b]);
                    var f = this;
                    return c.history.route(a, function(d) {
                        var g = f._extractParameters(a, d);
                        f.execute(e, g), f.trigger.apply(f, ["route:" + b].concat(g)), f.trigger("route", b, g), c.history.trigger("route", f, b, g)
                    }), this
                },
                execute: function(a, b) {
                    a && a.apply(this, b)
                },
                navigate: function(a, b) {
                    return c.history.navigate(a, b), this
                },
                _bindRoutes: function() {
                    if (this.routes) {
                        this.routes = d.result(this, "routes");
                        for (var a, b = d.keys(this.routes); null != (a = b.pop());) this.route(a, this.routes[a])
                    }
                },
                _routeToRegExp: function(a) {
                    return a = a.replace(D, "\\$&").replace(A, "(?:$1)?").replace(B, function(a, b) {
                        return b ? a : "([^/?]+)"
                    }).replace(C, "([^?]*?)"), new RegExp("^" + a + "(?:\\?([\\s\\S]*))?$")
                },
                _extractParameters: function(a, b) {
                    var c = a.exec(b).slice(1);
                    return d.map(c, function(a, b) {
                        return b === c.length - 1 ? a || null : a ? decodeURIComponent(a) : null
                    })
                }
            });
            var E = c.History = function() {
                    this.handlers = [], d.bindAll(this, "checkUrl"), "undefined" != typeof a && (this.location = a.location, this.history = a.history)
                },
                F = /^[#\/]|\s+$/g,
                G = /^\/+|\/+$/g,
                H = /msie [\w.]+/,
                I = /\/$/,
                J = /#.*$/;
            E.started = !1, d.extend(E.prototype, i, {
                interval: 50,
                atRoot: function() {
                    return this.location.pathname.replace(/[^\/]$/, "$&/") === this.root
                },
                getHash: function(a) {
                    var b = (a || this).location.href.match(/#(.*)$/);
                    return b ? b[1] : ""
                },
                getFragment: function(a, b) {
                    if (null == a)
                        if (this._hasPushState || !this._wantsHashChange || b) {
                            a = decodeURI(this.location.pathname + this.location.search);
                            var c = this.root.replace(I, "");
                            a.indexOf(c) || (a = a.slice(c.length))
                        } else a = this.getHash();
                    return a.replace(F, "")
                },
                start: function(b) {
                    if (E.started) throw new Error("Backbone.history has already been started");
                    E.started = !0, this.options = d.extend({
                        root: "/"
                    }, this.options, b), this.root = this.options.root, this._wantsHashChange = this.options.hashChange !== !1, this._wantsPushState = !!this.options.pushState, this._hasPushState = !!(this.options.pushState && this.history && this.history.pushState);
                    var e = this.getFragment(),
                        f = document.documentMode,
                        g = H.exec(navigator.userAgent.toLowerCase()) && (!f || 7 >= f);
                    if (this.root = ("/" + this.root + "/").replace(G, "/"), g && this._wantsHashChange) {
                        var h = c.$('<iframe src="javascript:0" tabindex="-1">');
                        this.iframe = h.hide().appendTo("body")[0].contentWindow, this.navigate(e)
                    }
                    this._hasPushState ? c.$(a).on("popstate", this.checkUrl) : this._wantsHashChange && "onhashchange" in a && !g ? c.$(a).on("hashchange", this.checkUrl) : this._wantsHashChange && (this._checkUrlInterval = setInterval(this.checkUrl, this.interval)), this.fragment = e;
                    var i = this.location;
                    if (this._wantsHashChange && this._wantsPushState) {
                        if (!this._hasPushState && !this.atRoot()) return this.fragment = this.getFragment(null, !0), this.location.replace(this.root + "#" + this.fragment), !0;
                        this._hasPushState && this.atRoot() && i.hash && (this.fragment = this.getHash().replace(F, ""), this.history.replaceState({}, document.title, this.root + this.fragment))
                    }
                    return this.options.silent ? void 0 : this.loadUrl()
                },
                stop: function() {
                    c.$(a).off("popstate", this.checkUrl).off("hashchange", this.checkUrl), this._checkUrlInterval && clearInterval(this._checkUrlInterval), E.started = !1
                },
                route: function(a, b) {
                    this.handlers.unshift({
                        route: a,
                        callback: b
                    })
                },
                checkUrl: function() {
                    var a = this.getFragment();
                    return a === this.fragment && this.iframe && (a = this.getFragment(this.getHash(this.iframe))), a === this.fragment ? !1 : (this.iframe && this.navigate(a), void this.loadUrl())
                },
                loadUrl: function(a) {
                    return a = this.fragment = this.getFragment(a), d.any(this.handlers, function(b) {
                        return b.route.test(a) ? (b.callback(a), !0) : void 0
                    })
                },
                navigate: function(a, b) {
                    if (!E.started) return !1;
                    b && b !== !0 || (b = {
                        trigger: !!b
                    });
                    var c = this.root + (a = this.getFragment(a || ""));
                    if (a = a.replace(J, ""), this.fragment !== a) {
                        if (this.fragment = a, "" === a && "/" !== c && (c = c.slice(0, -1)), this._hasPushState) this.history[b.replace ? "replaceState" : "pushState"]({}, document.title, c);
                        else {
                            if (!this._wantsHashChange) return this.location.assign(c);
                            this._updateHash(this.location, a, b.replace), this.iframe && a !== this.getFragment(this.getHash(this.iframe)) && (b.replace || this.iframe.document.open().close(), this._updateHash(this.iframe.location, a, b.replace))
                        }
                        return b.trigger ? this.loadUrl(a) : void 0
                    }
                },
                _updateHash: function(a, b, c) {
                    if (c) {
                        var d = a.href.replace(/(javascript:|#).*$/, "");
                        a.replace(d + "#" + b)
                    } else a.hash = "#" + b
                }
            }), c.history = new E;
            var K = function(a, b) {
                var c, e = this;
                c = a && d.has(a, "constructor") ? a.constructor : function() {
                    return e.apply(this, arguments)
                }, d.extend(c, e, b);
                var f = function() {
                    this.constructor = c
                };
                return f.prototype = e.prototype, c.prototype = new f, a && d.extend(c.prototype, a), c.__super__ = e.prototype, c
            };
            n.extend = p.extend = z.extend = u.extend = E.extend = K;
            var L = function() {
                    throw new Error('A "url" property or function must be specified')
                },
                M = function(a, b) {
                    var c = b.error;
                    b.error = function(d) {
                        c && c(a, d, b), a.trigger("error", a, d, b)
                    }
                };
            return c
        }), ! function(a, b) {
            "use strict";

            function c(a, b) {
                var c, d, e = a.toLowerCase();
                for (b = [].concat(b), c = 0; b.length > c; c += 1)
                    if (d = b[c]) {
                        if (d.test && d.test(a)) return !0;
                        if (d.toLowerCase() === e) return !0
                    }
            }
            var d = b.prototype.trim,
                e = b.prototype.trimRight,
                f = b.prototype.trimLeft,
                g = function(a) {
                    return 1 * a || 0
                },
                h = function(a, b) {
                    if (1 > b) return "";
                    for (var c = ""; b > 0;) 1 & b && (c += a), b >>= 1, a += a;
                    return c
                },
                i = [].slice,
                j = function(a) {
                    return null == a ? "\\s" : a.source ? a.source : "[" + o.escapeRegExp(a) + "]"
                },
                k = {
                    lt: "<",
                    gt: ">",
                    quot: '"',
                    amp: "&",
                    apos: "'"
                },
                l = {};
            for (var m in k) l[k[m]] = m;
            l["'"] = "#39";
            var n = function() {
                    function a(a) {
                        return Object.prototype.toString.call(a).slice(8, -1).toLowerCase()
                    }
                    var c = h,
                        d = function() {
                            return d.cache.hasOwnProperty(arguments[0]) || (d.cache[arguments[0]] = d.parse(arguments[0])), d.format.call(null, d.cache[arguments[0]], arguments)
                        };
                    return d.format = function(d, e) {
                        var f, g, h, i, j, k, l, m = 1,
                            o = d.length,
                            p = "",
                            q = [];
                        for (g = 0; o > g; g++)
                            if (p = a(d[g]), "string" === p) q.push(d[g]);
                            else if ("array" === p) {
                            if (i = d[g], i[2])
                                for (f = e[m], h = 0; i[2].length > h; h++) {
                                    if (!f.hasOwnProperty(i[2][h])) throw new Error(n('[_.sprintf] property "%s" does not exist', i[2][h]));
                                    f = f[i[2][h]]
                                } else f = i[1] ? e[i[1]] : e[m++];
                            if (/[^s]/.test(i[8]) && "number" != a(f)) throw new Error(n("[_.sprintf] expecting number but found %s", a(f)));
                            switch (i[8]) {
                                case "b":
                                    f = f.toString(2);
                                    break;
                                case "c":
                                    f = b.fromCharCode(f);
                                    break;
                                case "d":
                                    f = parseInt(f, 10);
                                    break;
                                case "e":
                                    f = i[7] ? f.toExponential(i[7]) : f.toExponential();
                                    break;
                                case "f":
                                    f = i[7] ? parseFloat(f).toFixed(i[7]) : parseFloat(f);
                                    break;
                                case "o":
                                    f = f.toString(8);
                                    break;
                                case "s":
                                    f = (f = b(f)) && i[7] ? f.substring(0, i[7]) : f;
                                    break;
                                case "u":
                                    f = Math.abs(f);
                                    break;
                                case "x":
                                    f = f.toString(16);
                                    break;
                                case "X":
                                    f = f.toString(16).toUpperCase()
                            }
                            f = /[def]/.test(i[8]) && i[3] && f >= 0 ? "+" + f : f, k = i[4] ? "0" == i[4] ? "0" : i[4].charAt(1) : " ", l = i[6] - b(f).length, j = i[6] ? c(k, l) : "", q.push(i[5] ? f + j : j + f)
                        }
                        return q.join("")
                    }, d.cache = {}, d.parse = function(a) {
                        for (var b = a, c = [], d = [], e = 0; b;) {
                            if (null !== (c = /^[^\x25]+/.exec(b))) d.push(c[0]);
                            else if (null !== (c = /^\x25{2}/.exec(b))) d.push("%");
                            else {
                                if (null === (c = /^\x25(?:([1-9]\d*)\$|\(([^\)]+)\))?(\+)?(0|'[^$])?(-)?(\d+)?(?:\.(\d+))?([b-fosuxX])/.exec(b))) throw new Error("[_.sprintf] huh?");
                                if (c[2]) {
                                    e |= 1;
                                    var f = [],
                                        g = c[2],
                                        h = [];
                                    if (null === (h = /^([a-z_][a-z_\d]*)/i.exec(g))) throw new Error("[_.sprintf] huh?");
                                    for (f.push(h[1]);
                                        "" !== (g = g.substring(h[0].length));)
                                        if (null !== (h = /^\.([a-z_][a-z_\d]*)/i.exec(g))) f.push(h[1]);
                                        else {
                                            if (null === (h = /^\[(\d+)\]/.exec(g))) throw new Error("[_.sprintf] huh?");
                                            f.push(h[1])
                                        }
                                    c[2] = f
                                } else e |= 2;
                                if (3 === e) throw new Error("[_.sprintf] mixing positional and named placeholders is not (yet) supported");
                                d.push(c)
                            }
                            b = b.substring(c[0].length)
                        }
                        return d
                    }, d
                }(),
                o = {
                    VERSION: "2.3.0",
                    isBlank: function(a) {
                        return null == a && (a = ""), /^\s*$/.test(a)
                    },
                    stripTags: function(a) {
                        return null == a ? "" : b(a).replace(/<\/?[^>]+>/g, "")
                    },
                    capitalize: function(a) {
                        return a = null == a ? "" : b(a), a.charAt(0).toUpperCase() + a.slice(1)
                    },
                    chop: function(a, c) {
                        return null == a ? [] : (a = b(a), c = ~~c, c > 0 ? a.match(new RegExp(".{1," + c + "}", "g")) : [a])
                    },
                    clean: function(a) {
                        return o.strip(a).replace(/\s+/g, " ")
                    },
                    count: function(a, c) {
                        if (null == a || null == c) return 0;
                        a = b(a), c = b(c);
                        for (var d = 0, e = 0, f = c.length; e = a.indexOf(c, e), -1 !== e;) d++, e += f;
                        return d
                    },
                    chars: function(a) {
                        return null == a ? [] : b(a).split("")
                    },
                    swapCase: function(a) {
                        return null == a ? "" : b(a).replace(/\S/g, function(a) {
                            return a === a.toUpperCase() ? a.toLowerCase() : a.toUpperCase()
                        })
                    },
                    escapeHTML: function(a) {
                        return null == a ? "" : b(a).replace(/[&<>"']/g, function(a) {
                            return "&" + l[a] + ";"
                        })
                    },
                    unescapeHTML: function(a) {
                        return null == a ? "" : b(a).replace(/\&([^;]+);/g, function(a, c) {
                            var d;
                            return c in k ? k[c] : (d = c.match(/^#x([\da-fA-F]+)$/)) ? b.fromCharCode(parseInt(d[1], 16)) : (d = c.match(/^#(\d+)$/)) ? b.fromCharCode(~~d[1]) : a
                        })
                    },
                    escapeRegExp: function(a) {
                        return null == a ? "" : b(a).replace(/([.*+?^=!:${}()|[\]\/\\])/g, "\\$1")
                    },
                    splice: function(a, b, c, d) {
                        var e = o.chars(a);
                        return e.splice(~~b, ~~c, d), e.join("")
                    },
                    insert: function(a, b, c) {
                        return o.splice(a, b, 0, c)
                    },
                    include: function(a, c) {
                        return "" === c ? !0 : null == a ? !1 : -1 !== b(a).indexOf(c)
                    },
                    join: function() {
                        var a = i.call(arguments),
                            b = a.shift();
                        return null == b && (b = ""), a.join(b)
                    },
                    lines: function(a) {
                        return null == a ? [] : b(a).split("\n")
                    },
                    reverse: function(a) {
                        return o.chars(a).reverse().join("")
                    },
                    startsWith: function(a, c) {
                        return "" === c ? !0 : null == a || null == c ? !1 : (a = b(a), c = b(c), a.length >= c.length && a.slice(0, c.length) === c)
                    },
                    endsWith: function(a, c) {
                        return "" === c ? !0 : null == a || null == c ? !1 : (a = b(a), c = b(c), a.length >= c.length && a.slice(a.length - c.length) === c)
                    },
                    succ: function(a) {
                        return null == a ? "" : (a = b(a), a.slice(0, -1) + b.fromCharCode(a.charCodeAt(a.length - 1) + 1))
                    },
                    titleize: function(a) {
                        return null == a ? "" : (a = b(a).toLowerCase(), a.replace(/(?:^|\s|-)\S/g, function(a) {
                            return a.toUpperCase()
                        }))
                    },
                    camelize: function(a) {
                        return o.trim(a).replace(/[-_\s]+(.)?/g, function(a, b) {
                            return b ? b.toUpperCase() : ""
                        })
                    },
                    underscored: function(a) {
                        return o.trim(a).replace(/([a-z\d])([A-Z]+)/g, "$1_$2").replace(/[-\s]+/g, "_").toLowerCase()
                    },
                    dasherize: function(a) {
                        return o.trim(a).replace(/([A-Z])/g, "-$1").replace(/[-_\s]+/g, "-").toLowerCase()
                    },
                    classify: function(a) {
                        return o.titleize(b(a).replace(/[\W_]/g, " ")).replace(/\s/g, "")
                    },
                    humanize: function(a) {
                        return o.capitalize(o.underscored(a).replace(/_id$/, "").replace(/_/g, " "))
                    },
                    trim: function(a, c) {
                        return null == a ? "" : !c && d ? d.call(a) : (c = j(c), b(a).replace(new RegExp("^" + c + "+|" + c + "+$", "g"), ""))
                    },
                    ltrim: function(a, c) {
                        return null == a ? "" : !c && f ? f.call(a) : (c = j(c), b(a).replace(new RegExp("^" + c + "+"), ""))
                    },
                    rtrim: function(a, c) {
                        return null == a ? "" : !c && e ? e.call(a) : (c = j(c), b(a).replace(new RegExp(c + "+$"), ""))
                    },
                    truncate: function(a, c, d) {
                        return null == a ? "" : (a = b(a), d = d || "...", c = ~~c, a.length > c ? a.slice(0, c) + d : a)
                    },
                    prune: function(a, c, d) {
                        if (null == a) return "";
                        if (a = b(a), c = ~~c, d = null != d ? b(d) : "...", c >= a.length) return a;
                        var e = function(a) {
                                return a.toUpperCase() !== a.toLowerCase() ? "A" : " "
                            },
                            f = a.slice(0, c + 1).replace(/.(?=\W*\w*$)/g, e);
                        return f = f.slice(f.length - 2).match(/\w\w/) ? f.replace(/\s*\S+$/, "") : o.rtrim(f.slice(0, f.length - 1)), (f + d).length > a.length ? a : a.slice(0, f.length) + d
                    },
                    words: function(a, b) {
                        return o.isBlank(a) ? [] : o.trim(a, b).split(b || /\s+/)
                    },
                    pad: function(a, c, d, e) {
                        a = null == a ? "" : b(a), c = ~~c;
                        var f = 0;
                        switch (d ? d.length > 1 && (d = d.charAt(0)) : d = " ", e) {
                            case "right":
                                return f = c - a.length, a + h(d, f);
                            case "both":
                                return f = c - a.length, h(d, Math.ceil(f / 2)) + a + h(d, Math.floor(f / 2));
                            default:
                                return f = c - a.length, h(d, f) + a
                        }
                    },
                    lpad: function(a, b, c) {
                        return o.pad(a, b, c)
                    },
                    rpad: function(a, b, c) {
                        return o.pad(a, b, c, "right")
                    },
                    lrpad: function(a, b, c) {
                        return o.pad(a, b, c, "both")
                    },
                    sprintf: n,
                    vsprintf: function(a, b) {
                        return b.unshift(a), n.apply(null, b)
                    },
                    toNumber: function(a, b) {
                        return a ? (a = o.trim(a), a.match(/^-?\d+(?:\.\d+)?$/) ? g(g(a).toFixed(~~b)) : 0 / 0) : 0
                    },
                    numberFormat: function(a, b, c, d) {
                        if (isNaN(a) || null == a) return "";
                        a = a.toFixed(~~b), d = "string" == typeof d ? d : ",";
                        var e = a.split("."),
                            f = e[0],
                            g = e[1] ? (c || ".") + e[1] : "";
                        return f.replace(/(\d)(?=(?:\d{3})+$)/g, "$1" + d) + g
                    },
                    strRight: function(a, c) {
                        if (null == a) return "";
                        a = b(a), c = null != c ? b(c) : c;
                        var d = c ? a.indexOf(c) : -1;
                        return ~d ? a.slice(d + c.length, a.length) : a
                    },
                    strRightBack: function(a, c) {
                        if (null == a) return "";
                        a = b(a), c = null != c ? b(c) : c;
                        var d = c ? a.lastIndexOf(c) : -1;
                        return ~d ? a.slice(d + c.length, a.length) : a
                    },
                    strLeft: function(a, c) {
                        if (null == a) return "";
                        a = b(a), c = null != c ? b(c) : c;
                        var d = c ? a.indexOf(c) : -1;
                        return ~d ? a.slice(0, d) : a
                    },
                    strLeftBack: function(a, b) {
                        if (null == a) return "";
                        a += "", b = null != b ? "" + b : b;
                        var c = a.lastIndexOf(b);
                        return ~c ? a.slice(0, c) : a
                    },
                    toSentence: function(a, b, c, d) {
                        b = b || ", ", c = c || " and ";
                        var e = a.slice(),
                            f = e.pop();
                        return a.length > 2 && d && (c = o.rtrim(b) + c), e.length ? e.join(b) + c + f : f
                    },
                    toSentenceSerial: function() {
                        var a = i.call(arguments);
                        return a[3] = !0, o.toSentence.apply(o, a)
                    },
                    slugify: function(a) {
                        if (null == a) return "";
                        var c = "ąàáäâãåæăćęèéëêìíïîłńòóöôõøśșțùúüûñçżź",
                            d = "aaaaaaaaaceeeeeiiiilnoooooosstuuuunczz",
                            e = new RegExp(j(c), "g");
                        return a = b(a).toLowerCase().replace(e, function(a) {
                            var b = c.indexOf(a);
                            return d.charAt(b) || "-"
                        }), o.dasherize(a.replace(/[^\w\s-]/g, ""))
                    },
                    surround: function(a, b) {
                        return [b, a, b].join("")
                    },
                    quote: function(a, b) {
                        return o.surround(a, b || '"')
                    },
                    unquote: function(a, b) {
                        return b = b || '"', a[0] === b && a[a.length - 1] === b ? a.slice(1, a.length - 1) : a
                    },
                    exports: function() {
                        var a = {};
                        for (var b in this) this.hasOwnProperty(b) && !b.match(/^(?:include|contains|reverse)$/) && (a[b] = this[b]);
                        return a
                    },
                    repeat: function(a, c, d) {
                        if (null == a) return "";
                        if (c = ~~c, null == d) return h(b(a), c);
                        for (var e = []; c > 0; e[--c] = a);
                        return e.join(d)
                    },
                    naturalCmp: function(a, c) {
                        if (a == c) return 0;
                        if (!a) return -1;
                        if (!c) return 1;
                        for (var d = /(\.\d+)|(\d+)|(\D+)/g, e = b(a).toLowerCase().match(d), f = b(c).toLowerCase().match(d), g = Math.min(e.length, f.length), h = 0; g > h; h++) {
                            var i = e[h],
                                j = f[h];
                            if (i !== j) {
                                var k = parseInt(i, 10);
                                if (!isNaN(k)) {
                                    var l = parseInt(j, 10);
                                    if (!isNaN(l) && k - l) return k - l
                                }
                                return j > i ? -1 : 1
                            }
                        }
                        return e.length === f.length ? e.length - f.length : c > a ? -1 : 1
                    },
                    levenshtein: function(a, c) {
                        if (null == a && null == c) return 0;
                        if (null == a) return b(c).length;
                        if (null == c) return b(a).length;
                        a = b(a), c = b(c);
                        for (var d, e, f = [], g = 0; c.length >= g; g++)
                            for (var h = 0; a.length >= h; h++) e = g && h ? a.charAt(h - 1) === c.charAt(g - 1) ? d : Math.min(f[h], f[h - 1], d) + 1 : g + h, d = f[h], f[h] = e;
                        return f.pop()
                    },
                    toBoolean: function(a, b, d) {
                        return "number" == typeof a && (a = "" + a), "string" != typeof a ? !!a : (a = o.trim(a), c(a, b || ["true", "1"]) ? !0 : c(a, d || ["false", "0"]) ? !1 : void 0)
                    }
                };
            o.strip = o.trim, o.lstrip = o.ltrim, o.rstrip = o.rtrim, o.center = o.lrpad, o.rjust = o.lpad, o.ljust = o.rpad, o.contains = o.include, o.q = o.quote, o.toBool = o.toBoolean, "undefined" != typeof exports && ("undefined" != typeof module && module.exports && (module.exports = o), exports._s = o), "function" == typeof define && define.amd && define("underscore.string", [], function() {
                return o
            }), a._ = a._ || {}, a._.string = a._.str = o
        }(this, String), _.mixin({
            simpleFormat: function(a, b) {
                return b !== !1 && (a = _.escape(a)), (a + "").replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, "$1<br />$2")
            }
        });
    var c, d = [].indexOf || function(a) {
        for (var b = 0, c = this.length; c > b; b++)
            if (b in this && this[b] === a) return b;
        return -1
    };
    c = ["True", "Yes", "true", "1", 1, "yes", !0], _.mixin({
            toBoolean: function(a) {
                return d.call(c, a) >= 0
            }
        }),
        function() {
            var b;
            b = function() {
                function b() {}
                return b.footerText = "Are you sure you want to leave this page?", b.defaults = {
                    "if": function() {
                        return !0
                    },
                    message: "Existen cambiossin guardar."
                }, b.enable = function(b) {
                    return b = $.extend({}, this.defaults, b), $(a).bind("beforeunload", function() {
                        return b["if"]() ? b.message : void 0
                    }), $(document).on("page:before-change.beforeunload", function(a) {
                        return function(c) {
                            return b["if"]() ? b.cb ? (b.cb(c.originalEvent.data.url), !1) : confirm("" + b.message + "\n\n" + a.footerText) ? a.disable() : !1 : a.disable()
                        }
                    }(this))
                }, b.disable = function() {
                    return $(a).unbind("beforeunload"), $(document).off("page:before-change.beforeunload")
                }, b
            }(), a.BeforeUnload = b
        }.call(this), b.REGEX_PROTOCOL = /^([A-Za-z0-9\+\-\.\&\;\*\s]*?)(?:\:|&*0*58|&*x0*3a)/i, b.RELATIVE = "__RELATIVE__", b.ALL = "__ALL__", b.prototype.clean_node = function(a) {
            function c(a, b) {
                var c;
                for (c = 0; c < b.length; c++)
                    if (b[c] == a) return c;
                return -1
            }

            function d() {
                var a, b, c = [],
                    d = {};
                for (a = 0; a < arguments.length; a++)
                    if (arguments[a] && arguments[a].length)
                        for (b = 0; b < arguments[a].length; b++) d[arguments[a][b]] || (d[arguments[a][b]] = !0, c.push(arguments[a][b]));
                return c
            }

            function e(a) {
                var b;
                switch (a.nodeType) {
                    case 1:
                        f.call(this, a);
                        break;
                    case 3:
                        b = a.cloneNode(!1), this.current_element.appendChild(b);
                        break;
                    case 5:
                        b = a.cloneNode(!1), this.current_element.appendChild(b);
                        break;
                    case 8:
                        this.config.allow_comments && (b = a.cloneNode(!1), this.current_element.appendChild(b));
                        break;
                    default:
                        console && console.log && console.log("unknown node type", a.nodeType)
                }
            }

            function f(a) {
                var f, h, i, j, k, l, m, n, o, p, q = g.call(this, a);
                if (a = q.node, i = a.nodeName.toLowerCase(), h = this.current_element, this.allowed_elements[i] || q.whitelist) {
                    this.current_element = this.dom.createElement(a.nodeName), h.appendChild(this.current_element);
                    var r = this.config.attributes;
                    for (j = d(r[i], r[b.ALL], q.attr_whitelist), f = 0; f < j.length; f++) l = j[f], k = a.attributes[l], k && (p = !0, this.config.protocols[i] && this.config.protocols[i][l] && (n = this.config.protocols[i][l], o = k.nodeValue.toLowerCase().match(b.REGEX_PROTOCOL), p = o ? -1 != c(o[1], n) : -1 != c(b.RELATIVE, n)), p && (m = document.createAttribute(l), m.value = k.nodeValue, this.current_element.setAttributeNode(m)));
                    if (this.config.add_attributes[i])
                        for (l in this.config.add_attributes[i]) m = document.createAttribute(l), m.value = this.config.add_attributes[i][l], this.current_element.setAttributeNode(m)
                } else if (-1 != c(a, this.whitelist_nodes)) {
                    for (this.current_element = a.cloneNode(!0); this.current_element.childNodes.length > 0;) this.current_element.removeChild(this.current_element.firstChild);
                    h.appendChild(this.current_element)
                }
                if (!this.config.remove_all_contents && !this.config.remove_element_contents[i])
                    for (f = 0; f < a.childNodes.length; f++) e.call(this, a.childNodes[f]);
                this.current_element.normalize && this.current_element.normalize(), this.current_element = h
            }

            function g(a) {
                var b, e, f, g = {
                    attr_whitelist: [],
                    node: a,
                    whitelist: !1
                };
                for (b = 0; b < this.transformers.length; b++)
                    if (f = this.transformers[b]({
                            allowed_elements: this.allowed_elements,
                            config: this.config,
                            node: a,
                            node_name: a.nodeName.toLowerCase(),
                            whitelist_nodes: this.whitelist_nodes,
                            dom: this.dom
                        }), null != f) {
                        if ("object" != typeof f) throw new Error("transformer output must be an object or null");
                        if (f.whitelist_nodes && f.whitelist_nodes instanceof Array)
                            for (e = 0; e < f.whitelist_nodes.length; e++) - 1 == c(f.whitelist_nodes[e], this.whitelist_nodes) && this.whitelist_nodes.push(f.whitelist_nodes[e]);
                        g.whitelist = f.whitelist ? !0 : !1, f.attr_whitelist && (g.attr_whitelist = d(g.attr_whitelist, f.attr_whitelist)), g.node = f.node ? f.node : g.node
                    }
                return g
            }
            var h = this.dom.createDocumentFragment();
            for (this.current_element = h, this.whitelist_nodes = [], i = 0; i < a.childNodes.length; i++) e.call(this, a.childNodes[i]);
            return h.normalize && h.normalize(), h
        }, "function" == typeof define && define("sanitize", [], function() {
            return b
        }), b.Config || (b.Config = {}), b.Config.RELAXED = {
            elements: ["a", "b", "blockquote", "br", "caption", "cite", "code", "col", "colgroup", "dd", "dl", "dt", "em", "h1", "h2", "h3", "h4", "h5", "h6", "i", "img", "li", "ol", "p", "pre", "q", "small", "strike", "strong", "sub", "sup", "table", "tbody", "td", "tfoot", "th", "thead", "tr", "u", "ul"],
            attributes: {
                a: ["href", "title"],
                blockquote: ["cite"],
                col: ["span", "width"],
                colgroup: ["span", "width"],
                img: ["align", "alt", "height", "src", "title", "width"],
                ol: ["start", "type"],
                q: ["cite"],
                table: ["summary", "width"],
                td: ["abbr", "axis", "colspan", "rowspan", "width"],
                th: ["abbr", "axis", "colspan", "rowspan", "scope", "width"],
                ul: ["type"]
            },
            protocols: {
                a: {
                    href: ["ftp", "http", "https", "mailto", b.RELATIVE]
                },
                blockquote: {
                    cite: ["http", "https", b.RELATIVE]
                },
                img: {
                    src: ["http", "https", b.RELATIVE]
                },
                q: {
                    cite: ["http", "https", b.RELATIVE]
                }
            }
        }, _.mixin({
            sanitize: function(a, c) {
                try {
                    var d = document.createElement("div");
                    d.innerHTML = a;
                    var e = new b(c || b.Config.RELAXED),
                        f = e.clean_node(d),
                        g = document.createElement("div");
                    return g.appendChild(f.cloneNode(!0)), g.innerHTML
                } catch (h) {
                    return _.escape(a)
                }
            }
        }),
        function() {
            var a, b, c, d, e, f, g = [].slice;
            c = function(a) {
                var b, d;
                return !_.isObject(a) || _.isFunction(a) ? a : a instanceof Backbone.Collection || a instanceof Backbone.Model ? a : _.isDate(a) ? new Date(a.getTime()) : _.isRegExp(a) ? new RegExp(a.source, a.toString().replace(/.*\//, "")) : (d = _.isArray(a || _.isArguments(a)), b = function(a, b, e) {
                    return d ? a.push(c(b)) : a[e] = c(b), a
                }, _.reduce(a, b, d ? [] : {}))
            }, f = function(a) {
                return null == a ? !1 : !(a.prototype !== {}.prototype && a.prototype !== Object.prototype || !_.isObject(a) || _.isArray(a) || _.isFunction(a) || _.isDate(a) || _.isRegExp(a) || _.isArguments(a))
            }, b = function(a) {
                return _.filter(_.keys(a), function(b) {
                    return f(a[b])
                })
            }, a = function(a) {
                return _.filter(_.keys(a), function(b) {
                    return _.isArray(a[b])
                })
            }, e = function(c, d, f) {
                var g, h, i, j, k, l, m, n, o, p;
                if (null == f && (f = 20), 0 >= f) return console.warn("_.deepExtend(): Maximum depth of recursion hit."), _.extend(c, d);
                for (l = _.intersection(b(c), b(d)), h = function(a) {
                        return d[a] = e(c[a], d[a], f - 1)
                    }, m = 0, o = l.length; o > m; m++) k = l[m], h(k);
                for (j = _.intersection(a(c), a(d)), g = function(a) {
                        return d[a] = _.union(c[a], d[a])
                    }, n = 0, p = j.length; p > n; n++) i = j[n], g(i);
                return _.extend(c, d)
            }, d = function() {
                var a, b, d, f;
                if (d = 2 <= arguments.length ? g.call(arguments, 0, f = arguments.length - 1) : (f = 0, []), b = arguments[f++], _.isNumber(b) || (d.push(b), b = 20), d.length <= 1) return d[0];
                if (0 >= b) return _.extend.apply(this, d);
                for (a = d.shift(); d.length > 0;) a = e(a, c(d.shift()), b);
                return a
            }, _.mixin({
                deepClone: c,
                isBasicObject: f,
                basicObjects: b,
                arrays: a,
                deepExtend: d
            })
        }.call(this),
        function(a) {
            "function" == typeof define && define.amd ? define(["underscore", "backbone"], a) : a(_, Backbone)
        }(function(a, b) {
            function c(b) {
                var d = {},
                    e = g.keyPathSeparator;
                for (var f in b) {
                    var h = b[f];
                    if (h && h.constructor === Object && !a.isEmpty(h)) {
                        var i = c(h);
                        for (var j in i) {
                            var k = i[j];
                            d[f + e + j] = k
                        }
                    } else d[f] = h
                }
                return d
            }

            function d(b, c, d) {
                for (var e = g.keyPathSeparator, f = c.split(e), h = b, i = 0, j = f.length; j > i; i++) {
                    if (d && !a.has(h, f[i])) return !1;
                    if (h = h[f[i]], null == h && j - 1 > i && (h = {}), "undefined" == typeof h) return d ? !0 : h
                }
                return d ? !0 : h
            }

            function e(b, c, d, e) {
                e = e || {};
                for (var f = g.keyPathSeparator, h = c.split(f), i = b, j = 0, k = h.length; k > j && void 0 !== i; j++) {
                    var l = h[j];
                    j === k - 1 ? e.unset ? delete i[l] : i[l] = d : ("undefined" != typeof i[l] && a.isObject(i[l]) || (i[l] = {}), i = i[l])
                }
            }

            function f(a, b) {
                e(a, b, null, {
                    unset: !0
                })
            }
            var g = b.Model.extend({
                constructor: function(b, c) {
                    var d, e = b || {};
                    this.cid = a.uniqueId("c"), this.attributes = {}, c && c.collection && (this.collection = c.collection), c && c.parse && (e = this.parse(e, c) || {}), (d = a.result(this, "defaults")) && (e = a.deepExtend({}, d, e)), this.set(e, c), this.changed = {}, this.initialize.apply(this, arguments)
                },
                toJSON: function() {
                    return a.deepClone(this.attributes)
                },
                get: function(a) {
                    return d(this.attributes, a)
                },
                set: function(b, h, i) {
                    var j, k, l, m, n, o, p, q;
                    if (null == b) return this;
                    if ("object" == typeof b ? (k = b, i = h || {}) : (k = {})[b] = h, i || (i = {}), !this._validate(k, i)) return !1;
                    l = i.unset, n = i.silent, m = [], o = this._changing, this._changing = !0, o || (this._previousAttributes = a.deepClone(this.attributes), this.changed = {}), q = this.attributes, p = this._previousAttributes, this.idAttribute in k && (this.id = k[this.idAttribute]), k = c(k);
                    for (j in k) h = k[j], a.isEqual(d(q, j), h) || m.push(j), a.isEqual(d(p, j), h) ? f(this.changed, j) : e(this.changed, j, h), l ? f(q, j) : e(q, j, h);
                    if (!n) {
                        m.length && (this._pending = !0);
                        for (var r = g.keyPathSeparator, s = 0, t = m.length; t > s; s++) {
                            var b = m[s];
                            this.trigger("change:" + b, this, d(q, b), i);
                            for (var u = b.split(r), v = u.length - 1; v > 0; v--) {
                                var w = a.first(u, v).join(r),
                                    x = w + r + "*";
                                this.trigger("change:" + x, this, d(q, w), i)
                            }
                        }
                    }
                    if (o) return this;
                    if (!n)
                        for (; this._pending;) this._pending = !1, this.trigger("change", this, i);
                    return this._pending = !1, this._changing = !1, this
                },
                clear: function(b) {
                    var d = {},
                        e = c(this.attributes);
                    for (var f in e) d[f] = void 0;
                    return this.set(d, a.extend({}, b, {
                        unset: !0
                    }))
                },
                hasChanged: function(b) {
                    return null == b ? !a.isEmpty(this.changed) : void 0 !== d(this.changed, b)
                },
                changedAttributes: function(b) {
                    if (!b) return this.hasChanged() ? c(this.changed) : !1;
                    var d = this._changing ? this._previousAttributes : this.attributes;
                    b = c(b), d = c(d);
                    var e, f = !1;
                    for (var g in b) a.isEqual(d[g], e = b[g]) || ((f || (f = {}))[g] = e);
                    return f
                },
                previous: function(a) {
                    return null != a && this._previousAttributes ? d(this._previousAttributes, a) : null
                },
                previousAttributes: function() {
                    return a.deepClone(this._previousAttributes)
                }
            });
            return g.keyPathSeparator = ".", b.DeepModel = g, "undefined" != typeof module && (module.exports = g), b
        }),
        function() {
            var b, c = function(a, b) {
                    return function() {
                        return a.apply(b, arguments)
                    }
                },
                d = [].slice,
                e = [].indexOf || function(a) {
                    for (var b = 0, c = this.length; c > b; b++)
                        if (b in this && this[b] === a) return b;
                    return -1
                };
            b = {}, String.prototype.trim || (String.prototype.trim = function() {
                return this.replace(/^\s+|\s+$/g, "")
            }), b.Binding = function() {
                function a(a, b, d, e, f, g) {
                    var h, i, j, k;
                    if (this.view = a, this.el = b, this.type = d, this.key = e, this.keypath = f, this.options = null != g ? g : {}, this.update = c(this.update, this), this.unbind = c(this.unbind, this), this.bind = c(this.bind, this), this.publish = c(this.publish, this), this.sync = c(this.sync, this), this.set = c(this.set, this), this.formattedValue = c(this.formattedValue, this), !(this.binder = this.view.binders[this.type])) {
                        k = this.view.binders;
                        for (h in k) j = k[h], "*" !== h && -1 !== h.indexOf("*") && (i = new RegExp("^" + h.replace("*", ".+") + "$"), i.test(this.type) && (this.binder = j, this.args = new RegExp("^" + h.replace("*", "(.+)") + "$").exec(this.type), this.args.shift()))
                    }
                    this.binder || (this.binder = this.view.binders["*"]), this.binder instanceof Function && (this.binder = {
                        routine: this.binder
                    }), this.formatters = this.options.formatters || [], this.model = this.view.models[this.key]
                }
                return a.prototype.formattedValue = function(a) {
                    var b, c, e, f, g, h;
                    for (h = this.formatters, f = 0, g = h.length; g > f; f++) c = h[f], b = c.split(/\s+/), e = b.shift(), c = this.model[e] instanceof Function ? this.model[e] : this.view.formatters[e], (null != c ? c.read : void 0) instanceof Function ? a = c.read.apply(c, [a].concat(d.call(b))) : c instanceof Function && (a = c.apply(null, [a].concat(d.call(b))));
                    return a
                }, a.prototype.set = function(a) {
                    var b;
                    return a = this.formattedValue(a instanceof Function && !this.binder["function"] ? a.call(this.model) : a), null != (b = this.binder.routine) ? b.call(this, this.el, a) : void 0
                }, a.prototype.sync = function() {
                    return this.set(this.options.bypass ? this.model[this.keypath] : this.view.config.adapter.read(this.model, this.keypath))
                }, a.prototype.publish = function() {
                    var a, c, e, f, g, h, i, j, k;
                    for (f = b.Util.getInputValue(this.el), i = this.formatters.slice(0).reverse(), g = 0, h = i.length; h > g; g++) c = i[g], a = c.split(/\s+/), e = a.shift(), (null != (j = this.view.formatters[e]) ? j.publish : void 0) && (f = (k = this.view.formatters[e]).publish.apply(k, [f].concat(d.call(a))));
                    return this.view.config.adapter.publish(this.model, this.keypath, f)
                }, a.prototype.bind = function() {
                    var a, b, c, d, e, f, g, h, i;
                    if (null != (f = this.binder.bind) && f.call(this, this.el), this.options.bypass ? this.sync() : (this.view.config.adapter.subscribe(this.model, this.keypath, this.sync), this.view.config.preloadData && this.sync()), null != (g = this.options.dependencies) ? g.length : void 0) {
                        for (h = this.options.dependencies, i = [], d = 0, e = h.length; e > d; d++) a = h[d], /^\./.test(a) ? (c = this.model, b = a.substr(1)) : (a = a.split("."), c = this.view.models[a.shift()], b = a.join(".")), i.push(this.view.config.adapter.subscribe(c, b, this.sync));
                        return i
                    }
                }, a.prototype.unbind = function() {
                    var a, b, c, d, e, f, g, h, i;
                    if (null != (f = this.binder.unbind) && f.call(this, this.el), this.options.bypass || this.view.config.adapter.unsubscribe(this.model, this.keypath, this.sync), null != (g = this.options.dependencies) ? g.length : void 0) {
                        for (h = this.options.dependencies, i = [], d = 0, e = h.length; e > d; d++) a = h[d], /^\./.test(a) ? (c = this.model, b = a.substr(1)) : (a = a.split("."), c = this.view.models[a.shift()], b = a.join(".")), i.push(this.view.config.adapter.unsubscribe(c, b, this.sync));
                        return i
                    }
                }, a.prototype.update = function() {
                    return this.unbind(), this.model = this.view.models[this.key], this.bind()
                }, a
            }(), b.View = function() {
                function a(a, d, e) {
                    var f, g, h, i, j, k, l, m, n;
                    for (this.els = a, this.models = d, this.options = null != e ? e : {}, this.update = c(this.update, this), this.publish = c(this.publish, this), this.sync = c(this.sync, this), this.unbind = c(this.unbind, this), this.bind = c(this.bind, this), this.select = c(this.select, this), this.build = c(this.build, this), this.bindingRegExp = c(this.bindingRegExp, this), this.els.jquery || this.els instanceof Array || (this.els = [this.els]), l = ["config", "binders", "formatters"], j = 0, k = l.length; k > j; j++) {
                        if (g = l[j], this[g] = {}, this.options[g]) {
                            m = this.options[g];
                            for (f in m) h = m[f], this[g][f] = h
                        }
                        n = b[g];
                        for (f in n) h = n[f], null == (i = this[g])[f] && (i[f] = h)
                    }
                    this.build()
                }
                return a.prototype.bindingRegExp = function() {
                    var a;
                    return a = this.config.prefix, a ? new RegExp("^data-" + a + "-") : /^data-/
                }, a.prototype.build = function() {
                    var a, c, d, f, g, h, i, j, k, l, m, n = this;
                    for (this.bindings = [], g = [], a = this.bindingRegExp(), f = function(c) {
                            var d, f, h, i, j, k, l, m, o, p, q, r, s, t, u, v, w, x, y, z, A, B, C, D, E, F, G, H;
                            if (e.call(g, c) < 0) {
                                for (E = c.attributes, y = 0, B = E.length; B > y; y++)
                                    if (d = E[y], a.test(d.name)) {
                                        if (w = d.name.replace(a, ""), !(h = n.binders[w])) {
                                            F = n.binders;
                                            for (l in F) x = F[l], "*" !== l && -1 !== l.indexOf("*") && (u = new RegExp("^" + l.replace("*", ".+") + "$"), u.test(w) && (h = x))
                                        }
                                        if (h || (h = n.binders["*"]), h.block) {
                                            for (G = c.getElementsByTagName("*"), z = 0, C = G.length; C > z; z++) p = G[z], g.push(p);
                                            f = [d]
                                        }
                                    }
                                for (H = f || c.attributes, A = 0, D = H.length; D > A; A++) d = H[A], a.test(d.name) && (q = {}, w = d.name.replace(a, ""), t = function() {
                                    var a, b, c, e;
                                    for (c = d.value.split("|"), e = [], a = 0, b = c.length; b > a; a++) s = c[a], e.push(s.trim());
                                    return e
                                }(), i = function() {
                                    var a, b, c, d;
                                    for (c = t.shift().split("<"), d = [], a = 0, b = c.length; b > a; a++) j = c[a], d.push(j.trim());
                                    return d
                                }(), r = i.shift(), v = r.split(/\.|:/), q.formatters = t, q.bypass = -1 !== r.indexOf(":"), v[0] ? m = v.shift() : (m = null, v.shift()), o = v.join("."), null != n.models[m] && ((k = i.shift()) && (q.dependencies = k.split(/\s+/)), n.bindings.push(new b.Binding(n, c, w, m, o, q))));
                                f && (f = null)
                            }
                        }, l = this.els, h = 0, j = l.length; j > h; h++)
                        for (c = l[h], f(c), m = c.getElementsByTagName("*"), i = 0, k = m.length; k > i; i++) d = m[i], null != d.attributes && f(d)
                }, a.prototype.select = function(a) {
                    var b, c, d, e, f;
                    for (e = this.bindings, f = [], c = 0, d = e.length; d > c; c++) b = e[c], a(b) && f.push(b);
                    return f
                }, a.prototype.bind = function() {
                    var a, b, c, d, e;
                    for (d = this.bindings, e = [], b = 0, c = d.length; c > b; b++) a = d[b], e.push(a.bind());
                    return e
                }, a.prototype.unbind = function() {
                    var a, b, c, d, e;
                    for (d = this.bindings, e = [], b = 0, c = d.length; c > b; b++) a = d[b], e.push(a.unbind());
                    return e
                }, a.prototype.sync = function() {
                    var a, b, c, d, e;
                    for (d = this.bindings, e = [], b = 0, c = d.length; c > b; b++) a = d[b], e.push(a.sync());
                    return e
                }, a.prototype.publish = function() {
                    var a, b, c, d, e;
                    for (d = this.select(function(a) {
                            return a.binder.publishes
                        }), e = [], b = 0, c = d.length; c > b; b++) a = d[b], e.push(a.publish());
                    return e
                }, a.prototype.update = function(a) {
                    var b, c, d, e;
                    null == a && (a = {}), e = [];
                    for (c in a) d = a[c], this.models[c] = d, e.push(function() {
                        var a, d, e, f;
                        for (e = this.select(function(a) {
                                return a.key === c
                            }), f = [], a = 0, d = e.length; d > a; a++) b = e[a], f.push(b.update());
                        return f
                    }.call(this));
                    return e
                }, a
            }(), b.Util = {
                bindEvent: function(b, c, d, e) {
                    var f;
                    return f = function(a) {
                        return d.call(this, a, e)
                    }, null != a.jQuery ? (b = jQuery(b), null != b.on ? b.on(c, f) : b.bind(c, f)) : null != a.addEventListener ? b.addEventListener(c, f, !1) : (c = "on" + c, b.attachEvent(c, f)), f
                },
                unbindEvent: function(b, c, d) {
                    return null != a.jQuery ? (b = jQuery(b), null != b.off ? b.off(c, d) : b.unbind(c, d)) : a.removeEventListener ? b.removeEventListener(c, d, !1) : (c = "on" + c, b.detachEvent(c, d))
                },
                getInputValue: function(b) {
                    var c, d, e, f;
                    if (null != a.jQuery) switch (b = jQuery(b), b[0].type) {
                        case "checkbox":
                            return b.is(":checked");
                        default:
                            return b.val()
                    } else switch (b.type) {
                        case "checkbox":
                            return b.checked;
                        case "select-multiple":
                            for (f = [], d = 0, e = b.length; e > d; d++) c = b[d], c.selected && f.push(c.value);
                            return f;
                        default:
                            return b.value
                    }
                }
            }, b.binders = {
                enabled: function(a, b) {
                    return a.disabled = !b
                },
                disabled: function(a, b) {
                    return a.disabled = !!b
                },
                checked: {
                    publishes: !0,
                    bind: function(a) {
                        return this.currentListener = b.Util.bindEvent(a, "change", this.publish)
                    },
                    unbind: function(a) {
                        return b.Util.unbindEvent(a, "change", this.currentListener)
                    },
                    routine: function(a, b) {
                        var c;
                        return a.checked = "radio" === a.type ? (null != (c = a.value) ? c.toString() : void 0) === (null != b ? b.toString() : void 0) : !!b
                    }
                },
                unchecked: {
                    publishes: !0,
                    bind: function(a) {
                        return this.currentListener = b.Util.bindEvent(a, "change", this.publish)
                    },
                    unbind: function(a) {
                        return b.Util.unbindEvent(a, "change", this.currentListener)
                    },
                    routine: function(a, b) {
                        var c;
                        return a.checked = "radio" === a.type ? (null != (c = a.value) ? c.toString() : void 0) !== (null != b ? b.toString() : void 0) : !b
                    }
                },
                show: function(a, b) {
                    return a.style.display = b ? "" : "none"
                },
                hide: function(a, b) {
                    return a.style.display = b ? "none" : ""
                },
                html: function(a, b) {
                    return a.innerHTML = null != b ? b : ""
                },
                value: {
                    publishes: !0,
                    bind: function(a) {
                        return this.currentListener = b.Util.bindEvent(a, "change", this.publish)
                    },
                    unbind: function(a) {
                        return b.Util.unbindEvent(a, "change", this.currentListener)
                    },
                    routine: function(b, c) {
                        var d, f, g, h, i, j, k;
                        if (null != a.jQuery) {
                            if (b = jQuery(b), (null != c ? c.toString() : void 0) !== (null != (h = b.val()) ? h.toString() : void 0)) return b.val(null != c ? c : "")
                        } else if ("select-multiple" === b.type) {
                            if (null != c) {
                                for (k = [], f = 0, g = b.length; g > f; f++) d = b[f], k.push(d.selected = (i = d.value, e.call(c, i) >= 0));
                                return k
                            }
                        } else if ((null != c ? c.toString() : void 0) !== (null != (j = b.value) ? j.toString() : void 0)) return b.value = null != c ? c : ""
                    }
                },
                text: function(a, b) {
                    return null != a.innerText ? a.innerText = null != b ? b : "" : a.textContent = null != b ? b : ""
                },
                "on-*": {
                    "function": !0,
                    routine: function(a, c) {
                        return this.currentListener && b.Util.unbindEvent(a, this.args[0], this.currentListener), this.currentListener = b.Util.bindEvent(a, this.args[0], c, this.view)
                    }
                },
                "each-*": {
                    block: !0,
                    bind: function(a) {
                        return a.removeAttribute(["data", this.view.config.prefix, this.type].join("-").replace("--", "-"))
                    },
                    unbind: function() {
                        var a, b, c, d, e;
                        if (null != this.iterated) {
                            for (d = this.iterated, e = [], b = 0, c = d.length; c > b; b++) a = d[b], e.push(a.unbind());
                            return e
                        }
                    },
                    routine: function(a, c) {
                        var d, e, f, g, h, i, j, k, l, m, n, o, p, q, r, s, t, u, v, w, x, y, z;
                        if (null != this.iterated)
                            for (u = this.iterated, o = 0, r = u.length; r > o; o++)
                                for (n = u[o], n.unbind(), v = n.els, p = 0, s = v.length; s > p; p++) e = v[p], e.parentNode.removeChild(e);
                        else this.marker = document.createComment(" rivets: " + this.type + " "), a.parentNode.insertBefore(this.marker, a), a.parentNode.removeChild(a);
                        if (this.iterated = [], c) {
                            for (z = [], q = 0, t = c.length; t > q; q++) {
                                f = c[q], d = {}, w = this.view.models;
                                for (j in w) i = w[j], d[j] = i;
                                if (d[this.args[0]] = f, g = a.cloneNode(!0), l = this.iterated.length ? this.iterated[this.iterated.length - 1].els[0] : this.marker, this.marker.parentNode.insertBefore(g, null != (x = l.nextSibling) ? x : null), k = {
                                        binders: this.view.options.binders,
                                        formatters: this.view.options.binders,
                                        config: {}
                                    }, this.view.options.config) {
                                    y = this.view.options.config;
                                    for (h in y) m = y[h], k.config[h] = m
                                }
                                k.config.preloadData = !0, n = new b.View(g, d, k), n.bind(), z.push(this.iterated.push(n))
                            }
                            return z
                        }
                    }
                },
                "class-*": function(a, b) {
                    var c;
                    return c = " " + a.className + " ", !b == (-1 !== c.indexOf(" " + this.args[0] + " ")) ? a.className = b ? "" + a.className + " " + this.args[0] : c.replace(" " + this.args[0] + " ", " ").trim() : void 0
                },
                "*": function(a, b) {
                    return b ? a.setAttribute(this.type, b) : a.removeAttribute(this.type)
                }
            }, b.config = {
                preloadData: !0
            }, b.formatters = {}, b.factory = function(a) {
                return a.binders = b.binders, a.formatters = b.formatters, a.config = b.config, a.configure = function(a) {
                    var c, d;
                    null == a && (a = {});
                    for (c in a) d = a[c], b.config[c] = d
                }, a.bind = function(a, c, d) {
                    var e;
                    return null == c && (c = {}), null == d && (d = {}), e = new b.View(a, c, d), e.bind(), e
                }
            }, "object" == typeof exports ? b.factory(exports) : "function" == typeof define && define.amd ? define(["exports"], function(a) {
                return b.factory(this.rivets = a), a
            }) : b.factory(this.rivets = {})
        }.call(this);
    var e = {
        AF: "Afghanistan",
        AX: "Åland Islands",
        AL: "Albania",
        DZ: "Algeria",
        AS: "American Samoa",
        AD: "Andorra",
        AO: "Angola",
        AI: "Anguilla",
        AQ: "Antarctica",
        AG: "Antigua and Barbuda",
        AR: "Argentina",
        AM: "Armenia",
        AW: "Aruba",
        AU: "Australia",
        AT: "Austria",
        AZ: "Azerbaijan",
        BS: "Bahamas",
        BH: "Bahrain",
        BD: "Bangladesh",
        BB: "Barbados",
        BY: "Belarus",
        BE: "Belgium",
        BZ: "Belize",
        BJ: "Benin",
        BM: "Bermuda",
        BT: "Bhutan",
        BO: "Bolivia, Plurinational State of",
        BQ: "Bonaire, Sint Eustatius and Saba",
        BA: "Bosnia and Herzegovina",
        BW: "Botswana",
        BV: "Bouvet Island",
        BR: "Brazil",
        IO: "British Indian Ocean Territory",
        BN: "Brunei Darussalam",
        BG: "Bulgaria",
        BF: "Burkina Faso",
        BI: "Burundi",
        KH: "Cambodia",
        CM: "Cameroon",
        CA: "Canada",
        CV: "Cape Verde",
        KY: "Cayman Islands",
        CF: "Central African Republic",
        TD: "Chad",
        CL: "Chile",
        CN: "China",
        CX: "Christmas Island",
        CC: "Cocos (Keeling) Islands",
        CO: "Colombia",
        KM: "Comoros",
        CG: "Congo",
        CD: "Congo, the Democratic Republic of the",
        CK: "Cook Islands",
        CR: "Costa Rica",
        CI: "Côte d'Ivoire",
        HR: "Croatia",
        CU: "Cuba",
        CW: "Curaçao",
        CY: "Cyprus",
        CZ: "Czech Republic",
        DK: "Denmark",
        DJ: "Djibouti",
        DM: "Dominica",
        DO: "Dominican Republic",
        EC: "Ecuador",
        EG: "Egypt",
        SV: "El Salvador",
        GQ: "Equatorial Guinea",
        ER: "Eritrea",
        EE: "Estonia",
        ET: "Ethiopia",
        FK: "Falkland Islands (Malvinas)",
        FO: "Faroe Islands",
        FJ: "Fiji",
        FI: "Finland",
        FR: "France",
        GF: "French Guiana",
        PF: "French Polynesia",
        TF: "French Southern Territories",
        GA: "Gabon",
        GM: "Gambia",
        GE: "Georgia",
        DE: "Germany",
        GH: "Ghana",
        GI: "Gibraltar",
        GR: "Greece",
        GL: "Greenland",
        GD: "Grenada",
        GP: "Guadeloupe",
        GU: "Guam",
        GT: "Guatemala",
        GG: "Guernsey",
        GN: "Guinea",
        GW: "Guinea-Bissau",
        GY: "Guyana",
        HT: "Haiti",
        HM: "Heard Island and McDonald Mcdonald Islands",
        VA: "Holy See (Vatican City State)",
        HN: "Honduras",
        HK: "Hong Kong",
        HU: "Hungary",
        IS: "Iceland",
        IN: "India",
        ID: "Indonesia",
        IR: "Iran, Islamic Republic of",
        IQ: "Iraq",
        IE: "Ireland",
        IM: "Isle of Man",
        IL: "Israel",
        IT: "Italy",
        JM: "Jamaica",
        JP: "Japan",
        JE: "Jersey",
        JO: "Jordan",
        KZ: "Kazakhstan",
        KE: "Kenya",
        KI: "Kiribati",
        KP: "Korea, Democratic People's Republic of",
        KR: "Korea, Republic of",
        KW: "Kuwait",
        KG: "Kyrgyzstan",
        LA: "Lao People's Democratic Republic",
        LV: "Latvia",
        LB: "Lebanon",
        LS: "Lesotho",
        LR: "Liberia",
        LY: "Libya",
        LI: "Liechtenstein",
        LT: "Lithuania",
        LU: "Luxembourg",
        MO: "Macao",
        MK: "Macedonia, the Former Yugoslav Republic of",
        MG: "Madagascar",
        MW: "Malawi",
        MY: "Malaysia",
        MV: "Maldives",
        ML: "Mali",
        MT: "Malta",
        MH: "Marshall Islands",
        MQ: "Martinique",
        MR: "Mauritania",
        MU: "Mauritius",
        YT: "Mayotte",
        MX: "Mexico",
        FM: "Micronesia, Federated States of",
        MD: "Moldova, Republic of",
        MC: "Monaco",
        MN: "Mongolia",
        ME: "Montenegro",
        MS: "Montserrat",
        MA: "Morocco",
        MZ: "Mozambique",
        MM: "Myanmar",
        NA: "Namibia",
        NR: "Nauru",
        NP: "Nepal",
        NL: "Netherlands",
        NC: "New Caledonia",
        NZ: "New Zealand",
        NI: "Nicaragua",
        NE: "Niger",
        NG: "Nigeria",
        NU: "Niue",
        NF: "Norfolk Island",
        MP: "Northern Mariana Islands",
        NO: "Norway",
        OM: "Oman",
        PK: "Pakistan",
        PW: "Palau",
        PS: "Palestine, State of",
        PA: "Panama",
        PG: "Papua New Guinea",
        PY: "Paraguay",
        PE: "Peru",
        PH: "Philippines",
        PN: "Pitcairn",
        PL: "Poland",
        PT: "Portugal",
        PR: "Puerto Rico",
        QA: "Qatar",
        RE: "Réunion",
        RO: "Romania",
        RU: "Russian Federation",
        RW: "Rwanda",
        BL: "Saint Barthélemy",
        SH: "Saint Helena, Ascension and Tristan da Cunha",
        KN: "Saint Kitts and Nevis",
        LC: "Saint Lucia",
        MF: "Saint Martin (French part)",
        PM: "Saint Pierre and Miquelon",
        VC: "Saint Vincent and the Grenadines",
        WS: "Samoa",
        SM: "San Marino",
        ST: "Sao Tome and Principe",
        SA: "Saudi Arabia",
        SN: "Senegal",
        RS: "Serbia",
        SC: "Seychelles",
        SL: "Sierra Leone",
        SG: "Singapore",
        SX: "Sint Maarten (Dutch part)",
        SK: "Slovakia",
        SI: "Slovenia",
        SB: "Solomon Islands",
        SO: "Somalia",
        ZA: "South Africa",
        GS: "South Georgia and the South Sandwich Islands",
        SS: "South Sudan",
        ES: "Spain",
        LK: "Sri Lanka",
        SD: "Sudan",
        SR: "Suriname",
        SJ: "Svalbard and Jan Mayen",
        SZ: "Swaziland",
        SE: "Sweden",
        CH: "Switzerland",
        SY: "Syrian Arab Republic",
        TW: "Taiwan, Province of China",
        TJ: "Tajikistan",
        TZ: "Tanzania, United Republic of",
        TH: "Thailand",
        TL: "Timor-Leste",
        TG: "Togo",
        TK: "Tokelau",
        TO: "Tonga",
        TT: "Trinidad and Tobago",
        TN: "Tunisia",
        TR: "Turkey",
        TM: "Turkmenistan",
        TC: "Turks and Caicos Islands",
        TV: "Tuvalu",
        UG: "Uganda",
        UA: "Ukraine",
        AE: "United Arab Emirates",
        GB: "United Kingdom",
        US: "United States",
        UM: "United States Minor Outlying Islands",
        UY: "Uruguay",
        UZ: "Uzbekistan",
        VU: "Vanuatu",
        VE: "Venezuela, Bolivarian Republic of",
        VN: "Viet Nam",
        VG: "Virgin Islands, British",
        VI: "Virgin Islands, U.S.",
        WF: "Wallis and Futuna",
        EH: "Western Sahara",
        YE: "Yemen",
        ZM: "Zambia",
        ZW: "Zimbabwe"
    };
    (function() {
        var a;
        a = document.addEventListener ? "input" : "keyup", rivets.binders.input = {
            publishes: !0,
            routine: rivets.binders.value.routine,
            bind: function(b) {
                return $(b).bind("" + a + ".rivets", this.publish)
            },
            unbind: function(b) {
                return $(b).unbind("" + a + ".rivets")
            }
        }, rivets.formatters.prepend = function(a, b) {
            return "" + b + a
        }, rivets.configure({
            prefix: "rv",
            adapter: {
                subscribe: function(a, b, c) {
                    return c.wrapped = function(a, b) {
                        return c(b)
                    }, a.on("change:" + b, c.wrapped)
                },
                unsubscribe: function(a, b, c) {
                    return a.off("change:" + b, c.wrapped)
                },
                read: function(a, b) {
                    return "cid" === b ? a.cid : a.get(b)
                },
                publish: function(a, b, c) {
                    return a.cid ? a.set(b, c) : a[b] = c
                }
            }
        })
    }).call(this),
        function() {
            var b;
            a.FormRenderer = b = Backbone.View.extend({
                defaults: {
                    enableAutosave: !0,
                    enableBeforeUnload: !0,
                    enablePages: !0,
                    enableErrorAlertBar: !0,
                    enableBottomStatusBar: !0,
                    enableLocalstorage: !0,
                    screendoorBase: "https://screendoor.dobt.co",
                    target: "[data-formrenderer]",
                    validateImmediately: !1,
                    response: {},
                    preview: !1,
                    skipValidation: void 0,
                    saveParams: {},
                    showLabels: !1
                },
                events: {
                    "click [data-activate-page]": function(a) {
                        return this.activatePage($(a.currentTarget).data("activate-page"), {
                            skipValidation: !0
                        })
                    }
                },
                draftIdStorageKey: function() {
                    return "project-" + this.options.project_id + "-response-id"
                },
                constructor: function(a) {
                    return this.options = $.extend({}, this.defaults, a), this.uploads = 0, this.state = new Backbone.Model({
                        hasChanges: !1
                    }), this.setElement($(this.options.target)), this.$el.addClass("fr_form"), this.$el.data("form-renderer", this), this.subviews = {
                        pages: {}
                    }, this.$el.html(JST.main(this)), this.options.enableLocalstorage && store.enabled && this.initLocalstorage(), this.loadFromServer(function(a) {
                        return function() {
                            return a.$el.find(".fr_loading").remove(), a.constructResponseFields(), a.constructPages(), a.options.enablePages ? a.constructPagination() : a.disablePagination(), a.options.enableBottomStatusBar && a.constructBottomStatusBar(), a.options.enableErrorAlertBar && a.constructErrorAlertBar(), a.options.enableAutosave && a.initAutosave(), a.options.enableBeforeUnload && a.initBeforeUnload(), a.options.validateImmediately ? a.validateAllPages() : void 0
                        }
                    }(this))
                },
                initLocalstorage: function() {
                    var a;
                    return (a = this.options.response).id || (a.id = store.get(this.draftIdStorageKey())), this.listenTo(this, "afterSave", function() {
                        return this.state.get("submitting") ? void 0 : store.set(this.draftIdStorageKey(), this.options.response.id)
                    })
                },
                loadFromServer: function(a) {
                    return null != this.options.response_fields && null != this.options.response.responses ? a() : $.ajax({
                        url: "" + this.options.screendoorBase + "/api/form_renderer/load",
                        type: "get",
                        dataType: "json",
                        data: {
                            project_id: this.options.project_id,
                            response_id: this.options.response.id,
                            v: 0
                        },
                        success: function(b) {
                            return function(c) {
                                var d, e, f;
                                return b.options.response.id = c.response_id, (d = b.options).response_fields || (d.response_fields = c.project.response_fields), (e = b.options.response).responses || (e.responses = (null != (f = c.response) ? f.responses : void 0) || {}), a()
                            }
                        }(this),
                        error: function(a) {
                            return function() {
                                return store.remove(a.draftIdStorageKey())
                            }
                        }(this)
                    })
                },
                constructResponseFields: function() {
                    var a, c, d, e, f;
                    for (this.response_fields = new Backbone.Collection, f = this.options.response_fields, d = 0, e = f.length; e > d; d++) c = f[d], a = new(b.Models["ResponseField" + _.str.classify(c.field_type)])(c), a.input_field && a.setExistingValue(this.options.response.responses[a.get("id")]), this.response_fields.add(a);
                    return this.listenTo(this.response_fields, "change", function() {
                        return this.state.get("hasChanges") ? void 0 : this.state.set("hasChanges", !0)
                    })
                },
                validateCurrentPage: function() {
                    return this.trigger("beforeValidate beforeValidate:" + this.state.get("activePage")), this.subviews.pages[this.state.get("activePage")].validate(), this.trigger("afterValidate afterValidate:" + this.state.get("activePage")), this.isPageValid(this.state.get("activePage"))
                },
                validateAllPages: function() {
                    var a, b, c;
                    this.trigger("beforeValidate beforeValidate:all"), c = this.subviews.pages;
                    for (b in c) a = c[b], a.validate();
                    return this.trigger("afterValidate afterValidate:all"), this.areAllPagesValid()
                },
                isPageValid: function(a) {
                    return !_.find(this.subviews.pages[a].models, function(a) {
                        return a.input_field && a.errors.length > 0
                    })
                },
                areAllPagesValid: function() {
                    var a;
                    return _.every(function() {
                        a = [];
                        for (var b = 1, c = this.numPages; c >= 1 ? c >= b : b >= c; c >= 1 ? b++ : b--) a.push(b);
                        return a
                    }.apply(this), function(a) {
                        return function(b) {
                            return a.isPageValid(b)
                        }
                    }(this))
                },
                numValidationErrors: function() {
                    return this.response_fields.filter(function(a) {
                        return a.input_field && a.errors.length > 0
                    }).length
                },
                constructPages: function() {
                    var a, c, d, e, f, g;
                    a = function(a) {
                        return function() {
                            return a.subviews.pages[c] = new b.Views.Page({
                                form_renderer: a
                            })
                        }
                    }(this), this.numPages = this.response_fields.filter(function(a) {
                        return "page_break" === a.get("field_type")
                    }).length + 1, this.state.set("activePage", 1), c = 1, a(), this.response_fields.each(function(b) {
                        return function(d) {
                            return "page_break" === d.get("field_type") ? (c++, a()) : b.subviews.pages[c].models.push(d)
                        }
                    }(this)), f = this.subviews.pages, g = [];
                    for (e in f) d = f[e], g.push(this.$el.append(d.render().el));
                    return g
                },
                constructPagination: function() {
                    return this.subviews.pagination = new b.Views.Pagination({
                        form_renderer: this
                    }), this.$el.prepend(this.subviews.pagination.render().el), this.subviews.pages[this.state.get("activePage")].show()
                },
                disablePagination: function() {
                    var a, b, c, d;
                    c = this.subviews.pages, d = [];
                    for (b in c) a = c[b], d.push(a.show());
                    return d
                },
                constructBottomStatusBar: function() {
                    return this.subviews.bottomStatusBar = new b.Views.BottomStatusBar({
                        form_renderer: this
                    }), this.$el.append(this.subviews.bottomStatusBar.render().el)
                },
                constructErrorAlertBar: function() {
                    return this.subviews.errorAlertBar = new b.Views.ErrorAlertBar({
                        form_renderer: this
                    }), this.$el.prepend(this.subviews.errorAlertBar.render().el)
                },
                activatePage: function(a, b) {
                    return null == b && (b = {}), b.skipValidation || this.validateCurrentPage() ? (this.subviews.pages[this.state.get("activePage")].hide(), this.subviews.pages[a].show(), this.state.set("activePage", a)) : void 0
                },
                getValue: function() {
                    return _.tap({}, function(a) {
                        return function(b) {
                            return a.response_fields.each(function(a) {
                                var c;
                                if (a.input_field) return c = a.getValue(), "object" == typeof c && c.merge ? (delete c.merge, _.extend(b, c)) : b[a.get("id")] = c
                            })
                        }
                    }(this))
                },
                saveParams: function() {
                    return _.extend({
                        v: 0,
                        response_id: this.options.response.id,
                        project_id: this.options.project_id,
                        skip_validation: this.options.skipValidation
                    }, this.options.saveParams)
                },
                save: function(a) {
                    return null == a && (a = {}), this.isSaving = !0, $.ajax({
                        url: "" + this.options.screendoorBase + "/api/form_renderer/save",
                        type: "post",
                        dataType: "json",
                        data: _.extend(this.saveParams(), {
                            raw_responses: this.getValue(),
                            submit: a.submit ? !0 : void 0
                        }),
                        complete: function(b) {
                            return function() {
                                var c;
                                return b.isSaving = !1, null != (c = a.complete) && c.apply(b, arguments), b.trigger("afterSave")
                            }
                        }(this),
                        success: function(b) {
                            return function(c) {
                                var d;
                                return b.state.set({
                                    hasChanges: !1,
                                    hasServerErrors: !1
                                }), b.options.response.id = c.response_id, null != (d = a.success) ? d.apply(b, arguments) : void 0
                            }
                        }(this),
                        error: function(b) {
                            return function() {
                                var c;
                                return b.state.set({
                                    hasServerErrors: !0,
                                    submitting: !1
                                }), null != (c = a.error) ? c.apply(b, arguments) : void 0
                            }
                        }(this)
                    })
                },
                initAutosave: function() {
                    return setInterval(function(a) {
                        return function() {
                            return a.state.get("hasChanges") && !a.isSaving ? a.save() : void 0
                        }
                    }(this), 5e3)
                },
                autosaveImmediately: function() {
                    return this.state.get("hasChanges") && !this.isSaving && this.options.enableAutosave ? this.save() : void 0
                },
                initBeforeUnload: function() {
                    return BeforeUnload.enable({
                        "if": function(a) {
                            return function() {
                                return a.state.get("hasChanges")
                            }
                        }(this)
                    })
                },
                waitForUploads: function(a) {
                    return this.uploads > 0 ? setTimeout(function(b) {
                        return function() {
                            return b.waitForUploads(a)
                        }
                    }(this), 100) : a()
                },
                submit: function(b) {
                    var c;
                    return null == b && (b = {}), b.skipValidation || this.options.skipValidation || this.validateAllPages() ? (this.state.set("submitting", !0), this.options.preview ? this.preview() : (c = b.afterSubmit || this.options.afterSubmit, this.waitForUploads(function(b) {
                        return function() {
                            return b.save({
                                submit: !0,
                                success: function() {
                                    var d;
                                    return store.remove(b.draftIdStorageKey()), "function" == typeof c ? c.call(b) : "string" == typeof c ? a.location = c.replace(":id", b.options.response.id) : "object" == typeof c && "page" === c.method ? (d = $('<input name="textoInicial" type="text" id="textoInicial" style="text-align: center;" value="' + c.html + '" disabled>'), b.$el.replaceWith(d)) : console.log("[FormRenderer] Not sure what to do...")
                                }
                            })
                        }
                    }(this)))) : void 0
                },
                preview: function() {
                    var b;
                    return b = function(b) {
                        return function() {
                            return a.location = b.options.preview.replace(":id", b.options.response.id)
                        }
                    }(this), !this.state.get("hasChanges") && this.options.enableAutosave && this.options.response.id ? b() : this.save({
                        success: b
                    })
                }
            }), b.INPUT_FIELD_TYPES = ["identification", "address", "checkboxes", "date", "dropdown", "email", "file", "number", "paragraph", "price", "radio", "table", "text", "time", "website", "map_marker"], b.NON_INPUT_FIELD_TYPES = ["block_of_text", "page_break", "section_break"], b.FIELD_TYPES = _.union(b.INPUT_FIELD_TYPES, b.NON_INPUT_FIELD_TYPES), b.Views = {}, b.Models = {}, b.Validators = {}, b.BUTTON_CLASS = "", b.DEFAULT_LAT_LNG = [40.7700118, -73.9800453], b.MAPBOX_URL = "https://api.tiles.mapbox.com/mapbox.js/v2.1.4/mapbox.js", b.FILE_TYPES = {}, b.loadLeaflet = function(a) {
                return null != ("undefined" != typeof L && null !== L ? L.GeoJSON : void 0) ? a() : b.loadingLeaflet ? b.loadingLeaflet.push(a) : (b.loadingLeaflet = [a], $.getScript(b.MAPBOX_URL, function() {
                    var a, c, d, e, f;
                    for (e = b.loadingLeaflet, f = [], c = 0, d = e.length; d > c; c++) a = e[c], f.push(a());
                    return f
                }))
            }, b.initMap = function(a) {
                return L.mapbox.accessToken = "pk.eyJ1IjoiYWRhbWphY29iYmVja2VyIiwiYSI6Im1SVEQtSm8ifQ.ZgEOSXsv9eLfGQ-9yAmtIg", L.mapbox.map(a, "adamjacobbecker.ja7plkah")
            }
        }.call(this),
        function() {
            FormRenderer.Validators.BaseValidator = function() {
                function a(a) {
                    this.model = a
                }
                return a
            }()
        }.call(this),
        function() {
            var a = {}.hasOwnProperty,
                b = function(b, c) {
                    function d() {
                        this.constructor = b
                    }
                    for (var e in c) a.call(c, e) && (b[e] = c[e]);
                    return d.prototype = c.prototype, b.prototype = new d, b.__super__ = c.prototype, b
                };
            FormRenderer.Validators.DateValidator = function(a) {
                function c() {
                    return c.__super__.constructor.apply(this, arguments)
                }
                return b(c, a), c.prototype.validate = function() {
                    var a, b, c;
                    if ("date" === this.model.field_type) return c = parseInt(this.model.get("value.year"), 10) || 0, a = parseInt(this.model.get("value.day"), 10) || 0, b = parseInt(this.model.get("value.month"), 10) || 0, c > 0 && a > 0 && 31 >= a && b > 0 && 12 >= b ? void 0 : "Formato de Fecha Invalido"
                }, c
            }(FormRenderer.Validators.BaseValidator)
        }.call(this),
        function() {
            var a = {}.hasOwnProperty,
                b = function(b, c) {
                    function d() {
                        this.constructor = b
                    }
                    for (var e in c) a.call(c, e) && (b[e] = c[e]);
                    return d.prototype = c.prototype, b.prototype = new d, b.__super__ = c.prototype, b
                };
            FormRenderer.Validators.EmailValidator = function(a) {
                function c() {
                    return c.__super__.constructor.apply(this, arguments)
                }
                return b(c, a), c.prototype.validate = function() {
                    return "email" === this.model.field_type ? this.model.get("value").match("@") ? void 0 : "Email Invalido!" : void 0
                }, c
            }(FormRenderer.Validators.BaseValidator)
        }.call(this),
        function() {
            var a = {}.hasOwnProperty,
                b = function(b, c) {
                    function d() {
                        this.constructor = b
                    }
                    for (var e in c) a.call(c, e) && (b[e] = c[e]);
                    return d.prototype = c.prototype, b.prototype = new d, b.__super__ = c.prototype, b
                };
            FormRenderer.Validators.IdentificationValidator = function(a) {
                function c() {
                    return c.__super__.constructor.apply(this, arguments)
                }
                return b(c, a), c.prototype.validate = function() {
                    return this.model.get("value.name") && this.model.get("value.email") ? this.model.get("value.email").match("@") ? void 0 : "email is invalid" : "please enter your name and email"
                }, c
            }(FormRenderer.Validators.BaseValidator)
        }.call(this),
        function() {
            var a = {}.hasOwnProperty,
                b = function(b, c) {
                    function d() {
                        this.constructor = b
                    }
                    for (var e in c) a.call(c, e) && (b[e] = c[e]);
                    return d.prototype = c.prototype, b.prototype = new d, b.__super__ = c.prototype, b
                };
            FormRenderer.Validators.IntegerValidator = function(a) {
                function c() {
                    return c.__super__.constructor.apply(this, arguments)
                }
                return b(c, a), c.VALID_REGEX = /^-?\d+$/, c.prototype.validate = function() {
                    return this.model.get("field_options.integer_only") ? this.model.get("value").match(this.constructor.VALID_REGEX) ? void 0 : "is not an integer" : void 0
                }, c
            }(FormRenderer.Validators.BaseValidator)
        }.call(this),
        function() {
            var a = {}.hasOwnProperty,
                b = function(b, c) {
                    function d() {
                        this.constructor = b
                    }
                    for (var e in c) a.call(c, e) && (b[e] = c[e]);
                    return d.prototype = c.prototype, b.prototype = new d, b.__super__ = c.prototype, b
                };
            FormRenderer.Validators.MinMaxLengthValidator = function(a) {
                function c() {
                    return c.__super__.constructor.apply(this, arguments)
                }
                return b(c, a), c.prototype.validate = function() {
                    var a;
                    if (this.model.get("field_options.minlength") || this.model.get("field_options.maxlength")) return this.min = parseInt(this.model.get("field_options.minlength"), 10) || void 0, this.max = parseInt(this.model.get("field_options.maxlength"), 10) || void 0, a = "words" === this.model.get("field_options.min_max_length_units") ? this.countWords() : this.countCharacters(), this.min && a < this.min ? "is too short" : this.max && a > this.max ? "is too long" : void 0
                }, c.prototype.countWords = function() {
                    return (_.str.trim(this.model.get("value")).replace(/['";:,.?¿\-!¡]+/g, "").match(/\S+/g) || "").length
                }, c.prototype.countCharacters = function() {
                    return _.str.trim(this.model.get("value")).replace(/\s/g, "").length
                }, c
            }(FormRenderer.Validators.BaseValidator)
        }.call(this),
        function() {
            var a = {}.hasOwnProperty,
                b = function(b, c) {
                    function d() {
                        this.constructor = b
                    }
                    for (var e in c) a.call(c, e) && (b[e] = c[e]);
                    return d.prototype = c.prototype, b.prototype = new d, b.__super__ = c.prototype, b
                };
            FormRenderer.Validators.MinMaxValidator = function(a) {
                function c() {
                    return c.__super__.constructor.apply(this, arguments)
                }
                return b(c, a), c.prototype.validate = function() {
                    var a;
                    if (this.model.get("field_options.min") || this.model.get("field_options.max")) return this.min = this.model.get("field_options.min") && parseFloat(this.model.get("field_options.min")), this.max = this.model.get("field_options.max") && parseFloat(this.model.get("field_options.max")), a = parseFloat("price" === this.model.field_type ? "" + (this.model.get("value.dollars") || 0) + "." + (this.model.get("value.cents") || 0) : this.model.get("value").replace(/,/g, "")), this.min && a < this.min ? "is too small" : this.max && a > this.max ? "is too large" : void 0
                }, c
            }(FormRenderer.Validators.BaseValidator)
        }.call(this),
        function() {
            var a = {}.hasOwnProperty,
                b = function(b, c) {
                    function d() {
                        this.constructor = b
                    }
                    for (var e in c) a.call(c, e) && (b[e] = c[e]);
                    return d.prototype = c.prototype, b.prototype = new d, b.__super__ = c.prototype, b
                };
            FormRenderer.Validators.NumberValidator = function(a) {
                function c() {
                    return c.__super__.constructor.apply(this, arguments)
                }
                return b(c, a), c.VALID_REGEX = /^-?\d*(\.\d+)?$/, c.prototype.validate = function() {
                    var a;
                    if ("number" === this.model.field_type) return a = this.model.get("value"), a = a.replace(/,/g, "").replace(/-/g, "").replace(/^\+/, ""), a.match(this.constructor.VALID_REGEX) ? void 0 : "Numero Invalido! / Invalid number"
                }, c
            }(FormRenderer.Validators.BaseValidator)
        }.call(this),
        function() {
            var a = {}.hasOwnProperty,
                b = function(b, c) {
                    function d() {
                        this.constructor = b
                    }
                    for (var e in c) a.call(c, e) && (b[e] = c[e]);
                    return d.prototype = c.prototype, b.prototype = new d, b.__super__ = c.prototype, b
                };
            FormRenderer.Validators.PriceValidator = function(a) {
                function c() {
                    return c.__super__.constructor.apply(this, arguments)
                }
                return b(c, a), c.prototype.validate = function() {
                    var a;
                    if ("price" === this.model.field_type) return a = [], this.model.get("value.dollars") && a.push(this.model.get("value.dollars").replace(/,/g, "")), this.model.get("value.cents") && a.push(this.model.get("value.cents")), _.every(a, function(a) {
                        return a.match(/^-?\d+$/)
                    }) ? void 0 : "isn't a valid price"
                }, c
            }(FormRenderer.Validators.BaseValidator)
        }.call(this),
        function() {
            var a = {}.hasOwnProperty,
                b = function(b, c) {
                    function d() {
                        this.constructor = b
                    }
                    for (var e in c) a.call(c, e) && (b[e] = c[e]);
                    return d.prototype = c.prototype, b.prototype = new d, b.__super__ = c.prototype, b
                };
            FormRenderer.Validators.TimeValidator = function(a) {
                function c() {
                    return c.__super__.constructor.apply(this, arguments)
                }
                return b(c, a), c.prototype.validate = function() {
                    var a, b, c;
                    if ("time" === this.model.field_type) return a = parseInt(this.model.get("value.hours"), 10) || 0, b = parseInt(this.model.get("value.minutes"), 10) || 0, c = parseInt(this.model.get("value.seconds"), 10) || 0, a >= 1 && 12 >= a && b >= 0 && 60 >= b && c >= 0 && 60 >= c ? void 0 : "Hora inválida! / Invalid Hour"
                }, c
            }(FormRenderer.Validators.BaseValidator)
        }.call(this),
        function() {
            //console.log("A");

            var a, b, c, d, e = [].indexOf || function(a) {
                for (var b = 0, c = this.length; c > b; b++)
                    if (b in this && this[b] === a) return b;
                return -1
            };
            for (FormRenderer.Models.ResponseField = Backbone.DeepModel.extend({
                    input_field: !0,
                    field_type: void 0,
                    validators: [],
                    sync: function() {},
                    initialize: function() {
                        return this.errors = [], this.hasLengthValidations() ? this.listenTo(this, "change:value", this.calculateLength) : void 0
                    },
                    validate: function() {
                        var a, b, c, d, e, f;
                        var valorValidateRequerido;
                         if (this.get("required")=="0"){
                                valorValidateRequerido=false;
                            }else{
                                console.log("NO ENTRA")
                                valorValidateRequerido=true;
                            }
                        if (this.errors = [], !this.hasValue()) return void(valorValidateRequerido && this.errors.push("No puede ser Vacio / Could not be empty"));
                        e = this.validators, f = [];
                        for (d in e) c = e[d], b = new c(this), a = b.validate(), f.push(a ? this.errors.push(a) : void 0);
                        return f
                    },
                    getError: function() {
                        return this.errors.length > 0 ? this.errors.join(". ") : void 0
                    },
                    hasLengthValidations: function() {
                        var a;
                        return a = FormRenderer.Validators.MinMaxLengthValidator, e.call(this.validators, a) >= 0 && this.get("field_options.minlength") || this.get("field_options.maxlength")
                    },
                    calculateLength: function() {
                        var a;
                        return a = new FormRenderer.Validators.MinMaxLengthValidator(this), this.set("currentLength", a["words" === this.getLengthValidationUnits() ? "countWords" : "countCharacters"]())
                    },
                    hasMinMaxValidations: function() {
                        var a;
                        return a = FormRenderer.Validators.MinMaxValidator, e.call(this.validators, a) >= 0 && this.get("field_options.min") || this.get("field_options.max")
                    },
                    getLengthValidationUnits: function() {
                        return this.get("field_options.min_max_length_units") || "characters"
                    },
                    setExistingValue: function(a) {
                        return a && this.set("value", a), this.hasLengthValidations() ? this.calculateLength() : void 0
                    },
                    getValue: function() {
                        return this.get("value")
                    },
                    hasValue: function() {
                        return !!this.get("value")
                    },
                    hasAnyValueInHash: function() {
                        return _.some(this.get("value"), function(a) {
                            return !!a
                        })
                    },
                    hasValueHashKey: function(a) {
                        return _.some(a, function(a) {
                            return function(b) {
                                return !!a.get("value." + b)
                            }
                        }(this))
                    },
                    getOptions: function() {
                        return this.get("field_options.options") || []
                    },
                    getColumns: function() {
                        return this.get("field_options.columns") || []
                    },
                    columnOrOptionKeypath: function() {
                        return "table" === this.field_type ? "field_options.columns" : "field_options.options"
                    },
                    addOptionOrColumnAtIndex: function(a) {
                        var b, c;
                        return c = "table" === this.field_type ? this.getColumns() : this.getOptions(), b = {
                            label: ""
                        }, "table" !== this.field_type && (b.checked = !1), -1 === a ? c.push(b) : c.splice(a + 1, 0, b), this.set(this.columnOrOptionKeypath(), c), this.trigger("change")
                    },
                    removeOptionOrColumnAtIndex: function(a) {
                        var b;
                        return b = this.get(this.columnOrOptionKeypath()), b.splice(a, 1), this.set(this.columnOrOptionKeypath(), b), this.trigger("change")
                    }
                }), FormRenderer.Models.NonInputResponseField = Backbone.DeepModel.extend({
                    input_field: !1,
                    field_type: void 0,
                    sync: function() {}
                }), FormRenderer.Models.ResponseFieldIdentification = FormRenderer.Models.ResponseField.extend({
                    field_type: "identification",
                    validators: [FormRenderer.Validators.IdentificationValidator],
                    hasValue: function() {
                        return !0
                    }
                }), FormRenderer.Models.ResponseFieldMapMarker = FormRenderer.Models.ResponseField.extend({
                    field_type: "map_marker",
                    hasValue: function() {
                        return _.every(["lat", "lng"], function(a) {
                            return function(b) {
                                return !!a.get("value." + b)
                            }
                        }(this))
                    },
                    latLng: function() {
                        return this.hasValue() ? [this.get("value.lat"), this.get("value.lng")] : void 0
                    },
                    defaultLatLng: function() {
                        var a, b;
                        return (a = this.get("field_options.default_lat")) && (b = this.get("field_options.default_lng")) ? [a, b] : void 0
                    }
                }), FormRenderer.Models.ResponseFieldAddress = FormRenderer.Models.ResponseField.extend({
                    field_type: "address",
                    setExistingValue: function(a) {
                        var b;
                        return FormRenderer.Models.ResponseField.prototype.setExistingValue.apply(this, arguments), "city_state" === (b = this.get("field_options.address_format")) || "city_state_zip" === b || (null != a ? a.country : void 0) ? void 0 : this.set("value.country", "US")
                    },
                    hasValue: function() {
                        return this.hasValueHashKey(["street", "city", "state", "zipcode"])
                    }
                }), FormRenderer.Models.ResponseFieldCheckboxes = FormRenderer.Models.ResponseField.extend({
                    field_type: "checkboxes",
                    setExistingValue: function(a) {
                        return this.set("value", _.tap({}, function(b) {
                            return function(c) {
                                var d, e, f, g, h, i, j, k, l;
                                if (_.isEmpty(a)) {
                                    for (k = b.getOptions(), l = [], d = g = 0, i = k.length; i > g; d = ++g) e = k[d], l.push(c["" + d] = _.toBoolean(e.checked));
                                    return l
                                }
                                for (j = b.getOptions(), d = f = 0, h = j.length; h > f; d = ++f) e = j[d], c["" + d] = a[e.label];
                                return a.Other ? (c.other_checkbox = !0, c.other = a.Other) : void 0
                            }
                        }(this)))
                    },
                    getValue: function() {
                        var a, b, c, d;
                        b = {}, d = this.get("value");
                        for (a in d) c = d[a], b[a] = c === !0 ? "on" : c;
                        return b
                    },
                    hasValue: function() {
                        return this.hasAnyValueInHash()
                    }
                }), FormRenderer.Models.ResponseFieldRadio = FormRenderer.Models.ResponseField.extend({
                    field_type: "radio",
                    setExistingValue: function(a) {
                        var b;
                        return (null != a ? a.selected : void 0) ? this.set("value", a) : (b = _.find(this.getOptions(), function(a) {
                            return _.toBoolean(a.checked)
                        })) ? this.set("value.selected", b.label) : this.set("value", {})
                    },
                    getValue: function() {
                        return _.tap({
                            merge: !0
                        }, function(a) {
                            return function(b) {
                                return b["" + a.get("id")] = a.get("value.selected"), b["" + a.get("id") + "_other"] = a.get("value.other")
                            }
                        }(this))
                    },
                    hasValue: function() {
                        return !!this.get("value.selected")
                    }
                }), FormRenderer.Models.ResponseFieldDropdown = FormRenderer.Models.ResponseField.extend({
                    field_type: "dropdown",
                    setExistingValue: function(a) {
                        var b;
                        return null != a ? FormRenderer.Models.ResponseField.prototype.setExistingValue.apply(this, arguments) : (b = _.find(this.getOptions(), function(a) {
                            return _.toBoolean(a.checked)
                        }), b || this.get("field_options.include_blank_option") || (b = _.first(this.getOptions())), b ? this.set("value", b.label) : this.unset("value"))
                    }
                }), FormRenderer.Models.ResponseFieldTable = FormRenderer.Models.ResponseField.extend({
                    field_type: "table",
                    initialize: function() {
                        return FormRenderer.Models.ResponseField.prototype.initialize.apply(this, arguments), this.get("field_options.column_totals") ? this.listenTo(this, "change:value.*", this.calculateColumnTotals) : void 0
                    },
                    canAddRows: function() {
                        return this.numRows < this.maxRows()
                    },
                    minRows: function() {
                        return parseInt(this.get("field_options.minrows"), 10) || 0
                    },
                    maxRows: function() {
                        return this.get("field_options.maxrows") ? parseInt(this.get("field_options.maxrows"), 10) || 1 / 0 : 1 / 0
                    },
                    setExistingValue: function(a) {
                        var b, c;
                        return b = (null != (c = _.find(a, function() {
                            return !0
                        })) ? c.length : void 0) || 0, this.numRows = Math.max(this.minRows(), b, 1), this.set("value", _.tap({}, function(b) {
                            return function(c) {
                                var d, e, f, g, h, i;
                                for (i = [], e = g = 0, h = b.numRows - 1; h >= 0 ? h >= g : g >= h; e = h >= 0 ? ++g : --g) i.push(function() {
                                    var b, g, h, i, j, k;
                                    for (i = this.getColumns(), k = [], f = b = 0, g = i.length; g > b; f = ++b) d = i[f], c[h = "" + f] || (c[h] = {}), k.push(c["" + f]["" + e] = this.getPresetValue(d.label, e) || (null != a && null != (j = a[d.label]) ? j[e] : void 0));
                                    return k
                                }.call(b));
                                return i
                            }
                        }(this)))
                    },
                    hasValue: function() {
                        return _.some(this.get("value"), function(a) {
                            return _.some(a, function(a) {
                                return !!a
                            })
                        })
                    },
                    getPresetValue: function(a, b) {
                        var c;
                        return null != (c = this.get("field_options.preset_values." + a)) ? c[b] : void 0
                    },
                    getValue: function() {
                        var a, b, c, d, e, f, g, h, i;
                        for (d = {}, b = e = 0, h = this.numRows - 1; h >= 0 ? h >= e : e >= h; b = h >= 0 ? ++e : --e)
                            for (i = this.getColumns(), c = f = 0, g = i.length; g > f; c = ++f) a = i[c], d[c] || (d[c] = []), d[c].push(this.get("value." + c + "." + b) || "");
                        return d
                    },
                    calculateColumnTotals: function() {
                        var a, b, c, d, e, f, g, h, i, j, k;
                        for (i = this.getColumns(), k = [], e = f = 0, h = i.length; h > f; e = ++f) {
                            for (a = i[e], c = [], d = g = 0, j = this.numRows - 1; j >= 0 ? j >= g : g >= j; d = j >= 0 ? ++g : --g) c.push(parseFloat((this.get("value." + e + "." + d) || "").replace(/\$?,?/g, "")));
                            b = _.reduce(c, function(a, b) {
                                return _.isNaN(b) ? a : a + b
                            }, 0), k.push(this.set("columnTotals." + e, b > 0 ? parseFloat(b.toFixed(10)) : ""))
                        }
                        return k
                    }
                }), FormRenderer.Models.ResponseFieldFile = FormRenderer.Models.ResponseField.extend({
                    field_type: "file",
                    getValue: function() {
                        return this.get("value.id") || ""
                    },
                    hasValue: function() {
                        return this.hasValueHashKey(["id"])
                    },
                    getAcceptedExtensions: function() {
                        var a;
                        return (a = FormRenderer.FILE_TYPES[this.get("field_options.file_types")]) ? _.map(a, function(a) {
                            return "." + a
                        }) : void 0
                    }
                }), FormRenderer.Models.ResponseFieldDate = FormRenderer.Models.ResponseField.extend({
                    field_type: "date",
                    validators: [FormRenderer.Validators.DateValidator],
                    hasValue: function() {
                        return this.hasValueHashKey(["month", "day", "year"])
                    }
                }), FormRenderer.Models.ResponseFieldEmail = FormRenderer.Models.ResponseField.extend({
                    validators: [FormRenderer.Validators.EmailValidator],
                    field_type: "email"
                }), FormRenderer.Models.ResponseFieldNumber = FormRenderer.Models.ResponseField.extend({
                    validators: [FormRenderer.Validators.NumberValidator, FormRenderer.Validators.MinMaxValidator, FormRenderer.Validators.IntegerValidator],
                    field_type: "number"
                }), FormRenderer.Models.ResponseFieldParagraph = FormRenderer.Models.ResponseField.extend({
                    field_type: "paragraph",
                    validators: [FormRenderer.Validators.MinMaxLengthValidator]
                }), FormRenderer.Models.ResponseFieldPrice = FormRenderer.Models.ResponseField.extend({
                    validators: [FormRenderer.Validators.PriceValidator, FormRenderer.Validators.MinMaxValidator],
                    field_type: "price",
                    hasValue: function() {
                        return this.hasValueHashKey(["dollars", "cents"])
                    }
                }), FormRenderer.Models.ResponseFieldText = FormRenderer.Models.ResponseField.extend({
                    field_type: "text",
                    validators: [FormRenderer.Validators.MinMaxLengthValidator]
                }), FormRenderer.Models.ResponseFieldTime = FormRenderer.Models.ResponseField.extend({
                    validators: [FormRenderer.Validators.TimeValidator],
                    field_type: "time",
                    hasValue: function() {
                        return this.hasValueHashKey(["hours", "minutes", "seconds"])
                    },
                    setExistingValue: function(a) {
                        return FormRenderer.Models.ResponseField.prototype.setExistingValue.apply(this, arguments), (null != a ? a.am_pm : void 0) ? void 0 : this.set("value.am_pm", "AM")
                    }
                }), FormRenderer.Models.ResponseFieldWebsite = FormRenderer.Models.ResponseField.extend({
                    field_type: "website"
                }), d = FormRenderer.NON_INPUT_FIELD_TYPES, b = 0, c = d.length; c > b; b++) a = d[b], FormRenderer.Models["ResponseField" + _.str.classify(a)] = FormRenderer.Models.NonInputResponseField.extend({
                field_type: a
            })
        }.call(this),
        function() {
            var b, c, d, e, f, g, h;
            for (FormRenderer.Views.Pagination = Backbone.View.extend({
                    initialize: function(a) {
                        return this.form_renderer = a.form_renderer, this.listenTo(this.form_renderer.state, "change:activePage", this.render), this.listenTo(this.form_renderer, "afterValidate", this.render)
                    },
                    render: function() {
                        return this.$el.html(JST["partials/pagination"](this)), this
                    }
                }), FormRenderer.Views.ErrorAlertBar = Backbone.View.extend({
                    initialize: function(a) {
                        return this.form_renderer = a.form_renderer, this.listenTo(this.form_renderer, "afterValidate", this.render)
                    },
                    render: function() {
                        return this.$el.html(JST["partials/error_alert_bar"](this)), this.form_renderer.areAllPagesValid() || a.scrollTo(0, this.$el.offset().top - 10), this
                    }
                }), FormRenderer.Views.BottomStatusBar = Backbone.View.extend({
                    events: {
                        "click [data-js-back]": "handleBack",
                        "click [data-js-continue]": "handleContinue"
                    },
                    initialize: function(a) {
                        return this.form_renderer = a.form_renderer, this.listenTo(this.form_renderer.state, "change:activePage change:hasChanges change:submitting change:hasServerErrors", this.render)
                    },
                    render: function() {
                        return this.$el.html(JST["partials/bottom_status_bar"](this)), this
                    },
                    firstPage: function() {
                        return 1 === this.form_renderer.state.get("activePage")
                    },
                    lastPage: function() {
                        return this.form_renderer.state.get("activePage") === this.form_renderer.numPages
                    },
                    previousPage: function() {
                        return this.form_renderer.state.get("activePage") - 1
                    },
                    nextPage: function() {
                        return this.form_renderer.state.get("activePage") + 1
                    },
                    handleBack: function(a) {
                        return a.preventDefault(), this.form_renderer.activatePage(this.previousPage(), {
                            skipValidation: !0
                        })
                    },
                    handleContinue: function(a) {
                        return a.preventDefault(), this.lastPage() || !this.form_renderer.options.enablePages ? this.form_renderer.submit() : this.form_renderer.activatePage(this.nextPage())
                    }
                }), FormRenderer.Views.Page = Backbone.View.extend({
                    className: "fr_page",
                    initialize: function(a) {
                        return this.form_renderer = a.form_renderer, this.models = [], this.views = []
                    },
                    render: function() {
                        var a, b, c, d, e;
                        for (this.hide(), e = this.models, c = 0, d = e.length; d > c; c++) a = e[c], b = new(FormRenderer.Views["ResponseField" + _.str.classify(a.field_type)])({
                            model: a,
                            form_renderer: this.form_renderer
                        }), this.$el.append(b.render().el), this.views.push(b);
                        return this
                    },
                    hide: function() {
                        var a, b, c, d, e;
                        for (this.$el.hide(), d = this.views, e = [], b = 0, c = d.length; c > b; b++) a = d[b], e.push(a.trigger("hidden"));
                        return e
                    },
                    show: function() {
                        var a, b, c, d, e;
                        for (this.$el.show(), d = this.views, e = [], b = 0, c = d.length; c > b; b++) a = d[b], e.push(a.trigger("shown"));
                        return e
                    },
                    validate: function() {
                        var a, b, c, d, e, f, g, h, i;
                        for (g = _.filter(this.models, function(a) {
                                return a.input_field
                            }), c = 0, e = g.length; e > c; c++) a = g[c], a.validate();
                        for (h = this.views, i = [], d = 0, f = h.length; f > d; d++) b = h[d], i.push(b.render());
                        return i
                    }
                }), FormRenderer.Views.ResponseField = Backbone.View.extend({
                    field_type: void 0,
                    className: "fr_response_field",
                    initialize: function(a) {
                        return this.form_renderer = a.form_renderer, this.showLabels = this.form_renderer ? this.form_renderer.options.showLabels : a.showLabels, this.model = a.model, this.$el.addClass("fr_response_field_" + this.field_type)
                    },
                    getDomId: function() {
                        console.log("CID ES", this.model.cid, this.model);
                        return this.model.attributes.cid
                    },
                    render: function() {
                        return this.$el[this.model.getError() ? "addClass" : "removeClass"]("error"), this.$el.html(JST["partials/response_field"](this)), rivets.bind(this.$el, {
                            model: this.model
                        }), this
                    }
                }), FormRenderer.Views.NonInputResponseField = FormRenderer.Views.ResponseField.extend({
                    render: function() {
                        return this.$el.addClass("fr_response_field_" + this.field_type), this.$el.html(JST["partials/non_input_response_field"](this)), this
                    }
                }), FormRenderer.Views.ResponseFieldPrice = FormRenderer.Views.ResponseField.extend({
                    field_type: "price",
                    events: {
                        'blur [data-rv-input="model.value.cents"]': "formatCents"
                    },
                    formatCents: function(a) {
                        var b;
                        return b = $(a.target).val(), b && b.match(/^\d$/) ? this.model.set("value.cents", "0" + b) : void 0
                    }
                }), FormRenderer.Views.ResponseFieldTable = FormRenderer.Views.ResponseField.extend({
                    field_type: "table",
                    events: {
                        "click [data-js-add-row]": "addRow"
                    },
                    initialize: function() {
                        return FormRenderer.Views.ResponseField.prototype.initialize.apply(this, arguments), this.on("shown", function() {
                            return this.initExpanding()
                        })
                    },
                    render: function() {
                        return FormRenderer.Views.ResponseField.prototype.render.apply(this, arguments), this.initExpanding(), this
                    },
                    initExpanding: function() {},
                    addRow: function() {
                        return this.model.numRows++, this.render()
                    }
                }), FormRenderer.Views.ResponseFieldFile = FormRenderer.Views.ResponseField.extend({
                    field_type: "file",
                    events: {
                        "click [data-js-remove]": "doRemove"
                    },
                    render: function() {
                        return FormRenderer.Views.ResponseField.prototype.render.apply(this, arguments), this.$el[this.model.hasValue() ? "addClass" : "removeClass"]("existing"), this.$input = this.$el.find("input"), this.$status = this.$el.find(".upload_status"), this.bindChangeEvent(), this
                    },
                    bindChangeEvent: function() {
                        return this.$input.on("change", $.proxy(this.fileChanged, this))
                    },
                    fileChanged: function(a) {
                        var b, c;
                        return b = null != (null != (c = a.target.files) ? c[0] : void 0) ? a.target.files[0].name : a.target.value ? a.target.value.replace(/^.+\\/, "") : "Error reading filename", this.model.set("value.filename", b, {
                            silent: !0
                        }), this.$el.find(".filename").text(b), this.$status.text("Uploading..."), this.doUpload()
                    },
                    doUpload: function() {
                        var a, b;
                        return b = $("<form method='post' style='display: inline;' />"), a = this.$input, this.$input = a.clone().hide().val("").insertBefore(a), this.bindChangeEvent(), a.appendTo(b), b.insertBefore(this.$input), this.form_renderer.uploads += 1, b.ajaxSubmit({
                            url: "" + this.form_renderer.options.screendoorBase + "/api/form_renderer/file",
                            data: {
                                response_field_id: this.model.get("id"),
                                replace_file_id: this.model.get("value.id"),
                                v: 0
                            },
                            dataType: "json",
                            uploadProgress: function(a) {
                                return function(b, c, d, e) {
                                    return a.$status.text(100 === e ? "Finishing up..." : "Uploading... (" + e + "%)")
                                }
                            }(this),
                            complete: function(a) {
                                return function() {
                                    return a.form_renderer.uploads -= 1, b.remove()
                                }
                            }(this),
                            success: function(a) {
                                return function(b) {
                                    return a.model.set("value.id", b.file_id), a.form_renderer.autosaveImmediately(), a.render()
                                }
                            }(this),
                            error: function(a) {
                                return function(b) {
                                    var c, d;
                                    return c = null != (d = b.responseJSON) ? d.errors : void 0, a.$status.text(c ? "Error: " + c : "Error"), a.$status.addClass("is_error"), setTimeout(function() {
                                        return a.render()
                                    }, 2e3)
                                }
                            }(this)
                        })
                    },
                    doRemove: function() {
                        return this.model.set("value", {}), this.form_renderer.autosaveImmediately(), this.render()
                    }
                }), FormRenderer.Views.ResponseFieldMapMarker = FormRenderer.Views.ResponseField.extend({
                    field_type: "map_marker",
                    events: {
                        "click .fr_map_cover": "enable",
                        "click [data-js-clear]": "disable"
                    },
                    initialize: function() {
                        return FormRenderer.Views.ResponseField.prototype.initialize.apply(this, arguments), this.on("shown", function() {
                            var a;
                            return this.refreshing = !0, null != (a = this.map) && a._onResize(), setTimeout(function(a) {
                                return function() {
                                    return a.refreshing = !1
                                }
                            }(this), 0)
                        })
                    },
                    render: function() {
                        return FormRenderer.Views.ResponseField.prototype.render.apply(this, arguments), this.$cover = this.$el.find(".fr_map_cover"), FormRenderer.loadLeaflet(function(a) {
                            return function() {
                                return a.initMap(), a.model.latLng() ? a.enable() : void 0
                            }
                        }(this)), this
                    },
                    initMap: function() {
                        return this.map = FormRenderer.initMap(this.$el.find(".fr_map_map")[0]), this.$el.find(".fr_map_map").data("map", this.map), this.map.setView(this.model.latLng() || this.model.defaultLatLng() || FormRenderer.DEFAULT_LAT_LNG, 13), this.marker = L.marker([0, 0]), this.map.on("move", $.proxy(this._onMove, this))
                    },
                    _onMove: function() {
                        var a;
                        if (!this.refreshing) return a = this.map.getCenter(), this.marker.setLatLng(a), this.model.set({
                            value: {
                                lat: a.lat.toFixed(7),
                                lng: a.lng.toFixed(7)
                            }
                        })
                    },
                    enable: function() {
                        return this.map.addLayer(this.marker), this.$cover.hide(), this._onMove()
                    },
                    disable: function() {
                        return this.map.removeLayer(this.marker), this.$el.find(".fr_map_cover").show(), this.model.set({
                            value: {
                                lat: "",
                                lng: ""
                            }
                        })
                    }
                }), g = _.without(FormRenderer.INPUT_FIELD_TYPES, "table", "file", "map_marker", "price"), c = 0, e = g.length; e > c; c++) b = g[c], FormRenderer.Views["ResponseField" + _.str.classify(b)] = FormRenderer.Views.ResponseField.extend({
                field_type: b
            });
            for (h = FormRenderer.NON_INPUT_FIELD_TYPES, d = 0, f = h.length; f > d; d++) b = h[d], FormRenderer.Views["ResponseField" + _.str.classify(b)] = FormRenderer.Views.NonInputResponseField.extend({
                field_type: b
            })
        }.call(this), a.JST || (a.JST = {}), a.JST["fields/address"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    var a, c, f;
                    if (a = this.model.get("field_options.address_format"), d(b("\n\n")), "city_state" !== a && "city_state_zip" !== a && "country" !== a && (d(b('\n  <div class=\'fr_input_grid\'>\n    <div class=\'fr_item_full\'>\n      <label class="fr_sub_label">Address</label>\n      <input type="text"\n             id="')), d(this.getDomId()), d(b("\"\n             data-rv-input='model.value.street' />\n    </div>\n  </div>\n"))), d(b("\n\n")), "country" !== a && d(b("\n  <div class='fr_input_grid'>\n    <div class='fr_item_half'>\n      <label class=\"fr_sub_label\">City</label>\n      <input type=\"text\"\n             data-rv-input='model.value.city' />\n    </div>\n\n    <div class='fr_item_half'>\n      <label class=\"fr_sub_label\">State / Province / Region</label>\n      <input type=\"text\"\n             data-rv-input='model.value.state' />\n    </div>\n  </div>\n")), d(b("\n\n<div class='fr_input_grid'>\n  ")), "city_state" !== a && "country" !== a && d(b("\n    <div class='fr_item_half'>\n      <label class=\"fr_sub_label\">ZIP Code</label>\n      <input type=\"text\"\n             data-rv-input='model.value.zipcode' />\n    </div>\n  ")), d(b("\n\n  ")), "city_state" !== a && "city_state_zip" !== a) {
                        d(b("\n    <div class='fr_item_half'>\n      <label class=\"fr_sub_label\">Country</label>\n      <select data-rv-value='model.value.country' data-width='auto'>\n        "));
                        for (c in e) f = e[c], d(b("\n          <option value='")), d(c), d(b("'>")), d(f), d(b("</option>\n        "));
                        d(b("\n      </select>\n    </div>\n  "))
                    }
                    d(b("\n</div>\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["fields/block_of_text"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    d(b("<div class='size_")), d(this.model.get("field_options.size")), d(b("'>\n  ")), d(b(_.sanitize(_.simpleFormat(this.model.get("field_options.description"), !1)))), d(b("\n</div>\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["fields/checkboxes"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    var a, c, e, f, g;
                    for (g = this.model.getOptions(), a = e = 0, f = g.length; f > e; a = ++e) c = g[a], d(b("\n  <label class='fr_option control'>\n    <input type='checkbox' data-rv-checked='model.value.")), d(a), d(b("' />\n    ")), d(c.label), d(b("\n  </label>\n"));
                    d(b("\n\n")), this.model.get("field_options.include_other_option") && d(b("\n  <div class='fr_option fr_other_option'>\n    <label class='control'>\n      <input type='checkbox' data-rv-checked='model.value.other_checkbox' />\n      Other\n    </label>\n\n    <input type='text' data-rv-input='model.value.other' />\n  </div>\n")), d(b("\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["fields/date"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    d(b('<div class=\'fr_input_grid\'>\n  <div class=\'fr_item_auto\'>\n    <label class="fr_sub_label">MM</label>\n    <input type="text"\n           id="')), d(this.getDomId()), d(b("\"\n           data-rv-input='model.value.month'\n           maxlength='2'\n           size='2' />\n  </div>\n\n  <div class='fr_item_spacer'>/</div>\n\n  <div class='fr_item_auto'>\n    <label class=\"fr_sub_label\">DD</label>\n    <input type=\"text\"\n           data-rv-input='model.value.day'\n           maxlength='2'\n           size='2' />\n  </div>\n\n  <div class='fr_item_spacer'>/</div>\n\n  <div class='fr_item_auto'>\n    <label class=\"fr_sub_label\">YYYY</label>\n    <input type=\"text\"\n           data-rv-input='model.value.year'\n           maxlength='4'\n           size='4' />\n  </div>\n</div>\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["fields/dropdown"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    var a, c, e, f;
                    for (d(b('<select id="')), d(this.getDomId()), d(b("\" data-rv-value='model.value'>\n  ")), this.model.get("field_options.include_blank_option") && d(b("\n    <option></option>\n  ")), d(b("\n\n  ")), f = this.model.getOptions(), c = 0, e = f.length; e > c; c++) a = f[c], d(b('\n    <option value="')), d(a.label), d(b('">')), d(a.label), d(b("</option>\n  "));
                    d(b("\n</select>\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["fields/email"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    d(b('<input type="text" inputmode="email"\n       id="')), d(this.getDomId()), d(b("\"\n       data-rv-input='model.value' />\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["fields/file"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    var a;
                    d(b("<div class='existing'>\n  <span class='filename'>")), d(this.model.get("value.filename")), d(b("</span>\n  <button data-js-remove class='")), d(FormRenderer.BUTTON_CLASS), d(b("'>Remove</button>\n</div>\n\n<div class='not_existing'>\n  <input type='file'\n         id='")), d(this.getDomId()), d(b("'\n         name='file'\n         ")), (a = this.model.getAcceptedExtensions()) && (d(b("\n          accept='")), d(a.join(",")), d(b("'\n         "))), d(b("\n         />\n  <span class='upload_status'></span>\n\n  ")), (a = this.model.getAcceptedExtensions()) && (d(b("\n    <div class='file_type_help'>\n      We'll accept ")), d(_.str.toSentence(a)), d(b("\n    </div>\n  "))), d(b("\n</div>\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["fields/identification"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    d(b("<div class='fr_input_grid'>\n  <div class='fr_item_full lap_fr_item_half'>\n    <label for='")), d(this.getDomId()), d(b("-name'>Name <abbr title='required'>*</abbr></label>\n    <input type='text'\n           id='")), d(this.getDomId()), d(b("-name'\n           data-rv-input='model.value.name' />\n  </div>\n\n  <div class='fr_item_full lap_fr_item_half'>\n    <label for='")), d(this.getDomId()), d(b("-email'>Email <abbr title='required'>*</abbr></label>\n    <input type=\"text\"\n           id='")), d(this.getDomId()), d(b("-email'\n           data-rv-input='model.value.email' />\n  </div>\n</div>\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["fields/map_marker"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    d(b("<div class='fr_map_wrapper'>\n  <div class='fr_map_map' />\n\n  <div class='fr_map_cover'>\n    Click to set location\n  </div>\n\n  <div class='fr_map_toolbar fr_cf'>\n    <strong>Coordinates:</strong>\n    <span data-rv-show='model.value.lat'>\n      <span data-rv-text='model.value.lat' />,\n      <span data-rv-text='model.value.lng' />\n    </span>\n    <span data-rv-hide='model.value.lat' class='fr_map_no_location'>N/A</span>\n    <a data-js-clear data-rv-show='model.value.lat' href='javascript:void(0);'>Clear</a>\n  </div>\n</div>\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["fields/number"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    d(b('<input type="text"\n       id="')), d(this.getDomId()), d(b("\"\n       data-rv-input='model.value' />\n\n")), this.model.get("field_options.units") && (d(b("\n  <span class='units'>\n    ")), d(this.model.get("field_options.units")), d(b("\n  </span>\n"))), d(b("\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["fields/page_break"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    d(b("<div class='fr_page_break_inner'>\n  Page break\n</div>\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["fields/paragraph"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    d(b('<textarea\n   id="')), d(this.getDomId()), d(b('"\n   class="size_')), d(this.model.get("field_options.size")), d(b("\"\n   data-rv-input='model.value' />\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["fields/price"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    d(b("<div class='fr_input_grid'>\n  <div class='fr_item_spacer'>$</div>\n\n  <div class='fr_item_auto'>\n    <label class=\"fr_sub_label\">Dollars</label>\n    <input type=\"text\"\n           id=\"")), d(this.getDomId()), d(b("\"\n           data-rv-input='model.value.dollars'\n           size='6' />\n  </div>\n\n  ")), this.model.get("field_options.disable_cents") || d(b("\n    <div class='fr_item_spacer'>.</div>\n    <div class='fr_item_auto'>\n      <label class=\"fr_sub_label\">Cents</label>\n      <input type=\"text\"\n             data-rv-input='model.value.cents'\n             maxlength='2'\n             size='2' />\n    </div>\n  ")), d(b("\n</div>\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["fields/radio"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    var a, c, e, f, g;
                    for (g = this.model.getOptions(), a = e = 0, f = g.length; f > e; a = ++e) c = g[a], d(b("\n  <label class='fr_option control'>\n    <input type='radio'\n           data-rv-checked='model.value.selected'\n           id=\"")), d(this.getDomId()), d(b('"\n           name="')), d(this.getDomId()), d(b('"\n           value="')), d(c.label), d(b('" />\n    ')), d(c.label), d(b("\n  </label>\n"));
                    d(b("\n\n")), this.model.get("field_options.include_other_option") && (d(b("\n  <div class='fr_option fr_other_option'>\n    <label class='control'>\n      <input type='radio'\n             data-rv-checked='model.value.selected'\n             id=\"")), d(this.getDomId()), d(b('"\n             name="')), d(this.getDomId()), d(b("\"\n             value=\"Other\" />\n      Other\n    </label>\n\n    <input type='text' data-rv-input='model.value.other' />\n  </div>\n"))), d(b("\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["fields/section_break"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    d(b("<div class='size_")), d(this.model.get("field_options.size")), d(b("'>\n  <div class='fr_section_name'>")), d(this.model.get("label")), d(b("</div>\n  ")), this.model.get("field_options.description") && (d(b("\n    <p>")), d(b(_.sanitize(_.simpleFormat(this.model.get("field_options.description"), !1)))), d(b("</p>\n  "))), d(b("\n</div>\n\n<hr />\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["fields/table"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    var a, c, e, f, g, h, i, j, k, l, m, n, o, p;
                    for (d(b("<table class='fr_table'>\n  <thead>\n    <tr>\n      ")), m = this.model.getColumns(), f = 0, j = m.length; j > f; f++) a = m[f], d(b("\n        <th>")), d(a.label), d(b("</th>\n      "));
                    for (d(b("\n    </tr>\n  </thead>\n\n  <tbody>\n    ")), c = g = 0, n = this.model.numRows - 1; n >= 0 ? n >= g : g >= n; c = n >= 0 ? ++g : --g) {
                        for (d(b("\n      <tr>\n        ")), o = this.model.getColumns(), e = h = 0, k = o.length; k > h; e = ++h) a = o[e], d(b("\n          <td>\n            <textarea ")), this.model.getPresetValue(a.label, c) && d(b("readonly")), d(b("\n                      data-col='")), d(e), d(b("'\n                      data-row='")), d(c), d(b("'\n                      data-rv-input='model.value.")), d(e), d(b(".")), d(c), d(b("'\n                      rows='1' />\n          </td>\n        "));
                        d(b("\n      </tr>\n    "))
                    }
                    if (d(b("\n  </tbody>\n\n  ")), this.model.get("field_options.column_totals")) {
                        for (d(b("\n    <tfoot>\n      <tr>\n        ")), p = this.model.getColumns(), e = i = 0, l = p.length; l > i; e = ++i) a = p[e], d(b("\n          <td data-rv-text='model.columnTotals.")), d(e), d(b("'></td>\n        "));
                        d(b("\n      </tr>\n    </tfoot>\n  "))
                    }
                    d(b("\n</table>\n\n<div class='fr_table_add_row_wrapper'>\n  ")), this.model.canAddRows() && (d(b("\n    ")), d(b(JST["partials/add_row_link"](this))), d(b("\n  "))), d(b("\n</div>\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["fields/text"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    d(b('<input type="text"\n       id="')), d(this.getDomId()), d(b('"\n       class="size_')), d(this.model.get("field_options.size")), d(b("\"\n       data-rv-input='model.value' />\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["fields/time"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    d(b('<div class=\'fr_input_grid\'>\n  <div class=\'fr_item_auto\'>\n    <label class="fr_sub_label">HH</label>\n    <input type="text"\n           id="')), d(this.getDomId()), d(b("\"\n           data-rv-input='model.value.hours'\n           maxlength='2'\n           size='2' />\n  </div>\n\n  <div class='fr_item_spacer'>:</div>\n\n  <div class='fr_item_auto'>\n    <label class=\"fr_sub_label\">MM</label>\n    <input type=\"text\"\n           data-rv-input='model.value.minutes'\n           maxlength='2'\n           size='2' />\n  </div>\n\n  ")), this.model.get("field_options.disable_seconds") || d(b("\n    <div class='fr_item_spacer'>:</div>\n\n    <div class='fr_item_auto'>\n      <label class=\"fr_sub_label\">SS</label>\n      <input type=\"text\"\n             data-rv-input='model.value.seconds'\n             maxlength='2'\n             size='2' />\n    </div>\n  ")), d(b("\n\n  <div class='fr_item_spacer'>\n    <select data-rv-value='model.value.am_pm' data-width='auto'>\n      <option value='AM'>AM</option>\n      <option value='PM'>PM</option>\n    </select>\n  </div>\n</div>\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["fields/website"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    d(b('<input type="text" inputmode="url"\n       id="')), d(this.getDomId()), d(b("\"\n       data-rv-input='model.value'\n       placeholder='http://' />\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST.main = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    d(b("<div class='fr_loading'>\n  Loading form...\n</div>"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["partials/add_row_link"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    d(b("<a data-js-add-row href='javascript:void(0)'>+ Add another row</a>\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["partials/bottom_status_bar"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    d(b("<div class='fr_bottom_bar fr_cf'>\n  ")), this.form_renderer.options.enableAutosave && (d(b("\n    <div class='fr_bottom_bar_l'>\n      ")), d(this.form_renderer.state.get("hasServerErrors") ? b("\n        Error saving\n      ") : this.form_renderer.state.get("hasChanges") ? b("\n        \n      ") : b("\n        \n      ")), d(b("\n    </div>\n  "))), d(b("\n\n  <div class='fr_bottom_bar_r'>\n    ")), this.firstPage() || (d(b("\n      <button data-js-back class='")), d(FormRenderer.BUTTON_CLASS), d(b("'>\n        Back to page ")), d(this.previousPage()), d(b("\n      </button>\n    "))), d(b("\n\n    ")), this.form_renderer.state.get("submitting") ? (d(b("\n      <button disabled class='")), d(FormRenderer.BUTTON_CLASS), d(b("'>\n        ...\n      </button>\n    "))) : (d(b("\n      <button data-js-continue class='")), d(FormRenderer.BUTTON_CLASS), d(b("'>\n        ")), d(this.lastPage() || !this.form_renderer.options.enablePages ? b("Enviar / Send") : b("Next page")), d(b("\n      </button>\n    "))), d(b("\n  </div>\n</div>\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["partials/description"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    this.model.get("field_options.description") && (d(b("\n  <div class='fr_description'>\n    ")), d(b(_.sanitize(_.simpleFormat(this.model.get("field_options.description"), !1)))), d(b("\n  </div>\n"))), d(b("\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["partials/error"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    this.model.getError() && (d(b("\n  <div class='fr_error'>\n    ")), d(this.model.getError()), d(b("\n  </div>\n"))), d(b("\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["partials/error_alert_bar"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    this.form_renderer.areAllPagesValid() || d(b("\n  <div class='fr_error_alert_bar'>Por favor completar los campos mandatorios! <BR> Please complete mandatory fields</div>\n")), d(b("\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["partials/label"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    var valorRequerido;
                    if (this.model.get("required")=="0"){
                        console.log("ENTRA",this.model.get("required"))
                        valorRequerido=false;
                    }else{
                        console.log("NO ENTRA")
                        valorRequerido=true;
                    }
                    console.log("REULT",valorRequerido , d)
                    //Aca abajo.Donde pongo valor requerido,decia this.model.get("required")
                    d(b('<label for="')), d(this.getDomId()), d(b('">\n  ')), d(this.model.get("label")), d(b("\n  ")), valorRequerido && d(b("<abbr title='required'>*</abbr>")), d(b("\n\n  ")), this.showLabels && (d(b("\n    ")), this.model.get("blind") && d(b("\n      <span class='label'>Blind</span>\n    ")), d(b("\n    ")), this.model.get("admin_only") && d(b("\n      <span class='label'>Hidden</span>\n    ")), d(b("\n  "))), d(b("\n</label>\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["partials/length_validations"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    this.model.hasLengthValidations() && (d(b("\n  <div class='fr_min_max'>\n    ")), this.model.get("field_options.minlength") && this.model.get("field_options.maxlength") ? (d(b("\n      Between ")), d(this.model.get("field_options.minlength")), d(b(" and ")), d(this.model.get("field_options.maxlength")), d(b(" ")), d(this.model.getLengthValidationUnits()), d(b(".\n    "))) : this.model.get("field_options.minlength") ? (d(b("\n      More than ")), d(this.model.get("field_options.minlength")), d(b(" ")), d(this.model.getLengthValidationUnits()), d(b(".\n    "))) : this.model.get("field_options.maxlength") && (d(b("\n      Less than ")), d(this.model.get("field_options.maxlength")), d(b(" ")), d(this.model.getLengthValidationUnits()), d(b(".\n    "))), d(b("\n\n    Current count:\n    <code class='fr_min_max_counter' data-rv-text='model.currentLength'></code>\n    ")), d(this.model.getLengthValidationUnits()), d(b(".\n  </div>\n"))), d(b("\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["partials/min_max_validations"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    this.model.hasMinMaxValidations() && (d(b("\n  <div class='fr_min_max'>\n    ")), this.model.get("field_options.min") && this.model.get("field_options.max") ? (d(b("\n      Between ")), d(this.model.get("field_options.min")), d(b(" and ")), d(this.model.get("field_options.max")), d(b(".\n    "))) : this.model.get("field_options.min") ? (d(b("\n      More than ")), d(this.model.get("field_options.min")), d(b(".\n    "))) : this.model.get("field_options.max") && (d(b("\n      Less than ")), d(this.model.get("field_options.max")), d(b(".\n    "))), d(b("\n  </div>\n"))), d(b("\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["partials/non_input_response_field"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    d(b(JST["fields/" + this.field_type](this))), d(b("\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["partials/pagination"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    var a, c, e;
                    if (this.form_renderer.numPages > 1) {
                        for (d(b("\n  <ul class='fr_pagination fr_cf'>\n    ")), a = c = 1, e = this.form_renderer.numPages; e >= 1 ? e >= c : c >= e; a = e >= 1 ? ++c : --c) d(b("\n      ")), a === this.form_renderer.state.get("activePage") ? (d(b("\n        <li class='")), this.form_renderer.isPageValid(a) || d(b("has_errors")), d(b("'><span>")), d(a), d(b("</span></li>\n      "))) : (d(b("\n        <li class='")), this.form_renderer.isPageValid(a) || d(b("has_errors")), d(b("'><a data-activate-page=\"")), d(a), d(b("\" href='javascript:void(0)'>")), d(a), d(b("</a></li>\n      "))), d(b("\n    "));
                        d(b("\n  </ul>\n"))
                    }
                    d(b("\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }, a.JST || (a.JST = {}), a.JST["partials/response_field"] = function(a) {
            var b = function(a) {
                "undefined" == typeof a && null == a && (a = "");
                var b = new String(a);
                return b.ecoSafe = !0, b
            };
            return function() {
                var a = [],
                    c = this,
                    d = function(b) {
                        "undefined" != typeof b && null != b && a.push(b.ecoSafe ? b : c.escape(b))
                    };
                return function() {
                    d(b(JST["partials/label"](this))), d(b("\n")), d(b(JST["fields/" + this.field_type](this))), d(b("\n\n<div class='fr_clear' />\n\n")), d(b(JST["partials/length_validations"](this))), d(b("\n")), d(b(JST["partials/min_max_validations"](this))), d(b("\n")), d(b(JST["partials/error"](this))), d(b("\n")), d(b(JST["partials/description"](this))), d(b("\n"))
                }.call(this), a.join("")
            }.call(function() {
                var c, d = {
                    escape: function(a) {
                        return ("" + a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;")
                    },
                    safe: b
                };
                for (c in a) d[c] = a[c];
                return d
            }())
        }
}(window);