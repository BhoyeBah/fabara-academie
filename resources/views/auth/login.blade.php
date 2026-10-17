@extends('layouts.app', ['title' => 'Connexion'])

@section('content')
<div class="wrap narrow auth stack">
    <h1>Connexion</h1>
    <p class="muted">Accède à tes formations et à tes commandes.</p>
    @php($pending = \App\Models\Course::find(session('pending_course')))
    @if($pending)
        <div class="alert">Formation choisie : <strong>{{ $pending->title }}</strong> ({{ gnf($pending->price) }}). Elle sera dans ton panier dès que ton compte sera prêt.</div>
    @endif
    @include('partials.errors')
    <form method="post" action="{{ route('login') }}" class="panel stack">
        @csrf
        <div class="f"><label for="email">Adresse e-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"></div>
        <div class="f"><label for="password">Mot de passe</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"></div>
        <label class="check"><input type="checkbox" name="remember" value="1"> Rester connecté sur cet appareil</label>
        <button class="btn btn-main btn-block">Se connecter</button>
        <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
    </form>
    <p>Pas encore de compte ? <a href="{{ route('register') }}">Inscris-toi</a></p>
</div>
@endsection
