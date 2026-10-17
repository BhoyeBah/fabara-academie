<div class="row" style="padding-block:28px 18px">
    <div><h1 style="font-size:clamp(1.6rem,3.4vw,2.2rem)">Bonjour {{ auth()->user()->name }}</h1></div>
    <nav class="tabs">
        <a class="tab {{ request()->routeIs('account.dashboard') ? 'on' : '' }}" href="{{ route('account.dashboard') }}">Mes formations</a>
        <a class="tab {{ request()->routeIs('account.profile') ? 'on' : '' }}" href="{{ route('account.profile') }}">Mon profil et mes données</a>
        <form method="post" action="{{ route('logout') }}" class="inline">@csrf<button class="tab linkbtn" style="text-decoration:none">Déconnexion</button></form>
    </nav>
</div>
