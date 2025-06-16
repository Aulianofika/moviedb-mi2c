<!-- @extends('layouts.template')

@section('title', 'Data Movie')

@section('content')
    <h2 class="mb-4">Data Movie</h2>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-success">
            <tr>
                <th>No</th>
                <th>Cover</th>
                <th>Title</th>
                <th>Category</th>
                <th style="width: 180px;">Actors</th>
                <th>Year</th>
                <th style="width: 210px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($movies as $index => $movie)
                <tr>
                    <td>{{ $index + $movies->firstItem() }}</td>
                    <td>
                        @if ($movie->cover_image)
                            <img src="{{ asset($movie->cover_image) }}" alt="{{ $movie->title }}" style="width: 60px; height: 40px; object-fit: cover;">
                        @else
                            <span>-</span>
                        @endif
                    </td>
                    <td>{{ $movie->title }}</td>
                    <td>{{ $movie->category->category_name ?? '-' }}</td>
                    <td style="max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ $movie->actors }}
                    </td>
                    <td>{{ $movie->year }}</td>
                    <td>
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('movie.edit', $movie->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        @endif

                        @can('delete-movie')
                            <form action="{{ url('/movie/' . $movie->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        @endcan

                        <a href="{{ route('detail', $movie->id) }}" class="btn btn-sm btn-info">Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data movie.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        {{ $movies->links() }}
    </div>
@endsection -->
