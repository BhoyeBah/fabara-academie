@extends('layouts.app', ['title' => 'Page introuvable'])

@section('content')
<div class="wrap narrow auth stack">
    <h1>Page introuvable</h1>
    <p class="muted">Cette page n'existe pas ou n'est plus disponible.</p>
    <div><a class="btn btn-main" href="{{ route('catalog.index') }}">Voir les formations</a></div>
</div>
@endsection
