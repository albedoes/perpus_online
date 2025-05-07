<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $news->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900" style="font-family: Arial;">

<!-- Navbar -->
<nav class="bg-gray-800 p-3 fixed top-0 w-full z-50">
    <div class="container mx-auto flex items-center justify-between">
        <div class="flex items-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-8 mr-3">
            <a class="text-white text-xl font-light" href="#">Endemic Animals</a>
        </div>
        <div class="flex space-x-6">
            <a href="/" class="text-white hover:text-green-400">Home</a>
            <a href="/news" class="text-white hover:text-green-400">Berita</a>
        </div>
    </div>
</nav>

<!-- Konten Berita -->
<div class="container mx-auto mt-16 p-4 max-w-4xl">
    <div class="flex items-center justify-between mb-4">
        <a href="/news" class="bg-gray-600 hover:bg-gray-700 text-white text-sm font-bold py-2 px-4 rounded"><</a>
        <h1 class="text-3xl font-bold text-green-800 text-center flex-1">Berita</h1>
    </div><br>
    <h1 class="text-3xl font-bold text-green-800">{{ $news->title }}</h1>
    <p class="text-gray-600 mb-2">{{ $news->short_description }}</p><br>
    <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full h-64 object-cover rounded-lg mb-4">
    <p class="text-gray-800 leading-relaxed break-words whitespace-pre-line">{{ $news->description }}</p><br>
    <p class="text-gray-600 mb-4">Sumber: {{ $news->source }}</p>
    <p class="text-gray-600 mb-4 text-right">{{ $news->created_at->format('d M Y') }}</p>
</div>

<!-- Komentar -->
<div id="disqus_thread" class="max-w-4xl mx-auto mt-8"></div>
<script>
    (function() { // DON'T EDIT BELOW THIS LINE
        var d = document, s = d.createElement('script');
        s.src = 'https://endemic-animal.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
    })();
</script>
<noscript>
    Please enable JavaScript to view the 
    <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a>
</noscript>

<!-- Berita Lainnya -->
<div class="container mx-auto mt-8 p-4 max-w-4xl">
    <h1 class="text-2xl font-bold text-green-800 mb-6">Berita Lainnya</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ($otherNews as $item)
            <div class="bg-white border rounded-md overflow-hidden shadow-md news-card">
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-semibold">{{ $item->title }}</h2>
                    <p class="text-gray-600 mt-2">{{ $item->short_description }}</p>
                    <p class="text-gray-500 text-sm text-right">{{ $item->created_at->format('d M Y') }}</p>
                    <a href="{{ route('news.show', $item->id) }}" class="text-green-600 hover:text-green-800 mt-4 inline-block">Baca Selengkapnya</a>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Footer -->
<footer class="bg-gray-800 text-white py-6 mt-8">
    <div class="container mx-auto text-center">
        <p class="text-sm">
            &copy; {{ date('Y') }} Endemic Animals. All rights reserved.
        </p>
    </div>
</footer>

</body>
</html>