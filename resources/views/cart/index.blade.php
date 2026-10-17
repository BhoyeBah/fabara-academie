@extends('layouts.app', ['title' => 'Mon panier'])

@section('content')
<div class="wrap mid">
    <div class="page-head"><h1>Mon panier</h1></div>
    @if($courses->isEmpty())
        <div class="empty">Ton panier est vide. <a href="{{ route('catalog.index') }}">Voir les formations</a></div>
    @else
        <div class="table-wrap">
            <table>
                <thead><tr><th>Formation</th><th class="r">Prix</th><th></th></tr></thead>
                <tbody>
                @foreach($courses as $course)
                    <tr>
                        <td><span class="ref">{{ $course->code }}</span><br><a href="{{ route('catalog.show', $course) }}">{{ $course->title }}</a></td>
                        <td class="r num">{{ gnf($course->price) }}</td>
                        <td class="r"><form method="post" action="{{ route('cart.remove', $course) }}">@csrf @method('delete')<button class="linkbtn">Retirer</button></form></td>
                    </tr>
                @endforeach
                <tr><td><strong>Total</strong></td><td class="r num"><strong>{{ gnf($total) }}</strong></td><td></td></tr>
                </tbody>
            </table>
        </div>
        <div class="panel stack" style="margin-top:18px">
            <p>En validant, ta commande est enregistrée et tu reçois les instructions de paiement.</p>
            <form method="post" action="{{ route('checkout.store') }}">@csrf
                <button class="btn btn-main btn-block">Valider ma commande</button></form>
        </div>
    @endif
</div>
@endsection
