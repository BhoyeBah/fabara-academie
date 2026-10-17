@extends('layouts.app', ['title' => 'Politique de confidentialité'])

@section('content')
<div class="wrap prose" style="padding-block:32px 48px">
    <h1>Politique de confidentialité</h1>
    <p class="muted">Dernière mise à jour : {{ config('legal.updated_at') }} · version {{ config('legal.version') }}</p>

    <p>Cette politique explique quelles données {{ setting('brand') }} collecte quand tu utilises ce site (et, le cas échéant, son application mobile), pourquoi, combien de temps elles sont gardées et comment exercer tes droits. Nous collectons le minimum nécessaire et nous ne vendons jamais tes données.</p>

    <h2>1. Qui est responsable de tes données ?</h2>
    <p>{{ setting('brand') }}, {{ setting('city') }}. Contact : <a href="mailto:{{ setting('contact_email') }}">{{ setting('contact_email') }}</a> ou WhatsApp +{{ setting('whatsapp') }}.</p>

    <h2>2. Les données que nous collectons</h2>
    <ul>
        <li><strong>Compte</strong> : nom, adresse e-mail, numéro WhatsApp, mot de passe (stocké chiffré de façon irréversible : personne, même nous, ne peut le lire).</li>
        <li><strong>Commandes</strong> : formations commandées, montants, date, statut, moyen de paiement déclaré (Orange Money, MTN MoMo…). Nous ne collectons <strong>aucun</strong> numéro de carte ni code secret Mobile Money.</li>
        <li><strong>Données techniques</strong> : adresse IP et type de navigateur, enregistrés pour la sécurité de ta session (protection contre le piratage de compte).</li>
        <li><strong>Date et version des conditions acceptées</strong>, pour prouver ton accord.</li>
    </ul>
    <p>Nous ne collectons pas ta localisation, tes contacts, tes photos, ni aucune donnée sensible (santé, religion, opinions…).</p>

    <h2>3. Pourquoi nous les utilisons</h2>
    <ul>
        <li>Créer et sécuriser ton compte (exécution du contrat).</li>
        <li>Enregistrer tes commandes, vérifier ton paiement et te donner accès à tes formations (exécution du contrat).</li>
        <li>Te contacter sur WhatsApp ou par e-mail au sujet de tes commandes et de ton compte (exécution du contrat).</li>
        <li>Tenir notre comptabilité (obligation légale).</li>
    </ul>
    <p>Nous n'envoyons pas de publicité et nous n'utilisons pas tes données pour du profilage. Si un jour nous voulons t'envoyer des offres, nous te demanderons d'abord ton accord, que tu pourras retirer à tout moment.</p>

    <h2>4. Qui peut voir tes données ?</h2>
    <ul>
        <li>Uniquement l'équipe de {{ setting('brand') }} qui gère les commandes.</li>
        <li>Notre hébergeur, qui stocke le site de façon sécurisée, sans droit de les utiliser.</li>
        <li>Quand tu ouvres une formation, tu es redirigé vers <strong>Google Drive</strong> ; quand tu nous écris, tu utilises <strong>WhatsApp</strong>. Ces services appliquent leurs propres politiques de confidentialité.</li>
    </ul>
    <p>Nous ne vendons, ne louons et n'échangeons jamais tes données.</p>

    <h2>5. Combien de temps nous les gardons</h2>
    <ul>
        <li><strong>Compte</strong> : tant que tu ne le supprimes pas. Tu peux le supprimer à tout moment, en un clic.</li>
        <li><strong>Commandes</strong> : {{ config('legal.orders_retention_years') }} ans pour la comptabilité. Si tu supprimes ton compte, elles sont détachées de ton nom, de ton e-mail et de ton numéro.</li>
        <li><strong>Données de session</strong> : effacées à la déconnexion ou après expiration de la session.</li>
    </ul>

    <h2>6. Sécurité</h2>
    <p>Connexion chiffrée (HTTPS), mots de passe chiffrés, liens des formations chiffrés en base de données, limitation des tentatives de connexion, accès administrateur réservé et protégé.</p>

    <h2>7. Cookies</h2>
    <p>Nous utilisons seulement les cookies <strong>indispensables</strong> au fonctionnement du site : le cookie de session (pour rester connecté et garder ton panier) et un cookie de sécurité contre les formulaires frauduleux. Aucun cookie de publicité ni de mesure d'audience. Ces cookies ne nécessitent pas de consentement, car le site ne peut pas fonctionner sans eux.</p>

    <h2>8. Tes droits</h2>
    <p>Tu peux à tout moment, depuis <a href="{{ route('account.profile') }}">Mon profil et mes données</a> :</p>
    <ul>
        <li><strong>consulter et corriger</strong> tes informations ;</li>
        <li><strong>télécharger</strong> toutes tes données dans un fichier (portabilité) ;</li>
        <li><strong>supprimer</strong> ton compte et tes données personnelles (voir <a href="{{ route('pages.deletion') }}">Supprimer mon compte</a>).</li>
    </ul>
    <p>Pour toute autre demande (opposition, question, réclamation), écris-nous à <a href="mailto:{{ setting('contact_email') }}">{{ setting('contact_email') }}</a>. Nous répondons sous 30 jours maximum. Ces droits s'appliquent conformément à la loi guinéenne sur la protection des données à caractère personnel (loi L/2016/037/AN) et, pour les personnes concernées, aux autres lois applicables.</p>

    <h2>9. Enfants</h2>
    <p>Le service s'adresse aux personnes de 16 ans et plus. Un mineur ne peut créer de compte ou commander qu'avec l'accord de ses parents. Nous ne collectons pas sciemment de données sur des enfants de moins de 13 ans ; si cela arrive, écris-nous et nous les supprimerons.</p>

    <h2>10. Modifications</h2>
    <p>Si cette politique change de façon importante, nous te le signalerons à ta prochaine connexion et te demanderons de l'accepter à nouveau.</p>
</div>
@endsection
