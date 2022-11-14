<link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

<link rel="stylesheet" href="{{ asset('Admin-Lte/plugins/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('Admin-Lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('Admin-Lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('Admin-Lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('Admin-Lte\plugins\sweetalert2\sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('Admin-Lte/dist/css/adminlte.min.css?v=3.2.0') }}">
<link rel="stylesheet" href="{{ asset('Admin-Lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('Admin-Lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('Admin-Lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    {{-- <script nonce="ebbc264f-1d92-4319-a1a8-edbcd049ef43">
        (function (w, d) {
            ! function (Z, _, ba, bb) {
                Z.zarazData = Z.zarazData || {};
                Z.zarazData.executed = [];
                Z.zaraz = {
                    deferred: [],
                    listeners: []
                };
                Z.zaraz.q = [];
                Z.zaraz._f = function (bc) {
                    return function () {
                        var bd = Array.prototype.slice.call(arguments);
                        Z.zaraz.q.push({
                            m: bc,
                            a: bd
                        })
                    }
                };
                for (const be of ["track", "set", "debug"]) Z.zaraz[be] = Z.zaraz._f(be);
                Z.zaraz.init = () => {
                    var bf = _.getElementsByTagName(bb)[0],
                        bg = _.createElement(bb),
                        bh = _.getElementsByTagName("title")[0];
                    bh && (Z.zarazData.t = _.getElementsByTagName("title")[0].text);
                    Z.zarazData.x = Math.random();
                    Z.zarazData.w = Z.screen.width;
                    Z.zarazData.h = Z.screen.height;
                    Z.zarazData.j = Z.innerHeight;
                    Z.zarazData.e = Z.innerWidth;
                    Z.zarazData.l = Z.location.href;
                    Z.zarazData.r = _.referrer;
                    Z.zarazData.k = Z.screen.colorDepth;
                    Z.zarazData.n = _.characterSet;
                    Z.zarazData.o = (new Date).getTimezoneOffset();
                    Z.zarazData.q = [];
                    for (; Z.zaraz.q.length;) {
                        const bl = Z.zaraz.q.shift();
                        Z.zarazData.q.push(bl)
                    }
                    bg.defer = !0;
                    for (const bm of [localStorage, sessionStorage]) Object.keys(bm || {}).filter((bo => bo
                        .startsWith("_zaraz_"))).forEach((bn => {
                        try {
                            Z.zarazData["z_" + bn.slice(7)] = JSON.parse(bm.getItem(bn))
                        } catch {
                            Z.zarazData["z_" + bn.slice(7)] = bm.getItem(bn)
                        }
                    }));
                    bg.referrerPolicy = "origin";
                    bg.src = "/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(Z.zarazData)));
                    bf.parentNode.insertBefore(bg, bf)
                };
                ["complete", "interactive"].includes(_.readyState) ? zaraz.init() : Z.addEventListener(
                    "DOMContentLoaded", zaraz.init)
            }(w, d, 0, "script");
        })(window, document);

    </script> --}}