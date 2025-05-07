<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Berita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
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
            margin-left: 250px;
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
    <div class="p-4 flex items-center">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-8 mr-3">
        <h1 class="text-xl font-semibold">Admin Dashboard</h1>
    </div>
    <ul class="space-y-2 p-4">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 hover:bg-gray-700 rounded">
                <span>Dashboard Animal</span>
            </a>
        </li>
        <li>
            <a href="{{ route('news.dashboard') }}" class="flex items-center p-2 hover:bg-gray-700 rounded">
                <span>Dashboard Berita</span>
            </a>
        </li>
        <li>
            <a href="{{ route('logout') }}" class="flex items-center p-2 hover:bg-red-600 rounded" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span>Logout</span>
            </a>
        </li>
    </ul>
</nav>

<!-- Container untuk Search Bar dan Add News Button -->
<div class="fixed top-0 left-60 right-0 bg-gray-800 z-40 p-4">
    <div class="max-w-6xl mx-auto flex items-center justify-between">
        <div class="flex-grow mr-4">
            <input type="text" id="search" class="w-full bg-gray-200 px-4 py-2 border-black text-black rounded-md shadow-sm placeholder-green-800 text-sm" placeholder="Cari berita..." />
        </div>
        <a href="{{ route('news.create') }}" class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold py-2 px-4 rounded transition duration-200 whitespace-nowrap">
            Tambah Data
        </a>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="mt-16 overflow-x-auto relative">
        <div class="sticky top-0 z-10">
            <table class="min-w-full bg-white shadow-md rounded-t-md text-sm">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">#</th>
                        <th class="py-3 px-4 text-left">Judul</th>
                        <th class="py-3 px-4 text-left">Deskripsi</th>
                        <th class="py-3 px-4 text-left">Gambar</th>
                        <th class="py-3 px-4 text-left">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>

        <!-- Scrollable Body -->
        <div class="mt-1 overflow-y-auto" style="max-height: 80vh;">
            <table class="min-w-full bg-white shadow-md rounded-b-md text-sm">
            <tbody class="divide-y divide-gray-200">
    @foreach($news as $item)
        <tr class="hover:bg-gray-50">
            <td class="py-3 px-4">{{ $loop->iteration }}</td>
            <td class="py-3 px-6">{{ $item->title }}</td>
            <td class="py-3 px-4 max-w-xs truncate">{{ $item->description }}</td>
            <td class="py-3 px-4">
                @if ($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" class="w-16 h-16 object-cover rounded-lg shadow-sm">
                @endif
            </td>
            <td class="py-3 px-4 flex space-x-2">
                <a href="{{ route('news.edit', $item->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold py-1 px-3 rounded transition duration-200">
                    Edit
                </a>
                <form action="{{ route('news.destroy', $item->id) }}" method="POST">
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
            let newsTitle = row.querySelector("td:nth-child(2)").innerText.trim().toLowerCase();
            row.style.display = newsTitle.includes(searchText) ? "" : "none";
        });
    });
</script>
</body>
</html>