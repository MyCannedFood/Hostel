<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\ExperienceBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Str;

class AdminExperienceController extends Controller
{
    public function index(): View
    {
        $experiences = Experience::withCount('bookings')->orderBy('created_at', 'desc')->get();
        $bookings    = ExperienceBooking::with('experience')->orderBy('created_at', 'desc')->get();

        return view('admin.experience', compact('experiences', 'bookings'));
    }

    // ── EXPERIENCE CRUD ──

    public function storeExperience(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'category'          => 'required|string|max:255',
            'price'             => 'required|numeric|min:0',
            'inclusions'        => 'nullable|array',
            'time_slots'        => 'nullable|array',
            'cover_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'status'            => 'required|in:Active,Inactive',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $path      = $request->file('cover_image')->store('public/experiences');
            $coverPath = Storage::url($path);
        }

        $experience = Experience::create([
            'name'              => $validated['name'],
            'short_description' => $validated['short_description'] ?? null,
            'category'          => $validated['category'],
            'price'             => $validated['price'],
            'inclusions'        => $validated['inclusions'] ?? [],
            'time_slots'        => $validated['time_slots'] ?? [],
            'cover_image'       => $coverPath,
            'status'            => $validated['status'],
        ]);

        return response()->json(['success' => true, 'experience' => $experience]);
    }

    public function updateExperience(Request $request, Experience $experience): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'category'          => 'required|string|max:255',
            'price'             => 'required|numeric|min:0',
            'inclusions'        => 'nullable|array',
            'time_slots'        => 'nullable|array',
            'cover_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'status'            => 'required|in:Active,Inactive',
        ]);

        $coverPath = $experience->cover_image;
        if ($request->hasFile('cover_image')) {
            if ($experience->cover_image) {
                Storage::delete(str_replace('/storage/', 'public/', $experience->cover_image));
            }
            $path      = $request->file('cover_image')->store('public/experiences');
            $coverPath = Storage::url($path);
        }

        $experience->update([
            'name'              => $validated['name'],
            'short_description' => $validated['short_description'] ?? null,
            'category'          => $validated['category'],
            'price'             => $validated['price'],
            'inclusions'        => $validated['inclusions'] ?? [],
            'time_slots'        => $validated['time_slots'] ?? [],
            'cover_image'       => $coverPath,
            'status'            => $validated['status'],
        ]);

        return response()->json(['success' => true, 'experience' => $experience]);
    }

    public function toggleStatus(Experience $experience): \Illuminate\Http\JsonResponse
    {
        $experience->update([
            'status' => $experience->status === 'Active' ? 'Inactive' : 'Active',
        ]);

        return response()->json(['success' => true, 'status' => $experience->status]);
    }

    public function destroyExperience(Experience $experience): \Illuminate\Http\JsonResponse
    {
        if ($experience->cover_image) {
            Storage::delete(str_replace('/storage/', 'public/', $experience->cover_image));
        }
        $experience->delete();

        return response()->json(['success' => true]);
    }

    // ── BOOKING CRUD ──

    public function storeBooking(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'experience_id'  => 'required|exists:experiences,id',
            'guest_name'     => 'required|string|max:255',
            'guest_email'    => 'nullable|email|max:255',
            'guest_whatsapp' => 'nullable|string|max:255',
            'scheduled_date' => 'required|date',
            'time_slot'      => 'required|string|max:255',
            'guest_count'    => 'required|integer|min:1',
            'special_notes'  => 'nullable|string',
            'total_amount'   => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'payment_status' => 'required|in:Unpaid,Paid',
        ]);

        $booking = ExperienceBooking::create([
            ...$validated,
            'ticket_id' => 'EXP-' . strtoupper(Str::random(6)),
            'user_id'   => null,
            'status'    => 'Awaiting',
        ]);

        return response()->json(['success' => true, 'booking' => $booking->load('experience')]);
    }

    public function updateBooking(Request $request, ExperienceBooking $booking): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'guest_name'     => 'required|string|max:255',
            'guest_email'    => 'nullable|email|max:255',
            'guest_whatsapp' => 'nullable|string|max:255',
            'experience_id'  => 'required|exists:experiences,id',
            'scheduled_date' => 'required|date',
            'time_slot'      => 'required|string|max:255',
            'guest_count'    => 'required|integer|min:1',
            'special_notes'  => 'nullable|string',
        ]);

        $booking->update($validated);

        return response()->json(['success' => true, 'booking' => $booking->load('experience')]);
    }

    public function checkIn(ExperienceBooking $booking): \Illuminate\Http\JsonResponse
    {
        $booking->update(['status' => 'Checked In']);

        return response()->json(['success' => true]);
    }

    public function verifyTicket(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate(['ticket_id' => 'required|string']);

        // Strip # jika ada (user mungkin copy dari tampilan tabel yang ada prefix #)
        $ticketId = ltrim(trim($request->ticket_id), '#');

        $booking = ExperienceBooking::with('experience')
            ->where('ticket_id', $ticketId)
            ->first();

        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Ticket not found.'], 404);
        }

        return response()->json(['success' => true, 'booking' => $booking]);
    }
}