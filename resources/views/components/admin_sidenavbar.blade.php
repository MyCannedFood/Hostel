<aside style="width: 260px; min-height: 100vh; background: #fff; border-right: 1px solid #eee; padding: 16px; box-sizing: border-box; display:flex; flex-direction:column;">
    <div style="display:flex; flex-direction:column; gap: 12px;">
        <div style="display:flex; align-items:center; gap: 12px;">
            <div style="width:40px; height:40px; border-radius:10px; background:#111; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800;">L</div>
        </div>
    </div>

    <nav style="margin-top: 18px; display:flex; flex-direction:column; gap: 10px;">
        <a href="/Admin/Dashboard" style="text-decoration:none; color:#111; font-weight:600; padding: 10px 12px; border-radius: 12px; background: #f7f7f7; display:block;">Dashboard</a>
        <a href="/Admin/Rooms-Management" style="text-decoration:none; color:#111; font-weight:600; padding: 10px 12px; border-radius: 12px; background: transparent; display:block;">Rooms Management</a>
        <a href="/Admin/Manage-Bookings" style="text-decoration:none; color:#111; font-weight:600; padding: 10px 12px; border-radius: 12px; background: transparent; display:block;">Manage Bookings</a>
        <a href="/Admin/Price-Management" style="text-decoration:none; color:#111; font-weight:600; padding: 10px 12px; border-radius: 12px; background: transparent; display:block;">Price Management</a>
        <a href="/Admin/Finance" style="text-decoration:none; color:#111; font-weight:600; padding: 10px 12px; border-radius: 12px; background: transparent; display:block;">Finance</a>
    </nav>

    <div style="margin-top: auto; display:flex; flex-direction:column; gap: 10px;">
        <a href="/" style="text-decoration:none; color:#111; font-weight:600; padding: 10px 12px; border-radius: 12px; background: #f7f7f7; text-align:center;">Back</a>
        <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" style="width: 100%; text-decoration:none; color:#111; font-weight:600; padding: 10px 12px; border-radius: 12px; background: transparent; border:1px solid #eee; text-align:center; cursor: pointer;">Logout</button>
        </form>
    </div>
</aside>

