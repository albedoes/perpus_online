<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PustakaKu - Perpustakaan Digital</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Merriweather', serif;
      background-image: url('https://www.transparenttextures.com/patterns/paper-fibers.png'); /* Tekstur kertas */
      background-color: #fdfaf6;
    }

    .book-card:hover {
      transform: scale(1.02);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    .headline {
      font-family: 'Inter', sans-serif;
      letter-spacing: 0.5px;
    }

    .section {
      border-top: 1px dashed #ccc;
      padding-top: 2rem;
      margin-top: 2rem;
    }

    .bg-brown {
      background-color: #3e2c23;
    }

    .text-brown {
      color: #3e2c23;
    }

    .border-brown {
      border-color: #3e2c23;
    }
  </style>
</head>
<body class="text-gray-900 leading-relaxed">

  <!-- Navbar -->
  <nav class="bg-gray-800 p-4 fixed top-0 w-full z-50 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
      <div class="flex items-center gap-2">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-8" />
        <a href="/" class="text-white text-xl font-bold tracking-wide headline">PustakaKu</a>
      </div>
      <a href="/" class="text-gray-300 hover:text-white">Home</a>
    </div>
  </nav>

  <!-- Hero -->
  <section class="bg-brown text-white py-16 text-center mt-16">
    <div class="container mx-auto px-4">
      <h1 class="text-4xl md:text-5xl font-bold mb-3 headline">Pustaka Digital Anda</h1>
      <p class="text-lg max-w-2xl mx-auto">Koleksi buku klasik dan modern dalam gaya koran yang elegan</p>
    </div>
  </section>

  <!-- Search & Filter -->
  <section class="container mx-auto px-4 py-8 section">
    <div class="bg-white shadow-md border border-gray-200 rounded-lg p-6 max-w-3xl mx-auto">
      <div class="flex flex-col md:flex-row gap-4">
        <input type="text" id="search" placeholder="Cari judul atau penulis..."
          class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-brown" />
        <select id="filterType"
          class="border border-gray-300 rounded-md px-4 py-2 text-gray-700 focus:ring-2 focus:ring-brown">
          <option value="">Semua Kategori</option>
          <option value="Fiksi">Fiksi</option>
          <option value="Non-Fiksi">Non-Fiksi</option>
          <option value="Referensi">Referensi</option>
        </select>
      </div>
    </div>
  </section>

  <!-- Book List -->
<div class="container mx-auto px-4 py-8">
    <div id="book-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach($buku as $buku)
<div class="book-card bg-white rounded-lg overflow-hidden shadow-sm border border-gray-200" 
     data-type="{{ $buku->kategori }}" 
     data-name="{{ $buku->judul }}">
    <div class="w-full h-60 overflow-hidden">
        <img src="{{ asset('storage/' . $buku->image) }}" class="w-full h-full object-cover" alt="{{ $buku->judul }}">
    </div>
    <div class="p-4">
        <h3 class="font-semibold text-gray-800 mb-1">{{ $buku->judul }}</h3>
        <p class="text-gray-600 text-sm mb-3">{{ $buku->pengarang ?? 'Penulis tidak diketahui' }}</p>
        <span class="inline-block px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-700">
            {{ $buku->kategori }}
        </span>
        <!-- Tombol Selengkapnya -->
        <button onclick="showBookDetails({
            judul: '{{ $buku->judul }}',
            pengarang: '{{ $buku->pengarang ?? 'Penulis tidak diketahui' }}',
            penerbit: '{{ $buku->penerbit ?? '-' }}',
            tahun_terbit: '{{ $buku->tahun_terbit ?? '-' }}',
            isbn: '{{ $buku->isbn ?? '-' }}',
            description: `{{ $buku->description ?? 'Tidak ada deskripsi tersedia.' }}`,
            kategori: '{{ $buku->kategori }}',
            image: '{{ asset('storage/' . $buku->image) }}'
        })"
        class="mt-4 text-sm bg-brown text-white px-4 py-2 rounded hover:bg-opacity-90 transition">Selengkapnya</button>
    </div>
</div>
@endforeach
    </div>
    </div>



    <!-- Pagination -->
    <div id="pagination" class="flex justify-center mt-10 gap-2"></div>
  </section>

 <!-- Modal -->
<div id="bookModal" class="fixed inset-0 z-50 hidden">
  <!-- Overlay -->
  <div class="absolute inset-0 bg-black bg-opacity-40 backdrop-blur-sm" onclick="hideBookDetails()"></div>

  <!-- Modal Content -->
  <div class="relative z-10 flex items-center justify-center min-h-screen p-4">
    <div class="bg-[#fffdfa] rounded-lg shadow-lg w-full max-w-4xl border border-gray-300">
      <div class="relative p-6">
        <button onclick="hideBookDetails()" class="absolute top-4 right-4 text-gray-600 hover:text-gray-800">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>

        <div class="flex flex-col md:flex-row gap-6">
          <div class="md:w-1/3">
            <img id="bookImage" class="w-full rounded border border-gray-300" src="" alt="Book Cover">
          </div>
          <div class="md:w-2/3">
            <h2 id="bookName" class="text-2xl font-serif font-bold text-brown mb-2"></h2>
            <p class="text-sm text-gray-700 italic mb-4" id="author"></p>

            <div class="grid grid-cols-2 gap-4 text-sm mb-4">
              <div>
                <h4 class="text-gray-500 font-medium">Penerbit</h4>
                <p id="publisher" class="text-gray-800"></p>
              </div>
              <div>
                <h4 class="text-gray-500 font-medium">Tahun Terbit</h4>
                <p id="year" class="text-gray-800"></p>
              </div>
              <div>
                <h4 class="text-gray-500 font-medium">ISBN</h4>
                <p id="isbn" class="text-gray-800"></p>
              </div>
              <div>
                <h4 class="text-gray-500 font-medium">Kategori</h4>
                <p id="type" class="text-gray-800"></p>
              </div>
            </div>

            <div class="border-t pt-4">
              <h3 class="text-base font-semibold text-gray-800 mb-2">Deskripsi</h3>
              <p id="description" class="text-gray-700 text-sm whitespace-pre-line" style="column-count:2; column-gap:2rem;"></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


  <!-- Footer -->
  <footer class="bg-brown text-white py-6 mt-16 text-center">
    <p class="text-sm text-gray-300">&copy; {{ date('Y') }} PustakaKu - Gaya Klasik. Hak cipta dilindungi.</p>
  </footer>

  <!-- Script Pagination & Modal -->
  <script>
    let currentPage = 1;
    const itemsPerPage = 8;
    let bookCards = Array.from(document.querySelectorAll('.book-card'));
    let filteredBooks = bookCards;

    function showPage(page) {
      const startIndex = (page - 1) * itemsPerPage;
      const endIndex = startIndex + itemsPerPage;
      bookCards.forEach(card => card.style.display = 'none');
      filteredBooks.slice(startIndex, endIndex).forEach(card => card.style.display = 'block');
      updatePaginationButtons(page);
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function updatePaginationButtons(page) {
      const pagination = document.getElementById('pagination');
      pagination.innerHTML = '';
      const totalPages = Math.ceil(filteredBooks.length / itemsPerPage);
      if (page > 1) {
        const prev = document.createElement('button');
        prev.textContent = '← Sebelumnya';
        prev.className = 'px-3 py-1 border rounded bg-white';
        prev.onclick = () => showPage(page - 1);
        pagination.appendChild(prev);
      }
      for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement('button');
        btn.textContent = i;
        btn.className = `px-3 py-1 border ${i === page ? 'bg-brown text-white' : 'bg-white text-gray-800'} rounded`;
        btn.onclick = () => showPage(i);
        pagination.appendChild(btn);
      }
      if (page < totalPages) {
        const next = document.createElement('button');
        next.textContent = 'Selanjutnya →';
        next.className = 'px-3 py-1 border rounded bg-white';
        next.onclick = () => showPage(page + 1);
        pagination.appendChild(next);
      }
    }

    function filterBooks() {
      const search = document.getElementById('search').value.toLowerCase();
      const type = document.getElementById('filterType').value.toLowerCase();
      filteredBooks = bookCards.filter(card => {
        const name = card.dataset.name.toLowerCase();
        const category = card.dataset.type.toLowerCase();
        return name.includes(search) && (type === '' || category === type);
      });
      showPage(1);
    }

    function showBookDetails(book) {
    document.getElementById('bookImage').src = book.image;
    document.getElementById('bookName').textContent = book.judul;
    document.getElementById('author').textContent = book.pengarang;
    document.getElementById('publisher').textContent = book.penerbit;
    document.getElementById('year').textContent = book.tahun_terbit;
    document.getElementById('isbn').textContent = book.isbn;
    document.getElementById('type').textContent = book.kategori;
    document.getElementById('description').textContent = book.description;
    document.getElementById('bookModal').classList.remove('hidden');
  }

  function hideBookDetails() {
    document.getElementById('bookModal').classList.add('hidden');
  }

    document.getElementById('search').addEventListener('input', filterBooks);
    document.getElementById('filterType').addEventListener('change', filterBooks);
    showPage(currentPage);
  </script>
</body>
</html>
