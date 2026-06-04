<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AddonController extends Controller
{
    public function index(): JsonResponse
    {
        $addons = Addon::orderByDesc('created_at')->get();
        return response()->json(['success' => true, 'data' => $addons]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'price'          => 'required|numeric|min:0',
            'discount'       => 'nullable|numeric|min:0',
            'note'           => 'nullable|string|max:500',
            'is_auto_include' => 'boolean',
            'include_days'   => 'nullable|array',
        ]);

        $addon = Addon::create([
            'name'           => $validated['name'],
            'price'          => $validated['price'],
            'discount'       => $validated['discount'] ?? null,
            'note'           => $validated['note'] ?? '',
            'is_auto_include' => $validated['is_auto_include'] ?? false,
            'include_days'   => $validated['include_days'] ?? [],
            'is_active'      => true,
        ]);

        return response()->json(['success' => true, 'data' => $addon], 201);
    }

    public function update(Request $request, Addon $addon): JsonResponse
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'price'          => 'required|numeric|min:0',
            'discount'       => 'nullable|numeric|min:0',
            'note'           => 'nullable|string|max:500',
            'is_auto_include' => 'boolean',
            'include_days'   => 'nullable|array',
        ]);

        $addon->update($validated);

        return response()->json(['success' => true, 'data' => $addon]);
    }

    public function destroy(Addon $addon): JsonResponse
    {
        $addon->delete();
        return response()->json(['success' => true]);
    }
}
