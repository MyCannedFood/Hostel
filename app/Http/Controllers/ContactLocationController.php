<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use App\Models\ContactMessage;
use App\Models\SiteSetting;
use App\Models\TransportationInfo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactLocationController extends Controller
{

    public function index(): View
    {
        $transports = TransportationInfo::orderBy('sort_order')->orderBy('id')->get();
        $address    = SiteSetting::get('address', 'Jl. Prof. Dr. Sutami No 62, Bandung, Jawa Barat 40152');

        return view('pages.contact-location', [
            'address'     => $address,
            'phone'       => SiteSetting::get('phone', ''),
            'publicEmail' => SiteSetting::get('public_email', ''),
            'mapsLink'    => static::toMapsEmbedUrl(SiteSetting::get('maps_link', ''), $address),
            'transports'  => $transports,
        ]);
    }

    private static function toMapsEmbedUrl(?string $url, string $fallbackAddress): string
    {
        if (empty($url)) {
            return 'https://www.google.com/maps?q=' . urlencode($fallbackAddress) . '&output=embed';
        }

        if (str_contains($url, 'output=embed')) {
            return $url;
        }

        $parsed = parse_url($url);

        if (isset($parsed['host']) && str_contains($parsed['host'], 'google.com') && str_contains($parsed['path'] ?? '', '/maps/')) {
            if (preg_match('#/maps/place/([^/@]+)#', $parsed['path'], $m)) {
                return 'https://www.google.com/maps?q=' . urlencode(urldecode($m[1])) . '&output=embed';
            }

            parse_str($parsed['query'] ?? '', $qp);
            if (!empty($qp['q'])) {
                return 'https://www.google.com/maps?q=' . urlencode($qp['q']) . '&output=embed';
            }

            if (preg_match('#@(-?\d+\.\d+),(-?\d+\.\d+)#', $url, $m)) {
                return 'https://www.google.com/maps?q=' . $m[1] . ',' . $m[2] . '&output=embed';
            }
        }

        return $url;
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:100',
            'email'        => 'required|email|max:100',
            'country_code' => 'nullable|string|max:10',
            'phone'        => 'nullable|string|max:20',
            'message'      => 'required|string|max:2000',
        ]);

        // Save to DB
        $msg = ContactMessage::create($validated);

        // Send email notification
        $receiverEmail = SiteSetting::get('contact_form_email', config('mail.from.address'));
        Mail::to($receiverEmail)->send(new ContactFormMail($msg));

        return redirect()->route('contact')
            ->with('success', 'Your message has been sent! We will get back to you shortly.');
    }
}