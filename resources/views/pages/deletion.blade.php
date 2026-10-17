@extends('layouts.app', ['title' => 'Supprimer mon compte'])

@section('content')
<div class="wrap prose" style="padding-block:32px 48px">
    <h1>Supprimer ton compte et tes données</h1>
    <p>Tu peux supprimer ton compte {{ setting('brand') }} à tout moment, gratuitement.</p>

    <h2>Méthode 1 : toi-même, en 1 minute</h2>
    <ol>
        <li><a href="{{ route('login') }}">Connecte-toi</a> à ton compte.</li>
        <li>Ouvre <strong>Mon compte → Mon profil et mes données</strong>.</li>
        <li>En bas de la page, section <strong>Supprimer mon compte</strong> : entre ton mot de passe et confirme.</li>
    </ol>
    <p>La suppression est immédiate.</p>

    <h2>Méthode 2 : sur demande</h2>
    <p>Si tu ne peux plus te connecter, écris-nous depuis l'adresse e-mail ou le numéro WhatsApp de ton compte : <a href="mailto:{{ setting('contact_email') }}">{{ setting('contact_email') }}</a> ou WhatsApp +{{ setting('whatsapp') }}. Nous supprimons le compte sous 30 jours maximum (en pratique, sous 72 heures).</p>

    <h2>Ce qui est supprimé</h2>
    <ul>
        <li>Ton nom, ton adresse e-mail, ton numéro de téléphone et ton mot de passe.</li>
        <li>Tes sessions de connexion et tes demandes de réinitialisation de mot de passe.</li>
        <li>Ton accès aux formations achetées.</li>
    </ul>

    <h2>Ce qui est conservé</h2>
    <p>Les montants et le contenu des commandes passées sont conservés {{ config('legal.orders_retention_years') }} ans pour nos obligations comptables, <strong>sans aucun lien</strong> avec ton nom, ton e-mail ou ton numéro.</p>
</div>
@endsection
