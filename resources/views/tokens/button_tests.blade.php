<div style="margin-top:16px; display:flex; flex-direction:column; gap:16px;">
  <div>
    <h2 style="margin:0 0 8px; font-size:16px;">PUBLIC (tanpa login)</h2>
    <div style="display:flex; flex-wrap:wrap; gap:8px;">
      @php($items = [
        ['label'=>'Landing: /', 'url'=>'/'],
        ['label'=>'rooms', 'url'=>'/rooms'],
        ['label'=>'rooms/1', 'url'=>'/rooms/1'],
        ['label'=>'rooms/1/beds/2', 'url'=>'/rooms/1/beds/2'],
        ['label'=>'register', 'url'=>'/register'],
        ['label'=>'login', 'url'=>'/login'],
        ['label'=>'forgot-password', 'url'=>'/forgot-password'],
      ])
      @foreach($items as $it)
        <a href="{{ $it['url'] }}" style="padding:8px 10px; border:1px solid #ddd; text-decoration:none; color:#111; background:#fff;">{{ $it['label'] }}</a>
      @endforeach
    </div>
  </div>

  <div>
    <h2 style="margin:0 0 8px; font-size:16px;">AUTH (sementara bisa diakses tanpa login)</h2>
    <div style="display:flex; flex-wrap:wrap; gap:8px;">
      @php($items = [
        ['label'=>'dashboard', 'url'=>'/dashboard'],
        ['label'=>'profile', 'url'=>'/profile'],
        ['label'=>'booking/create/2', 'url'=>'/booking/create/2'],
        ['label'=>'booking/1/payment', 'url'=>'/booking/1/payment'],
        ['label'=>'booking/1/success', 'url'=>'/booking/1/success'],
        ['label'=>'booking/1/failed', 'url'=>'/booking/1/failed'],
        ['label'=>'my-bookings', 'url'=>'/my-bookings'],
        ['label'=>'my-bookings/1', 'url'=>'/my-bookings/1'],
        ['label'=>'notifications', 'url'=>'/notifications'],
      ])
      @foreach($items as $it)
        <a href="{{ $it['url'] }}" style="padding:8px 10px; border:1px solid #ddd; text-decoration:none; color:#111; background:#fff;">{{ $it['label'] }}</a>
      @endforeach
    </div>
  </div>

  <div>
    <h2 style="margin:0 0 8px; font-size:16px;">ADMIN (sementara bisa diakses tanpa role khusus)</h2>
    <div style="display:flex; flex-wrap:wrap; gap:8px;">
      @php($items = [
        ['label'=>'admin/login', 'url'=>'/admin/login'],
        ['label'=>'admin/dashboard', 'url'=>'/admin/dashboard'],
        ['label'=>'admin/rooms', 'url'=>'/admin/rooms'],
        ['label'=>'admin/rooms/create', 'url'=>'/admin/rooms/create'],
        ['label'=>'admin/rooms/1/edit', 'url'=>'/admin/rooms/1/edit'],
        ['label'=>'admin/rooms/1/beds', 'url'=>'/admin/rooms/1/beds'],
        ['label'=>'admin/rooms/1/beds/create', 'url'=>'/admin/rooms/1/beds/create'],
        ['label'=>'admin/beds/1/edit', 'url'=>'/admin/beds/1/edit'],
        ['label'=>'admin/beds/1/pricing', 'url'=>'/admin/beds/1/pricing'],
        ['label'=>'admin/facilities', 'url'=>'/admin/facilities'],
        ['label'=>'admin/facilities/create', 'url'=>'/admin/facilities/create'],
        ['label'=>'admin/beds/1/facilities', 'url'=>'/admin/beds/1/facilities'],
        ['label'=>'admin/bookings', 'url'=>'/admin/bookings'],
        ['label'=>'admin/bookings/1', 'url'=>'/admin/bookings/1'],
        ['label'=>'admin/payments', 'url'=>'/admin/payments'],
        ['label'=>'admin/payments/1', 'url'=>'/admin/payments/1'],
        ['label'=>'admin/logs', 'url'=>'/admin/logs'],
        ['label'=>'admin/refunds', 'url'=>'/admin/refunds'],
        ['label'=>'admin/reports/revenue', 'url'=>'/admin/reports/revenue'],
        ['label'=>'admin/reports/occupancy', 'url'=>'/admin/reports/occupancy'],
        ['label'=>'admin/reviews', 'url'=>'/admin/reviews'],
        ['label'=>'admin/users', 'url'=>'/admin/users'],
        ['label'=>'admin/users/1', 'url'=>'/admin/users/1'],
      ])
      @foreach($items as $it)
        <a href="{{ $it['url'] }}" style="padding:8px 10px; border:1px solid #ddd; text-decoration:none; color:#111; background:#fff;">{{ $it['label'] }}</a>
      @endforeach
    </div>
  </div>

  <div>
    <h2 style="margin:0 0 8px; font-size:16px;">WEBHOOK</h2>
    <div style="display:flex; flex-wrap:wrap; gap:8px;">
      <div style="padding:10px 12px; border:1px dashed #ddd; color:#666; background:#fff;">
        POST /webhook/midtrans (coba pakai curl)
      </div>
    </div>
  </div>
</div>

