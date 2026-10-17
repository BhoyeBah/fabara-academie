<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ isset($title) ? $title.' · ' : '' }}{{ setting('brand') }}</title>
    <meta name="description" content="{{ $description ?? 'Formations vidéo complètes en français, livrées sur Google Drive après paiement Mobile Money.' }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
<header class="top">
    <div class="wrap">
        <a class="logo" href="{{ route('catalog.index') }}"><b>{{ mb_strtoupper(mb_substr(setting('brand'), 0, 1)) }}</b><span>{{ setting('brand') }}</span></a>
        <form class="search" action="{{ route('catalog.index') }}" method="get" role="search">
            <label class="sr" for="q">Rechercher une formation</label>
            <input id="q" type="search" name="q" value="{{ request('q') }}" placeholder="Rechercher : Excel, AutoCAD, anglais…">
        </form>
        <nav class="nav">
            @auth
                <a class="btn btn-ghost btn-sm" href="{{ route('cart.index') }}">Panier @if(count(session('cart', [])))<span class="badge">{{ count(session('cart', [])) }}</span>@endif</a>
                @if(auth()->user()->isAdmin())
                    <a class="btn btn-main btn-sm" href="{{ route('admin.dashboard') }}">Espace admin</a>
                @else
                    <a class="btn btn-main btn-sm" href="{{ route('account.dashboard') }}">Mon compte</a>
                @endif
            @else
                <a class="btn btn-ghost btn-sm" href="{{ route('login') }}">Connexion</a>
                <a class="btn btn-main btn-sm" href="{{ route('register') }}">Inscription</a>
            @endauth
        </nav>
    </div>
</header>

<main>
    <div class="wrap">@include('partials.flash')</div>
    @yield('content')
</main>

<footer class="site">
    <div class="wrap">
        <span>© {{ date('Y') }} {{ setting('brand') }} · {{ setting('city') }}</span>
        <nav>
            <a href="{{ route('pages.terms') }}">Conditions d'utilisation</a>
            <a href="{{ route('pages.privacy') }}">Confidentialité</a>
            <a href="{{ route('pages.deletion') }}">Supprimer mon compte</a>
            <a href="{{ wa_link(setting('whatsapp'), 'Bonjour '.setting('brand').', j\'ai une question.') }}" target="_blank" rel="noopener">Nous contacter</a>
        </nav>
    </div>
</footer>
</body>
</html>
