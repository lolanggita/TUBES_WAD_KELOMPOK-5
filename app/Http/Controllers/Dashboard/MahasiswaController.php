<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        // Dummy activity feed
        $activities = [
            ['action' => 'Bergabung dengan UKM Musik', 'time' => now()->subHours(2)],
            ['action' => 'Ikut dalam acara Festival Kampus', 'time' => now()->subDay()],
            ['action' => 'Membagikan postingan terbaru', 'time' => now()->subDays(3)],
        ];

        return view('dashboard.user', compact('activities'));
    }
}