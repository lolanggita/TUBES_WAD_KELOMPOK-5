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

            {{-- Bagian Komentar --}}
            <div class="bg-white shadow-sm rounded-lg p-6" id="comments-section">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Komentar</h3>

                {{-- Form Tambah Komentar --}}
                @auth
                    <form id="comment-form" class="mb-6">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">

                        <textarea
                            name="content"
                            rows="3"
                            id="comment-content"
                            class="w-full mb-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            placeholder="Tulis komentar..."
                        ></textarea>
                        <p id="error-message" class="text-sm text-red-600 mb-2 hidden"></p>

                        <button
                            type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow"
                        >
                            Kirim Komentar
                        </button>
                    </form>
                @else
                    <p class="text-gray-500 italic mb-4">Silakan <a href="{{ route('login') }}" class="underline">login</a> untuk memberikan komentar.</p>
                @endauth

                {{-- Daftar Komentar Dinamis --}}
                <div id="comments-list">
                    @foreach ($event->comments as $comment)
                        <div class="border-b border-gray-200 pb-4 mb-4 comment-item">
                            <div class="flex items-center mb-2">
                                <span class="text-sm font-medium text-gray-800">{{ $comment->user->name }}</span>
                                <span class="text-xs text-gray-500 ml-2">
                                    {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-gray-700">{{ $comment->content }}</p>
                        </div>
                    @endforeach
                </div>

                {{-- Pesan Kosong --}}
                @if ($event->comments->isEmpty())
                    <p id="no-comments" class="text-gray-500 italic mt-4">Belum ada komentar.</p>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const form = document.getElementById('comment-form');
        const contentInput = document.getElementById('comment-content');
        const errorMessage = document.getElementById('error-message');
        const commentsList = document.getElementById('comments-list');
        const noCommentsMessage = document.getElementById('no-comments');

        // Submit komentar via Fetch API
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(form);
            const content = formData.get('content').trim();
            const eventId = formData.get('event_id');

            if (!content) {
                errorMessage.textContent = 'Konten komentar wajib diisi.';
                errorMessage.classList.remove('hidden');
                return;
            }

            fetch("{{ route('api.comments.store', $event->id) }}", {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ content })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                contentInput.value = '';
                errorMessage.classList.add('hidden');

                // Tampilkan pesan kosong jika sebelumnya muncul
                if (noCommentsMessage) noCommentsMessage.style.display = 'none';

                // Render komentar baru
                const commentHTML = `
                    <div class="border-b border-gray-200 pb-4 mb-4 comment-item">
                        <div class="flex items-center mb-2">
                            <span class="text-sm font-medium text-gray-800">${data.data.user.name}</span>
                            <span class="text-xs text-gray-500 ml-2">${new Date(data.data.created_at).toLocaleString()}</span>
                        </div>
                        <p class="text-gray-700">${data.data.content}</p>
                    </div>
                `;
                commentsList.insertAdjacentHTML('afterbegin', commentHTML);
            })
            .catch(error => {
                console.error('Error:', error);
                errorMessage.textContent = 'Gagal mengirim komentar. Silakan coba lagi.';
                errorMessage.classList.remove('hidden');
            });
        });

        // Optional: Auto-refresh komentar setiap beberapa detik
        setInterval(() => {
            fetch("{{ route('api.comments.index', $event->id) }}")
                .then(res => res.json())
                .then(comments => {
                    commentsList.innerHTML = '';
                    if (comments.length === 0 && noCommentsMessage) {
                        noCommentsMessage.style.display = 'block';
                    } else if (noCommentsMessage) {
                        noCommentsMessage.style.display = 'none';
                    }

                    comments.forEach(comment => {
                        const commentHTML = `
                            <div class="border-b border-gray-200 pb-4 mb-4 comment-item">
                                <div class="flex items-center mb-2">
                                    <span class="text-sm font-medium text-gray-800">${comment.user.name}</span>
                                    <span class="text-xs text-gray-500 ml-2">${new Date(comment.created_at).toLocaleString()}</span>
                                </div>
                                <p class="text-gray-700">${comment.content}</p>
                            </div>
                        `;
                        commentsList.innerHTML += commentHTML;
                    });
                });
        }, 30000); // Refresh setiap 30 detik
    </script>
    @endpush
</x-app-layout>