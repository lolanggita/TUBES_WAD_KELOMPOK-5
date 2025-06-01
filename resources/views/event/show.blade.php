<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Postingan Kegiatan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                {{-- Judul & Info Dasar --}}
                <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $event->title }}</h1>
                <p class="text-sm text-gray-600 mb-4">
                    Dibuat oleh: <span class="font-medium">{{ $event->creator->name }}</span> •
                    {{ \Carbon\Carbon::parse($event->created_at)->translatedFormat('d F Y, H:i') }}
                </p>

                {{-- Tanggal & Waktu --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <span class="block text-sm font-medium text-gray-700">Waktu Mulai:</span>
                        <span class="block text-base text-gray-900">
                            {{ \Carbon\Carbon::parse($event->start_time)->translatedFormat('d F Y, H:i') }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-700">Waktu Selesai:</span>
                        <span class="block text-base text-gray-900">
                            @if($event->end_time)
                                {{ \Carbon\Carbon::parse($event->end_time)->translatedFormat('d F Y, H:i') }}
                            @else
                                <span class="text-gray-500 italic">Belum ditentukan</span>
                            @endif
                        </span>
                    </div>
                </div>

                {{-- Registrasi --}}
                <div class="mb-6">
                    <span class="block text-sm font-medium text-gray-700">Registrasi Dibuka:</span>
                    @if ($event->is_registrable)
                        <a href="{{ route('event_registrations.create', $event) }}"
                           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md shadow">
                            Daftar Sekarang
                        </a>
                    @else
                        <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-600 text-sm font-medium rounded-full">
                            Tidak Bisa Registrasi
                        </span>
                    @endif
                </div>

                {{-- Deskripsi --}}
                <div class="prose prose-sm sm:prose lg:prose-lg">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Deskripsi</h2>
                    @if ($event->description)
                        <p class="text-gray-700">{{ $event->description }}</p>
                    @else
                        <p class="text-gray-500 italic">Belum ada deskripsi untuk kegiatan ini.</p>
                    @endif
                </div>
            </div>

            {{-- Komentar (jika fitur komentar sudah tersedia) --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Komentar</h3>

                {{-- Form Tambah Komentar --}}
                @auth
                    <form action="{{ route('comments.store') }}" method="POST" class="mb-6">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">

                        <textarea
                            name="content"
                            rows="3"
                            class="w-full mb-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            placeholder="Tulis komentar..."
                        ></textarea>
                        @error('content')
                            <p class="text-sm text-red-600 mb-2">{{ $message }}</p>
                        @enderror

                        <button
                            type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow"
                        >
                            Kirim Komentar
                        </button>
                    </form>
                @else
                    <p class="text-gray-500 italic mb-4">Silakan login untuk memberikan komentar.</p>
                @endauth

                {{-- Daftar Komentar --}}
                @forelse ($event->comments as $comment)
                    <div class="border-b border-gray-200 pb-4 mb-4">
                        <div class="flex items-center mb-2">
                            <span class="text-sm font-medium text-gray-800">{{ $comment->user->name }}</span>
                            <span class="text-xs text-gray-500 ml-2">
                                {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-gray-700">{{ $comment->content }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 italic">Belum ada komentar.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>