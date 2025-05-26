@extends('layouts.template')

@section('content')
<h1>Input Movie</h1>

<form action="{{ url('/movie-store') }}" method="post" enctype="multipart/form-data">
    @csrf

    {{-- Title --}}
    <div class="mb-3 row">
        <label for="title" class="col-sm-2 col-form-label">Title</label>
        <div class="col-sm-10">
            <input type="text" name="title" class="form-control" id="title" required>
        </div>
    </div>

    {{-- Synopsis --}}
    <div class="mb-3 row">
        <label for="synopsis" class="col-sm-2 col-form-label">Synopsis</label>
        <div class="col-sm-10">
            <textarea name="synopsis" class="form-control" id="synopsis" rows="3" required></textarea>
        </div>
    </div>

    {{-- Category --}}
    <div class="mb-3 row">
        <label for="category_id" class="col-sm-2 col-form-label">Category</label>
        <div class="col-sm-10">
            <select name="category_id" id="category_id" class="form-select" required>
                <option disabled selected>-- Select Category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Year --}}
    <div class="mb-3 row">
        <label for="year" class="col-sm-2 col-form-label">Year</label>
        <div class="col-sm-10">
            <input type="number" name="year" class="form-control" id="year" required>
        </div>
    </div>

    {{-- Actors --}}
    <div class="mb-3 row">
        <label for="actors" class="col-sm-2 col-form-label">Actors</label>
        <div class="col-sm-10">
            <input type="text" name="actors" class="form-control" id="actors"  required>
        </div>
    </div>

    

    {{-- Cover Image Upload --}}
    <div class="mb-3 row">
        <label for="cover_image" class="col-sm-2 col-form-label">Cover Image</label>
        <div class="col-sm-10">
            <input type="file" name="cover_image" class="form-control" id="cover_image" required>
        </div>
    </div>

    <div class="mb-3 row">
        <div class="col-sm-10 offset-sm-2">
            <button type="submit" class="btn btn-success">Submit Movie</button>
        </div>
    </div>
</form>
@endsection
