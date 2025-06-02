<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashUkmController extends Controller
{
    public function index()
    {
        // Contoh data dashboard UKM
        $data = [
            'total_members' => 50,
            'upcoming_events' => 3,
            'recent_posts' => 10,
        ];

        return view('dashboard.ukm', compact('data'));
    }

    public function events()
    {
        // Dummy data event
        $events = [
            ['id' => 1, 'title' => 'Pertunjukan Seni Rakyat', 'date' => '2024-12-10'],
            ['id' => 2, 'title' => 'Lomba Band UKM', 'date' => '2024-12-15'],
        ];

        return view('dashboard.ukm_events', compact('events'));
    }

    public function posts()
    {
        // Dummy data post
        $posts = [
            ['id' => 1, 'title' => 'Pendaftaran Anggota Baru UKM Musik', 'created_at' => now()->format('d M Y')],
            ['id' => 2, 'title' => 'Latihan Rutin UKM Tari Setiap Sabtu', 'created_at' => now()->subDays(2)->format('d M Y')],
        ];

        return view('dashboard.ukm_posts', compact('posts'));
    }
}