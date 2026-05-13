<nav style="width: 100%; background: #fff; padding: 12px 24px; box-sizing: border-box;">
    <div style="display:flex; align-items:center; justify-content:space-between; gap: 16px;">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="width:32px; height:32px; border-radius: 8px; background:#111; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700;">L</div>
        </div>

        <div style="display:flex; align-items:center; gap: 22px;">
            <a href="/" style="text-decoration:none; color:#111; font-size:14px;">Home</a>
            <a href="/rooms" style="text-decoration:none; color:#111; font-size:14px;">Rooms</a>
            <a href="/gallery" style="text-decoration:none; color:#111; font-size:14px;">Gallery</a>
            <a href="/experience" style="text-decoration:none; color:#111; font-size:14px;">Experience</a>
        </div>

        <div style="display:flex; align-items:center; gap: 12px;">
            <!-- State: belum login -->
            <button id="navbarLoginBtn" type="button" style="border:0; background:transparent; cursor:pointer; padding: 6px 10px; font-size:14px; color:#111;">
                Login
            </button>

            <!-- State: sudah login (disembunyikan dulu) -->
            <div id="navbarLoggedIn" style="display:none; align-items:center; gap: 8px;">
                <!-- Tombol lonceng: buka popup notifikasi -->
                <button id="navbarBellBtn" type="button" title="Notifications" style="border:0; background:transparent; cursor:pointer; padding: 6px; display:flex; align-items:center;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 8a6 6 0 10-12 0c0 7-3 7-3 7h18s-3 0-3-7" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M13.73 21a2 2 0 01-3.46 0" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <!-- Link profile: navigasi langsung -->
                <a href="/profile" style="text-decoration:none; color:#111; font-size:14px;">Profile</a>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const loginBtn       = document.getElementById('navbarLoginBtn');
            const loggedInGroup  = document.getElementById('navbarLoggedIn');
            const bellBtn        = document.getElementById('navbarBellBtn');

            if (!loginBtn || !loggedInGroup || !bellBtn) return;

            // Fungsi untuk set tampilan navbar sesuai state login
            function setLoggedIn(val) {
                if (val) {
                    localStorage.setItem('navbar_loggedin', '1');
                    loginBtn.style.display      = 'none';
                    loggedInGroup.style.display = 'flex';
                } else {
                    localStorage.removeItem('navbar_loggedin');
                    loginBtn.style.display      = '';
                    loggedInGroup.style.display = 'none';
                }
            }

            // Cek localStorage saat halaman dimuat → restore state login
            if (localStorage.getItem('navbar_loggedin') === '1') {
                setLoggedIn(true);
            }

            // Klik Login → simpan state & tampilkan grup lonceng + profile
            loginBtn.addEventListener('click', function () {
                setLoggedIn(true);
            });

            // Klik lonceng → buka popup notifikasi
            bellBtn.addEventListener('click', openPopup);

            /* ── Popup notifikasi ── */
            let popupEl  = null;
            let popupOpen = false;

            function closePopup() {
                if (popupEl) popupEl.style.display = 'none';
                popupOpen = false;
            }

            function openPopup() {
                if (popupOpen) return;
                popupOpen = true;

                if (!popupEl) {
                    popupEl = document.createElement('div');
                    popupEl.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,0.35);display:flex;align-items:center;justify-content:center;z-index:9999;';

                    popupEl.innerHTML = `
                        <div style="background:#fff; width:min(520px,92vw); border-radius:14px; padding:18px; box-sizing:border-box;">
                            <div style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
                                <div style="font-weight:700;">Notification</div>
                                <button type="button" id="navbarPopupCloseBtn" style="border:1px solid #ddd; background:#fff; cursor:pointer; padding:6px 10px; border-radius:10px;">✕</button>
                            </div>
                            <div style="margin-top:14px; padding:12px; border:1px solid #eee; border-radius:12px; color:#111;">
                                Notification
                            </div>
                        </div>
                    `;

                    document.body.appendChild(popupEl);

                    popupEl.querySelector('#navbarPopupCloseBtn')
                           .addEventListener('click', closePopup);

                    // Klik backdrop → tutup popup
                    popupEl.addEventListener('click', function (e) {
                        if (e.target === popupEl) closePopup();
                    });
                }

                popupEl.style.display = 'flex';
            }

        })();
    </script>
</nav>