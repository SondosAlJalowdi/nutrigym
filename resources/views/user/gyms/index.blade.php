@extends('user.generalLayout')

@section('content')

<div class="container" style="min-height: 100vh; padding-top: 30px; margin-top: 150px;">
    {{-- Search & Filter Form --}}


    {{-- Title --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="section-title text-center">
                <h2>Available Gyms</h2>
            </div>
        </div>
    </div>
    <form method="GET" class="mb-4 p-3 rounded shadow-sm" style="border: 1px solid #f36100; background-color:rgba(0, 0, 0, 0.1);">
        <div class="row align-items-end">
            <div class="col-md-9">
                <input type="text" class="form-control border-0" name="search" id="search" placeholder="Search by Name or Location" value="{{ request('search') }}"  style="background-color: #000000;">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn text-white w-100 mr-2" style="background-color: #f36100; border: 2px solid #ffffff;">
                    <i class="fa-solid fa-search mr-2"></i> Search
                </button>
                <a href="{{ route('gyms.index') }}" class="btn w-100" style="border: 2px solid #f36100; color: #f36100; background-color: white;">
                    <i class="fa-solid fa-rotate-right mr-2"></i> Reset
                </a>
            </div>
        </div>
    </form>

    {{-- Gym Cards --}}
    <div class="row">
        @forelse($gyms as $gym)
        <div class="col-md-4 mb-4">
            <div class="card" style="border-radius: 10px; overflow: hidden; box-shadow: 0 0 10px rgba(207, 90, 12, 0.1); border-color:#f36100; border-width: 2px;">
                @if ($gym->image)
                    <img src="{{ asset('storage/providers/' . $gym->image) }}" alt="Gym Image" class="img-fluid" style="height: 200px; object-fit: cover; width: 100%;">
                @else
                    <img src="{{ asset('images/default-gym.jpg') }}" alt="Default Image" class="img-fluid" style="height: 200px; object-fit: cover; width: 100%;">
                @endif
                <div class="p-3">
                    <h4 class="mb-2 text-center">{{ $gym->user->name ?? 'Gym Name' }}</h4>
                    <p class="text-muted">Description: {{ Str::limit($gym->about, 100) }}</p>
                    <p><strong>Location:</strong> {{ $gym->user->location }}</p>
                    <a href="{{ route('gyms.show', $gym->id) }}" class="primary-btn d-block text-center">See Details</a>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center mt-4">
            <p>No gyms found.</p>
        </div>
        @endforelse
    </div>

    {{-- Styled Pagination --}}
    @if($gyms->hasPages())
    <div class="mt-1 d-flex justify-content-center mb-2">
        <nav>
            <ul class="pagination pagination-md custom-pagination">
                {{-- Previous Page Link --}}
                @if ($gyms->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $gyms->previousPageUrl() }}&search={{ $search }}">&laquo;</a></li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($gyms->getUrlRange(1, $gyms->lastPage()) as $page => $url)
                    <li class="page-item {{ $gyms->currentPage() == $page ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}&search={{ $search }}">{{ $page }}</a>
                    </li>
                @endforeach

                {{-- Next Page Link --}}
                @if ($gyms->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $gyms->nextPageUrl() }}&search={{ $search }}">&raquo;</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                @endif
            </ul>
        </nav>
    </div>
    @endif
</div>
@endsection


<style>
    .custom-pagination .page-link {
    color: #f36100; /* default text color (black) */
    background-color: rgb(43, 43, 43);
    border: 1px solid #f36100; /* orange border */
}

.custom-pagination .page-link:hover {
    background-color: #f36100; /* orange on hover */
    color: #fff;
    border-color: #f36100;

}

.custom-pagination .page-item.active .page-link {
    background-color: #f36100; /* active page - orange */
    border-color: #f36100;
    color: #fff;
    font-weight: bold;

}

.custom-pagination .page-item.disabled .page-link {
    background-color: rgb(43, 43, 43);
    color: #ffa467;
    border: 1px solid #f36100;
}



</style>
