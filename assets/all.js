! function() {
    "use strict";
    var e = ["CO", "H2S", "O2", "Ex", "NO2", "NO", "SO2", "Cl2", "NH3", "H2", "PH3", "CH2O", "O3", "F2", "HF", "HCL", "HBr", "C2H4O", "COCl2", "SiH4", "ClO2", "CO2", "SF6", "TVOC", "CH4", "HC", "N20", "R123a", "TiCL4", "CH3NH2", "SO2F2", "C4H8S", "C4H9SH", "CCL4", "GAS", "Br2", "BF3", "CH3CL", "CHCL3", "SIHCL3", "AsH3", "C2H3Cl", "B2H6", "C2H5OH", "CH3OH", "HCN", "C2H4", "H2O2", "PM2.5", "PM10", "TH"],
        a = ["PM2.5", "PM10", "RH", "T", "WS", "WD", "ATM", "NOISE", "PRCP"],
        n = ["PPM", "PPB", "PPM", "â€°", "%", "%LEL", "%VOL", "mg/m3", "mg/L", "ug/m3", "â„ƒ", "m/s", "Â°", "kPa", "dB", "mm"];

    function u(t) {
        return e[t - 1] || a[t - 200]
    }

    function c(t) {
        return n[t]
    }

    function z(t) {
        var e = "function" == typeof Symbol && t[Symbol.iterator],
            a = 0;
        return e ? e.call(t) : {
            next: function() {
                return t && a >= t.length && (t = void 0), {
                    value: t && t[a++],
                    done: !t
                }
            }
        }
    }
    var d, i, s, l = (d = [], function(t) {
            var e, a;
            try {
                for (var n = z(d), i = n.next(); !i.done; i = n.next()) i.value.animate({
                    bottom: "+=60px"
                }, 400)
            } catch (t) {
                e = {
                    error: t
                }
            } finally {
                try {
                    i && !i.done && (a = n.return) && a.call(n)
                } finally {
                    if (e) throw e.error
                }
            }
            var r = $(".flash.template").clone();
            for (var o in d.push(r), t) r.find("." + o).text(t[o]).removeClass("template");
            r.appendTo("body").addClass("alert-" + t.type).removeClass("template").css({
                right: -1 * r.outerWidth(!0) + "px"
            }), r.animate({
                right: "10px"
            }, 400, function() {
                setTimeout(function() {
                    r.animate({
                        right: -1 * r.outerWidth(!0)
                    }, 400, function() {
                        d.shift(), r.remove()
                    })
                }, 4e3)
            })
        }),
        t = $("html").attr("lang");

    function O(t, e) {
        try {
            return e ? i[t][e] : i[t]
        } catch (t) {
            return ""
        }
    }
    var f = $("#confirm");

    function m(t) {
        var e = {
            html: !0,
            animation: !0,
            placement: "top",
            trigger: "manual",
            title: "",
            content: f[0]
        };
        e.title = O("message", "delete-confirm"), t.find('[data-target="delete-confirm"]').popover(e), e.title = O("message", "reset-confirm"), t.find('[data-target="reset-confirm"]').popover(e)
    }
    var p = (r.prototype.getUpdateStatus = function(t) {
        return !!this.eidUpdateInfo[t] && 2 == this.eidUpdateInfo[t].updateState
    }, r.prototype.update = function(t, e) {
        void 0 === e && (e = !1), (e || this.eidUpdateInfo[t] && 0 == this.eidUpdateInfo[t].updateState) && this._update(t)
    }, r.prototype.getDataCount = function(t, e, a) {
        if (this.getUpdateStatus(t)) {
            var n = 0;
            for (var i in this.eidUpdateInfo[t].data) e <= i && i <= a && (n += this.eidUpdateInfo[t].data[i].length);
            return n
        }
    }, r.prototype.getData = function(t, e, a, n) {
        if (this.getUpdateStatus(t)) {
            var i = this.eidUpdateInfo[t].timezone,
                r = 0,
                o = 0,
                d = [],
                s = moment.tz(e, i).valueOf(),
                l = this.eidUpdateInfo[t].firstDate;
            if (l)
                for (;;) {
                    var f = moment(s).tz(i).format("YYYY-MM-DD");
                    if (f < l) return d;
                    var u = this.eidUpdateInfo[t].data[f];
                    if (u) {
                        if (r + u.length - 1 >= a)
                            for (var c = r < a ? a - r : 0; c < u.length; c++)
                                if (d.push(u[c]), ++o >= n) return d;
                        r += u.length
                    }
                    s -= 864e5
                }
        }
    }, r.prototype._update = function(o) {
        var e = this,
            d = {
                timezone: "",
                lastUpdate: 0,
                data: {}
            };
        this.eidUpdateInfo[o].updateState = 1, $.get("/api/equipment/" + o, function(r) {
            var i;
            r && r.firstCreatetime && (i = r.firstCreatetime.slice(0, 10)), e.eidUpdateInfo[o].firstDate = i, localforage.getItem(o.toString()).then(function(t) {
                var e = t;
                if (d.timezone = r.timezone, i && e && e.timezone == r.timezone) {
                    for (var a in e.data)
                        if (a < i && delete e.data[a], a == i) {
                            var n = void 0;
                            for (n = 0; n < e.data[a].length && !(e.data[a][n].ct < r.firstCt); n++);
                            e.data[a] = e.data[a].slice(0, n)
                        } d = e
                }
            }).then(function() {
                var e, t, a = r.firstCt && parseInt(r.firstCt) || null;

                function n(n) {
                    return new Promise(function(e, t) {
                        var a = moment(n).tz(r.timezone).format("YYYY-MM-DD");
                        a in d.data ? e() : $.get("/data/" + o + "/" + a, function(t) {
                            d.data[a] = t, e()
                        }, "json")
                    })
                }
                if (t = moment().tz(r.timezone).format("YYYY-MM-DD"), t = moment.tz(t, r.timezone).valueOf(), a)
                    for (var i = function() {
                            var t = a;
                            e = e ? e.then(function() {
                                return n(t)
                            }) : n(t), a += 864e5
                        }; a < t;) i();
                return e
            }).then(function() {
                return d.lastUpdate = Date.now(), localforage.setItem(o.toString(), d)
            }).then(function() {
                for (e.eidUpdateInfo[o].data = d.data, e.eidUpdateInfo[o].timezone = d.timezone, e.eidUpdateInfo[o].updateState = 2;;) {
                    var t = e.eidUpdateQueue.shift();
                    if ("number" != typeof t) break;
                    if (0 == e.eidUpdateInfo[t].updateState) {
                        e._update(t);
                        break
                    }
                }
            }).catch(function(t) {
                console.log(t)
            })
        }, "json")
    }, r);

    function r() {
        var r = this;
        this.eidUpdateInfo = {}, this.eidUpdateQueue = [], $.get("/api/equipment/list/", function(d) {
            d.length && localforage.getItem("version").then(function(t) {
                return 1 == t ? localforage.keys() : localforage.clear().then(function() {
                    return localforage.setItem("version", 1)
                }).then(function() {
                    return localforage.keys()
                })
            }).then(function(t) {
                var e, a, n = [];
                try {
                    for (var i = z(t), r = i.next(); !r.done; r = i.next()) {
                        var o = r.value;
                        "version" != o && n.push(o)
                    }
                } catch (t) {
                    e = {
                        error: t
                    }
                } finally {
                    try {
                        r && !r.done && (a = i.return) && a.call(i)
                    } finally {
                        if (e) throw e.error
                    }
                }
                return n
            }).then(function(t) {
                function e(t) {
                    d.includes(parseInt(t)) || (i = i ? i.then(function() {
                        return localforage.removeItem(t)
                    }) : localforage.removeItem(t))
                }
                var a, n, i;
                try {
                    for (var r = z(t), o = r.next(); !o.done; o = r.next()) {
                        e(o.value)
                    }
                } catch (t) {
                    a = {
                        error: t
                    }
                } finally {
                    try {
                        o && !o.done && (n = r.return) && n.call(r)
                    } finally {
                        if (a) throw a.error
                    }
                }
                return i || Promise.resolve()
            }).then(function() {
                var e, t;
                try {
                    for (var a = z(d), n = a.next(); !n.done; n = a.next()) {
                        var i = n.value;
                        r.eidUpdateInfo[i] = {
                            updateState: 0,
                            firstDate: void 0,
                            timezone: "",
                            data: {}
                        }
                    }
                } catch (t) {
                    e = {
                        error: t
                    }
                } finally {
                    try {
                        n && !n.done && (t = a.return) && t.call(a)
                    } finally {
                        if (e) throw e.error
                    }
                }
                r.eidUpdateQueue = d
            }).then(function() {
                for (var t = 0; t < 2; t++) {
                    var e = r.eidUpdateQueue.shift();
                    if ("number" != typeof e) break;
                    r._update(e)
                }
            })
        }, "json")
    }
    var j, H = ["N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSW", "SW", "WSW", "W", "WNW", "NW", "NNW"];

    function T(t, e) {
        var a, n = Object.assign({}, t);
        for (var i in e) {
            var r = "c" + i,
                o = t[r],
                d = Number.parseFloat(o);
            Number.isFinite(d) && (n[r] = d.toFixed(e[i].decimal), "WD" == e[i].type && (n[r] = ((a = d) < 0 && (a = 0), 360 <= a && (a = 359), a += 11.25, a %= 360, a /= 22.5, a = Math.floor(a), H[a])))
        }
        return n
    }
    $(document).ready(function() {
        -1 < navigator.userAgent.toLowerCase().indexOf("trident") && $('<link rel="stylesheet" href="static/stylesheets/ie.css" type="text/css">').appendTo($("head")), $("input").change(function() {
            $(this).removeClass("is-valid is-invalid")
        }), $(".invalid-tooltip").siblings("input").addClass("is-invalid")
    }), $(document).ready(function() {
        $(".modal").on("hidden.bs.modal", function() {
            $(this).find("input").removeClass("is-valid is-invalid")
        }), $(".modal form").submit(function(t) {
            t.preventDefault()
        })
    }), $(document).ready(function() {
        $("#alter-usernick").on("show.bs.modal", function(t) {
            $("#alter-usernick .loading").hide(), $("#alter-usernick #nickname").val("")
        }), $("#alter-usernick").on("shown.bs.modal", function(t) {
            $("#alter-usernick #nickname").focus()
        }), $("#alter-usernick").submit(function(t) {
            var a = $(this);
            return a.find(".loading").show(), $.post("/user/alter/usernick/", a.find("form").serialize(), function(t) {
                if (a.find(".loading").hide(), t)
                    if (t.error && t.field) {
                        var e = a.find("input[name='" + t.field + "']");
                        e.addClass("is-invalid").siblings(".invalid-tooltip").remove(), e.after($('<div class="invalid-tooltip">' + t.error + "</div>"))
                    } else t.error ? l({
                        title: t.error,
                        type: "fail"
                    }) : t.msg && (a.modal("hide"), l({
                        title: t.msg,
                        type: "success"
                    }), $("#label-usernick").text(t.usernick))
            }, "json"), !1
        }), $("#alter-password").on("show.bs.modal", function(t) {
            $('#alter-password input[type="password"]').val(""), $("#alter-password .loading").hide()
        }), $("#alter-password").on("shown.bs.modal", function(t) {
            $('#alter-password input[type="password"]:first').focus()
        }), $("#alter-password").submit(function(t) {
            var a = $(this);
            return a.find(".loading").show(), $.post("/user/alter/password/", a.find("form").serialize(), function(t) {
                if (a.find(".loading").hide(), t)
                    if (t.error && t.field) {
                        var e = a.find("input[name='" + t.field + "']");
                        e.addClass("is-invalid").siblings(".invalid-tooltip").remove(), e.after($('<div class="invalid-tooltip">' + t.error + "</div>"))
                    } else t.error ? l({
                        title: t.error,
                        type: "fail"
                    }) : t.msg && (a.modal("hide"), l({
                        title: t.msg,
                        type: "success"
                    }))
            }, "json"), !1
        }), $(".set-lang").on("click", function(t) {
            var e = $(t.target).attr("lang");
            return $.cookie("lang", e, {
                expires: 3650
            }), location.reload(), !1
        })
    }), $(document).ready(function() {
        $('[data-toggle="popover"]').click(function(t) {
            return s && s.popover("hide"), (s = $(this)).popover("show"), !1
        }), $("body").click(function(t) {
            $(t.target).is(".popover *") || s && s.popover("hide")
        }), f.click(function(t) {
            $(t.target).is("button") && s.popover("hide")
        }).removeClass("template").detach()
    }), $.ajax("static/locales/" + t + "/translation.json", {
        type: "GET",
        async: !1,
        timeout: 5e3,
        ifModified: !0,
        dataType: "json",
        success: function(t) {
            i = t
        }
    }), $(".page-data").length ? $(document).ready(function() {
        var U, a, n, i = $("#datalocation"),
            r = new BMap.Convertor,
            o = !0;
        $(".nav[data-nav]").on("click", function(t) {
            var e = $(t.currentTarget),
                a = e.data("nav"),
                n = $(t.target),
                i = n.data("page");
            if (i) {
                var r = e.parents(".modal");
                e.find(".nav-link").removeClass("active");
                for (var o = n; !o.hasClass("nav-link");) {
                    var d = (o = o.parent()).find(".nav-link");
                    if (d.length) {
                        o = d;
                        break
                    }
                }
                o.addClass("active"), r.find(".page[data-nav=" + a + "]").removeClass("active"), r.find(".page[data-nav=" + a + "][data-page=" + i + "]").addClass("active"), t.preventDefault()
            }
        }), $.fn.datepicker.setDefaults({
            language: $("html").attr("lang"),
            autoHide: !0,
            autoPick: !0,
            format: "yyyy-mm-dd",
            zIndex: 2048
        }), m($(".data"));
        var t = io(),
            e = $(".data [data-eid]");
        t.on("connect", function() {
            var a = [];
            e.each(function(t, e) {
                a.push($(this).attr("data-eid"))
            }), t.emit("getOnlineStatus", a)
        }), t.on("onlineStatus", function(i) {
            e.each(function(t, e) {
                var a = parseInt($(this).attr("data-eid"));
                for (var n in i)
                    if (i[n].eid == a) {
                        i[n].online ? $(this).find(".status").text(O("data-view", "online")).removeClass("text-muted").addClass("text-success") : $(this).find(".status").text(O("data-view", "offline")).removeClass("text-success").addClass("text-muted"), delete i[n];
                        break
                    }
            })
        }), $("a.datarealtime").on("click", function(t) {
            t.preventDefault();
            var e = $(".template.datarealtime").clone(!0),
                a = e.find('div[data-nav="data-realtime"][data-page="list"]'),
                n = e.find('div[data-nav="data-history"][data-page="list"]');
            e[0].equipmentRow = $(this).parentsUntil(".data", ".row"), e[0].eid = e[0].equipmentRow.attr("data-eid"), e[0].channelCount = parseInt(e[0].equipmentRow.data("channelcount")), e[0].stoSync = void 0;
            var i = e[0].equipmentRow.data("timezone"),
                r = moment().tz(i).format("YYYY-MM-DD");
            r = moment.tz(r, i).valueOf(), r -= 864e5, r = moment(r).tz(i).format("YYYY-MM-DD");
            var o = e.find(".start-date"),
                d = e.find(".end-date");
            o.datepicker({
                endDate: r,
                date: r
            }), d.datepicker({
                endDate: r,
                date: r,
                startDate: o.datepicker("getDate")
            }), o.on("change", function() {
                d.datepicker("setStartDate", o.datepicker("getDate"))
            });
            for (var s = 1; s <= e[0].channelCount; s++) a.find("thead tr").append($('<th scope="col" class="c' + s + '">--</th>')), n.find("thead tr").append($('<th scope="col" class="c' + s + '">--</th>')), a.find("tbody tr").append($("<td></td>"));
            e.appendTo($("body")).removeClass(["template", "datarealtime"]).modal("show")
        }), $(".template.datarealtime").on("show.bs.modal", function(t) {
            function c() {
                y.find("tbody tr").slice(10).remove(), y.find("tbody tr").attr("data-placeholder", ""), y.find("tbody td:not(.time)").text(""), y.find("tbody td.time").text("0000-00-00 00:00:00")
            }

            function m(t) {
                for (var e = $('<tr><td class="time"></td></tr>'), a = 1; a <= g[0].channelCount; a++) e.append($("<td></td>"));
                var n = e.find("td");
                for (n.eq(0).text(t && t.createtime || "0000-00-00 00:00:00"), a = 1; a <= g[0].channelCount; a++) n.eq(a).text(t && t["c" + a] || "");
                return e
            }
            var p, v, h, g = $(this),
                r = g.find('div[data-nav="data"][data-page="realtime"]'),
                o = g.find('div[data-nav="data"][data-page="history"]'),
                y = g.find('div[data-nav="data-realtime"][data-page="list"]'),
                f = g.find('div[data-nav="data-realtime"][data-page="curve"]'),
                x = g.find('div[data-nav="data-history"][data-page="list"]'),
                b = g.find('div[data-nav="data-history"][data-page="curve"]'),
                w = g.find(".start-date"),
                k = g.find(".end-date"),
                e = g[0].equipmentRow,
                C = g[0].eid,
                q = parseInt(C),
                D = Number.MAX_VALUE,
                n = 10,
                S = 1;

            function I(t, e, a) {
                var n = {
                    tooltip: {
                        trigger: "axis",
                        formatter: function(t) {
                            return (t = t[0]).value[0] + "<br />" + t.value[1]
                        },
                        axisPointer: {
                            animation: !1,
                            type: "cross"
                        },
                        confine: !0
                    },
                    xAxis: {
                        type: "time",
                        splitLine: {
                            show: !1
                        }
                    },
                    yAxis: {
                        type: "value",
                        name: t + " ( " + e + " )",
                        nameTextStyle: {
                            color: "rgb(0, 119, 118)",
                            lineHeight: 24,
                            fontWeight: "bold"
                        },
                        boundaryGap: [0, "20%"],
                        min: function(t) {
                            var e;
                            return e = .1 * (t.max - t.min), e = t.min - e, e = 10 * Math.floor(e / 10)
                        },
                        max: null,
                        splitLine: {
                            show: !1
                        }
                    },
                    series: [{
                        type: "line",
                        showSymbol: !1,
                        hoverAnimation: !1,
                        data: a,
                        markArea: null
                    }]
                };
                if ("WD" == t) {
                    n.yAxis.min = 0, n.yAxis.max = 360;
                    for (var i = {
                            silent: !0,
                            label: {
                                position: "right"
                            },
                            data: []
                        }, r = [{
                            min: 0,
                            max: 11.25
                        }], o = 1; o <= 15; o++) r.push({
                        min: r[o - 1].max,
                        max: r[o - 1].max + 22.5
                    });
                    for (r.push({
                            min: 348.75,
                            max: 360
                        }), o = 0; o < r.length; o++) {
                        var d = H[o % H.length],
                            s = [{
                                name: "",
                                yAxis: 0
                            }, {
                                yAxis: 0
                            }];
                        o % 2 && (s[0].itemStyle = {
                            color: "#DDD"
                        }), s[0].name = d, s[0].yAxis = r[o].max, s[1].yAxis = r[o].min, i.data.push(s)
                    }
                    n.series[0].markArea = i
                }
                return n
            }
            g.find("a.dropdown-toggle").click(function(t) {
                ! function() {
                    var t = g.find(".modal-body > div").height() - 20;
                    g.find('.dropdown-menu[data-mark="curveMenu"]').css({
                        "max-height": t + "px"
                    })
                }()
            }), g.find(".loading").show(), g.find("span.equipment-name").text(e.find(".name").text()), y.find("thead th:not(.time)").text(""), c(), U && U.disconnect(), (U = io()).on("connect", function() {
                g.find(".loading").hide(), U && U.emit("getRealTimeData", C)
            }), U.on("offline", function() {
                l({
                    title: O("message", "offline"),
                    type: "normal"
                })
            }), U.on("settings", function(t, e) {
                if (U) {
                    for (var a in g[0].settings = t) {
                        var n = parseInt(a) - 1;
                        if (t[a].type && t[a].unit) {
                            y.find("thead").find("th.c" + a).text(t[a].type + "(" + t[a].unit + ")"), x.find("thead").find("th.c" + a).text(t[a].type + "(" + t[a].unit + ")");
                            var i = $('<a class="dropdown-item" href="#" data-page="curve"></a>').attr("data-channel", "c" + (1 + n)).attr("data-gastype", "" + t[a].type).attr("data-gasunit", "" + t[a].unit).text("" + t[a].type);
                            g.find('[data-mark="curveMenu"]').append(i)
                        } else y.find("thead").find("th.c" + a).text("--(--)"), x.find("thead").find("th.c" + a).text("--(--)")
                    }
                    g.find('[data-mark="curveMenu"] a').on("click", function(t) {
                        var e = $(t.target);
                        o.find(e).length ? d(e.data("channel"), e.data("gastype"), e.data("gasunit")) : r.find(e).length && M(e.data("channel"), e.data("gastype"), e.data("gasunit"))
                    })
                }
                e()
            }), U.on("some", function(t) {
                var e, a;
                if (U) {
                    c(), D = Number.MAX_VALUE, p = [];
                    try {
                        for (var n = z(t), i = n.next(); !i.done; i = n.next()) {
                            var r = i.value;
                            p.unshift(Object.assign({}, r))
                        }
                    } catch (t) {
                        e = {
                            error: t
                        }
                    } finally {
                        try {
                            i && !i.done && (a = n.return) && a.call(n)
                        } finally {
                            if (e) throw e.error
                        }
                    }
                    v && M(v.cx, v.gastype, v.gasunit);
                    for (var o = 0; o < 10; o++) {
                        var d = y.find("tbody").find("tr").eq(o),
                            s = d.find("td"),
                            l = void(r = void 0);
                        if (o < t.length) d.removeAttr("data-placeholder"), r = t[o], t[o].ct < D && (D = t[o].ct), l = T(r, g[0].settings);
                        else {
                            l = {
                                ct: 0,
                                createtime: "0000-00-00 00:00:00"
                            };
                            for (var f = 1; f <= g[0].channelCount; f++) l["c" + f] = "------"
                        }
                        s.eq(0).text(l.createtime);
                        for (var u = 1; u <= g[0].channelCount; u++) s.eq(u).text(l["c" + u])
                    }
                    $.get("/data/" + C, function(t) {
                        var e, a;
                        if (U && t) {
                            try {
                                for (var n = z(t), i = n.next(); !i.done; i = n.next()) {
                                    var r = i.value;
                                    if (!(r.ct >= D)) {
                                        p.unshift(r);
                                        var o = T(r, g[0].settings);
                                        y.find("tbody").append(m(o))
                                    }
                                }
                            } catch (t) {
                                e = {
                                    error: t
                                }
                            } finally {
                                try {
                                    i && !i.done && (a = n.return) && a.call(n)
                                } finally {
                                    if (e) throw e.error
                                }
                            }
                            v && M(v.cx, v.gastype, v.gasunit)
                        }
                    }, "json")
                }
            }), U.on("one", function(t) {
                if (U) {
                    var e = y.find("tbody tr[data-placeholder]");
                    e.length && e.first().remove(), p.push(t);
                    var a = T(t, g[0].settings);
                    y.find("tbody").prepend(m(a)), v && M(v.cx, v.gastype, v.gasunit)
                }
            });
            var M = function(t, e, a) {
                var n, i, r = [];
                try {
                    for (var o = z(p), d = o.next(); !d.done; d = o.next()) {
                        var s = d.value;
                        r.push({
                            value: [s.createtime, s[t]]
                        })
                    }
                } catch (t) {
                    n = {
                        error: t
                    }
                } finally {
                    try {
                        d && !d.done && (i = o.return) && i.call(o)
                    } finally {
                        if (n) throw n.error
                    }
                }
                var l = I(e, a, r);
                setTimeout(function() {
                    var t = f.find('div[data-mark="curve"]');
                    echarts.init(t[0]).setOption(l)
                }, 300), v = {
                    cx: t,
                    gastype: e,
                    gasunit: a
                }
            };

            function i(t) {
                if (j && 1 <= t) {
                    var e = w.datepicker("getDate", !0),
                        a = k.datepicker("getDate", !0),
                        n = j.getDataCount(q, e, a),
                        i = parseInt(x.find('[data-mark="numPerPage"]').val()),
                        r = n && Math.ceil(n / i) || 0;
                    if (0 == r && 1 == t || t <= r) {
                        x.find('[data-mark="listCurrent"]').text(t), x.find('[data-mark="listCount"]').text(r);
                        var o = x.find('[data-mark="start"]'),
                            d = x.find('[data-mark="prev"]'),
                            s = x.find('[data-mark="next"]'),
                            l = x.find('[data-mark="end"]'),
                            f = x.find('[data-mark="jump"]');
                        1 == t ? (o.attr("disabled", "true"), d.attr("disabled", "true")) : (o.removeAttr("disabled"), d.removeAttr("disabled")), r <= t ? (s.attr("disabled", "true"), l.attr("disabled", "true")) : (s.removeAttr("disabled"), l.removeAttr("disabled")), 0 == r ? f.attr("disabled", "true") : f.removeAttr("disabled");
                        var u = [];
                        if (n)
                            if (t < r) u = j.getData(q, a, (t - 1) * i, i) || [];
                            else {
                                var c = n % i;
                                u = j.getData(q, a, (t - 1) * i, c || i) || []
                            }!
                        function(t, e) {
                            var a = x.find("tbody");
                            a.empty();
                            for (var n = 0; n < e; n++) {
                                var i = void 0;
                                t[n] && (i = T(t[n], g[0].settings)), a.append(m(i))
                            }
                        }(u, i)
                    }
                }
                S = t, h = void 0
            }

            function a() {
                S = 1, h ? d(h.cx, h.gastype, h.gasunit) : i(S)
            }
            r.find('a[data-page="list"]').on("click", function(t) {
                v = void 0
            });
            var d = function(t, e, a) {
                var n, i;
                if (j) {
                    var r = w.datepicker("getDate", !0),
                        o = k.datepicker("getDate", !0),
                        d = j.getDataCount(q, r, o),
                        s = [];
                    if (d) {
                        var l = j.getData(q, o, 0, d);
                        if (l) try {
                            for (var f = z(l), u = f.next(); !u.done; u = f.next()) {
                                var c = u.value;
                                s.unshift({
                                    value: [c.createtime, c[t]]
                                })
                            }
                        } catch (t) {
                            n = {
                                error: t
                            }
                        } finally {
                            try {
                                u && !u.done && (i = f.return) && i.call(f)
                            } finally {
                                if (n) throw n.error
                            }
                        }
                    }
                    var m = I(e, a, s);
                    setTimeout(function() {
                        var t = b.find('div[data-mark="curve"]');
                        echarts.init(t[0]).setOption(m)
                    }, 300)
                }
                h = {
                    cx: t,
                    gastype: e,
                    gasunit: a
                }
            };
            w.on("change", a), k.on("change", a), x.find('[data-mark="pageControl"] button').on("click", function(t) {
                t.preventDefault();
                var e = parseInt(x.find('[data-mark="listCurrent"]').text()),
                    a = parseInt(x.find('[data-mark="listCount"]').text());
                if (a) switch ($(t.currentTarget).data("mark")) {
                    case "start":
                        i(1);
                        break;
                    case "prev":
                        i(e = e - 1 || 1);
                        break;
                    case "next":
                        i((e += 1) <= a ? e : a);
                        break;
                    case "end":
                        i(a);
                        break;
                    case "jump":
                        var n = parseInt(x.find('[data-mark="pageToJump"]').val());
                        1 <= n && n <= a && i(n)
                }
            }), x.find('[data-mark="numPerPage"]').on("change", function(t) {
                var e = parseInt(x.find('[data-mark="listCurrent"]').text()),
                    a = parseInt(x.find('[data-mark="numPerPage"]').val());
                i(function(t, e, a) {
                    if (t == a) return e;
                    if (a < t) return (e - 1) * (n = t / a) + 1;
                    var n = a / t;
                    return Math.ceil(e / n)
                }(n, e, a)), n = a
            }), o.find('a[data-page="list"]').on("click", function(t) {
                i(S)
            }), j && j.update(q), g[0].stoSync = setInterval(function() {
                j && (j.update(q), j.getUpdateStatus(q) && g[0].settings && (i(1), $('a[data-page="history"]').removeClass("disabled"), $(".history-loading").hide(), clearInterval(g[0].stoSync)))
            }, 200)
        }), $(".template.datarealtime").on("hidden.bs.modal", function(t) {
            var e = $(this);
            U && (U.disconnect(), U = null), clearInterval(e[0].stoSync), $(this).remove()
        }), $("#datalocation").on("show.bs.modal", function(t) {
            var e = $(t.relatedTarget).parentsUntil(".container.data", ".row").attr("data-eid");
            i.find(".loading").show(), o = !0, a && a.disconnect(), (a = io()).on("connect", function() {
                a && a.emit("getMapSite", e)
            }), a.on("site", function(t) {
                if (a && n && (n.clearOverlays(), i.find(".loading").hide(), "number" == typeof t.lng && "number" == typeof t.lat)) {
                    var e = new BMap.Point(t.lng, t.lat);
                    r.translate([e], 1, 5, function(t) {
                        if (0 === t.status && n) {
                            var e = t.points[0],
                                a = new BMap.Marker(e);
                            n.addOverlay(a), o && (n.setZoom(11), n.panTo(e), o = !1)
                        }
                    })
                }
            })
        }), $("#datalocation").on("shown.bs.modal", function(t) {
            (n = new BMap.Map("map")).centerAndZoom(new BMap.Point(116.404, 39.915), 3), n.enableScrollWheelZoom(), n.addControl(new BMap.MapTypeControl({
                mapTypes: [BMAP_NORMAL_MAP, BMAP_HYBRID_MAP]
            })), n.addControl(new BMap.NavigationControl), n.addControl(new BMap.ScaleControl)
        }), $("#datalocation").on("hidden.bs.modal", function(t) {
            n = void 0, a && (a.disconnect(), a = null)
        }), $("#datadownload").on("show.bs.modal", function(t) {
            var e = $(this),
                a = $(t.relatedTarget).parentsUntil(".data", ".row");
            e[0].equipmentRow = a, e[0].eid = a.find(".eid").text();
            var n = a.data("timezone"),
                i = moment().tz(n).format("YYYY-MM-DD");
            i = moment.tz(i, n).valueOf(), i -= 864e5, i = moment(i).tz(n).format("YYYY-MM-DD");
            var r = e.find(".start-date"),
                o = e.find(".end-date");
            r.datepicker({
                endDate: i,
                date: i
            }), o.datepicker({
                endDate: i,
                date: i,
                startDate: r.datepicker("getDate")
            }), r.off("change").on("change", function() {
                o.datepicker("setStartDate", r.datepicker("getDate"))
            })
        }), $("#datadownload .btn-ok").click(function(t) {
            var e = $("#datadownload"),
                a = e.find(".start-date"),
                n = e.find(".end-date"),
                i = e[0].equipmentRow.data("timezone"),
                r = a.datepicker("getDate", !0),
                o = n.datepicker("getDate", !0);
            r = moment.tz(r, i).valueOf(), o = moment.tz(o, i).valueOf(), o += 864e5, e.modal("hide"), l({
                title: O("message", "downloading"),
                type: "normal"
            }), $.post("/data/export", {
                "equipment[eid]": e[0].eid,
                "equipment[startDate]": r,
                "equipment[endDate]": o
            }, function(t) {
                t && (t.error ? l({
                    title: t.error,
                    type: "fail"
                }) : t.msg && (l({
                    title: t.msg,
                    type: "success"
                }), function(t, e, a) {
                    var n = new Blob([t], {
                        type: e
                    });
                    if (null == window.navigator.msSaveBlob) {
                        var i = document.createElement("a");
                        i.href = URL.createObjectURL(n), i.download = a, $("body").append(i), i.click(), URL.revokeObjectURL(i.href), $(i).remove()
                    } else window.navigator.msSaveOrOpenBlob(n, a)
                }(t.data, "text/csv", e[0].eid.padStart(10, "0") + ".csv")))
            }, "json")
        }), f.click(function(t) {
            if ($(t.target).is("#confirm-ok")) {
                var e = s.attr("data-target"),
                    a = s.parentsUntil(".data", ".row").attr("data-eid");
                switch (e) {
                    case "delete-confirm":
                        $.post("/data/delete", {
                            "equipment[eid]": a
                        }, function(t) {
                            t && (t.error ? l({
                                title: t.error,
                                type: "fail"
                            }) : t.msg && (l({
                                title: t.msg,
                                type: "success"
                            }), j && j.update(parseInt(a), !0)))
                        }, "json")
                }
            }
        }), j = new p
    }) : $(".page-equipment").length ? $(document).ready(function() {
        m($(".data")), $(".row.pagetitle > div:nth-child(2)").on("click", function(t) {
            var e = $(t.currentTarget).find("a");
            t.target != e[0] && e.click()
        }), $("#equipmentadd").on("show.bs.modal", function(t) {
            var e = $(this);
            e.find("#add-eid").val(""), e.find(".loading").hide()
        }), $("#equipmentadd").on("shown.bs.modal", function(t) {
            $(this).find('input[type="text"]:first').focus()
        }), $("#equipmentadd").submit(function(t) {
            var i = $(this);
            return i.find(".loading").show(), $.post("/equipments/add/", $(this).find("form").serialize(), function(t) {
                if (i.find(".loading").hide(), t)
                    if (t.error && t.field) {
                        var e = i.find("[name='" + t.field + "']");
                        e.addClass("is-invalid").siblings(".invalid-tooltip").remove(), e.after($('<div class="invalid-tooltip">' + t.error + "</div>"))
                    } else if (t.error) i.modal("hide"), l({
                    title: t.error,
                    type: "fail"
                });
                else if (t.msg) {
                    i.modal("hide"), l({
                        title: t.msg,
                        type: "success"
                    });
                    var a = parseInt($("#equipment-count").text()) + 1;
                    $("#equipment-count").text(a);
                    var n = $(".template.equipmentrow").clone(!0);
                    m(n), n.find(".eid").text(t.eid.toString().padStart(10, "0")), n.find(".name").text(t.name), n.find(".owner").text(t.owner), n.attr("data-eid", t.eid).attr("data-version", t.version).attr("data-channelcount", t.channelcount).attr("data-collect", t.collect).attr("data-timezone", t.timezone).insertAfter(".table-title").removeClass(["template", "equipmentrow"])
                }
            }, "json"), !1
        }), $("#equipmentedit").on("show.bs.modal", function(t) {
            var e = $(this),
                a = $(t.relatedTarget).parentsUntil(".data", ".row");
            e.find(".loading").hide(), e.find("span.equipment-name").text(a.find(".name").text()), e.find("#edit-name").val(a.find(".name").text()), e.find("#edit-eid").val(a.find(".eid").text()), e.find("#edit-timezone").val(a.attr("data-timezone")), e.find("#edit-version").val(a.attr("data-version")), e.find("#edit-collect").val(a.attr("data-collect"))
        }), $("#equipmentedit").on("shown.bs.modal", function(t) {
            $(this).find("#edit-name").focus()
        }), $("#equipmentedit").submit(function(t) {
            var a = $(this);
            return a.find(".loading").show(), $.post("/equipment/edit/", $(this).find("form").serialize(), function(t) {
                if (a.find(".loading").hide(), t)
                    if (t.error && t.field) {
                        var e = a.find("[name='" + t.field + "']");
                        e.addClass("is-invalid").siblings(".invalid-tooltip").remove(), e.after($('<div class="invalid-tooltip">' + t.error + "</div>"))
                    } else t.error ? (a.modal("hide"), l({
                        title: t.error,
                        type: "fail"
                    })) : t.msg && (a.modal("hide"), l({
                        title: t.msg,
                        type: "success"
                    }), $("[data-eid=" + t.eid + "]").find(".name").text(t.name).end().find(".timezone").text(t.timezone).end().attr("data-timezone", t.timezone).attr("data-version", t.version).attr("data-collect", t.collect))
            }, "json"), !1
        }), $("a.equipmentpara").on("click", function(t) {
            t.preventDefault();
            var e = $(".template.equipmentpara").clone(!0);
            e[0].equipmentRow = $(this).parentsUntil(".data", ".row"), e[0].eid = e[0].equipmentRow.attr("data-eid"), e[0].channelCount = parseInt(e[0].equipmentRow.data("channelcount"));
            for (var a = 1; a <= e[0].channelCount; a++) e.find("thead tr").append($('<th scope="col">' + O("aisle") + a + "</th>")), e.find("tbody tr").append($("<td></td>"));
            e.appendTo($("body")).removeClass(["template", "equipmentpara"]).modal("show")
        }), $(".template.equipmentpara").on("show.bs.modal", function(t) {
            var f = $(this),
                e = f[0].equipmentRow,
                a = f[0].eid;
            f.find(".loading").show(), f.find("span.equipment-name").text(e.find(".name").text()), f.find("td").text("--"), $.ajax("/equipment/para/" + a, {
                type: "GET",
                cache: !1,
                dataType: "json",
                success: function(t) {
                    var e, a;
                    if (f.find(".loading").hide(), t && t.settings) try {
                        for (var n = z(Object.values(t.settings)), i = n.next(); !i.done; i = n.next()) {
                            var r = i.value;
                            if (1 <= r.channel && r.channel <= f[0].channelCount) {
                                var o = void 0,
                                    d = void 0,
                                    s = void 0,
                                    l = u(r.type) || "--";
                                "--" == l && (s = d = o = "--"), f.find("tr.type td").eq(r.channel - 1).text(l), o = o || c(r.unit) || "--", f.find("tr.unit td").eq(r.channel - 1).text(o), d = d || ("number" == typeof r.decimal ? r.decimal : "--"), f.find("tr.decimal td").eq(r.channel - 1).text(d), s = s || ("number" == typeof r.range && "number" == typeof r.decimal ? r.range.toFixed(r.decimal) : "--"), f.find("tr.range td").eq(r.channel - 1).text(s)
                            }
                        }
                    } catch (t) {
                        e = {
                            error: t
                        }
                    } finally {
                        try {
                            i && !i.done && (a = n.return) && a.call(n)
                        } finally {
                            if (e) throw e.error
                        }
                    }
                }
            })
        }), $(".template.equipmentpara").on("hidden.bs.modal", function(t) {
            $(this).remove()
        }), $("a.equipmentadjust").on("click", function(t) {
            t.preventDefault();
            var e = $(".template.equipmentadjust").clone(!0);
            e[0].equipmentRow = $(this).parentsUntil(".data", ".row"), e[0].eid = e[0].equipmentRow.attr("data-eid"), e[0].channelCount = parseInt(e[0].equipmentRow.data("channelcount"));
            var n = e.find("fieldset")[0];
            e.find("fieldset").remove();
            for (var i = e.find(".modal-body"), a = function(a) {
                    var t = $(n).clone(!0);
                    t.attr("data-channel", a), t.find("legend").text("-- (--)"), t.find("div[data-opt]").each(function() {
                        var t = $(this),
                            e = t.attr("data-opt");
                        t.find("label").attr("for", e + a), t.find("[name]").attr("id", e + a).attr("name", "settings[" + e + "][" + a + "]")
                    }), t.appendTo(i)
                }, r = 1; r <= e[0].channelCount; r++) a(r);
            e.appendTo($("body")).removeClass(["template", "equipmentadjust"]).modal("show")
        }), $(".template.equipmentadjust").on("show.bs.modal", function(t) {
            var l = $(this),
                e = l[0].equipmentRow,
                a = l[0].eid;
            l.find(".loading").show(), l.find("span.equipment-name").text(e.find(".name").text()), l.find('input[type="text"]').text(""), $.ajax("/equipment/para/" + a, {
                type: "GET",
                cache: !1,
                dataType: "json",
                success: function(t) {
                    var e, a;
                    if (l.find(".loading").hide(), t && t.settings) try {
                        for (var n = z(Object.values(t.settings)), i = n.next(); !i.done; i = n.next()) {
                            var r = i.value;
                            if (1 <= r.channel && r.channel <= l[0].channelCount) {
                                var o = void 0,
                                    d = u(r.type) || "--";
                                "--" == d && (o = "--"), o = o || c(r.unit) || "--";
                                var s = l.find('fieldset[data-channel="' + r.channel + '"]');
                                s.find("legend").text(d + " (" + o + ")"), s.find('div[data-opt="offset"] [name]').val("number" == typeof r.offset ? r.offset : ""), s.find('div[data-opt="ratio"] [name]').val(r.ratio)
                            }
                        }
                    } catch (t) {
                        e = {
                            error: t
                        }
                    } finally {
                        try {
                            i && !i.done && (a = n.return) && a.call(n)
                        } finally {
                            if (e) throw e.error
                        }
                    }
                }
            })
        }), $(".template.equipmentadjust").on("shown.bs.modal", function(t) {
            $(this).find('input[type="text"]:first').focus()
        }), $(".template.equipmentadjust").on("hidden.bs.modal", function(t) {
            $(this).remove()
        }), $(".template.equipmentadjust").submit(function(t) {
            var a = $(this),
                e = (a[0].equipmentRow, a[0].eid);
            return a.find('button[type="submit"]').prop("disabled", !0), a.find(".loading").show(), $.post("/equipment/para/" + e, $(this).find("form").serialize(), function(t) {
                if (a.find(".loading").hide(), t)
                    if (t.error && t.field) {
                        var e = a.find("input[name='" + t.field + "']");
                        e.addClass("is-invalid").siblings(".invalid-tooltip").remove(), e.after($('<div class="invalid-tooltip">' + t.error + "</div>"))
                    } else t.error ? (a.modal("hide"), l({
                        title: t.error,
                        type: "fail"
                    })) : t.msg && (a.modal("hide"), l({
                        title: t.msg,
                        type: t.type || "success"
                    }))
            }, "json"), !1
        }), f.click(function(t) {
            if ($(t.target).is("#confirm-ok")) {
                var e = s.attr("data-target"),
                    a = s.parentsUntil(".data", ".row");
                switch (e) {
                    case "delete-confirm":
                        $.post("/equipment/delete", {
                            "equipment[eid]": a.attr("data-eid")
                        }, function(t) {
                            if (t)
                                if (t.error) l({
                                    title: t.error,
                                    type: "fail"
                                });
                                else if (t.msg) {
                                l({
                                    title: t.msg,
                                    type: "success"
                                }), a.slideUp(400).queue(function() {
                                    a.remove()
                                });
                                var e = parseInt($("#equipment-count").text()) - 1;
                                $("#equipment-count").text(e)
                            }
                        }, "json")
                }
            }
        })
    }) : $(".page-users").length && $(document).ready(function() {
        m($(".data")), $(".row.pagetitle > div:nth-child(2)").on("click", function(t) {
            var e = $(t.currentTarget).find("a");
            t.target != e[0] && e.click()
        }), $("#useradd").on("show.bs.modal", function(t) {
            $('#useradd input[type="text"]').val(""), $("#useradd .loading").hide()
        }), $("#useradd").on("shown.bs.modal", function(t) {
            $('#useradd input[type="text"]:first').focus()
        }), $("#useradd").submit(function(t) {
            var i = $(this);
            return i.find(".loading").show(), $.post("/users/add/", $(this).find("form").serialize(), function(t) {
                if (i.find(".loading").hide(), t)
                    if (t.error && t.field) {
                        var e = i.find("input[name='" + t.field + "']");
                        e.addClass("is-invalid").siblings(".invalid-tooltip").remove(), e.after($('<div class="invalid-tooltip">' + t.error + "</div>"))
                    } else if (t.error) i.modal("hide"), l({
                    title: t.error,
                    type: "fail"
                });
                else if (t.msg) {
                    i.modal("hide"), l({
                        title: t.msg,
                        type: "success"
                    });
                    var a = parseInt($("#user-count").text()) + 1;
                    $("#user-count").text(a);
                    var n = $(".template.userrow").clone(!0);
                    m(n), n.find(".username").text(t.username), n.find(".uid").text(t.uid), n.insertAfter(".table-title").removeClass(["template", "userrow"])
                }
            }, "json"), !1
        }), $("#useredit").on("show.bs.modal", function(t) {
            var e = $(t.relatedTarget).parentsUntil(".data", ".row");
            $("#useredit .loading").hide(), $(this).find("#edit-uid").val(e.find(".uid").text()), $(this).find("#edit-usernick").val(e.find(".usernick").text()), $(this).find("#edit-username").val(e.find(".username").text())
        }), $("#useredit").on("shown.bs.modal", function(t) {
            $(this).find("#edit-username").focus()
        }), $("#useredit").submit(function(t) {
            var a = $(this);
            return a.find(".loading").show(), $.post("/users/edit/", $(this).find("form").serialize(), function(t) {
                if (a.find(".loading").hide(), t)
                    if (t.error && t.field) {
                        var e = a.find("input[name='" + t.field + "']");
                        e.addClass("is-invalid").siblings(".invalid-tooltip").remove(), e.after($('<div class="invalid-tooltip">' + t.error + "</div>"))
                    } else t.error ? (a.modal("hide"), l({
                        title: t.error,
                        type: "fail"
                    })) : t.msg && (a.modal("hide"), l({
                        title: t.msg,
                        type: "success"
                    }), $(".data .uid:contains(" + t.uid + ")").parent().find(".username").text(t.username))
            }, "json"), !1
        }), f.click(function(t) {
            if ($(t.target).is("#confirm-ok")) {
                var e = s.attr("data-target"),
                    a = s.parentsUntil(".data", ".row");
                switch (e) {
                    case "delete-confirm":
                        $.post("/users/delete", {
                            "user[uid]": a.find("div.uid").text()
                        }, function(t) {
                            if (t)
                                if (t.error) l({
                                    title: t.error,
                                    type: "fail"
                                });
                                else if (t.msg) {
                                l({
                                    title: t.msg,
                                    type: "success"
                                }), a.slideUp(400).queue(function() {
                                    a.remove()
                                });
                                var e = parseInt($("#user-count").text()) - 1;
                                $("#user-count").text(e)
                            }
                        }, "json");
                        break;
                    case "reset-confirm":
                        $.post("/users/reset", {
                            "user[uid]": a.find("div.uid").text()
                        }, function(t) {
                            t && (t.error ? l({
                                title: t.error,
                                type: "fail"
                            }) : t.msg && (l({
                                title: t.msg,
                                type: "success"
                            }), a.find("div.usernick").text("")))
                        }, "json")
                }
            }
        })
    })
}();