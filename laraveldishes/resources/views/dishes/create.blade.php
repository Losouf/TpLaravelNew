@extends('layouts.app')
@section('content')
<div class="container">
  <h1 class="h3 mb-3">Créer un plat</h1>
  <form method="POST" action="{{ route('dishes.store') }}" enctype="multipart/form-data" class="card p-3">
    @csrf
    <div class="mb-3"><label class="form-label">Nom</label><input name="name" class="form-control" value="{{ old('name') }}">@error('name')<div class="text-danger small">{{ $message }}</div>@enderror</div>
    <div class="mb-3"><label class="form-label">Image</label><input type="file" name="image" class="form-control">@error('image')<div class="text-danger small">{{ $message }}</div>@enderror</div>
    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>@error('description')<div class="text-danger small">{{ $message }}</div>@enderror</div>
    <div class="mb-3"><label class="form-label">Recette</label><textarea name="recipe" rows="6" class="form-control">{{ old('recipe') }}</textarea>@error('recipe')<div class="text-danger small">{{ $message }}</div>@enderror</div>
    <button class="btn btn-primary">Publier</button>
  </form>
</div>
@endsection
