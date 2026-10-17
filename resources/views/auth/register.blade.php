@extends('layouts.app', ['title' => 'Inscription'])

@section('content')
<div class="wrap narrow auth stack">
    <h1>Créer mon compte</h1>
    <p class="muted">Ton compte te permet de commander et de retrouver tes formations à tout moment.</p>
    @php($pending = \App\Models\Course::find(session('pending_course')))
    @if($pending)
        <div class="alert">Formation choisie : <strong>{{ $pending->title }}</strong> ({{ gnf($pending->price) }}). Elle sera dans ton panier dès que ton compte sera prêt.</div>
    @endif
    @include('partials.errors')
    <form method="post" action="{{ route('register') }}" class="panel stack">
        @csrf
        <div class="f"><label for="name">Nom complet</label>
            <input id="name" name="name" value="{{ old('name') }}" required maxlength="100" autocomplete="name"></div>
        <div class="f"><label for="email">Adresse e-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"></div>
        <div class="f"><label for="phone">Numéro WhatsApp</label>
            <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required placeholder="224 620 00 00 00" autocomplete="tel">
            <small>Utilisé uniquement pour confirmer ton paiement et t'envoyer tes formations.</small></div>
        <div class="f"><label for="password">Mot de passe</label>
            <input id="password" type="password" name="password" required minlength="8" autocomplete="new-password">
            <small>8 caractères minimum, avec des lettres et des chiffres.</small></div>
        <div class="f"><label for="password_confirmation">Confirme le mot de passe</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"></div>
        <label class="check"><input type="checkbox" name="terms" value="1" {{ old('terms') ? 'checked' : '' }} required>
            <span>J'ai lu et j'accepte les <a href="{{ route('pages.terms') }}" target="_blank">conditions d'utilisation</a> et la <a href="{{ route('pages.privacy') }}" target="_blank">politique de confidentialité</a>.</span></label>
        <button class="btn btn-main btn-block">Créer mon compte</button>
    </form>
    <p>Déjà inscrit ? <a href="{{ route('login') }}">Connecte-toi</a></p>
</div>
@endsection
