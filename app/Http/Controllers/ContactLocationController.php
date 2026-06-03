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
    /**
     * Show the public contact & location page.
     */
    public function index(): View
    {
        $transports = TransportationInfo::orderBy('sort_order')->orderBy('id')->get();

        return view('pages.contact-location', [
            'address'     => SiteSetting::get('address', 'Jl. Prof. Dr. Sutami No 62, Bandung, Jawa Barat 40152'),
            'phone'       => SiteSetting::get('phone', ''),
            'publicEmail' => SiteSetting::get('public_email', ''),
            'mapsLink'    => SiteSetting::get('maps_link', ''),
            'transports'  => $transports,
        ]);
    }

    /**
     * Handle the "Drop us a line" form submission.
     */
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