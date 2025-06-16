@extends('layouts.template')

@section('content')
    <h1>Latest Movie</h1>
    @if (session('success'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{session('success')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    
    @endif
    <div  class="row">
        <!-- ini untuk perulangan 6x -->
        @foreach ($movies as $movie) 

        <div class="col-lg-6">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                    <img src="{{ asset('storage/'.$movie->cover_image) }}" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $movie->title }}</h5>
                        <p class="card-text">{{Str::words($movie->synopsis, 20,'...') }}</p>
                    <a href="{{ route('movie.detail', $movie->id) }}" class="btn btn-success">See More</a>
                    @auth
                        <a href="{{ route('movies.edit', $movie->id) }}" class="btn btn-primary ms-2">Edit</a>
                        @can('delete')
                        <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" class="d-inline ms-2" onsubmit="return confirm('Are you sure you want to delete this movie?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        @endcan
                        @endauth
                    </div>
                    </div>
                </div>
                </div>
        </div>
        @endforeach
        {{ $movies->links() }}

    </div>

@endsection
