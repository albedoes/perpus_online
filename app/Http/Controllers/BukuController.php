<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        return Buku::all();
    }

    public function create()
    {
        return view('admin.create');
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        return view('admin.edit', compact('buku'));
    }

    public function store(Request $request)
    {
        $request->validate([    
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4|integer',
            'isbn' => 'nullable|string|max:20',
            'kategori' => 'required|string|max:50',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file' => 'nullable|mimes:pdf|max:10240', // maks 10MB

        ]);

        $imagePath = null;
        $filePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('buku', 'public');
        }

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('buku_files', 'public');
        }

        try {
            Buku::create([
                'judul' => $request->judul,
                'pengarang' => $request->pengarang,
                'penerbit' => $request->penerbit,
                'tahun_terbit' => $request->tahun_terbit,
                'isbn' => $request->isbn,
                'kategori' => $request->kategori,
                'description' => $request->description,
                'image' => $imagePath, 
                'file' => $filePath,
            ]);

            return redirect()->route('admin.dashboard')->with('success', 'Buku berhasil ditambahkan!');
        } catch (\Exception $e) {
            \Log::error('Error saat menyimpan buku: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function show($id)
    {
        $buku = Buku::findOrFail($id);

        return response()->json([
            'id' => $buku->id,
            'judul' => $buku->judul,
            'pengarang' => $buku->pengarang,
            'penerbit' => $buku->penerbit,
            'tahun_terbit' => $buku->tahun_terbit,
            'isbn' => $buku->isbn,
            'kategori' => $buku->kategori,
            'description' => $buku->description,
            'image' => $buku->image ? asset('storage/' . $buku->image) : null,
            'created_at' => $buku->created_at,
            'updated_at' => $buku->updated_at,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4|integer',
            'isbn' => 'nullable|string|max:20',
            'kategori' => 'required|string|max:50',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file' => 'nullable|mimes:pdf,doc,docx,txt|max:10240',
        ]);

        $buku = Buku::findOrFail($id);

        $buku->update([
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'isbn' => $request->isbn,
            'kategori' => $request->kategori,
            'description' => $request->description,
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($buku->image) {
                Storage::disk('public')->delete($buku->image);
            }
            // Simpan gambar baru
            $imagePath = $request->file('image')->store('buku', 'public');
            $buku->image = $imagePath;
            $buku->save();
        }

        if ($request->hasFile('file')) {
            if ($buku->file) {
                Storage::disk('public')->delete($buku->file);  // hapus file pdf lama
            }
            $filePath = $request->file('file')->store('buku_files', 'public');
            $buku->file = $filePath;
            $buku->save();
        }

        $buku->save();

        return redirect()->route('admin.dashboard')->with('success', 'Data buku diperbarui!');
    }

    public function dashboard(Request $request)
    {
        $search = $request->query('search');

        $buku = Buku::when($search, function ($query, $search) {
            return $query->where('judul', 'like', '%' . $search . '%');
        })->get();

        return view('admin.dashboard', compact('buku'));
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->image) {
            Storage::disk('public')->delete($buku->image);
        }

        $buku->delete();

        return response()->json(['message' => 'Buku berhasil dihapus.']);
    }

    public function baca($id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.baca', compact('buku'));
    }
}
