<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // Periksa apakah user memiliki role admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('bukus')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $bukus = Buku::all();
        // Ambil parameter pencarian
        $search = $request->query('search');

        // Query data hewan berdasarkan pencarian
        $bukus = Buku::when($search, function ($query, $search) {
            return $query->where('judul', 'like', '%' . $search . '%');
        })->get();

        // Kirim data ke view
        return view('admin.dashboard', compact('bukus'));

        

    }
    
}