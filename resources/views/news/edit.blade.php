<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Edit Berita</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900" style="background-image: url('{{ asset('images/background/background.jpg') }}'); background-size: cover; background-position: center;">
    <!-- Navbar -->
    <nav class="bg-gray-800 p-3 fixed top-0 w-full z-50">
        <div class="container mx-auto flex items-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-8 mr-3">
            <a class="text-white text-xl" href="#">Endemic Animals | Edit Berita</a>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="max-w-4xl mx-auto p-4 pt-20"> <!-- Padding-top (pt-20) untuk menghindari navbar -->
        <h1 class="text-2xl font-bold text-green-600 mb-4">Edit Berita</h1>

        <!-- Form untuk mengedit berita -->
        <form action="{{ route('news.update', ['id' => $news->id]) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
    @csrf
    @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Judul Berita</label>
                <input type="text" id="title" name="title" value="{{ $news->title }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" required>
            </div>

            <div class="mb-4">
                <label for="short_description" class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                <input type="text" id="short_description" name="short_description" value="{{ $news->short_description }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="description" name="description" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" required>{{ $news->description }}</textarea>
            </div>

            <div class="mb-4">
                <label for="source" class="block text-sm font-medium text-gray-700">Sumber</label>
                <input type="text" id="source" name="source" value="{{ $news->source }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" required>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Gambar</label>
                <input type="file" id="image" name="image" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                @if ($news->image)
                    <img src="{{ asset('storage/' . $news->image) }}" alt="Gambar Berita" class="mt-2 w-24 h-24 object-cover rounded">
                @endif
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('news.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white text-sm font-bold py-2 px-4 rounded">
                    Kembali
                </a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-sm font-bold py-2 px-4 rounded">
                    Update Berita
                </button>
            </div>
        </form>
    </div>

    <!-- Form Logout -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</body>
</html>