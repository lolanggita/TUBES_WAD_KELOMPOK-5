<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UKM;

class AdminController extends Controller
{
    public function index()
    {
        // Contoh data dashboard admin
        $data = [
            'total_users' => User::count(),
            'total_ukms' => UKM::count(),
            'pending_requests' => 7, // Ganti dengan query jika ada fitur request
        ];

        return view('dashboard.admin', compact('data'));
    }

    public function manageUsers()
    {
        // Ambil semua user dari database
        $users = User::all();

        return view('dashboard.admin_users', compact('users'));
    }

    public function manageUkms()
    {
        // Ambil semua UKM dari database
        $ukms = UKM::all();

        return view('dashboard.admin_ukms', compact('ukms'));
    }

    // === USER CRUD ===
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.admin_users_edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    // === UKM CRUD ===
    public function createUkm()
    {
        return view('dashboard.admin_ukms_create');
    }

    public function storeUkm(Request $request)
    {
        UKM::create($request->all());
        return redirect()->route('admin.ukms.index')->with('success', 'UKM created successfully.');
    }

    public function editUkm($id)
    {
        $ukm = UKM::findOrFail($id);
        return view('dashboard.admin_ukms_edit', compact('ukm'));
    }

    public function updateUkm(Request $request, $id)
    {
        $ukm = UKM::findOrFail($id);
        $ukm->update($request->all());
        return redirect()->route('admin.ukms.index')->with('success', 'UKM updated successfully.');
    }

    public function deleteUkm($id)
    {
        $ukm = UKM::findOrFail($id);
        $ukm->delete();
        return back()->with('success', 'UKM deleted successfully.');
    }   
}