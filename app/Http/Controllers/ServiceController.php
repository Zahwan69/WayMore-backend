<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Service.index
     */
    public function index()
    {
        return Service::with('category')->get();
    }


    /**
     * Service.store
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'duration_minutes' => 'required|integer|min:1',
            'price'            => 'required|numeric|min:0',
            'is_active'        => 'boolean',
        ]);

        return response()->json(Service::create($validated), 201);
    }
    /**
     * Service.show
     */
   public function show(Service $service)
    {
        return $service->load('category');
    }

    /**
     * Service.update
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'category_id'      => 'sometimes|exists:categories,id',
            'name'             => 'sometimes|string|max:255',
            'description'      => 'nullable|string',
            'duration_minutes' => 'sometimes|integer|min:1',
            'price'            => 'sometimes|numeric|min:0',
            'is_active'        => 'boolean',
        ]);

        $service->update($validated);

        return response()->json($service);
    }

    /**
     * Service.destroy
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return response()->json(null, 204);
    }
}