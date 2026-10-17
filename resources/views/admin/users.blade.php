@extends('layouts.admin', ['title' => 'Clients'])

@section('content')
<div class="row">
    <h1>Clients</h1>
    <form method="get" class="search" style="min-width:240px"><input type="search" name="q" value="{{ $q }}" placeholder="Nom, e-mail, téléphone"></form>
</div>
<p class="muted">Ces données sont confidentielles : elles servent uniquement à livrer les commandes. Ne les partagez pas et ne les utilisez pas pour de la publicité sans l'accord des clients.</p>
<div class="table-wrap"><table>
    <thead><tr><th>Nom</th><th>E-mail</th><th>Téléphone</th><th>Inscrit le</th><th class="r">Commandes payées</th></tr></thead>
    <tbody>
    @forelse($users as $user)
        <tr><td>{{ $user->name }}</td><td>{{ $user->email }}</td><td>{{ $user->phone }}</td><td>{{ $user->created_at->format('d/m/Y') }}</td><td class="r num">{{ $user->paid_orders_count }}</td></tr>
    @empty
        <tr><td colspan="5" class="muted">Aucun client.</td></tr>
    @endforelse
    </tbody>
</table></div>
<div class="pager">
    @if($users->previousPageUrl())<a href="{{ $users->previousPageUrl() }}">← Précédent</a>@endif
    @if($users->nextPageUrl())<a href="{{ $users->nextPageUrl() }}">Suivant →</a>@endif
</div>
@endsection
