@extends('layouts.app', ['title' => 'Mon compte'])

@section('content')
<div class="wrap stack" style="padding-bottom:40px">
    @include('account._nav')

    <h2 style="font-size:1.3rem">Mes formations</h2>
    @if($courses->isEmpty())
        <div class="empty">Tu n'as pas encore de formation disponible.
            @if($orders->where('status', 'pending')->isNotEmpty()) Ta commande sera disponible ici dès que le paiement est vérifié.@endif
            <br><a href="{{ route('catalog.index') }}">Voir le catalogue</a></div>
    @else
        <div class="mine">
            @foreach($courses as $course)
                <div class="card" style="--dom: {{ $course->category->color }}">
                    <div class="band"></div>
                    <div class="body">
                        <span class="dom">{{ $course->category->name }}</span>
                        <h3>{{ $course->title }}</h3>
                        <span class="ref">{{ $course->code }}</span>
                    </div>
                    <div class="foot">
                        <a class="btn btn-main btn-block" href="{{ route('account.access', $course) }}" target="_blank" rel="noopener">Ouvrir sur Google Drive</a>
                    </div>
                </div>
            @endforeach
        </div>
        <p class="muted">Astuce : dans Google Drive, appuie sur ⋮ puis « Télécharger » pour garder les vidéos et les regarder sans connexion.</p>
    @endif

    <h2 style="font-size:1.3rem;margin-top:16px">Mes commandes</h2>
    @if($orders->isEmpty())
        <p class="muted">Aucune commande pour le moment.</p>
    @else
        <div class="table-wrap">
            <table>
                <thead><tr><th>Référence</th><th>Date</th><th>Formations</th><th class="r">Total</th><th>Statut</th></tr></thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td><a href="{{ route('orders.show', $order) }}">{{ $order->reference }}</a></td>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        <td>{{ $order->items->pluck('course_title')->implode(', ') }}</td>
                        <td class="r num">{{ gnf($order->total) }}</td>
                        <td><span class="tag {{ $order->status }}">{{ $order->statusLabel() }}</span></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
