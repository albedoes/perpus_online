<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tambah Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900" style="background-image: url('{{ asset('images/background/background.jpg') }}'); background-size: cover; background-position: center;">
    <!-- Navbar -->
    <nav class="bg-gray-800 p-3 fixed top-0 w-full z-50">
        <div class="container mx-auto flex items-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-8 mr-3">
            <a class="text-white text-xl" href="#">Admin Dashboard | Tambah Buku</a>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="max-w-4xl mx-auto p-4 pt-20"> <!-- Padding-top (pt-20) untuk menghindari navbar -->
        <h1 class="text-2xl font-bold text-green-600 mb-4">Tambah Buku Baru</h1>

        <!-- Form untuk menambah buku -->
        <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium text-gray-700">Judul Buku</label>
                <input type="text" id="judul" name="judul" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" required>
            </div>
            <div class="mb-4">
                <label for="pengarang" class="block text-sm font-medium text-gray-700">Pengarang</label>
                <input type="text" id="pengarang" name="pengarang" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" required>
            </div>
            <div class="mb-4">
                <label for="penerbit" class="block text-sm font-medium text-gray-700">Penerbit</label>
                <input type="text" id="penerbit" name="penerbit" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" required>
            </div>
            <div class="mb-4">
                <label for="tahun_terbit" class="block text-sm font-medium text-gray-700">Tahun Terbit</label>
                <input type="number" id="tahun_terbit" name="tahun_terbit" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" required>
            </div>
            <div class="mb-4">
                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select id="kategori" name="kategori" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                    <option value="Fiksi">Fiksi</option>
                    <option value="Non-Fiksi">Non-Fiksi</option>
                    <option value="Referensi">Referensi</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="description" name="description" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" required></textarea>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Gambar</label>
                <input type="file" id="image" name="image" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" required>
            </div>
            <div class="mb-4">
                <label for="file" class="block text-sm font-medium text-gray-700">File Buku (PDF/EPUB/DLL.)</label>
                <input type="file" id="file" name="file" accept=".pdf,.epub,.docx,.doc,.txt" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" required>
            </div>
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white text-sm font-bold py-2 px-4 rounded">
                    Kembali
                </a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-sm font-bold py-2 px-4 rounded">
                    Tambah Data
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