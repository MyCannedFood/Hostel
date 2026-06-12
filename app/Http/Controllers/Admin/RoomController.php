<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Bed;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function addNewRoomPopup()
    {
        $roomTypes = ['Male', 'Female', 'Mixed'];
        $statuses = ['Available', 'Maintenance', 'Closed'];

        return view('admin.partials.add-room-modal', compact('roomTypes', 'statuses'));
    }

    public function editRoomPopup(Room $room)
    {
        return view('admin.edit-new-room-full', compact('room'));
    }

    public function store(Request $req)
    {
        $validated = $req->validate([
            'name'            => 'required|string|max:255',
            'gender_type'     => 'required|in:Male,Female,Mixed',
            'capacity'        => 'required|integer|min:1',
            'description'     => 'nullable|string',
            'description_id'  => 'nullable|string',
            'status'          => 'required|string',
            'photo'           => 'nullable|image|max:5120',
            'attributes'      => 'nullable|array',
            'attributes_id'   => 'nullable|array',
            'main_facilities' => 'nullable|array',
            'beds'            => 'nullable|array',
        ]);

        if ($req->hasFile('photo')) {
            $path = $req->file('photo')->store('rooms', 'public');
            $validated['photo'] = $path;
        }

        $validated['attributes'] = isset($validated['attributes'])
            ? implode(',', array_filter($validated['attributes']))
            : null;

        $validated['attributes_id'] = isset($validated['attributes_id'])
            ? implode(',', array_filter($validated['attributes_id']))
            : null;

        $validated['main_facilities'] = isset($validated['main_facilities'])
            ? implode(',', array_filter($validated['main_facilities']))
            : null;

        $beds = $req->input('beds');
        unset($validated['beds']);

        $room = Room::create($validated);

        if (!empty($beds)) {
            foreach ($beds as $b) {
                $b['room_id'] = $room->id;
                Bed::create($b);
            }
        }

        return response()->json([
            'success' => true,
            'data'    => $room->load('beds')
        ]);
    }

    public function update(Request $req, Room $room)
    {
        $validated = $req->validate([
            'name'            => 'required|string|max:255',
            'gender_type'     => 'required|in:Male,Female,Mixed',
            'capacity'        => 'required|integer|min:1',
            'description'     => 'nullable|string',
            'description_id'  => 'nullable|string',
            'status'          => 'required|string',
            'photo'           => 'nullable|image|max:5120',
            'attributes'      => 'nullable|array',
            'attributes_id'   => 'nullable|array',
            'main_facilities' => 'nullable|array',
        ]);

        if ($req->hasFile('photo')) {
            if ($room->photo) {
                Storage::disk('public')->delete($room->photo);
            }
            $validated['photo'] = $req->file('photo')->store('rooms', 'public');
        }

        $validated['attributes'] = isset($validated['attributes'])
            ? implode(',', array_filter($validated['attributes']))
            : null;

        $validated['attributes_id'] = isset($validated['attributes_id'])
            ? implode(',', array_filter($validated['attributes_id']))
            : null;

        $validated['main_facilities'] = isset($validated['main_facilities'])
            ? implode(',', array_filter($validated['main_facilities']))
            : null;

        if (!isset($validated['base_price']) || is_null($validated['base_price'])) {
            $validated['base_price'] = $room->base_price ?? 0;
        }

        if (!isset($validated['type']) || trim((string) $validated['type']) === '') {
            $validated['type'] = $room->type ?: 'Standard';
        }

        if (!isset($validated['floor']) || is_null($validated['floor'])) {
            $validated['floor'] = $room->floor ?: 1;
        }

        $room->update($validated);

        return response()->json([
            'success' => true,
            'data'    => $room->fresh()->load('beds'),
        ]);
    }

    public function destroy(Room $room)
    {
        if ($room->photo) {
            Storage::disk('public')->delete($room->photo);
        }

        $room->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    public function uploadLayout(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $request->validate([
            'layout_photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($room->layout_photo && Storage::disk('public')->exists($room->layout_photo)) {
            Storage::disk('public')->delete($room->layout_photo);
        }

        $path = $request->file('layout_photo')->store('room_layouts', 'public');
        $room->update(['layout_photo' => $path]);

        return response()->json([
            'success'    => true,
            'message'    => 'Foto denah berhasil diunggah!',
            'layout_url' => asset('storage/' . $path)
        ]);
    }
}