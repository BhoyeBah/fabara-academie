@extends('layouts.app', ['title' => 'Nouveau mot de passe'])

@section('content')
<div class="wrap narrow auth stack">
    <h1>Nouveau mot de passe</h1>
    @include('partials.errors')
    <form method="post" action="{{ route('password.update') }}" class="panel stack">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="f"><label for="email">Adresse e-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email', $email) }}" required></div>
        <div class="f"><label for="password">Nouveau mot de passe</label>
            <input id="password" type="password" name="password" required minlength="8" autocomplete="new-password"></div>
        <div class="f"><label for="password_confirmation">Confirme le mot de passe</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"></div>
        <button class="btn btn-main btn-block">Enregistrer</button>
    </form>
</div>
@endsection
