<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Room;
use App\Models\BedPin;

class BedPinController extends Controller
{
    /**
     * Sinkronkan semua pin untuk satu room dari state map saat ini.
     */
    public function syncRoomPins(Request $request, Room $room)
    {
        $validated = $request->validate([
            'pins'                => 'required|array',
            'pins.*.bed_id'       => 'nullable|exists:beds,id',
            'pins.*.point_label'  => 'nullable|string',
            'pins.*.position_top' => 'required|string',
            'pins.*.position_left'=> 'required|string',
        ]);

        DB::transaction(function () use ($room, $validated) {
            $room->bedPins()->delete();

            foreach ($validated['pins'] as $pinData) {
                $room->bedPins()->create([
                    'bed_id'        => $pinData['bed_id'] ?? null,
                    'point_label'   => $pinData['point_label'] ?? null,
                    'position_top'  => $pinData['position_top'],
                    'position_left' => $pinData['position_left'],
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Semua pin denah berhasil disimpan.',
        ]);
    }

    /**
     * Menyimpan titik pin baru saat area gambar denah diklik
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id'       => 'required|exists:rooms,id',
            'bed_id'        => 'nullable|exists:beds,id',
            'point_label'   => 'nullable|string',         // Misal: "1", "2", dll
            'position_top'  => 'required|string',         // Wajib string untuk menampung persentase (misal: 45%)
            'position_left' => 'required|string',
        ]);

        $pin = BedPin::create($validated);

        // Load relasi bed agar data kasur bisa langsung dikembalikan ke frontend
        $pin->load('bed');

        return response()->json([
            'success' => true,
            'message' => 'Titik pin berhasil disimpan.',
            'data'    => $pin
        ]);
    }

    /**
     * Mengaitkan (assign) pin dengan kasur tertentu (Tombol "Save Point")
     */
    public function update(Request $request, $id)
    {
        $pin = BedPin::findOrFail($id);

        $validated = $request->validate([
            'bed_id'      => 'nullable|exists:beds,id',
            'point_label' => 'nullable|string',
        ]);

        $pin->update($validated);
        $pin->load('bed');

        return response()->json([
            'success' => true,
            'message' => 'Informasi pin berhasil diperbarui.',
            'data'    => $pin
        ]);
    }

    /**
     * Menghapus titik pin dari denah
     */
    public function destroy($id)
    {
        $pin = BedPin::findOrFail($id);
        $pin->delete();

        return response()->json([
            'success' => true,
            'message' => 'Titik pin berhasil dihapus.'
        ]);
    }
}