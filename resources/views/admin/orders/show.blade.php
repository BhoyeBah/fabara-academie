@extends('layouts.admin', ['title' => 'Commande '.$order->reference])

@section('content')
<div class="row"><h1>Commande {{ $order->reference }}</h1><a href="{{ route('admin.orders.index') }}">← Commandes</a></div>
<div><span class="tag {{ $order->status }}">{{ $order->statusLabel() }}</span>
    @if($order->paid_at)<span class="muted"> · payée le {{ $order->paid_at->format('d/m/Y H:i') }} ({{ $order->payment_method }})</span>@endif</div>

<div class="panel stack">
    <h2 style="font-size:1.15rem">Client</h2>
    @if($order->user)
        <p><strong>{{ $order->user->name }}</strong> · {{ $order->user->email }} · {{ $order->user->phone }}</p>
        <div><a class="btn btn-ghost btn-sm" target="_blank" rel="noopener" href="{{ wa_link($order->user->phone, 'Bonjour '.$order->user->name.', concernant votre commande '.$order->reference.' sur '.setting('brand').' : ') }}">Écrire au client sur WhatsApp</a></div>
    @else
        <p class="muted">Ce client a supprimé son compte.</p>
    @endif
</div>

<div class="table-wrap"><table>
    <thead><tr><th>Formation</th><th>Lien Drive</th><th class="r">Prix</th></tr></thead>
    <tbody>
    @foreach($order->items as $item)
        <tr><td><span class="ref">{{ $item->course_code }}</span> {{ $item->course_title }}</td>
            <td>@if($item->course?->drive_url)<span class="tag ok">Prêt</span>@elseif($item->course)<a href="{{ route('admin.courses.edit', $item->course) }}" class="tag no">À ajouter</a>@else<span class="muted">Formation supprimée</span>@endif</td>
            <td class="r num">{{ gnf($item->price) }}</td></tr>
    @endforeach
    <tr><td colspan="2"><strong>Total</strong></td><td class="r num"><strong>{{ gnf($order->total) }}</strong></td></tr>
    </tbody>
</table></div>

@if($order->status === 'pending')
    <form method="post" action="{{ route('admin.orders.paid', $order) }}" class="panel stack">
        @csrf
        <h2 style="font-size:1.15rem">J'ai reçu le paiement</h2>
        <p class="muted">Vérifiez la capture et le montant ({{ gnf($order->total) }}, référence {{ $order->reference }}) avant de valider. Le client verra aussitôt ses formations dans son compte.</p>
        <div class="f" style="max-width:300px"><label for="payment_method">Moyen de paiement</label>
            <select id="payment_method" name="payment_method">@foreach(\App\Models\Order::PAYMENT_METHODS as $m)<option>{{ $m }}</option>@endforeach</select></div>
        <div class="row" style="justify-content:flex-start"><button class="btn btn-main">Valider le paiement</button></div>
    </form>
    <form method="post" action="{{ route('admin.orders.cancel', $order) }}" data-confirm="Annuler cette commande ?">@csrf<button class="linkbtn" style="color:var(--bad)">Annuler la commande</button></form>
@elseif($order->status === 'paid' && $delivery)
    <div class="panel stack">
        <h2 style="font-size:1.15rem">Livrer au client</h2>
        <p class="muted">Le message contient les liens Drive de ses formations et le lien vers son compte.</p>
        <div><a class="btn btn-wa" href="{{ $delivery }}" target="_blank" rel="noopener">Envoyer les formations sur WhatsApp</a></div>
    </div>
@endif
@endsection
