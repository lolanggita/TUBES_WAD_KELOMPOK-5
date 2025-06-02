<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My UKM Profile</title>
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
            <h1 class="text-3xl font-bold">My UKM Profile</h1>
        </header>

        @if($ukm)
            <div class="space-y-6">
                <div>
                    <h2 class="text-xl font-semibold">Name</h2>
                    <p>{{ $ukm->name }}</p>
                </div>
                <div>
                    <h2 class="text-xl font-semibold">Description</h2>
                    <p>{{ $ukm->description }}</p>
                </div>
                <div>
                    <h2 class="text-xl font-semibold">Contact</h2>
                    <p>{{ $ukm->contact }}</p>
                </div>
                <div>
                    <h2 class="text-xl font-semibold">Logo</h2>
                    @if($ukm->logo)
                        <img src="{{ asset('storage/' . $ukm->logo) }}" alt="Logo" class="h-32 w-32 object-contain" />
                    @else
                        <p class="text-gray-500">No logo uploaded.</p>
                    @endif
                </div>
                <div>
                    <a href="{{ route('ukm.edit', $ukm) }}" class="inline-block px-6 py-2 bg-black text-white rounded hover:bg-gray-800 transition">Edit Profile</a>
                </div>
            </div>
        @else
            <p class="text-gray-500">No UKM profile found.</p>
            <a href="{{ route('ukm.create') }}" class="inline-block mt-4 px-6 py-2 bg-black text-white rounded hover:bg-gray-800 transition">Create Profile</a>
        @endif
    </div>
</body>
</html>
