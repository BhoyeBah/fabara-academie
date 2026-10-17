@extends('layouts.app', ['title' => 'Mot de passe oublié'])

@section('content')
<div class="wrap narrow auth stack">
    <h1>Mot de passe oublié</h1>
    <p class="muted">Entre ton adresse e-mail : nous t'envoyons un lien pour choisir un nouveau mot de passe.</p>
    @include('partials.errors')
    <form method="post" action="{{ route('password.email') }}" class="panel stack">
        @csrf
        <div class="f"><label for="email">Adresse e-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus></div>
        <button class="btn btn-main btn-block">Envoyer le lien</button>
    </form>
    <a href="{{ route('login') }}">← Retour à la connexion</a>
</div>
@endsection
