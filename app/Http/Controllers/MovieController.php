<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MovieController extends Controller
{
    // Menampilkan homepage dengan 6 movie terbaru (pagination)
    public function homepage()
    {
        $movies = Movie::latest()->paginate(6);
        return view('homepage', compact('movies'));
    }

    // Menampilkan detail movie berdasarkan ID
    public function show($id)
    {
        $movie = Movie::findOrFail($id);
        return view('detail', compact('movie'));
    }

    // Menampilkan form create movie
    public function create()
    {
        $categories = Category::all();
        return view('create_movie', compact('categories'));
    }

    // Menyimpan movie baru ke database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'synopsis' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'year' => 'required|integer',
            'actors' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Simpan file gambar ke storage/public/covers jika ada
        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('covers', 'public');
        } 

        // Generate slug dari title
        $slug = Str::slug($request->title);

        // Simpan data ke database dengan mass assignment
        Movie::create([
            'title' => $request->title,
            'slug' => $slug,
            'synopsis' => $request->synopsis,
            'category_id' => $request->category_id,
            'year' => $request->year,
            'actors' => $request->actors,
            'cover_image' => $coverPath,
        ]);

        return redirect('/')->with('success', 'Movie created successfully!');
    }
}
