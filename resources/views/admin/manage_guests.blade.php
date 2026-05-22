<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Guests - AlaSare</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/manage_guests.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="dashboard-container">
        <x-admin_sidenavbar />
        <div class="sidebar-backdrop" id="sidebarBackdrop" hidden></div>
    
        <!-- Main content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <button type="button" class="hamburger mobile-only" id="sidebarToggle" aria-label="Open sidebar" aria-controls="adminSidebar" aria-expanded="false">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="header-actions">
                    <img src="{{ asset('images/admin/img_button_trailing.svg') }}" alt="Menu" width="34" height="28">
                    <img src="{{ asset('images/admin/img_button_white_a700.svg') }}" alt="Notifications" width="32" height="36">
                    <img src="{{ asset('images/admin/profile.png') }}" alt="User profile" width="40" height="40">
                </div>
            </header>
      
            <!-- Content area -->
            <div class="content-area">
                
                <div class="guest-dashboard-header">
                    <h1 class="guest-page-title">Dashboard Guest</h1>
                    <button class="btn-add-guest"><span>+</span> Add Guest</button>
                </div>

                <!-- Top Stats -->
                <div class="guest-stats-grid">
                    
                    <!-- Today -->
                    <div class="guest-stat-card">
                        <div class="guest-stat-title">Today</div>
                        <div class="guest-stat-value">18 / 25</div>
                        <div class="guest-stat-sub">Guest</div>
                        <div class="guest-breakdown">
                            <div class="guest-breakdown-item" style="font-weight: bold;"><span>Foreigner</span><span>15 / 50.0%</span></div>
                            <div class="guest-breakdown-item"><span>Asia</span><span>7 / 23.3%</span></div>
                            <div class="guest-breakdown-item"><span>USA/EU/OC</span><span>3 / 10.0%</span></div>
                            <div class="guest-breakdown-item"><span>AF</span><span>4 / 13.3</span></div>
                            <div class="guest-breakdown-item" style="font-weight: bold;"><span>Local</span><span>15 / 50.0%</span></div>
                        </div>
                    </div>

                    <!-- This Week -->
                    <div class="guest-stat-card">
                        <div class="guest-stat-title">This Week</div>
                        <div class="guest-stat-value">50</div>
                        <div class="guest-stat-sub">Guest</div>
                        <div class="guest-breakdown">
                            <div class="guest-breakdown-item" style="font-weight: bold;"><span>Foreigner</span><span>15 / 50.0%</span></div>
                            <div class="guest-breakdown-item"><span>Asia</span><span>7 / 23.3%</span></div>
                            <div class="guest-breakdown-item"><span>USA/EU/OC</span><span>3 / 10.0%</span></div>
                            <div class="guest-breakdown-item"><span>AF</span><span>4 / 13.3</span></div>
                            <div class="guest-breakdown-item" style="font-weight: bold;"><span>Local</span><span>15 / 50.0%</span></div>
                        </div>
                    </div>

                    <!-- This Month -->
                    <div class="guest-stat-card">
                        <div class="guest-stat-title">This Month</div>
                        <div class="guest-stat-value">90</div>
                        <div class="guest-stat-sub">Guest</div>
                        <div class="guest-breakdown">
                            <div class="guest-breakdown-item" style="font-weight: bold;"><span>Foreigner</span><span>15 / 50.0%</span></div>
                            <div class="guest-breakdown-item"><span>Asia</span><span>7 / 23.3%</span></div>
                            <div class="guest-breakdown-item"><span>USA/EU/OC</span><span>3 / 10.0%</span></div>
                            <div class="guest-breakdown-item"><span>AF</span><span>4 / 13.3</span></div>
                            <div class="guest-breakdown-item" style="font-weight: bold;"><span>Local</span><span>15 / 50.0%</span></div>
                        </div>
                    </div>

                    <!-- Check In/Out -->
                    <div class="guest-stat-card-split">
                        <div class="split-item">
                            <div class="split-value">7</div>
                            <button type="button" class="split-label split-label-btn" data-guest-action="checkout">Check-out</button>
                        </div>
                        <div class="split-item">
                            <div class="split-value">25</div>
                            <button type="button" class="split-label split-label-btn" data-guest-action="checkin">Check-in</button>
                        </div>
                    </div>

                </div>

                <!-- Middle Section -->
                <div class="guest-middle-grid">
                    
                    <!-- Guest List -->
                    <div class="guest-list-card">
                        <div class="guest-list-header">
                            <div class="guest-list-title">Guest list</div>
                            <div class="guest-search">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#43493e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                <input type="text" placeholder="Search Guest">
                            </div>
                        </div>
                        <div style="overflow-x: auto;">
                            <table class="guest-table">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Guest Name</th>
                                        <th>Country</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>BK-2026-1042</td>
                                        <td>Aria Kusuma</td>
                                        <td>Indonesia</td>
                                    </tr>
                                    <tr>
                                        <td>BK-2026-1042</td>
                                        <td>Aria Kusuma</td>
                                        <td>Indonesia</td>
                                    </tr>
                                    <tr>
                                        <td>BK-2026-1042</td>
                                        <td>Aria Kusuma</td>
                                        <td>Indonesia</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Guests per Room -->
                    <div class="guests-room-card">
                        <div class="guests-room-title">Guests per Room</div>
                        
                        <div class="room-item">
                            <div>
                                <div class="room-info-name">Serene Heaven</div>
                                <div class="room-info-details">Top 3/4<br>Bottom 4/4</div>
                            </div>
                            <div class="room-count">7</div>
                        </div>

                        <div class="room-item">
                            <div>
                                <div class="room-info-name">Botanice</div>
                                <div class="room-info-details">Top 3/4<br>Bottom 4/4</div>
                            </div>
                            <div class="room-count">7</div>
                        </div>

                        <div class="room-item">
                            <div>
                                <div class="room-info-name">The Heritage</div>
                                <div class="room-info-details">Top 3/4<br>Bottom 4/4</div>
                            </div>
                            <div class="room-count">7</div>
                        </div>
                    </div>

                    <!-- Guest Trend -->
                    <div class="guest-trend-card">
                        <div class="guest-trend-header">
                            <div class="guest-trend-title">Guest Trend</div>
                            <select class="trend-dropdown">
                                <option>Days</option>
                                <option>Weeks</option>
                            </select>
                        </div>
                        <div class="guest-trend-chart">
                            <canvas id="guestTrendChart"></canvas>
                        </div>
                    </div>

                </div>
                
            </div>
        </main>
    </div>

    <!-- Guest Check-in / Check-out Modal -->
    <div class="guest-action-overlay" id="guestActionOverlay" hidden>
        <div class="guest-action-modal" id="guestActionModal" role="dialog" aria-modal="true" aria-labelledby="guestActionTitle">
            <div class="guest-action-modal-header">
                <h2 class="guest-action-modal-title" id="guestActionTitle">Guest Check-in</h2>
                <button type="button" class="guest-action-close" id="guestActionClose" aria-label="Close">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Step 1: Search booking -->
            <div class="guest-action-step" id="guestActionStepSearch">
                <label class="guest-action-label" for="guestBookingId">Input Booking ID</label>
                <div class="guest-action-search-row">
                    <input type="text" id="guestBookingId" class="guest-action-input" placeholder="" autocomplete="off">
                    <button type="button" class="guest-action-search-btn" id="guestActionSearch">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <span>Search</span>
                    </button>
                </div>
            </div>

            <!-- Step 2a: Check-in form -->
            <div class="guest-action-step guest-action-step-checkin" id="guestActionStepCheckin" hidden>
                <p class="guest-action-booking-ref" id="guestActionBookingRef">BK-2026-1042</p>
                <div class="guest-action-form-scroll">
                    <x-admin_guest_details_form />
                </div>
                <div class="guest-action-form-footer">
                    <button type="button" class="guest-action-btn-back" id="guestActionFormBack">Back</button>
                    <button type="button" class="guest-action-btn-done" id="guestActionFormDone">Done</button>
                </div>
            </div>

            <!-- Step 2b: Check-out form -->
            <div class="guest-action-step guest-action-step-checkout" id="guestActionStepCheckout" hidden>
                <div class="guest-action-form-scroll">
                    <x-admin_guest_checkout_form />
                </div>
                <div class="guest-action-form-footer">
                    <button type="button" class="guest-action-btn-back" id="guestCheckoutFormBack">Back</button>
                    <button type="button" class="guest-action-btn-done" id="guestCheckoutFormDone">Done</button>
                </div>
            </div>
        </div>
    </div>
  
    <script>
        // Sidebar Logic
        const sidebar = document.getElementById('adminSidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');

        function setSidebarOpen(isOpen) {
            if (!sidebar || !sidebarToggle || !sidebarBackdrop) {
                return;
            }
            sidebar.classList.toggle('open', isOpen);
            sidebarBackdrop.hidden = !isOpen;
            document.body.classList.toggle('sidebar-open', isOpen);
            sidebarToggle.setAttribute('aria-expanded', String(isOpen));
            sidebarToggle.setAttribute('aria-label', isOpen ? 'Close sidebar' : 'Open sidebar');
        }

        if (sidebarToggle && sidebarBackdrop && sidebar) {
            sidebarToggle.addEventListener('click', function () {
                setSidebarOpen(!sidebar.classList.contains('open'));
            });
            sidebarBackdrop.addEventListener('click', function () {
                setSidebarOpen(false);
            });
            window.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !document.getElementById('guestActionOverlay')?.classList.contains('is-open')) {
                    setSidebarOpen(false);
                }
            });
            window.addEventListener('resize', function () {
                if (window.innerWidth >= 1024) setSidebarOpen(false);
            });
        }

        // Guest Check-in / Check-out Modal
        const guestActionOverlay = document.getElementById('guestActionOverlay');
        const guestActionModal = document.getElementById('guestActionModal');
        const guestActionTitle = document.getElementById('guestActionTitle');
        const guestActionClose = document.getElementById('guestActionClose');
        const guestBookingId = document.getElementById('guestBookingId');
        const guestActionSearch = document.getElementById('guestActionSearch');
        const guestActionStepSearch = document.getElementById('guestActionStepSearch');
        const guestActionStepCheckin = document.getElementById('guestActionStepCheckin');
        const guestActionStepCheckout = document.getElementById('guestActionStepCheckout');
        const guestActionBookingRef = document.getElementById('guestActionBookingRef');
        const guestActionFormBack = document.getElementById('guestActionFormBack');
        const guestActionFormDone = document.getElementById('guestActionFormDone');
        const guestCheckoutFormBack = document.getElementById('guestCheckoutFormBack');
        const guestCheckoutFormDone = document.getElementById('guestCheckoutFormDone');
        const guestActionLabels = document.querySelectorAll('.split-label-btn');

        let currentGuestAction = 'checkin';

        const guestActionTitles = {
            checkin: 'Guest Check-in',
            checkout: 'Guest Check-out',
        };

        function showGuestActionSearchStep() {
            guestActionStepSearch?.removeAttribute('hidden');
            guestActionStepCheckin?.setAttribute('hidden', '');
            guestActionStepCheckout?.setAttribute('hidden', '');
            guestActionModal?.classList.remove('is-form-step', 'is-checkout-step');
            guestActionTitle?.removeAttribute('hidden');
        }

        const adminGuestTabs = document.querySelectorAll('.admin-guest-tab');
        const adminTabIdCard = document.getElementById('adminTabIdCard');
        const adminTabDeposit = document.getElementById('adminTabDeposit');

        function setAdminGuestTab(tabName) {
            const isDeposit = tabName === 'deposit';
            adminGuestTabs.forEach(function (tab) {
                const isActive = tab.dataset.tab === tabName;
                tab.classList.toggle('active', isActive);
                tab.setAttribute('aria-selected', String(isActive));
            });
            adminTabIdCard?.classList.toggle('active', !isDeposit);
            adminTabDeposit?.classList.toggle('active', isDeposit);
            if (isDeposit) {
                adminTabIdCard?.setAttribute('hidden', '');
                adminTabDeposit?.removeAttribute('hidden');
            } else {
                adminTabIdCard?.removeAttribute('hidden');
                adminTabDeposit?.setAttribute('hidden', '');
            }
        }

        adminGuestTabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                setAdminGuestTab(tab.dataset.tab);
            });
        });

        function showGuestActionCheckinStep(bookingId) {
            setAdminGuestTab('id-card');
            if (guestActionBookingRef) {
                guestActionBookingRef.textContent = bookingId;
            }
            guestActionStepSearch?.setAttribute('hidden', '');
            guestActionStepCheckout?.setAttribute('hidden', '');
            guestActionStepCheckin?.removeAttribute('hidden');
            guestActionModal?.classList.add('is-form-step');
            guestActionModal?.classList.remove('is-checkout-step');
            guestActionTitle?.setAttribute('hidden', '');
            document.getElementById('admin_first_name')?.focus();
        }

        function showGuestActionCheckoutStep(bookingId) {
            resetCheckoutForm();
            guestActionStepSearch?.setAttribute('hidden', '');
            guestActionStepCheckin?.setAttribute('hidden', '');
            guestActionStepCheckout?.removeAttribute('hidden');
            guestActionModal?.classList.add('is-form-step', 'is-checkout-step');
            guestActionTitle?.removeAttribute('hidden');
            guestActionTitle.textContent = guestActionTitles.checkout;
            document.getElementById('checkout_notes')?.focus();
            // TODO: load booking payment data from API for bookingId
        }

        function openGuestActionModal(action) {
            if (!guestActionOverlay || !guestActionTitle) return;
            currentGuestAction = action || 'checkin';
            guestActionTitle.textContent = guestActionTitles[currentGuestAction] || 'Guest Check-in';
            guestActionTitle.removeAttribute('hidden');
            showGuestActionSearchStep();
            guestActionOverlay.hidden = false;
            guestActionOverlay.classList.add('is-open');
            document.body.classList.add('guest-action-open');
            if (guestBookingId) {
                guestBookingId.value = '';
                guestBookingId.focus();
            }
        }

        function closeGuestActionModal() {
            if (!guestActionOverlay) return;
            guestActionOverlay.classList.remove('is-open');
            guestActionOverlay.hidden = true;
            document.body.classList.remove('guest-action-open');
            showGuestActionSearchStep();
        }

        function handleGuestActionSearch() {
            const bookingId = guestBookingId?.value.trim();
            if (!bookingId) {
                guestBookingId?.focus();
                return;
            }

            if (currentGuestAction === 'checkin') {
                showGuestActionCheckinStep(bookingId);
                return;
            }

            showGuestActionCheckoutStep(bookingId);
        }

        guestActionLabels.forEach(function (btn) {
            btn.addEventListener('click', function () {
                openGuestActionModal(btn.dataset.guestAction);
            });
        });

        guestActionClose?.addEventListener('click', closeGuestActionModal);
        guestActionFormBack?.addEventListener('click', showGuestActionSearchStep);
        guestCheckoutFormBack?.addEventListener('click', showGuestActionSearchStep);

        guestActionFormDone?.addEventListener('click', function () {
            // TODO: submit check-in data to API
            closeGuestActionModal();
        });

        guestCheckoutFormDone?.addEventListener('click', function () {
            // TODO: submit check-out data to API
            closeGuestActionModal();
        });

        // Check-out: additional charges & status
        const checkoutChargesList = document.getElementById('checkoutChargesList');
        const checkoutChargeDesc = document.getElementById('checkout_charge_desc');
        const checkoutChargeNominal = document.getElementById('checkout_charge_nominal');
        const checkoutAddCharge = document.getElementById('checkoutAddCharge');
        const checkoutRefunded = document.getElementById('checkoutRefunded');
        const checkoutStatus = document.getElementById('checkout_status');
        const checkoutNotes = document.getElementById('checkout_notes');

        const CHECKOUT_DEPOSIT = 200000;

        function formatIdr(amount) {
            return 'IDR ' + Math.max(0, Math.round(amount)).toLocaleString('id-ID');
        }

        function parseNominal(value) {
            const digits = String(value).replace(/\D/g, '');
            return digits ? parseInt(digits, 10) : 0;
        }

        function getCheckoutExtraChargesTotal() {
            let total = 0;
            checkoutChargesList?.querySelectorAll('.admin-checkout-charge-item').forEach(function (item) {
                total += parseInt(item.dataset.amount, 10) || 0;
            });
            return total;
        }

        function updateCheckoutRefunded() {
            const refunded = CHECKOUT_DEPOSIT - getCheckoutExtraChargesTotal();
            if (checkoutRefunded) {
                checkoutRefunded.textContent = formatIdr(refunded);
            }
        }

        function resetCheckoutForm() {
            if (checkoutChargesList) checkoutChargesList.innerHTML = '';
            if (checkoutChargeDesc) checkoutChargeDesc.value = '';
            if (checkoutChargeNominal) checkoutChargeNominal.value = '';
            if (checkoutNotes) checkoutNotes.value = '';
            if (checkoutStatus) {
                checkoutStatus.value = 'safe';
                checkoutStatus.classList.remove('is-blacklist');
            }
            updateCheckoutRefunded();
        }

        function addCheckoutCharge(desc, amount) {
            if (!checkoutChargesList || !desc || amount <= 0) return;
            const li = document.createElement('li');
            li.className = 'admin-checkout-charge-item';
            li.dataset.amount = String(amount);

            const chargeMain = document.createElement('div');
            chargeMain.className = 'admin-checkout-charge-main';

            const chargeDesc = document.createElement('span');
            chargeDesc.className = 'admin-checkout-charge-desc';
            chargeDesc.textContent = desc;

            const chargeAmount = document.createElement('span');
            chargeAmount.className = 'admin-checkout-charge-amount';
            chargeAmount.textContent = '-IDR ' + amount.toLocaleString('id-ID');

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'admin-checkout-charge-remove';
            removeButton.innerHTML = '<span aria-hidden="true">✕</span> Close';
            removeButton.setAttribute('aria-label', 'Remove ' + desc);
            removeButton.addEventListener('click', function () {
                li.remove();
                updateCheckoutRefunded();
            });

            chargeMain.append(chargeDesc, chargeAmount);
            li.append(chargeMain, removeButton);
            checkoutChargesList.appendChild(li);
            updateCheckoutRefunded();
        }

        checkoutAddCharge?.addEventListener('click', function () {
            const desc = checkoutChargeDesc?.value.trim();
            const amount = parseNominal(checkoutChargeNominal?.value);
            if (!desc || amount <= 0) {
                (desc ? checkoutChargeNominal : checkoutChargeDesc)?.focus();
                return;
            }
            addCheckoutCharge(desc, amount);
            if (checkoutChargeDesc) checkoutChargeDesc.value = '';
            if (checkoutChargeNominal) checkoutChargeNominal.value = '';
        });

        checkoutStatus?.addEventListener('change', function () {
            checkoutStatus.classList.toggle('is-blacklist', checkoutStatus.value === 'blacklist');
        });

        guestActionOverlay?.addEventListener('click', function (event) {
            if (event.target === guestActionOverlay) {
                closeGuestActionModal();
            }
        });

        guestActionSearch?.addEventListener('click', handleGuestActionSearch);

        guestBookingId?.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                handleGuestActionSearch();
            }
        });

        document.querySelectorAll('.admin-guest-upload-area input[type="file"]').forEach(function (input) {
            input.addEventListener('change', function () {
                const area = input.closest('.admin-guest-upload-area');
                const hint = area?.querySelector('.admin-guest-upload-hint');
                if (hint && input.files?.[0]) {
                    hint.textContent = input.files[0].name;
                }
            });
        });

        window.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && guestActionOverlay?.classList.contains('is-open')) {
                const onFormStep = (guestActionStepCheckin && !guestActionStepCheckin.hasAttribute('hidden'))
                    || (guestActionStepCheckout && !guestActionStepCheckout.hasAttribute('hidden'));
                if (onFormStep) {
                    showGuestActionSearchStep();
                    return;
                }
                closeGuestActionModal();
            }
        });

        // Guest Trend Chart
        const trendCtx = document.getElementById('guestTrendChart')?.getContext('2d');
        if (trendCtx) {
            new Chart(trendCtx, {
                type: 'bar',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        data: [7, 12, 5, 17, 20, 18, 10],
                        backgroundColor: '#29A4A1',
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            grid: { display: false }
                        },
                        y: {
                            beginAtZero: true,
                            max: 20,
                            grid: { display: false },
                            ticks: {
                                stepSize: 5
                            }
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>
