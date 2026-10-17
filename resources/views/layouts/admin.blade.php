<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title ?? 'Admin' }} · {{ setting('brand') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
<div class="admin-layout">
    <nav class="side" aria-label="Menu admin">
        <a class="logo" href="{{ route('admin.dashboard') }}"><b>{{ mb_strtoupper(mb_substr(setting('brand'), 0, 1)) }}</b><span>Admin</span></a>
        @php($pending = \App\Models\Order::where('status', 'pending')->count())
        <a class="{{ request()->routeIs('admin.dashboard') ? 'on' : '' }}" href="{{ route('admin.dashboard') }}">Tableau de bord</a>
        <a class="{{ request()->routeIs('admin.orders.*') ? 'on' : '' }}" href="{{ route('admin.orders.index') }}">Commandes @if($pending)<span class="badge">{{ $pending }}</span>@endif</a>
        <a class="{{ request()->routeIs('admin.courses.*') ? 'on' : '' }}" href="{{ route('admin.courses.index') }}">Formations</a>
        <a class="{{ request()->routeIs('admin.categories.*') ? 'on' : '' }}" href="{{ route('admin.categories.index') }}">Domaines</a>
        <a class="{{ request()->routeIs('admin.users.*') ? 'on' : '' }}" href="{{ route('admin.users.index') }}">Clients</a>
        <a class="{{ request()->routeIs('admin.settings.*') ? 'on' : '' }}" href="{{ route('admin.settings.edit') }}">Réglages</a>
        <a class="{{ request()->routeIs('admin.profile.*') ? 'on' : '' }}" href="{{ route('admin.profile.edit') }}">Mon login</a>
        <a href="{{ route('catalog.index') }}" target="_blank">Voir le site ↗</a>
        <form method="post" action="{{ route('logout') }}">@csrf<button class="btn btn-ghost btn-sm btn-block">Déconnexion</button></form>
    </nav>
    <main class="admin-main stack">
        @include('partials.flash')
        @include('partials.errors')
        @yield('content')
    </main>
</div>
</body>
</html>
