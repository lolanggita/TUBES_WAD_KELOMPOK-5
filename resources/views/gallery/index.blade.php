@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Galeri Dokumentasi</h1>
    <a href="{{ route('gallery.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Upload Foto Baru</a>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @foreach ($galleries as $item)
            <div class="border rounded overflow-hidden shadow-md">
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="font-semibold">{{ $item->title }}</h2>
                    <p class="text-sm text-gray-600">{{ $item->description }}</p>
                    <form action="{{ route('gallery.destroy', $item->id) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 text-sm">Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection