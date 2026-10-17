@extends('layouts.admin', ['title' => 'Commandes'])

@section('content')
<div class="row">
    <h1>Commandes</h1>
    <form method="get" class="search" style="min-width:240px"><input type="hidden" name="statut" value="{{ $status }}"><input type="search" name="q" value="{{ $q }}" placeholder="Référence, nom, téléphone"></form>
</div>
<nav class="tabs">
    @foreach(\App\Models\Order::STATUS_LABELS + ['all' => 'Toutes'] as $key => $label)
        <a class="tab {{ $status === $key ? 'on' : '' }}" href="{{ route('admin.orders.index', ['statut' => $key]) }}">{{ $label }}</a>
    @endforeach
</nav>
<div class="table-wrap"><table>
    <thead><tr><th>Référence</th><th>Client</th><th>Formations</th><th>Date</th><th class="r">Total</th><th>Statut</th><th></th></tr></thead>
    <tbody>
    @forelse($orders as $order)
        <tr>
            <td class="ref">{{ $order->reference }}</td>
            <td>{{ $order->user?->name ?? 'Compte supprimé' }}<br><small class="muted">{{ $order->user?->phone }}</small></td>
            <td>{{ $order->items->pluck('course_code')->implode(', ') }}</td>
            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
            <td class="r num">{{ gnf($order->total) }}</td>
            <td><span class="tag {{ $order->status }}">{{ $order->statusLabel() }}</span></td>
            <td class="r"><a class="btn btn-ghost btn-sm" href="{{ route('admin.orders.show', $order) }}">Ouvrir</a></td>
        </tr>
    @empty
        <tr><td colspan="7" class="muted">Aucune commande.</td></tr>
    @endforelse
    </tbody>
</table></div>
<div class="pager">
    @if($orders->previousPageUrl())<a href="{{ $orders->previousPageUrl() }}">← Précédent</a>@endif
    @if($orders->nextPageUrl())<a href="{{ $orders->nextPageUrl() }}">Suivant →</a>@endif
</div>
@endsection
