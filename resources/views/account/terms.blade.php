@extends('layouts.app', ['title' => 'Mise à jour des conditions'])

@section('content')
<div class="wrap narrow auth stack">
    <h1>Nos conditions ont changé</h1>
    <p>Merci de lire et d'accepter la nouvelle version pour continuer à utiliser ton compte.</p>
    @include('partials.errors')
    <form method="post" action="{{ route('terms.accept') }}" class="panel stack">
        @csrf
        <label class="check"><input type="checkbox" name="terms" value="1" required>
            <span>J'accepte les <a href="{{ route('pages.terms') }}" target="_blank">conditions d'utilisation</a> et la <a href="{{ route('pages.privacy') }}" target="_blank">politique de confidentialité</a>.</span></label>
        <button class="btn btn-main btn-block">Continuer</button>
    </form>
    <form method="post" action="{{ route('logout') }}">@csrf<button class="linkbtn">Me déconnecter</button></form>
</div>
@endsection
