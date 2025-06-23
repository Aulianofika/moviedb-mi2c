<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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
//     public function data_movie()
// {
//     $movies =Movie::orderBy('created_at', 'desc')->paginate(10);
//     return view('admin.data_movie', compact('movies'));
// }
// public function edit($id)
//     {
//         $movie = Movie::findOrFail($id);
//         $categories = Category::all(); // untuk dropdown kategori
//         return view('admin.movie_edit', compact('movie', 'categories'));
//     }

   public function destroy($id)
{
    if(Gate::allows('delete')){
        $movie = Movie::findOrFail($id);
        $movie->delete();

         return redirect('/')->with('success', 'Movie berhasil dihapus!');
    }else{
        abort(403);
    }
}
//     public function update(Request $request, $id)
//     {
//         $request->validate([
//             'title' => 'required|string|max:255',
//             'synopsis' => 'required|string',
//             'category_id' => 'required|exists:categories,id',
//             'year' => 'required|integer|min:1990|max:' . date('Y'),
//             'actors' => 'required|string',
//             'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
//         ]);

//         $movie = Movie::findOrFail($id);

//         // Update fields
//         $movie->title = $request->title;
//         $movie->synopsis = $request->synopsis;
//         $movie->category_id = $request->category_id;
//         $movie->year = $request->year;
//         $movie->actors = $request->actors;

//         //image

//         if ($request->hasFile('cover_image')) {
//             $file = $request->file('cover_image');
//             $filename = time() . '_' . $file->getClientOriginalName();

//             // Pindahkan file ke folder 'covers' supaya sama dengan method store
//             $file->move(public_path('covers'), $filename);

//             // Hapus gambar lama jika ada
//             if ($movie->cover_image && file_exists(public_path($movie->cover_image))) {
//                 unlink(public_path($movie->cover_image));
//             }

//             // Simpan path relatif lengkap
//             $movie->cover_image = 'covers/' . $filename;
//         }

//         $movie->save();

//         return redirect()->route('dataMovie')->with('success', 'Movie berhasil diupdate.');
//     }
    // public function detail($id)
    // {
    //     $movie = Movie::find($id);
    //     return view('admin.detail_movie', compact('movie'));
    // }

    public function edit($id)
{
    $movie = Movie::findOrFail($id);
    $categories = Category::all();
    return view('edit-movie', compact('movie', 'categories'));
}

public function update(Request $request, $id)
{
    $movie = Movie::findOrFail($id);


    $request->validate([
        'title' => 'required|max:255',
        'synopsis' => 'nullable',
        'category_id' => 'required|exists:categories,id',
        'year' => 'required|digits:4|integer',
        'actors' => 'nullable',
        'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // update cover
    // Jika ada gambar baru diupload
    if ($request->hasFile('cover_image')) {
        // Hapus file lama jika ada
        if ($movie->cover_image && file_exists(storage_path('app/public/' . $movie->cover_image))) {
            unlink(storage_path('app/public/' . $movie->cover_image));
        }

        // Simpan file baru
        $coverPath = $request->file('cover_image')->store('covers', 'public');
        $movie->cover_image = $coverPath;
    }


    $movie->update([
        'title' => $request->title,
        'slug' => Str::slug($request->title),
        'synopsis' => $request->synopsis,
        'category_id' => $request->category_id,
        'year' => $request->year,
        'actors' => $request->actors,
        'cover_image' => $movie->cover_image, // jika tetap pake cover lama
    ]);

    return redirect('/')->with('success', 'Movie berhasil diperbarui!');
}
    
}
