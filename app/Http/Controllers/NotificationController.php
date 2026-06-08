<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Booking;
use App\Models\ExperienceBooking;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // ──────────────────────────────────────────
    // GET /admin/notifications
    // ──────────────────────────────────────────
    public function index()
    {
        $notification = AdminNotification::active()
            ->latest()
            ->get()
            ->map(function ($notif) {
                $data = $notif->data;

                // Kalau reference sudah dihapus, skip
                if (!$data) return null;

                if ($notif->type === 'booking') {
                    $guest    = $data->guest;
                    $guestName = $guest
                        ? trim($guest->first_name . ' ' . $guest->last_name)
                        : 'Unknown Guest';

                    $notif->card = [
                        'title'    => 'New Room Booking: ' . $guestName,
                        'desc'     => ($data->room->name ?? 'Room') .
                                      ' (' . $data->total_nights . ' nights) — Check-in: ' .
                                      $data->check_in_date->format('M d, Y') .
                                      '. ' . ucfirst(strtolower($data->status)) . '.',
                        'time'     => $data->created_at->diffForHumans(),
                        'modal'    => [
                            'guest_name'    => $guestName,
                            'booking_type'  => $data->room->name ?? '-',
                            'dates'         => $data->check_in_date->format('M d') .
                                               ' – ' . $data->check_out_date->format('M d, Y'),
                            'duration'      => $data->total_nights . ' Nights',
                            'total_price'   => 'IDR ' . number_format($data->total_price, 0, ',', '.'),
                            'special_notes' => $data->special_requests ?? '-',
                            'status'        => $data->status,
                        ],
                    ];

                } else {
                    $exp = $data->experience;

                    $notif->card = [
                        'title' => 'Experience Booking: ' . $data->guest_name,
                        'desc'  => ($exp->name ?? 'Experience') .
                                   ' booked for ' . $data->scheduled_date->format('M d, Y') .
                                   ' at ' . $data->time_slot . '.',
                        'time'  => $data->created_at->diffForHumans(),
                        'modal' => [
                            'guest_name'   => $data->guest_name,
                            'experience'   => $exp->name ?? '-',
                            'datetime'     => $data->scheduled_date->format('M d, Y') .
                                              ', ' . $data->time_slot,
                            'participants' => $data->guest_count . ' People',
                            'status'       => $data->status,
                            'notes'        => $data->special_notes ?? '-',
                        ],
                    ];
                }

                return $notif;
            })
            ->filter() // buang yang null (reference dihapus)
            ->values();

        return view('admin.notification', compact('notification'));
    }

    // ──────────────────────────────────────────
    // PATCH /admin/notifications/{id}/read
    // ──────────────────────────────────────────
    public function markRead($id)
    {
        $notif = AdminNotification::findOrFail($id);
        $notif->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    // ──────────────────────────────────────────
    // PATCH /admin/notifications/read-all
    // ──────────────────────────────────────────
    public function markAllRead()
    {
        AdminNotification::active()
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    // ──────────────────────────────────────────
    // DELETE /admin/notifications/{id}
    // ──────────────────────────────────────────
    public function dismiss($id)
    {
        $notif = AdminNotification::findOrFail($id);
        $notif->update(['is_dismissed' => true]);

        return response()->json(['success' => true]);
    }

    // ──────────────────────────────────────────
    // PATCH /admin/notifications/{id}/confirm
    // ──────────────────────────────────────────
    public function confirm($id)
    {
        $notif = AdminNotification::findOrFail($id);

        if ($notif->type === 'booking') {
            Booking::where('id', $notif->reference_id)
                ->update(['status' => 'CONFIRMED']);

        } elseif ($notif->type === 'experience') {
            ExperienceBooking::where('id', $notif->reference_id)
                ->update(['status' => 'Checked In']);
        }

        // Tandai notif sebagai sudah dibaca setelah dikonfirmasi
        $notif->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}