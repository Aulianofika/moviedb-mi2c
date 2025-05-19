<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    //
    public function homepage(){
        //untuk membuat halaman cuma 6 slide
        $movies = Movie::latest()->paginate(6);
        return view('homepage', compact('movies'));
    }
}
