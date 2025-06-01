<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ isset($ukm) ? 'Edit UKM Profile' : 'Create UKM Profile' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-white text-black min-h-screen p-6">
    <div class="max-w-3xl mx-auto">
        <header class="mb-8">
            <h1 class="text-3xl font-bold">{{ isset($ukm) ? 'Edit UKM Profile' : 'Create UKM Profile' }}</h1>
        </header>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($ukm) ? route('ukm.update', $ukm) : route('ukm.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if(isset($ukm))
                @method('PUT')
            @endif

            <div>
                <label for="name" class="block mb-2 font-semibold">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $ukm->name ?? '') }}" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-black" />
            </div>

            <div>
                <label for="description" class="block mb-2 font-semibold">Description</label>
                <textarea name="description" id="description" rows="4" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-black">{{ old('description', $ukm->description ?? '') }}</textarea>
            </div>

            <div>
                <label for="logo" class="block mb-2 font-semibold">Logo</label>
                @if(isset($ukm) && $ukm->logo)
                    <img src="{{ asset('storage/' . $ukm->logo) }}" alt="Logo" class="h-20 w-20 object-contain mb-2" />
                @endif
                <input type="file" name="logo" id="logo" accept="image/*" class="w-full" />
            </div>

            <div>
                <label for="contact" class="block mb-2 font-semibold">Contact</label>
                <input type="text" name="contact" id="contact" value="{{ old('contact', $ukm->contact ?? '') }}" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-black" />
            </div>

            <div>
                <button type="submit" class="px-6 py-2 bg-black text-white rounded hover:bg-gray-800 transition">
                    {{ isset($ukm) ? 'Update Profile' : 'Create Profile' }}
                </button>
                <a href="{{ route('ukm.index') }}" class="ml-4 text-black hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
