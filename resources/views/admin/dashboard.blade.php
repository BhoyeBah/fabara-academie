@extends('layouts.admin', ['title' => 'Tableau de bord'])

@section('content')
<h1>Tableau de bord</h1>
<div class="stats">
    <div class="stat"><b class="num">{{ $stats['pending'] }}</b><span>commande(s) à vérifier</span></div>
    <div class="stat"><b class="num">{{ gnf($stats['revenue_month']) }}</b><span>encaissés ce mois-ci</span></div>
    <div class="stat"><b class="num">{{ $stats['clients'] }}</b><span>clients inscrits</span></div>
    <div class="stat"><b class="num">{{ $stats['courses'] }}</b><span>formations</span></div>
</div>
@if($stats['missing_links'])
    <div class="alert">{{ $stats['missing_links'] }} formation(s) n'ont pas encore de lien Google Drive. <a href="{{ route('admin.courses.index') }}">Les compléter</a></div>
@endif

<div class="row"><h2 style="font-size:1.25rem">Commandes en attente de paiement</h2><a href="{{ route('admin.orders.index') }}">Toutes les commandes →</a></div>
@if($pending->isEmpty())
    <p class="muted">Aucune commande en attente.</p>
@else
    <div class="table-wrap"><table>
        <thead><tr><th>Référence</th><th>Client</th><th>Date</th><th class="r">Total</th><th></th></tr></thead>
        <tbody>@foreach($pending as $order)
            <tr><td class="ref">{{ $order->reference }}</td><td>{{ $order->user?->name ?? 'Compte supprimé' }}</td><td>{{ $order->created_at->format('d/m H:i') }}</td>
                <td class="r num">{{ gnf($order->total) }}</td><td class="r"><a class="btn btn-main btn-sm" href="{{ route('admin.orders.show', $order) }}">Traiter</a></td></tr>
        @endforeach</tbody>
    </table></div>
@endif

<div class="panel flat stack">
    <h2 style="font-size:1.15rem">Ajouter une nouvelle formation</h2>
    <ol style="margin:0;padding-left:20px">
        <li>Dans <a href="https://drive.google.com/drive/my-drive" target="_blank" rel="noopener">Google Drive</a>, créez un dossier nommé avec le code (ex. <span class="ref">INF-04 – Access</span>) et envoyez-y les vidéos et PDF.</li>
        <li>Clic droit sur le dossier → Partager → « Tous les utilisateurs disposant du lien » (lecteur) → Copier le lien.</li>
        <li><a href="{{ route('admin.courses.create') }}">Nouvelle formation</a> : remplissez la fiche et collez le lien. Il reste invisible pour les clients tant qu'ils n'ont pas payé.</li>
    </ol>
</div>
@endsection
