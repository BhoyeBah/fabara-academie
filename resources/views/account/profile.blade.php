@extends('layouts.app', ['title' => 'Mon profil'])

@section('content')
<div class="wrap mid stack" style="padding-bottom:40px">
    @include('account._nav')
    @include('partials.errors')

    <form method="post" action="{{ route('account.profile.update') }}" class="panel stack">
        @csrf @method('put')
        <h2 style="font-size:1.2rem">Mes informations</h2>
        <div class="form">
            <div class="f"><label for="name">Nom complet</label><input id="name" name="name" value="{{ old('name', $user->name) }}" required></div>
            <div class="f"><label for="phone">Numéro WhatsApp</label><input id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required></div>
            <div class="f full"><label for="email">Adresse e-mail</label><input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required></div>
        </div>
        <div><button class="btn btn-main">Enregistrer</button></div>
    </form>

    <form method="post" action="{{ route('account.password') }}" class="panel stack">
        @csrf @method('put')
        <h2 style="font-size:1.2rem">Changer de mot de passe</h2>
        <div class="form">
            <div class="f full"><label for="current_password">Mot de passe actuel</label><input id="current_password" type="password" name="current_password" required autocomplete="current-password"></div>
            <div class="f"><label for="password">Nouveau mot de passe</label><input id="password" type="password" name="password" required autocomplete="new-password"></div>
            <div class="f"><label for="password_confirmation">Confirmation</label><input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"></div>
        </div>
        <div><button class="btn btn-main">Modifier le mot de passe</button></div>
    </form>

    <div class="panel stack">
        <h2 style="font-size:1.2rem">Mes données personnelles</h2>
        <p class="muted">Tu peux télécharger toutes les informations que nous avons sur toi (compte et commandes), dans un fichier lisible.</p>
        <div><a class="btn btn-ghost" href="{{ route('account.export') }}">Télécharger mes données</a></div>
    </div>

    @unless($user->isAdmin())
    <form method="post" action="{{ route('account.destroy') }}" class="panel stack" data-confirm="Supprimer définitivement ton compte ? Tu perdras l'accès à tes formations.">
        @csrf @method('delete')
        <h2 style="font-size:1.2rem">Supprimer mon compte</h2>
        <p class="muted">Ton compte, ton nom, ton e-mail et ton numéro sont effacés immédiatement et définitivement. Tu perds l'accès à tes formations. Les montants de tes anciennes commandes sont gardés sans ton nom, pour notre comptabilité.</p>
        <div class="f"><label for="password_delete">Confirme avec ton mot de passe</label><input id="password_delete" type="password" name="password_delete" required autocomplete="current-password"></div>
        <div><button class="btn btn-danger">Supprimer mon compte</button></div>
    </form>
    @endunless
</div>
@endsection
