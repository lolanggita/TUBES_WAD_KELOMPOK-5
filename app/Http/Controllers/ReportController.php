<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // Menampilkan semua laporan milik user yang login
    public function index()
    {
        $reports = Report::where('user_id', Auth::id())->get();
        return view('reports.index', compact('reports'));
    }

    // Menampilkan form untuk membuat laporan baru
    public function create()
    {
        return view('reports.create');
    }

    // Menyimpan laporan baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        Report::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'user_id' => Auth::id(),
            'status' => 'menunggu', // status default saat dibuat
        ]);

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil dibuat');
    }

    // Menampilkan detail laporan
    public function show($id)
    {
        $report = Report::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('reports.show', compact('report'));
    }

    // Menampilkan form edit jika status masih menunggu
    public function edit($id)
    {
        $report = Report::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'menunggu') // hanya jika status menunggu
            ->firstOrFail();

        return view('reports.edit', compact('report'));
    }

    // Memperbarui laporan jika status masih menunggu
    public function update(Request $request, $id)
    {
        $report = Report::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'menunggu') // hanya jika status menunggu
            ->firstOrFail();

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        $report->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil diperbarui');
    }

    // Menghapus laporan jika status masih menunggu
    public function destroy($id)
    {
        $report = Report::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'menunggu') // hanya jika status menunggu
            ->firstOrFail();

        $report->delete();

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil dihapus');
    }
}
