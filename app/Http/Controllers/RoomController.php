<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Bed;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('beds')
            ->where('is_active', true)
            ->where('status', 'Available')
            ->latest()
            ->get();

        $roomPhoto = function ($room) {
            if (!$room->photo) return null;
            return str_starts_with($room->photo, 'images/')
                ? asset($room->photo)
                : asset('storage/' . $room->photo);
        };

        $genderLabel = fn ($room) => match(strtolower($room->gender_type ?? 'mixed')) {
            'female' => 'Female Only',
            'male'   => 'Male Only',
            default  => 'Mixed',
        };

        $genderLabelId = fn ($room) => match(strtolower($room->gender_type ?? 'mixed')) {
            'female' => 'Khusus Perempuan',
            'male'   => 'Khusus Laki-laki',
            default  => 'Campur',
        };

        $roomData = $rooms->map(function ($room) use ($roomPhoto, $genderLabel, $genderLabelId) {
            $totalBeds = $room->beds->count();
            $availableBeds = $room->beds->where('is_active', true)->count();
            $availabilityPercentage = $totalBeds > 0 ? ($availableBeds / $totalBeds) * 100 : 0;
            $isSoldOut = $availableBeds === 0;

            return [
                'id' => $room->id,
                'name' => $room->name,
                'photo' => $roomPhoto($room),
                'gender_type' => $room->gender_type,
                'gender_label' => $genderLabel($room),
                'gender_label_id' => $genderLabelId($room),
                'capacity' => $room->capacity,
                'description' => $room->description,
                'description_id'   => $room->description_id ?: $room->description,
                'attributes' => $room->attributes ? explode(',', $room->attributes) : [],
                'attributes_id'    => $room->attributes_id 
                                        ? explode(',', $room->attributes_id)
                                        : ($room->attributes ? explode(',', $room->attributes) : []),
                'main_facilities' => $room->main_facilities ? explode(',', $room->main_facilities) : [],
                'main_facilities_id' => $room->main_facilities_id
                            ? explode(',', $room->main_facilities_id)
                            : ($room->main_facilities ? explode(',', $room->main_facilities) : []),

                'total_beds' => $totalBeds,
                'available_beds' => $availableBeds,
                'availability_percentage' => $availabilityPercentage,
                'is_sold_out' => $isSoldOut,
            ];
        });

        // Calculate sanctuary stats dynamically
        $totalCapacity = $rooms->sum('capacity');
        $roomTypes = $rooms->pluck('gender_type')->unique();
        $roomTypeLabel = $roomTypes->count() > 1 ? 'Mixed' : $roomTypes->first();

        return view('pages.rooms', [
            'rooms' => $roomData,
            'totalCapacity' => $totalCapacity,
            'roomTypeLabel' => $roomTypeLabel,
        ]);
    }
}
