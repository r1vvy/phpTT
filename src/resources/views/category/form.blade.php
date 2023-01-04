@extends('layout')
@section('content')
<h1>{{ $title }}</h1>
@if ($errors->any())
<div class="alert alert-danger">Lūdzu, novērsiet radušās kļūdas!</div>
@endif
<form method="post" action="{{ $category->exists ? '/categories/patch/' . $category->id : '/categories/put' }}">
    @csrf
    <div class="mb-3">
        <label for="category-name" class="form-label">Nosaukums</label>
        <input type="text" id="category-name" name="name" value="{{ old('name', $category->name) }}" class="form-control @error('name') is-invalid @enderror">
        @error('name')
        <p class="invalid-feedback">{{ $errors->first('name') }}</p>
        @enderror
    </div>
    </div>
    <button type="submit" class="btn btn-primary">
        {{ $category->exists ? 'Atjaunot ierakstu' : 'Pievienot ierakstu' }}
    </button>
</form>
@endsection