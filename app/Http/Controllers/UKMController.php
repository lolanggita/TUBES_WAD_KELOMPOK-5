<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UKMController extends Controller
{
    //

    // verifikasi ukm
    public function verify(Request $request)
    {
        $request->validate([
            'ukm_id' => 'required|exists:users,id'
        ]);

        $user = User::find($request->ukm_id);
        
        if ($user->isUkm()) {
            $user->update(['is_verified' => true]);
            
            // Kirim notifikasi ke UKM bahwa akun mereka terverifikasi
            // ...
            return back()->with('success', 'Akun UKM berhasil diverifikasi');
        }

        return back()->with('error', 'Hanya akun penyelenggara yang dapat diverifikasi');
    }
}
