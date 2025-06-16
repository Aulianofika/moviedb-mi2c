@extends('layouts.template')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Edit Movie</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" name="title" id="title" class="form-control"
                   value="{{ old('title', $movie->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="synopsis" class="form-label">Synopsis</label>
            <textarea name="synopsis" id="synopsis" class="form-control" rows="4">{{ old('synopsis', $movie->synopsis) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select name="category_id" id="category_id" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ $category->id == $movie->category_id ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Tahun</label>
            <input type="text" name="year" id="year" class="form-control"
                   value="{{ old('year', $movie->year) }}" required>
        </div>

        <div class="mb-3">
            <label for="actors" class="form-label">Aktor</label>
            <input type="text" name="actors" id="actors" class="form-control"
                   value="{{ old('actors', $movie->actors) }}">
        </div>

        <div class="mb-3">
            <label for="cover" class="form-label">Cover</label>
            <input type="file" name="cover" id="cover" class="form-control">
            @if($movie->cover_image)
                <img src="{{ asset('covers/' . $movie->cover_image) }}" alt="Cover Image" class="img-thumbnail mt-2" width="150">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Movie</button>
        <a href="{{ url('/') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection