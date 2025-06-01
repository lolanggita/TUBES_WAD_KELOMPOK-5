@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Laporan</h1>

    <form action="{{ route('reports.update', $report->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" value="{{ $report->judul }}" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4" required>{{ $report->deskripsi }}</textarea>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $report->tanggal }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
