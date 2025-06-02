@extends('layouts.app')

@section('title', 'Galeri UKM')

@section('content')
<div class="container">
    <h1>Galeri UKM</h1>
    <p>Di sini kamu bisa melihat semua foto yang telah diunggah.</p>

    <!-- Form Upload -->
    <div class="mb-4">
        <a href="{{ route('gallery.create') }}" class="btn btn-primary">Upload Foto Baru</a>
    </div>

    <!-- Daftar Foto -->
    @if ($galleries->count() > 0)
        <div class="row">
            @foreach ($galleries as $gallery)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="{{ Storage::url($gallery->image_path) }}" alt="{{ $gallery->title }}" class="card-img-top" style="max-height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $gallery->title }}</h5>
                            <p class="card-text">{{ $gallery->description ?? 'Tidak ada deskripsi' }}</p>
                            <a href="{{ route('gallery.show', $gallery->id) }}" class="btn btn-sm btn-primary">Detail</a>
                            <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>Tidak ada foto dalam galeri.</p>
    @endif
</div>
@endsection