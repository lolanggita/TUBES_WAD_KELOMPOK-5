@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Upload Foto Galeri</h1>
    <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-medium mb-2">Judul Foto</label>
            <input type="text" name="title" id="title" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-medium mb-2">Deskripsi</label>
            <textarea name="description" id="description" rows="3" class="w-full border rounded px-3 py-2"></textarea>
        </div>
        <div class="mb-4">
            <label for="image" class="block text-gray-700 font-medium mb-2">Pilih Foto</label>
            <input type="file" name="image" id="image" accept="image/*" class="w-full border rounded px-3 py-2" required>
        </div>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Upload</button>
    </form>
</div>
@endsection