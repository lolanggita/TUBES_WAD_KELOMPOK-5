@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Laporan</h1>

    <div class="mb-3">
        <strong>Judul:</strong> {{ $report->judul }}
    </div>

    <div class="mb-3">
        <strong>Deskripsi:</strong> <br> {{ $report->deskripsi }}
    </div>

    <div class="mb-3">
        <strong>Tanggal:</strong> {{ $report->tanggal }}
    </div>

    <div class="mb-3">
        <strong>Status:</strong> {{ ucfirst($report->status) }}
    </div>

    <a href="{{ route('reports.index') }}" class="btn btn-primary">Kembali</a>
</div>
@endsection
