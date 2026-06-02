<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Bed;

class BedController extends Controller
{
    public function addNewBedPopup(Request $req)
    {
        $rooms = Room::withCount('beds')->latest()->get();
        $selectedRoomId = (int) $req->query('room_id', $rooms->first()?->id ?? 0);

        return view('admin.add-new-bed', compact('rooms', 'selectedRoomId'));
    }

    public function editBedPopup(Request $req, Bed $bed)
    {
        $rooms = Room::withCount('beds')->latest()->get();

        return view('admin.edit-new-bed', [
            'rooms' => $rooms,
            'bed' => $bed,
            'selectedRoomId' => (int) $req->query('room_id', $bed->room_id),
        ]);
    }

    /**
     * Menyimpan kasur baru ke dalam kamar tertentu (Sesuai Form Popup Anda)
     */
    public function store(Request $req)
    {
        $validated = $req->validate([
            'room_id'    => 'required|exists:rooms,id',
            'name'       => 'required|string|unique:beds,name|max:255', // Contoh input: SH-B3
            'position'   => 'required|string',                          // Contoh: 1 - Bottom Bed
            'status'     => 'required|string',                          // Contoh: Available
            'base_price' => 'required|numeric|min:0',                   // Contoh: 175000
        ]);

        $validated['is_active'] = $req->has('is_active') ? (bool)$req->input('is_active') : true;

        $bed = Bed::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kasur berhasil ditambahkan ke kamar!',
            'data'    => $bed
        ]);
    }

    /**
     * Memperbarui data kasur
     */
    public function update(Request $req, $id)
    {
        $bed = Bed::findOrFail($id);

        $validated = $req->validate([
            'room_id'    => 'required|exists:rooms,id',
            'name'       => 'required|string|max:255|unique:beds,name,' . $id, // Mengabaikan id kasur ini sendiri
            'position'   => 'required|string',
            'status'     => 'required|string',
            'base_price' => 'required|numeric|min:0',
        ]);

        $validated['is_active'] = $req->has('is_active') ? (bool)$req->input('is_active') : $bed->is_active;

        $bed->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data kasur berhasil diperbarui!',
            'data'    => $bed
        ]);
    }

    /**
     * Menghapus kasur (Soft Delete)
     */
    public function destroy($id)
    {
        $bed = Bed::findOrFail($id);
        $bed->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kasur berhasil dihapus.'
        ]);
    }
}