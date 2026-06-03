<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\TransportationInfo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

    class AdminContactLocationSettingController extends Controller
    {
        /**
         * Show the settings page.
         */
    public function index(): View
    {
        $transports = TransportationInfo::orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.settings.settings', [
            'section'      => 'location', // tambah ini
            'address'      => SiteSetting::get('address', ''),
            'phone'        => SiteSetting::get('phone', ''),
            'publicEmail'  => SiteSetting::get('public_email', ''),
            'mapsLink'     => SiteSetting::get('maps_link', ''),
            'contactEmail' => SiteSetting::get('contact_form_email', ''),
            'transports'   => $transports,
        ]);
    }

    /**
     * Save contact/system settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'address'       => 'required|string|max:500',
            'phone'         => 'required|string|max:30',
            'public_email'  => 'required|email|max:100',
            'maps_link'     => 'nullable|url|max:500',
            'contact_email' => 'required|email|max:100',
        ]);

        SiteSetting::setMany([
            'address'            => $validated['address'],
            'phone'              => $validated['phone'],
            'public_email'       => $validated['public_email'],
            'maps_link'          => $validated['maps_link'] ?? '',
            'contact_form_email' => $validated['contact_email'],
        ]);

       return redirect()->route('admin.settings', ['section' => 'location'])
            ->with('success', 'Settings saved successfully!');
    }

    // ── Transportation CRUD ────────────────────────────────────────────────

    public function storeTransport(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'icon'        => 'required|string|max:30',
            'title'       => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'routes'      => 'nullable|array',
            'routes.*'    => 'nullable|string|max:100',
        ]);

        TransportationInfo::create([
            'icon'        => $validated['icon'],
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'routes'      => array_values(array_filter($validated['routes'] ?? [])),
            'sort_order'  => TransportationInfo::max('sort_order') + 1,
        ]);

        return redirect()->route('admin.settings', ['section' => 'location'])
            ->with('success', 'Transportation info added.');
    }

    public function updateTransport(Request $request, TransportationInfo $transport): RedirectResponse
    {
        $validated = $request->validate([
            'icon'        => 'required|string|max:30',
            'title'       => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'routes'      => 'nullable|array',
            'routes.*'    => 'nullable|string|max:100',
        ]);

        $transport->update([
            'icon'        => $validated['icon'],
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'routes'      => array_values(array_filter($validated['routes'] ?? [])),
        ]);

        return redirect()->route('admin.settings', ['section' => 'location'])
            ->with('success', 'Transportation info updated.');
    }

    public function destroyTransport(TransportationInfo $transport): RedirectResponse
    {
        $transport->delete();

        return redirect()->route('admin.settings', ['section' => 'location'])
            ->with('success', 'Transportation info deleted.');
    }
}