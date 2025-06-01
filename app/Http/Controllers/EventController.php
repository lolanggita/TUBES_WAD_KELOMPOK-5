<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function __construct()
    {
        // Memastikan user sudah login
        $this->middleware('auth');

        // Batasi create/update/delete hanya untuk 'admin'
        // Asumsikan Anda sudah punya middleware bernama 'role:admin'
        $this->middleware('role:administrator')->only([
            'create', 'store', 'edit', 'update', 'destroy'
        ]);
    }

    /**
     * Tampilkan daftar semua event (halaman index).
     */
    public function index()
    {
        // Ambil semua event, urutkan berdasarkan start_time terbaru
        $events = Event::orderBy('start_time', 'desc')->paginate(10);

        return view('events.index', compact('events'));
    }

    /**
     * Tampilkan form untuk membuat event baru.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Simpan event baru ke database.
     */
    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id(); // id admin yang membuat

        Event::create($data);

        return redirect()
            ->route('events.index')
            ->with('success', 'Event berhasil dibuat.');
    }

    /**
     * Tampilkan detail satu event.
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    /**
     * Tampilkan form edit event yang sudah ada.
     */
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Proses update data event.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $data = $request->validated();
        $event->update($data);

        return redirect()
            ->route('events.index')
            ->with('success', 'Event berhasil diperbarui.');
    }

    /**
     * Hapus sebuah event.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()
            ->route('events.index')
            ->with('success', 'Event berhasil dihapus.');
    }
}
