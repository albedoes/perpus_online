<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .book-card {
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .book-card:hover {
            transform: scale(1.05);
            opacity: 0.9;
        }

        @media (max-width: 640px) {
            .search-filter-container {
                display: flex;
                gap: 8px;
                align-items: center;
            }
            .search-filter-container input,
            .search-filter-container select {
                flex: 1;
            }
        }
    </style>
</head>
<body class="text-black" style="font-family: Arial; padding-top: 100px;">

<!-- Navbar -->
<nav class="bg-gray-800 p-3 fixed top-0 w-full z-50">
    <div class="container mx-auto flex items-center justify-between">
        <div class="flex items-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-8 mr-3">
            <a class="text-white text-xl font-light" href="#">PustakaKu</a>
        </div>
        <div class="flex space-x-6">
            <a href="/" class="text-white hover:text-orange-400">Home</a>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div id="heroSection" class="container mx-auto mt-0 text-center p-8 w-full">
    <h1 class="text-4xl sm:text-4xl font-bold text-orange-800">Welcome to PustakaKu</h1>
    <p class="text-lg text-black mt-2">Jelajahi berbagai jenis buku yang menginspirasi banyak orang</p>
</div>

<!-- Pencarian & Filter -->
<div class="top-17 mt-8 w-full z-40">
    <div class="container mx-auto search-filter-container flex justify-center items-center gap-1">
        <input type="text" id="search" class="p-2 border-black rounded-md bg-orange-600 bg-opacity-90 text-white placeholder-white w-full sm:w-80" placeholder="Cari buku...">
        <select id="filterType" class="p-2 border-black rounded-md bg-gray-800 text-white w-full sm:w-40">
            <option value="">Semua Kategori</option>
            <option value="Fiksi">Fiksi</option>
            <option value="Non-Fiksi">Non-Fiksi</option>
            <option value="Referensi">Referensi</option>
        </select>
    </div>
</div>

<!-- Daftar Buku -->
<div class="container mx-auto mt-16 p-4">
    <div id="book-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($buku as $buku)
            <div class="bg-white border rounded-md overflow-hidden shadow-md book-card" data-type="{{ $buku->kategori }}" data-name="{{ $buku->judul }}" onclick="showBookDetails({{ $buku->id }})">
                <h2 class="text-center font-semibold p-2 card-title">{{ $buku->judul }}</h2>
                <div class="w-full h-48 overflow-hidden">
                    <img src="{{ asset('storage/' . $buku->image) }}" class="w-full h-full object-cover object-center" alt="{{ $buku->judul }}">
                </div>
                <div class="p-2">
                    <p class="italic text-center">{{ $buku->pengarang ?? 'Penulis tidak diketahui' }}</p>
                    <div class="text-right mt-2">
                        <span class="bg-orange-800 text-white px-2 py-1 rounded-md">{{ $buku->kategori }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div id="pagination" class="flex justify-center mt-24 space-x-2">
        <!-- Tombol pagination akan di-generate oleh JavaScript -->
    </div>
</div>

<!-- Modal -->
<div class="bg-black bg-opacity-50 backdrop-blur-md fixed z-10 inset-0 overflow-y-auto hidden" id="bookModal">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div id="modalContent" class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full opacity-0 scale-90 duration-300">
            <div class="bg-gray-800 p-4 flex justify-between items-center">
                <h5 class="text-white text-xl" id="bookName"></h5>
                <button type="button" class="text-white" onclick="hideBookDetails()">Tutup</button>
            </div>
            <div class="p-4 overflow-y-auto max-h-[80vh] overflow-x-hidden">
                <img id="bookImage" class="w-full h-48 object-cover mb-3" alt="Book Image">
                <p><strong>Penulis:</strong> <span id="author"></span></p>
                <p><strong>Kategori:</strong> <span id="type"></span></p>
                <br>
                <p id="description" class="whitespace-pre-line break-words"></p>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-gray-800 text-white py-6 mt-8">
    <div class="container mx-auto text-center">
        <p class="text-sm">
            &copy; {{ date('Y') }} PustakaKu. All rights reserved.
        </p>
    </div>
</footer>

<script>
    let currentPage = 1;
    const itemsPerPage = 8;
    let bookCards = Array.from(document.querySelectorAll('.book-card'));
    let filteredBooks = bookCards;
    const paginationContainer = document.getElementById('pagination');
    const heroSection = document.getElementById('heroSection');

    function showPage(page) {
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;

        bookCards.forEach(card => card.style.display = 'none');
        filteredBooks.slice(startIndex, endIndex).forEach(card => card.style.display = 'block');

        updatePaginationButtons(page);

        if (page !== 1) {
            heroSection.style.display = 'none';
        } else {
            heroSection.style.display = 'block';
        }

        scrollToTop();
    }

    function updatePaginationButtons(page) {
        paginationContainer.innerHTML = '';

        if (page > 1) {
            const prevButton = document.createElement('button');
            prevButton.innerText = '<';
            prevButton.className = 'px-4 py-2 rounded-md bg-gray-200 text-gray-800 hover:bg-gray-300';
            prevButton.addEventListener('click', () => {
                currentPage = page - 1;
                showPage(currentPage);
            });
            paginationContainer.appendChild(prevButton);
        }

        const totalPages = Math.ceil(filteredBooks.length / itemsPerPage);
        for (let i = 1; i <= totalPages; i++) {
            const button = document.createElement('button');
            button.innerText = i;
            button.className = `px-4 py-2 rounded-md ${i === page ? 'bg-gray-800 text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300'}`;
            button.addEventListener('click', () => {
                currentPage = i;
                showPage(currentPage);
            });
            paginationContainer.appendChild(button);
        }

        if (page < totalPages) {
            const nextButton = document.createElement('button');
            nextButton.innerText = '>';
            nextButton.className = 'px-4 py-2 rounded-md bg-gray-200 text-gray-800 hover:bg-gray-300';
            nextButton.addEventListener('click', () => {
                currentPage = page + 1;
                showPage(currentPage);
            });
            paginationContainer.appendChild(nextButton);
        }
    }

    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    function filterBooks() {
        const searchText = document.getElementById("search").value.trim().toLowerCase();
        const selectedType = document.getElementById("filterType").value.trim().toLowerCase();

        filteredBooks = bookCards.filter(card => {
            const bookName = card.getAttribute('data-name').toLowerCase();
            const bookType = card.getAttribute('data-type').toLowerCase();

            const nameMatch = bookName.includes(searchText);
            const typeMatch = selectedType === "" || bookType === selectedType;

            return nameMatch && typeMatch;
        });

        currentPage = 1;
        showPage(currentPage);
    }

    document.getElementById("search").addEventListener("input", filterBooks);
    document.getElementById("filterType").addEventListener("change", filterBooks);

    showPage(currentPage);
</script>
</body>
</html>