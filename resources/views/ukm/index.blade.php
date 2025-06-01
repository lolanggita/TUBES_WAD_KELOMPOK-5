<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>UKM Profiles</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-white text-black min-h-screen p-6">
    <div class="max-w-5xl mx-auto">
        <header class="mb-8 flex justify-between items-center">
            <h1 class="text-3xl font-bold">UKM Profiles</h1>
            <a href="{{ route('ukm.create') }}" class="px-4 py-2 bg-black text-white rounded hover:bg-gray-800 transition">Add New UKM</a>
        </header>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border border-gray-300 rounded overflow-hidden">
            <thead class="bg-black text-white">
                <tr>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Description</th>
                    <th class="p-3 text-left">Contact</th>
                    <th class="p-3 text-left">Logo</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ukms as $ukm)
                <tr class="border-b border-gray-300 hover:bg-gray-100">
                    <td class="p-3">{{ $ukm->name }}</td>
                    <td class="p-3">{{ Str::limit($ukm->description, 100) }}</td>
                    <td class="p-3">{{ $ukm->contact }}</td>
                    <td class="p-3">
                        @if($ukm->logo)
                            <img src="{{ asset('storage/' . $ukm->logo) }}" alt="Logo" class="h-12 w-12 object-contain" />
                        @else
                            <span class="text-gray-500">No Logo</span>
                        @endif
                    </td>
                    <td class="p-3 space-x-2">
                        <a href="{{ route('ukm.edit', $ukm) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('ukm.destroy', $ukm) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this UKM?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-3 text-center text-gray-500">No UKM profiles found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
