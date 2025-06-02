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
      background-color: #232323; /* Warna coklat tua yang lebih gelap untuk kontras */
    }

    .text-brown {
      color: #3e2c23; /* Warna teks coklat yang lebih lembut */
    }

    .border-brown {
      border-color: #3e2c23;
    }
    /* Tambahan untuk tombol modal agar tidak tertutup oleh footer */
    #bookModal .fixed.bottom-8.right-8 {
        z-index: 60; /* Pastikan lebih tinggi dari z-index footer jika footer juga fixed */
    }
  </style>
</head>
<body class="text-gray-900 leading-relaxed">

  <nav class="bg-gray-800 p-4 fixed top-0 w-full z-50 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
      <div class="flex items-center gap-2">
        <img src="{{ asset('images/logo.png') }}" alt="Logo PustakaKu" class="h-8 w-8" onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');">
        <span class="text-white text-xl font-bold tracking-wide headline hidden">P</span> <a href="/" class="text-white text-xl font-bold tracking-wide headline">PustakaKu</a>
      </div>
      <a href="/" class="text-gray-300 hover:text-white">Home</a>
    </div>
  </nav>

  <section class="bg-brown text-white py-16 text-center mt-16">
    <div class="container mx-auto px-4">
      <h1 class="text-4xl md:text-5xl font-bold mb-3 headline">Pustaka Digital Anda</h1>
      <p class="text-lg max-w-2xl mx-auto">Koleksi buku klasik dan modern dalam gaya koran yang elegan</p>
    </div>
  </section>

  <section class="container mx-auto px-4 py-8 section">
    <div class="bg-white shadow-md border border-gray-200 rounded-lg p-6 max-w-3xl mx-auto">
      <div class="flex flex-col md:flex-row gap-4">
        <input type="text" id="search" placeholder="Cari judul atau penulis..."
          class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-brown-dark" />
        <select id="filterType"
          class="border border-gray-300 rounded-md px-4 py-2 text-gray-700 focus:ring-2 focus:ring-brown-dark">
          <option value="">Semua Kategori</option>
          <option value="Fiksi">Fiksi</option>
          <option value="Non-Fiksi">Non-Fiksi</option>
          <option value="Referensi">Referensi</option>
          </select>
      </div>
    </div>
  </section>

  <section class="container mx-auto px-4 py-8">
    <div id="book-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      {{-- Diasumsikan $buku adalah collection yang di-pass dari controller --}}
      @forelse($buku as $bukuItem)
      <div class="book-card bg-white rounded-lg overflow-hidden shadow-sm border border-gray-200 flex flex-col" 
           data-kategori="{{ $bukuItem->kategori }}" 
           data-judul="{{ $bukuItem->judul }}"
           data-pengarang="{{ $bukuItem->pengarang ?? 'Penulis tidak diketahui' }}"
           data-penerbit="{{ $bukuItem->penerbit ?? '-' }}"
           data-tahun_terbit="{{ $bukuItem->tahun_terbit ?? '-' }}"
           data-isbn="{{ $bukuItem->isbn ?? '-' }}"
           {{-- Untuk deskripsi yang panjang atau mengandung karakter khusus, pertimbangkan untuk mengambilnya via AJAX atau pastikan di-escape dengan benar --}}
           data-description="{{ $bukuItem->description ?? 'Tidak ada deskripsi tersedia.' }}"
           data-image="{{ asset('storage/' . $bukuItem->image) }}"
           data-file_pdf="{{ asset('storage/' . $bukuItem->file) }}">
        
        <div class="w-full h-60 overflow-hidden">
          <img src="{{ asset('storage/' . $bukuItem->image) }}" class="w-full h-full object-cover" alt="Sampul {{ $bukuItem->judul }}" 
               onerror="this.onerror=null; this.src='https://placehold.co/400x600/E0E0E0/757575?text=Sampul+Tidak+Ada';">
        </div>
        <div class="p-4 flex flex-col flex-grow">
          <h3 class="font-semibold text-gray-800 mb-1 text-lg">{{ $bukuItem->judul }}</h3>
          <p class="text-gray-600 text-sm mb-3">{{ $bukuItem->pengarang ?? 'Penulis tidak diketahui' }}</p>
          <span class="inline-block self-start px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-700 mb-3">
            {{ $bukuItem->kategori }}
          </span>
          <div class="mt-auto"> {{-- Mendorong tombol ke bawah jika kartu memiliki tinggi yang bervariasi --}}
            <button class="selengkapnya-btn mt-4 text-sm bg-brown text-white px-4 py-2 rounded hover:bg-opacity-90 transition w-full">Selengkapnya</button>
          </div>
        </div>
      </div>
      @empty
      <div class="col-span-full text-center py-10">
          <p class="text-gray-500 text-xl">Belum ada buku yang tersedia.</p>
          {{-- Anda bisa menambahkan link untuk admin menambah buku jika user adalah admin --}}
      </div>
      @endforelse
    </div>
  </section>

  <div id="pagination" class="flex justify-center mt-10 mb-16 gap-2"></div>

  <div id="bookModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modalTitle" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-black bg-opacity-40 backdrop-blur-sm" onclick="hideBookDetails()"></div>

    <div class="relative z-10 flex items-center justify-center min-h-screen p-4">
      <div class="bg-[#fffdfa] rounded-lg shadow-xl w-full max-w-4xl border border-gray-300 transform transition-all max-h-[90vh] overflow-y-auto">
        <div class="relative p-6 md:p-8">
          <button onclick="hideBookDetails()" class="absolute top-4 right-4 text-gray-600 hover:text-gray-800" aria-label="Tutup modal">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>

          <div class="flex flex-col md:flex-row gap-6 md:gap-8">
            <div class="md:w-1/3">
              <img id="modalBookImage" class="w-full rounded border border-gray-300 shadow-md" src="" alt="Sampul Buku">
            </div>
            <div class="md:w-2/3">
              <h2 id="modalBookName" class="text-2xl lg:text-3xl font-serif font-bold text-brown mb-2"></h2>
              <p class="text-sm text-gray-700 italic mb-4" id="modalAuthor"></p>

              <div class="grid grid-cols-2 gap-x-4 gap-y-3 text-sm mb-4">
                <div>
                  <h4 class="text-gray-500 font-medium">Penerbit</h4>
                  <p id="modalPublisher" class="text-gray-800"></p>
                </div>
                <div>
                  <h4 class="text-gray-500 font-medium">Tahun Terbit</h4>
                  <p id="modalYear" class="text-gray-800"></p>
                </div>
                <div>
                  <h4 class="text-gray-500 font-medium">ISBN</h4>
                  <p id="modalIsbn" class="text-gray-800"></p>
                </div>
                <div>
                  <h4 class="text-gray-500 font-medium">Kategori</h4>
                  <p id="modalKategori" class="text-gray-800"></p>
                </div>
              </div>

              <div class="border-t pt-4">
                <h3 class="text-base font-semibold text-gray-800 mb-2">Deskripsi</h3>
                <div id="modalDescription" class="text-gray-700 text-sm whitespace-pre-line prose prose-sm max-w-none" style="column-count:2; column-gap:2rem;"></div>
              </div>
            </div>
          </div>
      
          <div class="fixed bottom-6 right-6 md:bottom-8 md:right-8">
            <a id="modalReadLink" href="#" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-brown text-white px-5 py-3 rounded-lg shadow-lg hover:bg-opacity-90 transition text-sm font-medium">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
              Baca Buku
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="bg-brown text-white py-6 mt-16 text-center">
    <p class="text-sm text-gray-300">&copy; {{ date('Y') }} PustakaKu - Gaya Klasik. Hak cipta dilindungi.</p>
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      let currentPage = 1;
      const itemsPerPage = 8; // Jumlah buku per halaman
      const allBookCards = Array.from(document.querySelectorAll('.book-card'));
      let filteredBooks = allBookCards;

      const bookListContainer = document.getElementById('book-list');
      const bookModal = document.getElementById('bookModal');
      const searchInput = document.getElementById('search');
      const filterTypeSelect = document.getElementById('filterType');

      // Elements in Modal
      const modalBookImage = document.getElementById('modalBookImage');
      const modalBookName = document.getElementById('modalBookName');
      const modalAuthor = document.getElementById('modalAuthor');
      const modalPublisher = document.getElementById('modalPublisher');
      const modalYear = document.getElementById('modalYear');
      const modalIsbn = document.getElementById('modalIsbn');
      const modalKategori = document.getElementById('modalKategori');
      const modalDescription = document.getElementById('modalDescription');
      const modalReadLink = document.getElementById('modalReadLink');

      function showPage(page) {
        currentPage = page; // Update currentPage global
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        
        // Sembunyikan semua kartu buku terlebih dahulu di dalam #book-list
        allBookCards.forEach(card => card.style.display = 'none');
        
        // Tampilkan hanya kartu buku yang terfilter untuk halaman saat ini
        const booksToShow = filteredBooks.slice(startIndex, endIndex);
        booksToShow.forEach(card => card.style.display = 'flex'); // Gunakan 'flex' jika book-card adalah flex container

        updatePaginationButtons(page);
        // Scroll ke atas daftar buku, bukan ke paling atas halaman
        const bookListTop = bookListContainer.offsetTop - 80; // 80 adalah perkiraan tinggi navbar
         window.scrollTo({ top: bookListTop, behavior: 'smooth' });
      }

      function updatePaginationButtons(activePage) {
        const paginationContainer = document.getElementById('pagination');
        paginationContainer.innerHTML = ''; // Kosongkan tombol pagination sebelumnya
        const totalPages = Math.ceil(filteredBooks.length / itemsPerPage);

        if (totalPages <= 1) return; // Jangan tampilkan pagination jika hanya 1 halaman atau kurang

        // Tombol Sebelumnya
        if (activePage > 1) {
          const prevButton = createPaginationButton('← Sebelumnya', () => showPage(activePage - 1));
          paginationContainer.appendChild(prevButton);
        }

        // Tombol Halaman
        // Logika untuk menampilkan sejumlah tombol halaman (misal, maks 5 tombol)
        let startPage = Math.max(1, activePage - 2);
        let endPage = Math.min(totalPages, activePage + 2);

        if (activePage <= 3) {
            endPage = Math.min(totalPages, 5);
        }
        if (activePage > totalPages - 3) {
            startPage = Math.max(1, totalPages - 4);
        }
        
        if (startPage > 1) {
            paginationContainer.appendChild(createPaginationButton('1', () => showPage(1)));
            if (startPage > 2) {
                const dots = document.createElement('span');
                dots.textContent = '...';
                dots.className = 'px-3 py-1 text-gray-500';
                paginationContainer.appendChild(dots);
            }
        }

        for (let i = startPage; i <= endPage; i++) {
          const pageButton = createPaginationButton(i.toString(), () => showPage(i), i === activePage);
          paginationContainer.appendChild(pageButton);
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                 const dots = document.createElement('span');
                dots.textContent = '...';
                dots.className = 'px-3 py-1 text-gray-500';
                paginationContainer.appendChild(dots);
            }
            paginationContainer.appendChild(createPaginationButton(totalPages.toString(), () => showPage(totalPages)));
        }


        // Tombol Selanjutnya
        if (activePage < totalPages) {
          const nextButton = createPaginationButton('Selanjutnya →', () => showPage(activePage + 1));
          paginationContainer.appendChild(nextButton);
        }
      }
      
      function createPaginationButton(text, onClickAction, isActive = false) {
          const button = document.createElement('button');
          button.textContent = text;
          button.className = `px-3 py-1 border rounded transition-colors duration-150 ease-in-out ${isActive ? 'bg-brown text-white cursor-default' : 'bg-white text-gray-800 hover:bg-gray-100'}`;
          button.onclick = onClickAction;
          if (isActive) {
              button.disabled = true; // Menonaktifkan tombol halaman saat ini
          }
          return button;
      }


      function filterAndPaginateBooks() {
        const searchTerm = searchInput.value.toLowerCase();
        const filterCategory = filterTypeSelect.value.toLowerCase();

        filteredBooks = allBookCards.filter(card => {
          const title = card.dataset.judul.toLowerCase();
          const author = card.dataset.pengarang.toLowerCase(); // Asumsi ada data-pengarang
          const category = card.dataset.kategori.toLowerCase();
          
          const matchesSearch = title.includes(searchTerm) || author.includes(searchTerm);
          const matchesCategory = filterCategory === '' || category === filterCategory;
          
          return matchesSearch && matchesCategory;
        });
        showPage(1); // Selalu kembali ke halaman pertama setelah filter
      }

      function showBookDetailsModal(bookData) {
        modalBookImage.src = bookData.image;
        modalBookImage.alt = `Sampul ${bookData.judul}`;
        modalBookName.textContent = bookData.judul;
        modalAuthor.textContent = `oleh ${bookData.pengarang}`;
        modalPublisher.textContent = bookData.penerbit;
        modalYear.textContent = bookData.tahun_terbit;
        modalIsbn.textContent = bookData.isbn;
        modalKategori.textContent = bookData.kategori;
        modalDescription.textContent = bookData.description; // Pastikan deskripsi tidak mengandung HTML berbahaya jika tidak di-sanitize
        modalReadLink.href = bookData.file_pdf;
        
        bookModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Mencegah scroll body saat modal terbuka
      }

      window.hideBookDetails = function() { // Buat global agar bisa diakses dari onclick di HTML
        bookModal.classList.add('hidden');
        document.body.style.overflow = ''; // Kembalikan scroll body
      }

      // Event listener untuk tombol "Selengkapnya" menggunakan event delegation
      if (bookListContainer) {
        bookListContainer.addEventListener('click', function(event) {
          const selengkapnyaButton = event.target.closest('.selengkapnya-btn');
          if (selengkapnyaButton) {
            const card = selengkapnyaButton.closest('.book-card');
            if (card) {
              const bookData = {
                judul: card.dataset.judul,
                pengarang: card.dataset.pengarang,
                penerbit: card.dataset.penerbit,
                tahun_terbit: card.dataset.tahun_terbit,
                isbn: card.dataset.isbn,
                description: card.dataset.description,
                kategori: card.dataset.kategori,
                image: card.dataset.image,
                file_pdf: card.dataset.file_pdf
              };
              showBookDetailsModal(bookData);
            }
          }
        });
      }

      // Event listeners untuk filter dan search
      if (searchInput) {
        searchInput.addEventListener('input', filterAndPaginateBooks);
      }
      if (filterTypeSelect) {
        filterTypeSelect.addEventListener('change', filterAndPaginateBooks);
      }
      
      // Inisialisasi tampilan buku dan pagination saat halaman dimuat
      if (allBookCards.length > 0) {
        showPage(1);
      } else {
        // Jika tidak ada buku, mungkin sembunyikan pagination atau tampilkan pesan
        document.getElementById('pagination').innerHTML = '';
      }
    });
  </script>
</body>
</html>
