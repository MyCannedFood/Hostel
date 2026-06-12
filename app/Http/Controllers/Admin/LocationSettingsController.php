<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\TransportationInfo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LocationSettingsController extends Controller
{
    // ── Keys that are managed by this controller ──────────────────────────
    private const TEXT_SETTINGS = [
        'address',
        'address_id',
        'phone',
        'public_email',
        'maps_link',
        'contact_form_email',
        'contact_hero_title',
        'contact_hero_title_id',
        'contact_hero_subtitle',
        'contact_hero_subtitle_id',
        'contact_location_title',
        'contact_location_title_id',
        'contact_location_desc',
        'contact_location_desc_id',
    ];

    /**
     * Show the settings partial (rendered inside the admin settings page).
     */
    public function index(): View
    {
        $transports = TransportationInfo::orderBy('sort_order')->orderBy('id')->get();
        $address    = SiteSetting::get('address', 'Jl. Prof. Dr. Sutami No 62, Bandung, Jawa Barat 40152');

        return view('admin.settings.partials.contact-location-settings', [
            'transports'       => $transports,

            'address'          => $address,
            'address_id'       => SiteSetting::get('address_id', $address),

            'phone'            => SiteSetting::get('phone', ''),
            'publicEmail'      => SiteSetting::get('public_email', ''),
            'mapsLink'         => SiteSetting::get('maps_link', ''),
            'contactEmail'     => SiteSetting::get('contact_form_email', ''),

            'heroTitle'        => SiteSetting::get('contact_hero_title',        "We're here for you"),
            'heroTitle_id'     => SiteSetting::get('contact_hero_title_id',     'Kami siap membantu'),

            'heroSubtitle'     => SiteSetting::get('contact_hero_subtitle',
                'Questions, group bookings, collaborations, or just saying hi - we respond to everything within a few hours.'),
            'heroSubtitle_id'  => SiteSetting::get('contact_hero_subtitle_id',
                'Pertanyaan, pemesanan grup, kolaborasi, atau sekadar menyapa — kami membalas semuanya dalam beberapa jam.'),

            'locationTitle'    => SiteSetting::get('contact_location_title',    'Find us in ...'),
            'locationTitle_id' => SiteSetting::get('contact_location_title_id', 'Temukan kami di ...'),

            'locationDesc'     => SiteSetting::get('contact_location_desc',
                "Tucked in a green pocket of Bandung - close to everything that matters, removed from everything that doesn't."),
            'locationDesc_id'  => SiteSetting::get('contact_location_desc_id',
                'Tersembunyi di sudut hijau Bandung — dekat dengan semua yang penting, jauh dari semua yang tidak.'),
        ]);
    }

    /**
     * Save all text / CMS settings (Card 1, 2, 3).
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'address'                    => 'nullable|string|max:500',
            'address_id'                 => 'nullable|string|max:500',
            'phone'                      => 'nullable|string|max:30',
            'public_email'               => 'nullable|email|max:100',
            'maps_link'                  => 'nullable|url|max:2000',
            'contact_email'              => 'nullable|email|max:100',
            'contact_hero_title'         => 'nullable|string|max:120',
            'contact_hero_title_id'      => 'nullable|string|max:120',
            'contact_hero_subtitle'      => 'nullable|string|max:400',
            'contact_hero_subtitle_id'   => 'nullable|string|max:400',
            'contact_location_title'     => 'nullable|string|max:120',
            'contact_location_title_id'  => 'nullable|string|max:120',
            'contact_location_desc'      => 'nullable|string|max:400',
            'contact_location_desc_id'   => 'nullable|string|max:400',
        ]);

        // Map form field names → SiteSetting keys
        // (contact_email in the form maps to contact_form_email in settings)
        $map = [
            'address'                   => 'address',
            'address_id'                => 'address_id',
            'phone'                     => 'phone',
            'public_email'              => 'public_email',
            'maps_link'                 => 'maps_link',
            'contact_email'             => 'contact_form_email',
            'contact_hero_title'        => 'contact_hero_title',
            'contact_hero_title_id'     => 'contact_hero_title_id',
            'contact_hero_subtitle'     => 'contact_hero_subtitle',
            'contact_hero_subtitle_id'  => 'contact_hero_subtitle_id',
            'contact_location_title'    => 'contact_location_title',
            'contact_location_title_id' => 'contact_location_title_id',
            'contact_location_desc'     => 'contact_location_desc',
            'contact_location_desc_id'  => 'contact_location_desc_id',
        ];

        foreach ($map as $field => $key) {
            SiteSetting::set($key, $request->input($field, ''));
        }

        return redirect()
            ->route('admin.settings', ['section' => 'location'])
            ->with('success', 'Settings saved successfully.');
    }

    // ── Transportation CRUD ───────────────────────────────────────────────

    /**
     * Store a new transportation entry.
     */
    public function transportStore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'icon'           => 'required|string|in:car,motorcycle,bus,shuttle,bicycle,walking,boat',
            'title'          => 'required|string|max:100',
            'title_id'       => 'nullable|string|max:100',
            'description'    => 'nullable|string|max:300',
            'description_id' => 'nullable|string|max:300',
            'routes'         => 'nullable|array',
            'routes.*'       => 'nullable|string|max:200',
            'routes_id'      => 'nullable|array',
            'routes_id.*'    => 'nullable|string|max:200',
        ]);

        // Strip empty strings from route arrays
        $data['routes']    = $this->cleanRoutes($request->input('routes', []));
        $data['routes_id'] = $this->cleanRoutes($request->input('routes_id', []));

        TransportationInfo::create($data);

        return redirect()
            ->route('admin.settings', ['section' => 'location'])
            ->with('success', 'Transportation info added.');
    }

    /**
     * Update an existing transportation entry.
     */
    public function transportUpdate(Request $request, TransportationInfo $transportation): RedirectResponse
    {
        $data = $request->validate([
            'icon'           => 'required|string|in:car,motorcycle,bus,shuttle,bicycle,walking,boat',
            'title'          => 'required|string|max:100',
            'title_id'       => 'nullable|string|max:100',
            'description'    => 'nullable|string|max:300',
            'description_id' => 'nullable|string|max:300',
            'routes'         => 'nullable|array',
            'routes.*'       => 'nullable|string|max:200',
            'routes_id'      => 'nullable|array',
            'routes_id.*'    => 'nullable|string|max:200',
        ]);

        $data['routes']    = $this->cleanRoutes($request->input('routes', []));
        $data['routes_id'] = $this->cleanRoutes($request->input('routes_id', []));

        $transportation->update($data);

        return redirect()
            ->route('admin.settings', ['section' => 'location'])
            ->with('success', 'Transportation info updated.');
    }

    /**
     * Delete a transportation entry.
     */
    public function transportDestroy(TransportationInfo $transportation): RedirectResponse
    {
        $transportation->delete();

        return redirect()
            ->route('admin.settings', ['section' => 'location'])
            ->with('success', 'Transportation info deleted.');
    }

    // ── Helpers ───────────────────────────────────────────────────────────

    /**
     * Remove blank entries from a routes array.
     * Returns null if all entries are blank (stores NULL in DB instead of []).
     */
    private function cleanRoutes(array $routes): ?array
    {
        $filtered = array_values(array_filter(
            array_map('trim', $routes),
            fn($v) => $v !== ''
        ));

        return count($filtered) > 0 ? $filtered : null;
    }
}