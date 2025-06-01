<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\UKM;
use App\Http\Controllers\Controller;
use App\Http\Requests\UKMProfileRequest;

class UKMController extends Controller
{
    // List all UKM profiles
    public function index()
    {
        $ukms = UKM::all();
        return view('ukm.index', compact('ukms'));
    }

    // Show form to create a new UKM profile
    public function create()
    {
        return view('ukm.form');
    }

    // Store a new UKM profile
    public function store(UKMProfileRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        UKM::create($data);

        return redirect()->route('ukm.index')->with('success', 'UKM profile created successfully.');
    }

    // Show form to edit an existing UKM profile
    public function edit(UKM $ukm)
    {
        return view('ukm.form', compact('ukm'));
    }

    // Update an existing UKM profile
    public function update(UKMProfileRequest $request, UKM $ukm)
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($ukm->logo) {
                Storage::disk('public')->delete($ukm->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $ukm->update($data);

        return redirect()->route('ukm.index')->with('success', 'UKM profile updated successfully.');
    }

    // Delete a UKM profile
    public function destroy(UKM $ukm)
    {
        if ($ukm->logo) {
            Storage::disk('public')->delete($ukm->logo);
        }
        $ukm->delete();

        return redirect()->route('ukm.index')->with('success', 'UKM profile deleted successfully.');
    }

    // Show the current UKM profile (for /ukm/ukm-profile route)
    public function profile()
    {
        $ukm = auth()->user()->ukm; // Assuming User has relation to UKM
        return view('ukm.profile', compact('ukm'));
    }
}
