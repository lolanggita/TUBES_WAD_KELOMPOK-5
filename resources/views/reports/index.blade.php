@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Laporan</h1>

    <a href="{{ route('reports.create') }}" class="btn btn-primary mb-3">Buat Laporan Baru</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $report)
            <tr>
                <td>{{ $report->judul }}</td>
                <td>{{ $report->tanggal }}</td>
                <td>{{ ucfirst($report->status) }}</td>
                <td>
                    <a href="{{ route('reports.show', $report->id) }}" class="btn btn-info btn-sm">Lihat</a>

                    @if ($report->status === 'menunggu')
                        <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('reports.destroy', $report->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
