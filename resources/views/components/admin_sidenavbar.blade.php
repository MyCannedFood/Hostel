<style>
.sidebar {
  background-color: #f4f4ef;
  border-right: 1px solid #c3c9ba4c;
  box-shadow: 4px 0px 24px #1a3d0a0c;
  padding: 0px 24px 24px;
  width: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  position: fixed;
  height: 100vh;
  overflow-y: auto;
  top: 0;
  left: 0;
  z-index: 1000;
}

@media (max-width: 1023.98px) {
  .sidebar {
    width: 280px;
    max-width: 82vw;
    transform: translateX(-100%);
    transition: transform 0.25s ease;
    box-shadow: 12px 0 32px rgba(26, 61, 10, 0.16);
  }

  .sidebar.open {
    transform: translateX(0);
  }
}

@media (min-width: 1024px) {
  .sidebar {
    width: 18%;
    min-width: 250px;
    transform: none;
  }
}

.sidebar-logo {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 28px;
  margin-bottom: 24px;
}

.sidebar-logo img {
  width: 80px;
  height: 80px;
}

.sidebar-logo h1 {
  font-size: 24px;
  font-weight: 400;
  line-height: 42px;
  text-align: center;
  color: #082600;
  margin: 0;
}

@media (min-width: 768px) {
  .sidebar-logo h1 {
    font-size: 32px;
  }
}

.sidebar-logo-subtitle {
  font-size: 10px;
  font-weight: 700;
  line-height: 16px;
  letter-spacing: 1px;
  text-align: center;
  color: #43493e;
  margin-left: 6px;
}

@media (min-width: 768px) {
  .sidebar-logo-subtitle {
    font-size: 12px;
  }
}

.sidebar-menu {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin-right: 12px;
}

.menu-item {
  display: flex;
  align-items: center;
  padding: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.menu-item:hover {
  background-color: #e5e7eb;
}

.menu-item img {
  width: 16px;
  height: 16px;
  margin-left: 8px;
  filter: brightness(0) saturate(100%) invert(0.14) sepia(100%) hue-rotate(89deg) saturate(1.4);
}

.menu-item.active {
  background-color: #1a3d0a;
  border-radius: 4px;
}

.menu-item.active img {
  filter: brightness(0) invert(1);
}

.menu-item.active .menu-text {
  color: #ffffff;
}

.menu-text {
  font-size: 16px;
  font-weight: 700;
  line-height: 25px;
  color: #1a3d0a;
  margin-left: 10px;
}

@media (min-width: 768px) {
  .menu-text {
    font-size: 18px;
  }
}

.sidebar-footer {
  margin-top: auto;
  margin-right: 12px;
}

.admin-profile {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.admin-info {
  display: flex;
  align-items: flex-end;
  gap: 10px;
  border-top: 1px solid #c3c9ba4c;
  padding: 8px;
}

.admin-info img {
  width: 46px;
  height: 46px;
  border-radius: 22px;
  margin-top: 16px;
}

.admin-name {
  font-size: 16px;
  font-weight: 700;
  line-height: 25px;
  color: #1a3d0a;
  margin-bottom: 8px;
}

@media (min-width: 768px) {
  .admin-name {
    font-size: 18px;
  }
}

.logout-btn {
  display: flex;
  align-items: center;
  padding: 0 30px;
  cursor: pointer;
  transition: opacity 0.3s ease;
}

.logout-btn:hover {
  opacity: 0.8;
}

.logout-btn img {
  width: 18px;
  height: 18px;
}

.logout-text {
  font-size: 16px;
  font-weight: 700;
  color: #D9864A;
  margin-left: 10px;
}
</style>

<!-- Sidebar -->
<aside class="sidebar" id="adminSidebar" aria-hidden="false">
    <div>
        <div class="sidebar-logo">
            <img src="{{ asset('images/logo.jpg') }}" alt="AlaSare Logo">
            <h1>AlaSare</h1>
            <p class="sidebar-logo-subtitle">Management</p>
        </div>

        <nav class="sidebar-menu" role="navigation" aria-label="Main navigation">
            <div class="menu-item active" role="menuitem">
                <img src="{{ asset('images/admin/img_icon.svg') }}" alt="" width="16" height="16">
                <span class="menu-text">Dashboard</span>
            </div>
            <div class="menu-item" role="menuitem">
                <img src="{{ asset('images/admin/img_icon_gray_900.svg') }}" alt="" width="22" height="14">
                <span class="menu-text">Room & Bed</span>
            </div>
            <div class="menu-item" role="menuitem">
                <img src="{{ asset('images/admin/img_icon_gray_900_20x18.svg') }}" alt="" width="18" height="20">
                <span class="menu-text">Booking</span>
            </div>
            <div class="menu-item" role="menuitem">
                <img src="{{ asset('images/admin/img_icon_gray_900_16x18.svg') }}" alt="" width="18" height="16">
                <span class="menu-text">Article</span>
            </div>
            <div class="menu-item" role="menuitem">
                <img src="{{ asset('images/admin/img_icon_gray_900_20x20.svg') }}" alt="" width="20" height="20">
                <span class="menu-text">Settings</span>
            </div>
        </nav>
    </div>

    <div class="sidebar-footer">
        <div class="admin-profile">
            <div class="admin-info">
                <img src="{{ asset('images/admin/profile.png') }}" alt="AlaSare Admin profile picture">
                <span class="admin-name">AlaSare Admin</span>
            </div>
            <div class="logout-btn" role="button" tabindex="0">
                <img src="{{ asset('images/admin/img_icon_deep_orange_400.svg') }}" alt="" width="18" height="18">
                <span class="logout-text" style="padding: 0 5px;">  Logout</span>
            </div>
        </div>
    </div>
</aside>

