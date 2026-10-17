@extends('layouts.admin', ['title' => 'Mon login'])

@section('content')
<h1>Mon login</h1>
<p class="muted">Ce sont les identifiants que vous utilisez sur la page « Connexion » du site pour entrer dans l'espace admin.</p>

<form method="post" action="{{ route('admin.profile.update') }}" class="panel form">
    @csrf @method('put')
    <h2 class="f full" style="font-size:1.15rem">Nom et adresse e-mail de connexion</h2>
    <div class="f"><label for="name">Nom</label><input id="name" name="name" value="{{ old('name', $user->name) }}" required maxlength="100"></div>
    <div class="f"><label for="email">E-mail de connexion</label><input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username"></div>
    <div class="f full"><label for="current_password">Mot de passe actuel (pour confirmer)</label><input id="current_password" type="password" name="current_password" required autocomplete="current-password"></div>
    <div class="f full"><button class="btn btn-main">Enregistrer</button></div>
</form>

<form method="post" action="{{ route('admin.profile.password') }}" class="panel form">
    @csrf @method('put')
    <h2 class="f full" style="font-size:1.15rem">Changer le mot de passe</h2>
    <div class="f full"><label for="current_password_pw">Mot de passe actuel</label><input id="current_password_pw" type="password" name="current_password_pw" required autocomplete="current-password"></div>
    <div class="f"><label for="password">Nouveau mot de passe</label><input id="password" type="password" name="password" required minlength="12" autocomplete="new-password"><small>12 caractères minimum, avec des lettres et des chiffres.</small></div>
    <div class="f"><label for="password_confirmation">Confirmez le nouveau mot de passe</label><input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"></div>
    <div class="f full"><button class="btn btn-main">Modifier le mot de passe</button></div>
    <p class="f full muted">Après le changement, vos autres appareils connectés à l'espace admin sont déconnectés.</p>
</form>
@endsection
