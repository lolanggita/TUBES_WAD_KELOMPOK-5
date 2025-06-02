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