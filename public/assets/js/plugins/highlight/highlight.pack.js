var hljs = new function () {
    function j(v) {
        return v.replace(/&/gm, "&amp;").replace(/</gm, "&lt;").replace(/>/gm, "&gt;")
    }

    function t(v) {
        return v.nodeName.toLowerCase()
    }

    function h(w, x) {
        var v = w && w.exec(x);
        return v && v.index == 0
    }

    function r(w) {
        var v = (w.className + " " + (w.parentNode ? w.parentNode.className : "")).split(/\s+/);
        v = v.map(function (x) {
            return x.replace(/^lang(uage)?-/, "")
        });
        return v.filter(function (x) {
            return i(x) || /no(-?)highlight/.test(x)
        })[0]
    }

    function o(x, y) {
        var v = {};
        for (var w in x) {
            v[w] = x[w]
        }
        if (y) {
            for (var w in y) {
                v[w] = y[w]
            }
        }
        return v
    }

    function u(x) {
        var v = [];
        (function w(y, z) {
            for (var A = y.firstChild; A; A = A.nextSibling) {
                if (A.nodeType == 3) {
                    z += A.nodeValue.length
                } else {
                    if (A.nodeType == 1) {
                        v.push({event: "start", offset: z, node: A});
                        z = w(A, z);
                        if (!t(A).match(/br|hr|img|input/)) {
                            v.push({event: "stop", offset: z, node: A})
                        }
                    }
                }
            }
            return z
        })(x, 0);
        return v
    }

    function q(w, y, C) {
        var x = 0;
        var F = "";
        var z = [];

        function B() {
            if (!w.length || !y.length) {
                return w.length ? w : y
            }
            if (w[0].offset != y[0].offset) {
                return (w[0].offset < y[0].offset) ? w : y
            }
            return y[0].event == "start" ? w : y
        }

        function A(H) {
            function G(I) {
                return " " + I.nodeName + '="' + j(I.value) + '"'
            }

            F += "<" + t(H) + Array.prototype.map.call(H.attributes, G).join("") + ">"
        }

        function E(G) {
            F += "</" + t(G) + ">"
        }

        function v(G) {
            (G.event == "start" ? A : E)(G.node)
        }

        while (w.length || y.length) {
            var D = B();
            F += j(C.substr(x, D[0].offset - x));
            x = D[0].offset;
            if (D == w) {
                z.reverse().forEach(E);
                do {
                    v(D.splice(0, 1)[0]);
                    D = B()
                } while (D == w && D.length && D[0].offset == x);
                z.reverse().forEach(A)
            } else {
                if (D[0].event == "start") {
                    z.push(D[0].node)
                } else {
                    z.pop()
                }
                v(D.splice(0, 1)[0])
            }
        }
        return F + j(C.substr(x))
    }

    function m(y) {
        function v(z) {
            return (z && z.source) || z
        }

        function w(A, z) {
            return RegExp(v(A), "m" + (y.cI ? "i" : "") + (z ? "g" : ""))
        }

        function x(D, C) {
            if (D.compiled) {
                return
            }
            D.compiled = true;
            D.k = D.k || D.bK;
            if (D.k) {
                var z = {};
                var E = function (G, F) {
                    if (y.cI) {
                        F = F.toLowerCase()
                    }
                    F.split(" ").forEach(function (H) {
                        var I = H.split("|");
                        z[I[0]] = [G, I[1] ? Number(I[1]) : 1]
                    })
                };
                if (typeof D.k == "string") {
                    E("keyword", D.k)
                } else {
                    Object.keys(D.k).forEach(function (F) {
                        E(F, D.k[F])
                    })
                }
                D.k = z
            }
            D.lR = w(D.l || /\b[A-Za-z0-9_]+\b/, true);
            if (C) {
                if (D.bK) {
                    D.b = "\\b(" + D.bK.split(" ").join("|") + ")\\b"
                }
                if (!D.b) {
                    D.b = /\B|\b/
                }
                D.bR = w(D.b);
                if (!D.e && !D.eW) {
                    D.e = /\B|\b/
                }
                if (D.e) {
                    D.eR = w(D.e)
                }
                D.tE = v(D.e) || "";
                if (D.eW && C.tE) {
                    D.tE += (D.e ? "|" : "") + C.tE
                }
            }
            if (D.i) {
                D.iR = w(D.i)
            }
            if (D.r === undefined) {
                D.r = 1
            }
            if (!D.c) {
                D.c = []
            }
            var B = [];
            D.c.forEach(function (F) {
                if (F.v) {
                    F.v.forEach(function (G) {
                        B.push(o(F, G))
                    })
                } else {
                    B.push(F == "self" ? D : F)
                }
            });
            D.c = B;
            D.c.forEach(function (F) {
                x(F, D)
            });
            if (D.starts) {
                x(D.starts, C)
            }
            var A = D.c.map(function (F) {
                return F.bK ? "\\.?(" + F.b + ")\\.?" : F.b
            }).concat([D.tE, D.i]).map(v).filter(Boolean);
            D.t = A.length ? w(A.join("|"), true) : {
                exec: function (F) {
                    return null
                }
            }
        }

        x(y)
    }

    function c(T, L, J, R) {
        function v(V, W) {
            for (var U = 0; U < W.c.length; U++) {
                if (h(W.c[U].bR, V)) {
                    return W.c[U]
                }
            }
        }

        function z(V, U) {
            if (h(V.eR, U)) {
                return V
            }
            if (V.eW) {
                return z(V.parent, U)
            }
        }

        function A(U, V) {
            return !J && h(V.iR, U)
        }

        function E(W, U) {
            var V = M.cI ? U[0].toLowerCase() : U[0];
            return W.k.hasOwnProperty(V) && W.k[V]
        }

        function w(aa, Y, X, W) {
            var U = W ? "" : b.classPrefix, V = '<span class="' + U, Z = X ? "" : "</span>";
            V += aa + '">';
            return V + Y + Z
        }

        function N() {
            if (!I.k) {
                return j(C)
            }
            var U = "";
            var X = 0;
            I.lR.lastIndex = 0;
            var V = I.lR.exec(C);
            while (V) {
                U += j(C.substr(X, V.index - X));
                var W = E(I, V);
                if (W) {
                    H += W[1];
                    U += w(W[0], j(V[0]))
                } else {
                    U += j(V[0])
                }
                X = I.lR.lastIndex;
                V = I.lR.exec(C)
            }
            return U + j(C.substr(X))
        }

        function F() {
            if (I.sL && !f[I.sL]) {
                return j(C)
            }
            var U = I.sL ? c(I.sL, C, true, S) : e(C);
            if (I.r > 0) {
                H += U.r
            }
            if (I.subLanguageMode == "continuous") {
                S = U.top
            }
            return w(U.language, U.value, false, true)
        }

        function Q() {
            return I.sL !== undefined ? F() : N()
        }

        function P(W, V) {
            var U = W.cN ? w(W.cN, "", true) : "";
            if (W.rB) {
                D += U;
                C = ""
            } else {
                if (W.eB) {
                    D += j(V) + U;
                    C = ""
                } else {
                    D += U;
                    C = V
                }
            }
            I = Object.create(W, {parent: {value: I}})
        }

        function G(U, Y) {
            C += U;
            if (Y === undefined) {
                D += Q();
                return 0
            }
            var W = v(Y, I);
            if (W) {
                D += Q();
                P(W, Y);
                return W.rB ? 0 : Y.length
            }
            var X = z(I, Y);
            if (X) {
                var V = I;
                if (!(V.rE || V.eE)) {
                    C += Y
                }
                D += Q();
                do {
                    if (I.cN) {
                        D += "</span>"
                    }
                    H += I.r;
                    I = I.parent
                } while (I != X.parent);
                if (V.eE) {
                    D += j(Y)
                }
                C = "";
                if (X.starts) {
                    P(X.starts, "")
                }
                return V.rE ? 0 : Y.length
            }
            if (A(Y, I)) {
                throw new Error('Illegal lexeme "' + Y + '" for mode "' + (I.cN || "<unnamed>") + '"')
            }
            C += Y;
            return Y.length || 1
        }

        var M = i(T);
        if (!M) {
            throw new Error('Unknown language: "' + T + '"')
        }
        m(M);
        var I = R || M;
        var S;
        var D = "";
        for (var K = I; K != M; K = K.parent) {
            if (K.cN) {
                D = w(K.cN, "", true) + D
            }
        }
        var C = "";
        var H = 0;
        try {
            var B, y, x = 0;
            while (true) {
                I.t.lastIndex = x;
                B = I.t.exec(L);
                if (!B) {
                    break
                }
                y = G(L.substr(x, B.index - x), B[0]);
                x = B.index + y
            }
            G(L.substr(x));
            for (var K = I; K.parent; K = K.parent) {
                if (K.cN) {
                    D += "</span>"
                }
            }
            return {r: H, value: D, language: T, top: I}
        } catch (O) {
            if (O.message.indexOf("Illegal") != -1) {
                return {r: 0, value: j(L)}
            } else {
                throw O
            }
        }
    }

    function e(y, x) {
        x = x || b.languages || Object.keys(f);
        var v = {r: 0, value: j(y)};
        var w = v;
        x.forEach(function (z) {
            if (!i(z)) {
                return
            }
            var A = c(z, y, false);
            A.language = z;
            if (A.r > w.r) {
                w = A
            }
            if (A.r > v.r) {
                w = v;
                v = A
            }
        });
        if (w.language) {
            v.second_best = w
        }
        return v
    }

    function g(v) {
        if (b.tabReplace) {
            v = v.replace(/^((<[^>]+>|\t)+)/gm, function (w, z, y, x) {
                return z.replace(/\t/g, b.tabReplace)
            })
        }
        if (b.useBR) {
            v = v.replace(/\n/g, "<br>")
        }
        return v
    }

    function p(A) {
        var B = r(A);
        if (/no(-?)highlight/.test(B)) {
            return
        }
        var y;
        if (b.useBR) {
            y = document.createElementNS("http://www.w3.org/1999/xhtml", "div");
            y.innerHTML = A.innerHTML.replace(/\n/g, "").replace(/<br[ \/]*>/g, "\n")
        } else {
            y = A
        }
        var z = y.textContent;
        var v = B ? c(B, z, true) : e(z);
        var x = u(y);
        if (x.length) {
            var w = document.createElementNS("http://www.w3.org/1999/xhtml", "div");
            w.innerHTML = v.value;
            v.value = q(x, u(w), z)
        }
        v.value = g(v.value);
        A.innerHTML = v.value;
        A.className += " hljs " + (!B && v.language || "");
        A.result = {language: v.language, re: v.r};
        if (v.second_best) {
            A.second_best = {language: v.second_best.language, re: v.second_best.r}
        }
    }

    var b = {classPrefix: "hljs-", tabReplace: null, useBR: false, languages: undefined};

    function s(v) {
        b = o(b, v)
    }

    function l() {
        if (l.called) {
            return
        }
        l.called = true;
        var v = document.querySelectorAll("pre code");
        Array.prototype.forEach.call(v, p)
    }

    function a() {
        addEventListener("DOMContentLoaded", l, false);
        addEventListener("load", l, false)
    }

    var f = {};
    var n = {};

    function d(v, x) {
        var w = f[v] = x(this);
        if (w.aliases) {
            w.aliases.forEach(function (y) {
                n[y] = v
            })
        }
    }

    function k() {
        return Object.keys(f)
    }

    function i(v) {
        return f[v] || f[n[v]]
    }

    this.highlight = c;
    this.highlightAuto = e;
    this.fixMarkup = g;
    this.highlightBlock = p;
    this.configure = s;
    this.initHighlighting = l;
    this.initHighlightingOnLoad = a;
    this.registerLanguage = d;
    this.listLanguages = k;
    this.getLanguage = i;
    this.inherit = o;
    this.IR = "[a-zA-Z][a-zA-Z0-9_]*";
    this.UIR = "[a-zA-Z_][a-zA-Z0-9_]*";
    this.NR = "\\b\\d+(\\.\\d+)?";
    this.CNR = "(\\b0[xX][a-fA-F0-9]+|(\\b\\d+(\\.\\d*)?|\\.\\d+)([eE][-+]?\\d+)?)";
    this.BNR = "\\b(0b[01]+)";
    this.RSR = "!|!=|!==|%|%=|&|&&|&=|\\*|\\*=|\\+|\\+=|,|-|-=|/=|/|:|;|<<|<<=|<=|<|===|==|=|>>>=|>>=|>=|>>>|>>|>|\\?|\\[|\\{|\\(|\\^|\\^=|\\||\\|=|\\|\\||~";
    this.BE = {b: "\\\\[\\s\\S]", r: 0};
    this.ASM = {cN: "string", b: "'", e: "'", i: "\\n", c: [this.BE]};
    this.QSM = {cN: "string", b: '"', e: '"', i: "\\n", c: [this.BE]};
    this.PWM = {b: /\b(a|an|the|are|I|I'm|isn't|don't|doesn't|won't|but|just|should|pretty|simply|enough|gonna|going|wtf|so|such)\b/};
    this.CLCM = {cN: "comment", b: "//", e: "$", c: [this.PWM]};
    this.CBCM = {cN: "comment", b: "/\\*", e: "\\*/", c: [this.PWM]};
    this.HCM = {cN: "comment", b: "#", e: "$", c: [this.PWM]};
    this.NM = {cN: "number", b: this.NR, r: 0};
    this.CNM = {cN: "number", b: this.CNR, r: 0};
    this.BNM = {cN: "number", b: this.BNR, r: 0};
    this.CSSNM = {
        cN: "number",
        b: this.NR + "(%|em|ex|ch|rem|vw|vh|vmin|vmax|cm|mm|in|pt|pc|px|deg|grad|rad|turn|s|ms|Hz|kHz|dpi|dpcm|dppx)?",
        r: 0
    };
    this.RM = {cN: "regexp", b: /\//, e: /\/[gim]*/, i: /\n/, c: [this.BE, {b: /\[/, e: /\]/, r: 0, c: [this.BE]}]};
    this.TM = {cN: "title", b: this.IR, r: 0};
    this.UTM = {cN: "title", b: this.UIR, r: 0}
}();
hljs.registerLanguage("bash", function (b) {
    var a = {cN: "variable", v: [{b: /\$[\w\d#@][\w\d_]*/}, {b: /\$\{(.*?)\}/}]};
    var d = {cN: "string", b: /"/, e: /"/, c: [b.BE, a, {cN: "variable", b: /\$\(/, e: /\)/, c: [b.BE]}]};
    var c = {cN: "string", b: /'/, e: /'/};
    return {
        aliases: ["sh", "zsh"],
        l: /-?[a-z\.]+/,
        k: {
            keyword: "if then else elif fi for break continue while in do done exit return set declare case esac export exec",
            literal: "true false",
            built_in: "printf echo read cd pwd pushd popd dirs let eval unset typeset readonly getopts source shopt caller type hash bind help sudo",
            operator: "-ne -eq -lt -gt -f -d -e -s -l -a"
        },
        c: [{cN: "shebang", b: /^#![^\n]+sh\s*$/, r: 10}, {
            cN: "function",
            b: /\w[\w\d_]*\s*\(\s*\)\s*\{/,
            rB: true,
            c: [b.inherit(b.TM, {b: /\w[\w\d_]*/})],
            r: 0
        }, b.HCM, b.NM, d, c, a]
    }
});
hljs.registerLanguage("ruby", function (f) {
    var j = "[a-zA-Z_]\\w*[!?=]?|[-+~]\\@|<<|>>|=~|===?|<=>|[<>]=?|\\*\\*|[-/+%^&*~`|]|\\[\\]=?";
    var i = "and false then defined module in return redo if BEGIN retry end for true self when next until do begin unless END rescue nil else break undef not super class case require yield alias while ensure elsif or include attr_reader attr_writer attr_accessor";
    var b = {cN: "yardoctag", b: "@[A-Za-z]+"};
    var c = {cN: "value", b: "#<", e: ">"};
    var k = {
        cN: "comment",
        v: [{b: "#", e: "$", c: [b]}, {b: "^\\=begin", e: "^\\=end", c: [b], r: 10}, {b: "^__END__", e: "\\n$"}]
    };
    var d = {cN: "subst", b: "#\\{", e: "}", k: i};
    var e = {
        cN: "string",
        c: [f.BE, d],
        v: [{b: /'/, e: /'/}, {b: /"/, e: /"/}, {b: "%[qw]?\\(", e: "\\)"}, {b: "%[qw]?\\[", e: "\\]"}, {
            b: "%[qw]?{",
            e: "}"
        }, {b: "%[qw]?<", e: ">"}, {b: "%[qw]?/", e: "/"}, {b: "%[qw]?%", e: "%"}, {
            b: "%[qw]?-",
            e: "-"
        }, {b: "%[qw]?\\|", e: "\\|"}, {b: /\B\?(\\\d{1,3}|\\x[A-Fa-f0-9]{1,2}|\\u[A-Fa-f0-9]{4}|\\?\S)\b/}]
    };
    var a = {cN: "params", b: "\\(", e: "\\)", k: i};
    var h = [e, c, k, {
        cN: "class",
        bK: "class module",
        e: "$|;",
        i: /=/,
        c: [f.inherit(f.TM, {b: "[A-Za-z_]\\w*(::\\w+)*(\\?|\\!)?"}), {
            cN: "inheritance",
            b: "<\\s*",
            c: [{cN: "parent", b: "(" + f.IR + "::)?" + f.IR}]
        }, k]
    }, {cN: "function", bK: "def", e: " |$|;", r: 0, c: [f.inherit(f.TM, {b: j}), a, k]}, {
        cN: "constant",
        b: "(::)?(\\b[A-Z]\\w*(::)?)+",
        r: 0
    }, {cN: "symbol", b: f.UIR + "(\\!|\\?)?:", r: 0}, {cN: "symbol", b: ":", c: [e, {b: j}], r: 0}, {
        cN: "number",
        b: "(\\b0[0-7_]+)|(\\b0x[0-9a-fA-F_]+)|(\\b[1-9][0-9_]*(\\.[0-9_]+)?)|[0_]\\b",
        r: 0
    }, {cN: "variable", b: "(\\$\\W)|((\\$|\\@\\@?)(\\w+))"}, {
        b: "(" + f.RSR + ")\\s*",
        c: [c, k, {
            cN: "regexp",
            c: [f.BE, d],
            i: /\n/,
            v: [{b: "/", e: "/[a-z]*"}, {b: "%r{", e: "}[a-z]*"}, {b: "%r\\(", e: "\\)[a-z]*"}, {
                b: "%r!",
                e: "![a-z]*"
            }, {b: "%r\\[", e: "\\][a-z]*"}]
        }],
        r: 0
    }];
    d.c = h;
    a.c = h;
    var g = [{b: /^\s*=>/, cN: "status", starts: {e: "$", c: h}}, {
        cN: "prompt",
        b: /^\S[^=>\n]*>+/,
        starts: {e: "$", c: h}
    }];
    return {aliases: ["rb", "gemspec", "podspec", "thor", "irb"], k: i, c: [k].concat(g).concat(h)}
});
hljs.registerLanguage("javascript", function (a) {
    return {
        aliases: ["js"],
        k: {
            keyword: "in if for while finally var new function do return void else break catch instanceof with throw case default try this switch continue typeof delete let yield const class",
            literal: "true false null undefined NaN Infinity",
            built_in: "eval isFinite isNaN parseFloat parseInt decodeURI decodeURIComponent encodeURI encodeURIComponent escape unescape Object Function Boolean Error EvalError InternalError RangeError ReferenceError StopIteration SyntaxError TypeError URIError Number Math Date String RegExp Array Float32Array Float64Array Int16Array Int32Array Int8Array Uint16Array Uint32Array Uint8Array Uint8ClampedArray ArrayBuffer DataView JSON Intl arguments require module console window document"
        },
        c: [{
            cN: "pi",
            b: /^\s*('|")use strict('|")/,
            r: 10
        }, a.ASM, a.QSM, a.CLCM, a.CBCM, a.CNM, {
            b: "(" + a.RSR + "|\\b(case|return|throw)\\b)\\s*",
            k: "return throw case",
            c: [a.CLCM, a.CBCM, a.RM, {b: /</, e: />;/, r: 0, sL: "xml"}],
            r: 0
        }, {
            cN: "function",
            bK: "function",
            e: /\{/,
            eE: true,
            c: [a.inherit(a.TM, {b: /[A-Za-z$_][0-9A-Za-z$_]*/}), {
                cN: "params",
                b: /\(/,
                e: /\)/,
                c: [a.CLCM, a.CBCM],
                i: /["'\(]/
            }],
            i: /\[|%/
        }, {b: /\$[(.]/}, {b: "\\." + a.IR, r: 0}]
    }
});
hljs.registerLanguage("xml", function (a) {
    var c = "[A-Za-z0-9\\._:-]+";
    var d = {b: /<\?(php)?(?!\w)/, e: /\?>/, sL: "php", subLanguageMode: "continuous"};
    var b = {
        eW: true,
        i: /</,
        r: 0,
        c: [d, {cN: "attribute", b: c, r: 0}, {
            b: "=",
            r: 0,
            c: [{cN: "value", v: [{b: /"/, e: /"/}, {b: /'/, e: /'/}, {b: /[^\s\/>]+/}]}]
        }]
    };
    return {
        aliases: ["html", "xhtml", "rss", "atom", "xsl", "plist"],
        cI: true,
        c: [{cN: "doctype", b: "<!DOCTYPE", e: ">", r: 10, c: [{b: "\\[", e: "\\]"}]}, {
            cN: "comment",
            b: "<!--",
            e: "-->",
            r: 10
        }, {cN: "cdata", b: "<\\!\\[CDATA\\[", e: "\\]\\]>", r: 10}, {
            cN: "tag",
            b: "<style(?=\\s|>|$)",
            e: ">",
            k: {title: "style"},
            c: [b],
            starts: {e: "</style>", rE: true, sL: "css"}
        }, {
            cN: "tag",
            b: "<script(?=\\s|>|$)",
            e: ">",
            k: {title: "script"},
            c: [b],
            starts: {e: "<\/script>", rE: true, sL: "javascript"}
        }, {b: "<%", e: "%>", sL: "vbscript"}, d, {cN: "pi", b: /<\?\w+/, e: /\?>/, r: 10}, {
            cN: "tag",
            b: "</?",
            e: "/?>",
            c: [{cN: "title", b: /[^ \/><\n\t]+/, r: 0}, b]
        }]
    }
});
hljs.registerLanguage("markdown", function (a) {
    return {
        aliases: ["md", "mkdown", "mkd"],
        c: [{cN: "header", v: [{b: "^#{1,6}", e: "$"}, {b: "^.+?\\n[=-]{2,}$"}]}, {
            b: "<",
            e: ">",
            sL: "xml",
            r: 0
        }, {cN: "bullet", b: "^([*+-]|(\\d+\\.))\\s+"}, {cN: "strong", b: "[*_]{2}.+?[*_]{2}"}, {
            cN: "emphasis",
            v: [{b: "\\*.+?\\*"}, {b: "_.+?_", r: 0}]
        }, {cN: "blockquote", b: "^>\\s+", e: "$"}, {
            cN: "code",
            v: [{b: "`.+?`"}, {b: "^( {4}|\t)", e: "$", r: 0}]
        }, {cN: "horizontal_rule", b: "^[-\\*]{3,}", e: "$"}, {
            b: "\\[.+?\\][\\(\\[].*?[\\)\\]]",
            rB: true,
            c: [{cN: "link_label", b: "\\[", e: "\\]", eB: true, rE: true, r: 0}, {
                cN: "link_url",
                b: "\\]\\(",
                e: "\\)",
                eB: true,
                eE: true
            }, {cN: "link_reference", b: "\\]\\[", e: "\\]", eB: true, eE: true}],
            r: 10
        }, {
            b: "^\\[.+\\]:",
            rB: true,
            c: [{cN: "link_reference", b: "\\[", e: "\\]:", eB: true, eE: true, starts: {cN: "link_url", e: "$"}}]
        }]
    }
});
hljs.registerLanguage("css", function (a) {
    var b = "[a-zA-Z-][a-zA-Z0-9_-]*";
    var c = {cN: "function", b: b + "\\(", rB: true, eE: true, e: "\\("};
    return {
        cI: true,
        i: "[=/|']",
        c: [a.CBCM, {cN: "id", b: "\\#[A-Za-z0-9_-]+"}, {
            cN: "class",
            b: "\\.[A-Za-z0-9_-]+",
            r: 0
        }, {cN: "attr_selector", b: "\\[", e: "\\]", i: "$"}, {
            cN: "pseudo",
            b: ":(:)?[a-zA-Z0-9\\_\\-\\+\\(\\)\\\"\\']+"
        }, {cN: "at_rule", b: "@(font-face|page)", l: "[a-z-]+", k: "font-face page"}, {
            cN: "at_rule",
            b: "@",
            e: "[{;]",
            c: [{cN: "keyword", b: /\S+/}, {b: /\s/, eW: true, eE: true, r: 0, c: [c, a.ASM, a.QSM, a.CSSNM]}]
        }, {cN: "tag", b: b, r: 0}, {
            cN: "rules",
            b: "{",
            e: "}",
            i: "[^\\s]",
            r: 0,
            c: [a.CBCM, {
                cN: "rule",
                b: "[^\\s]",
                rB: true,
                e: ";",
                eW: true,
                c: [{
                    cN: "attribute",
                    b: "[A-Z\\_\\.\\-]+",
                    e: ":",
                    eE: true,
                    i: "[^\\s]",
                    starts: {
                        cN: "value",
                        eW: true,
                        eE: true,
                        c: [c, a.CSSNM, a.QSM, a.ASM, a.CBCM, {cN: "hexcolor", b: "#[0-9A-Fa-f]+"}, {
                            cN: "important",
                            b: "!important"
                        }]
                    }
                }]
            }]
        }]
    }
});
hljs.registerLanguage("http", function (a) {
    return {
        i: "\\S",
        c: [{cN: "status", b: "^HTTP/[0-9\\.]+", e: "$", c: [{cN: "number", b: "\\b\\d{3}\\b"}]}, {
            cN: "request",
            b: "^[A-Z]+ (.*?) HTTP/[0-9\\.]+$",
            rB: true,
            e: "$",
            c: [{cN: "string", b: " ", e: " ", eB: true, eE: true}]
        }, {
            cN: "attribute",
            b: "^\\w",
            e: ": ",
            eE: true,
            i: "\\n|\\s|=",
            starts: {cN: "string", e: "$"}
        }, {b: "\\n\\n", starts: {sL: "", eW: true}}]
    }
});
hljs.registerLanguage("java", function (c) {
    var b = c.UIR + "(<" + c.UIR + ">)?";
    var a = "false synchronized int abstract float private char boolean static null if const for true while long throw strictfp finally protected import native final return void enum else break transient new catch instanceof byte super volatile case assert short package default double public try this switch continue throws protected public private";
    return {
        aliases: ["jsp"],
        k: a,
        i: /<\//,
        c: [{
            cN: "javadoc",
            b: "/\\*\\*",
            e: "\\*/",
            r: 0,
            c: [{cN: "javadoctag", b: "(^|\\s)@[A-Za-z]+"}]
        }, c.CLCM, c.CBCM, c.ASM, c.QSM, {
            cN: "class",
            bK: "class interface",
            e: /[{;=]/,
            eE: true,
            k: "class interface",
            i: /[:"\[\]]/,
            c: [{bK: "extends implements"}, c.UTM]
        }, {bK: "new", e: /\s/, r: 0}, {
            cN: "function",
            b: "(" + b + "\\s+)+" + c.UIR + "\\s*\\(",
            rB: true,
            e: /[{;=]/,
            eE: true,
            k: a,
            c: [{b: c.UIR + "\\s*\\(", rB: true, c: [c.UTM]}, {
                cN: "params",
                b: /\(/,
                e: /\)/,
                k: a,
                c: [c.ASM, c.QSM, c.CNM, c.CBCM]
            }, c.CLCM, c.CBCM]
        }, c.CNM, {cN: "annotation", b: "@[A-Za-z]+"}]
    }
});
hljs.registerLanguage("php", function (b) {
    var e = {cN: "variable", b: "(\\$|->)+[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*"};
    var a = {cN: "preprocessor", b: /<\?(php)?|\?>/};
    var c = {
        cN: "string",
        c: [b.BE, a],
        v: [{b: 'b"', e: '"'}, {b: "b'", e: "'"}, b.inherit(b.ASM, {i: null}), b.inherit(b.QSM, {i: null})]
    };
    var d = {v: [b.BNM, b.CNM]};
    return {
        aliases: ["php3", "php4", "php5", "php6"],
        cI: true,
        k: "and include_once list abstract global private echo interface as static endswitch array null if endwhile or const for endforeach self var while isset public protected exit foreach throw elseif include __FILE__ empty require_once do xor return parent clone use __CLASS__ __LINE__ else break print eval new catch __METHOD__ case exception default die require __FUNCTION__ enddeclare final try switch continue endfor endif declare unset true false trait goto instanceof insteadof __DIR__ __NAMESPACE__ yield finally",
        c: [b.CLCM, b.HCM, {
            cN: "comment",
            b: "/\\*",
            e: "\\*/",
            c: [{cN: "phpdoc", b: "\\s@[A-Za-z]+"}, a]
        }, {cN: "comment", b: "__halt_compiler.+?;", eW: true, k: "__halt_compiler", l: b.UIR}, {
            cN: "string",
            b: "<<<['\"]?\\w+['\"]?$",
            e: "^\\w+;",
            c: [b.BE]
        }, a, e, {
            cN: "function",
            bK: "function",
            e: /[;{]/,
            eE: true,
            i: "\\$|\\[|%",
            c: [b.UTM, {cN: "params", b: "\\(", e: "\\)", c: ["self", e, b.CBCM, c, d]}]
        }, {
            cN: "class",
            bK: "class interface",
            e: "{",
            eE: true,
            i: /[:\(\$"]/,
            c: [{bK: "extends implements"}, b.UTM]
        }, {bK: "namespace", e: ";", i: /[\.']/, c: [b.UTM]}, {bK: "use", e: ";", c: [b.UTM]}, {b: "=>"}, c, d]
    }
});
hljs.registerLanguage("sql", function (a) {
    var b = {cN: "comment", b: "--", e: "$"};
    return {
        cI: true,
        i: /[<>]/,
        c: [{
            cN: "operator",
            bK: "begin end start commit rollback savepoint lock alter create drop rename call delete do handler insert load replace select truncate update set show pragma grant merge describe use explain help declare prepare execute deallocate savepoint release unlock purge reset change stop analyze cache flush optimize repair kill install uninstall checksum restore check backup",
            e: /;/,
            eW: true,
            k: {
                keyword: "abs absolute acos action add adddate addtime aes_decrypt aes_encrypt after aggregate all allocate alter analyze and any are as asc ascii asin assertion at atan atan2 atn2 authorization authors avg backup before begin benchmark between bin binlog bit_and bit_count bit_length bit_or bit_xor both by cache call cascade cascaded case cast catalog ceil ceiling chain change changed char_length character_length charindex charset check checksum checksum_agg choose close coalesce coercibility collate collation collationproperty column columns columns_updated commit compress concat concat_ws concurrent connect connection connection_id consistent constraint constraints continue contributors conv convert convert_tz corresponding cos cot count count_big crc32 create cross cume_dist curdate current current_date current_time current_timestamp current_user cursor curtime data database databases datalength date_add date_format date_sub dateadd datediff datefromparts datename datepart datetime2fromparts datetimeoffsetfromparts day dayname dayofmonth dayofweek dayofyear deallocate declare decode default deferrable deferred degrees delayed delete des_decrypt des_encrypt des_key_file desc describe descriptor diagnostics difference disconnect distinct distinctrow div do domain double drop dumpfile each else elt enclosed encode encrypt end end-exec engine engines eomonth errors escape escaped event eventdata events except exception exec execute exists exp explain export_set extended external extract fast fetch field fields find_in_set first first_value floor flush for force foreign format found found_rows from from_base64 from_days from_unixtime full function get get_format get_lock getdate getutcdate global go goto grant grants greatest group group_concat grouping grouping_id gtid_subset gtid_subtract handler having help hex high_priority hosts hour ident_current ident_incr ident_seed identified identity if ifnull ignore iif ilike immediate in index indicator inet6_aton inet6_ntoa inet_aton inet_ntoa infile initially inner innodb input insert install instr intersect into is is_free_lock is_ipv4 is_ipv4_compat is_ipv4_mapped is_not is_not_null is_used_lock isdate isnull isolation join key kill language last last_day last_insert_id last_value lcase lead leading least leaves left len lenght level like limit lines ln load load_file local localtime localtimestamp locate lock log log10 log2 logfile logs low_priority lower lpad ltrim make_set makedate maketime master master_pos_wait match matched max md5 medium merge microsecond mid min minute mod mode module month monthname mutex name_const names national natural nchar next no no_write_to_binlog not now nullif nvarchar oct octet_length of old_password on only open optimize option optionally or ord order outer outfile output pad parse partial partition password patindex percent_rank percentile_cont percentile_disc period_add period_diff pi plugin position pow power pragma precision prepare preserve primary prior privileges procedure procedure_analyze processlist profile profiles public publishingservername purge quarter query quick quote quotename radians rand read references regexp relative relaylog release release_lock rename repair repeat replace replicate reset restore restrict return returns reverse revoke right rlike rollback rollup round row row_count rows rpad rtrim savepoint schema scroll sec_to_time second section select serializable server session session_user set sha sha1 sha2 share show sign sin size slave sleep smalldatetimefromparts snapshot some soname soundex sounds_like space sql sql_big_result sql_buffer_result sql_cache sql_calc_found_rows sql_no_cache sql_small_result sql_variant_property sqlstate sqrt square start starting status std stddev stddev_pop stddev_samp stdev stdevp stop str str_to_date straight_join strcmp string stuff subdate substr substring subtime subtring_index sum switchoffset sysdate sysdatetime sysdatetimeoffset system_user sysutcdatetime table tables tablespace tan temporary terminated tertiary_weights then time time_format time_to_sec timediff timefromparts timestamp timestampadd timestampdiff timezone_hour timezone_minute to to_base64 to_days to_seconds todatetimeoffset trailing transaction translation trigger trigger_nestlevel triggers trim truncate try_cast try_convert try_parse ucase uncompress uncompressed_length unhex unicode uninstall union unique unix_timestamp unknown unlock update upgrade upped upper usage use user user_resources using utc_date utc_time utc_timestamp uuid uuid_short validate_password_strength value values var var_pop var_samp variables variance varp version view warnings week weekday weekofyear weight_string when whenever where with work write xml xor year yearweek zon",
                literal: "true false null",
                built_in: "array bigint binary bit blob boolean char character date dec decimal float int integer interval number numeric real serial smallint varchar varying int8 serial8 text"
            },
            c: [{cN: "string", b: "'", e: "'", c: [a.BE, {b: "''"}]}, {
                cN: "string",
                b: '"',
                e: '"',
                c: [a.BE, {b: '""'}]
            }, {cN: "string", b: "`", e: "`", c: [a.BE]}, a.CNM, a.CBCM, b]
        }, a.CBCM, b]
    }
});
hljs.registerLanguage("coffeescript", function (c) {
    var b = {
        keyword: "in if for while finally new do return else break catch instanceof throw try this switch continue typeof delete debugger super then unless until loop of by when and or is isnt not",
        literal: "true false null undefined yes no on off",
        reserved: "case default function var void with const let enum export import native __hasProp __extends __slice __bind __indexOf",
        built_in: "npm require console print module global window document"
    };
    var a = "[A-Za-z$_][0-9A-Za-z$_]*";
    var f = c.inherit(c.TM, {b: a});
    var e = {cN: "subst", b: /#\{/, e: /}/, k: b};
    var d = [c.BNM, c.inherit(c.CNM, {starts: {e: "(\\s*/)?", r: 0}}), {
        cN: "string",
        v: [{b: /'''/, e: /'''/, c: [c.BE]}, {b: /'/, e: /'/, c: [c.BE]}, {b: /"""/, e: /"""/, c: [c.BE, e]}, {
            b: /"/,
            e: /"/,
            c: [c.BE, e]
        }]
    }, {
        cN: "regexp",
        v: [{b: "///", e: "///", c: [e, c.HCM]}, {b: "//[gim]*", r: 0}, {b: /\/(?![ *])(\\\/|.)*?\/[gim]*(?=\W|$)/}]
    }, {cN: "property", b: "@" + a}, {b: "`", e: "`", eB: true, eE: true, sL: "javascript"}];
    e.c = d;
    return {
        aliases: ["coffee", "cson", "iced"],
        k: b,
        i: /\/\*/,
        c: d.concat([{cN: "comment", b: "###", e: "###"}, c.HCM, {
            cN: "function",
            b: "(^\\s*|\\B)(" + a + "\\s*=\\s*)?(\\(.*\\))?\\s*\\B[-=]>",
            e: "[-=]>",
            rB: true,
            c: [f, {cN: "params", b: "\\([^\\(]", rB: true, c: [{b: /\(/, e: /\)/, k: b, c: ["self"].concat(d)}]}]
        }, {
            cN: "class",
            bK: "class",
            e: "$",
            i: /[:="\[\]]/,
            c: [{bK: "extends", eW: true, i: /[:="\[\]]/, c: [f]}, f]
        }, {cN: "attribute", b: a + ":", e: ":", rB: true, eE: true, r: 0}])
    }
});
hljs.registerLanguage("json", function (a) {
    var e = {literal: "true false null"};
    var d = [a.QSM, a.CNM];
    var c = {cN: "value", e: ",", eW: true, eE: true, c: d, k: e};
    var b = {
        b: "{",
        e: "}",
        c: [{cN: "attribute", b: '\\s*"', e: '"\\s*:\\s*', eB: true, eE: true, c: [a.BE], i: "\\n", starts: c}],
        i: "\\S"
    };
    var f = {b: "\\[", e: "\\]", c: [a.inherit(c, {cN: null})], i: "\\S"};
    d.splice(d.length, 0, b, f);
    return {c: d, k: e, i: "\\S"}
});