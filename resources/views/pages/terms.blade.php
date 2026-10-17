@extends('layouts.app', ['title' => "Conditions d'utilisation"])

@section('content')
<div class="wrap prose" style="padding-block:32px 48px">
    <h1>Conditions d'utilisation et de vente</h1>
    <p class="muted">Dernière mise à jour : {{ config('legal.updated_at') }} · version {{ config('legal.version') }}</p>

    <h2>1. Le service</h2>
    <p>{{ setting('brand') }} ({{ setting('city') }}) vend des formations numériques (vidéos, supports PDF, exercices) accessibles en ligne via Google Drive après paiement.</p>

    <h2>2. Ton compte</h2>
    <p>Tu dois donner des informations exactes et garder ton mot de passe secret. Ton compte est personnel : tu es responsable de ce qui est fait avec. Préviens-nous immédiatement si tu penses que quelqu'un l'utilise à ta place.</p>

    <h2>3. Commande et paiement</h2>
    <p>Les prix sont indiqués en francs guinéens (GNF), toutes taxes comprises. Ta commande est enregistrée dès que tu la valides ; elle est confirmée une fois le paiement Mobile Money reçu et vérifié. Une commande non payée sous 7 jours peut être annulée.</p>

    <h2>4. Accès aux formations</h2>
    <p>Après vérification du paiement, la formation apparaît dans « Mon compte » avec son lien Google Drive, généralement dans l'heure (entre 8 h et 22 h). Tu peux télécharger les contenus pour les regarder hors ligne.</p>

    <h2>5. Utilisation autorisée</h2>
    <p>Les formations sont pour ton usage personnel. Il est interdit de les revendre, de les partager, de publier leurs liens ou de les diffuser, gratuitement ou non. En cas de partage constaté, nous pouvons suspendre ton accès sans remboursement. Les contenus restent la propriété de {{ setting('brand') }} ou de leurs auteurs.</p>

    <h2>6. Remboursement</h2>
    <p>S'agissant de contenus numériques livrés immédiatement, une formation à laquelle tu as eu accès n'est pas remboursable. En revanche, si un fichier est défectueux ou inaccessible et que nous ne pouvons pas corriger le problème sous 7 jours, nous te remboursons.</p>

    <h2>7. Responsabilité</h2>
    <p>Nous faisons le maximum pour que les formations soient exactes et à jour, mais elles ne garantissent pas un résultat professionnel. Nous ne sommes pas responsables d'une interruption de Google Drive, de WhatsApp ou de ton fournisseur Internet.</p>

    <h2>8. Suppression du compte</h2>
    <p>Tu peux supprimer ton compte à tout moment depuis « Mon profil et mes données ». Tu perds alors l'accès aux formations achetées. Nous pouvons fermer un compte qui ne respecte pas ces conditions.</p>

    <h2>9. Données personnelles</h2>
    <p>Voir notre <a href="{{ route('pages.privacy') }}">politique de confidentialité</a>.</p>

    <h2>10. Modifications et droit applicable</h2>
    <p>Nous pouvons modifier ces conditions ; la nouvelle version te sera présentée à ta prochaine connexion. Ces conditions sont régies par le droit guinéen. En cas de désaccord, contacte-nous d'abord : <a href="mailto:{{ setting('contact_email') }}">{{ setting('contact_email') }}</a>.</p>
</div>
@endsection
