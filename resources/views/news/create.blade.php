<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    // Menampilkan semua berita
    public function index()
    {
        $news = News::all(); // Ambil semua data berita
        return view('news', compact('news')); // Kirim data ke view
    }

    // Menampilkan detail berita
    public function show($id)
    {
        $news = News::findOrFail($id); // Cari berita berdasarkan ID
        $otherNews = News::where('id', '!=', $id)->take(3)->get(); // Ambil 3 berita lainnya
        return view('news.show', compact('news', 'otherNews')); // Kirim data ke view
    }

    // Menampilkan dashboard berita
    public function dashboard(Request $request)
    {
        $search = $request->query('search'); // Ambil parameter pencarian

        // Query data berita berdasarkan pencarian
        $news = News::when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })->get();

        return view('news.dashboard', compact('news')); // Kirim data ke view
    }

    // Menampilkan form tambah berita
    public function create()
    {
        return view('news.create'); // Pastikan file Blade ada di resources/views/news/create.blade.php
    }

    // Menyimpan berita baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:255',
            'description' => 'required|string',
            'source' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
        }

        News::create([
            'title' => $request->title,
            'short_description' => $request->short_description ?? '',
            'description' => $request->description,
            'source' => $request->source,
            'image' => $imagePath,
        ]);

        return redirect()->route('news.dashboard')->with('success', 'Berita berhasil ditambahkan.');
    }

    // Menampilkan form edit berita
    public function edit($id)
    {
        $news = News::findOrFail($id); // Cari berita berdasarkan ID
        return view('news.edit', compact('news')); // Kirim data ke view
    }

    // Memperbarui berita
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:255',
            'description' => 'required|string',
            'source' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $news = News::findOrFail($id); // Cari berita berdasarkan ID

        // Simpan gambar baru jika ada
        $imagePath = $news->image; // Simpan path gambar lama
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            // Simpan gambar baru
            $imagePath = $request->file('image')->store('news', 'public');
        }

        // Perbarui data berita
        $news->update([
            'title' => $request->title,
            'short_description' => $request->short_description ?? '',
            'description' => $request->description,
            'source' => $request->source,
            'image' => $imagePath, // Simpan path gambar baru atau lama
        ]);

        return redirect()->route('news.dashboard')->with('success', 'Berita berhasil diperbarui.');
    }

    // Menghapus berita
    public function destroy($id)
    {
        $news = News::findOrFail($id); // Cari berita berdasarkan ID

        if ($news->image) {
            Storage::disk('public')->delete($news->image); // Hapus gambar jika ada
        }
        $news->delete();

        return redirect()->route('news.dashboard')->with('success', 'Berita berhasil dihapus.');
    }
}