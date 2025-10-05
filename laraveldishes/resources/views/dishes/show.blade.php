@extends('layouts.app')
@section('content')
<div class="container">
  @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif

  <div class="row">
    <div class="col-md-6">
      <img src="{{ asset('storage/'.$dish->image_path) }}" class="img-fluid rounded" alt="{{ $dish->name }}">
    </div>
    <div class="col-md-6">
      <h1 class="h3">{{ $dish->name }}</h1>
      <p class="text-muted">par {{ $dish->creator->name }}</p>
      <p>{{ $dish->description }}</p>

      <div class="d-flex gap-2">
        <form method="POST" action="{{ route('dishes.favorite',$dish) }}"> @csrf <button class="btn btn-primary">Ajouter aux favoris</button></form>
        <form method="POST" action="{{ route('dishes.unfavorite',$dish) }}"> @csrf @method('DELETE') <button class="btn btn-outline-secondary">Retirer</button></form>
        @can('delete dishes')
          <form method="POST" action="{{ route('dishes.destroy',$dish) }}"> @csrf @method('DELETE') <button class="btn btn-danger">Supprimer</button></form>
        @endcan
      </div>
    </div>
  </div>

  <hr class="my-4">
  <h2 class="h5">Recette</h2>
  <pre class="bg-light p-3 rounded">{{ $dish->recipe }}</pre>
</div>
@endsection
