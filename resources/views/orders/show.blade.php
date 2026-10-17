@extends('layouts.app', ['title' => 'Commande '.$order->reference])

@section('content')
<div class="wrap mid stack" style="padding-block:32px">
    <div><span class="tag {{ $order->status }}">{{ $order->statusLabel() }}</span></div>
    <h1>Commande {{ $order->reference }}</h1>
    @if($order->status === 'pending')
        <div class="panel stack">
            <h2 style="font-size:1.2rem">Il reste une étape : le paiement</h2>
            <p>Envoie <strong>{{ gnf($order->total) }}</strong> par Mobile Money, en indiquant la référence <strong>{{ $order->reference }}</strong> :</p>
            <p style="white-space:pre-line" class="num">{{ setting('payment_info') }}</p>
            <p class="muted">Puis envoie-nous la capture du paiement sur WhatsApp. Dès qu'il est vérifié, tes formations apparaissent dans « Mon compte ».</p>
            <a class="btn btn-wa btn-block" href="{{ $whatsapp }}" target="_blank" rel="noopener">Envoyer ma commande sur WhatsApp</a>
        </div>
    @elseif($order->status === 'paid')
        <div class="flash">Paiement reçu. Tes formations sont disponibles. <a href="{{ route('account.dashboard') }}">Ouvrir mon compte</a></div>
    @endif
    <div class="table-wrap">
        <table>
            <thead><tr><th>Formation</th><th class="r">Prix</th></tr></thead>
            <tbody>
            @foreach($order->items as $item)
                <tr><td><span class="ref">{{ $item->course_code }}</span> {{ $item->course_title }}</td><td class="r num">{{ gnf($item->price) }}</td></tr>
            @endforeach
            <tr><td><strong>Total</strong></td><td class="r num"><strong>{{ gnf($order->total) }}</strong></td></tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
