<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom CSS untuk sidebar */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .main-content {
            margin-left: 250px; /* Sesuaikan dengan lebar sidebar */
            transition: margin 0.3s ease;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar.active {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900">

   <!-- Sidebar -->
<nav class="sidebar bg-gray-800 text-white">
    <!-- Container untuk Logo dan Judul -->
    <div class="p-4 flex items-center">
        <!-- Logo -->
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-8 mr-3">

        <!-- Judul -->
        <h1 class="text-xl font-semibold">Admin Dashboard</h1>
    </div>

    <!-- Menu Navigasi -->
    <ul class="space-y-2 p-4">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 hover:bg-gray-700 rounded">
                <span>Dashboard Buku</span>
            </a>
        </li>
        <li>
            <a href="{{ route('logout') }}" class="flex items-center p-2 hover:bg-red-600 rounded" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span>Logout</span>
            </a>
        </li>
    </ul>
</nav>

<!-- Container untuk Search Bar dan Add Buku Button (Fixed di Atas) -->
<div class="fixed top-0 left-60 right-0 bg-gray-800 z-40 p-4">
    <div class="max-w-6xl mx-auto flex items-center justify-between">
        <!-- Search Bar -->
        <div class="flex-grow mr-4">
            <input type="text" id="search" class="w-full bg-gray-200 px-4 py-2 border-black text-black rounded-md shadow-sm placeholder-green-800 text-sm" placeholder="Cari buku..." />
        </div>

        <!-- Add Buku Button -->
        <a href="{{ route('admin.create') }}" class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold py-2 px-4 rounded transition duration-200 whitespace-nowrap">
            Tambah Data
        </a>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <!-- Container untuk Tabel -->
    <div class="mt-16 overflow-x-auto relative">
        <!-- Fixed Header -->
        <div class="sticky top-0 z-10">
            <table class="min-w-full bg-white shadow-md rounded-t-md text-sm">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">#</th>
                        <th class="py-3 px-4 text-left">Judul</th>
                        <th class="py-3 px-4 text-left">Pengarang</th>
                        <th class="py-3 px-4 text-left">Kategori</th>
                        <th class="py-3 px-4 text-left">Penerbit</th>
                        <th class="py-3 px-14 text-left min-w-[100px]">Deskripsi</th>
                        <th class="py-3 px-4 text-left">Gambar</th>
                        <th class="py-3 px-4 text-left">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>

        <!-- Scrollable Body -->
        <div class="mt-1 overflow-y-auto" style="max-height: 80vh;"> <!-- Sesuaikan max-height sesuai kebutuhan -->
            <table class="min-w-full bg-white shadow-md rounded-b-md text-sm">
                <tbody class="divide-y divide-gray-200">
                    @foreach($bukus as $buku)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $loop->iteration }}</td>
                            <td class="py-3 px-6">{{ $buku->judul }}</td>
                            <td class="py-3 px-4 max-w-30">{{ $buku->pengarang }}</td>
                            <td class="py-3 px-4">{{ $buku->kategori }}</td>
                            <td class="py-3 px-4 max-w-20 truncate">{{ $buku->penerbit }}</td>
                            <td class="py-3 px-4 max-w-xs truncate">{{ $buku->description }}</td>
                            <td class="py-3 px-4">
                                <img src="{{ asset('storage/' . $buku->image) }}" class="w-16 h-16 object-cover rounded-lg shadow-sm">
                            </td>
                            <td class="py-3 px-4 flex space-x-2">
                                <a href="{{ route('admin.edit', $buku->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold py-1 px-3 rounded transition duration-200">
                                    Edit
                                </a>
                                <form action="{{ route('admin.destroy', $buku->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs font-semibold py-1 px-3 rounded transition duration-200" onclick="return confirm('Yakin ingin menghapus?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Logout Form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>

    <!-- Script untuk toggle sidebar di mobile -->
    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('active');
        }
    </script>

    <!-- Search Functionality Script -->
    <script>
        document.getElementById("search").addEventListener("input", function() {
            let searchText = this.value.trim().toLowerCase();
            document.querySelectorAll("tbody tr").forEach(row => {
                let bookTitle = row.querySelector("td:nth-child(2)").innerText.trim().toLowerCase();
                row.style.display = bookTitle.includes(searchText) ? "" : "none";
            });
        });
    </script>
</body>
</html>