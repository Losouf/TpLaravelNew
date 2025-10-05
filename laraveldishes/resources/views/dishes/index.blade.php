@extends('layouts.app')

@section('content')
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">{{ $title ?? 'Dishes' }}</h1>
    @can('create dishes')
      <a href="{{ route('dishes.create') }}" class="btn btn-primary">Nouveau plat</a>
    @endcan
  </div>

  @if(session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
  @endif

  @if($dishes->isEmpty())
    <div class="alert alert-info mb-0">Aucun plat à afficher.</div>
  @else
    <div class="row g-3">
      @foreach($dishes as $dish)
        <div class="col-md-3">
          <div class="card h-100">
            <img src="{{ asset('storage/'.$dish->image_path) }}" class="card-img-top" alt="{{ $dish->name }}">
            <div class="card-body">
              <h5 class="card-title mb-1">{{ $dish->name }}</h5>
              <small class="text-muted">par {{ $dish->creator->name }}</small>
            </div>
            <div class="card-footer d-flex gap-2">
              <a href="{{ route('dishes.show',$dish) }}" class="btn btn-sm btn-outline-secondary w-100">Voir</a>

              @if(!empty($isFavorites))
                <form method="POST" action="{{ route('dishes.unfavorite',$dish) }}" class="w-100">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger w-100">Retirer</button>
                </form>
              @else
                <form method="POST" action="{{ route('dishes.favorite',$dish) }}" class="w-100">
                  @csrf
                  <button class="btn btn-sm btn-outline-primary w-100">Favori</button>
                </form>
              @endif

            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="mt-3">{{ $dishes->links() }}</div>
  @endif
</div>
@endsection
