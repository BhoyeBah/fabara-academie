@extends('layouts.app', ['title' => $course->title, 'description' => $course->description])

@section('content')
<div class="wrap detail" style="--dom: {{ $course->category->color }}">
    <div class="stack">
        <a href="{{ route('catalog.index', ['domaine' => $course->category->slug]) }}" class="dom">{{ $course->category->name }}</a>
        <h1>{{ $course->title }}</h1>
        <p class="lead">{{ $course->description }}</p>
        <div class="facts">
            <span>{{ $course->level }}</span>
            @if($course->hours)<span>{{ $course->hours }} h de vidéo</span>@endif
            @if($course->lessons)<span>{{ $course->lessons }} leçons</span>@endif
            <span>Supports PDF</span><span>Code {{ $course->code }}</span>
        </div>
        @if($course->program)
            <div class="panel flat stack">
                <h2 style="font-size:1.2rem">Programme</h2>
                <ol>@foreach($course->program as $chapter)<li>{{ $chapter }}</li>@endforeach</ol>
            </div>
        @endif
        <div class="panel flat stack">
            <h2 style="font-size:1.2rem">Comment je reçois la formation ?</h2>
            <p class="muted">Après ta commande, tu paies par Mobile Money. Dès que le paiement est vérifié, la formation apparaît dans « Mon compte » avec son lien Google Drive : tu télécharges les vidéos et les PDF sur ton téléphone ou ton ordinateur.</p>
        </div>
    </div>

    <aside class="panel buy">
        <span class="price num" style="font-size:1.8rem">{{ gnf($course->price) }}</span>
        @if($owned)
            <p>Tu as déjà cette formation.</p>
            <a class="btn btn-main btn-block" href="{{ route('account.dashboard') }}">Voir mes formations</a>
        @elseif($inCart)
            <a class="btn btn-main btn-block" href="{{ route('cart.index') }}">Voir mon panier</a>
            <form method="post" action="{{ route('cart.remove', $course) }}">@csrf @method('delete')
                <button class="btn btn-ghost btn-block">Retirer du panier</button></form>
        @else
            <form method="post" action="{{ route('cart.add', $course) }}">@csrf
                <button class="btn btn-main btn-block">@auth Ajouter au panier @else Obtenir cette formation @endauth</button></form>
            @guest<p class="muted" style="font-size:.9rem">Un compte gratuit est nécessaire : c'est là que tu retrouveras ta formation. Déjà inscrit ? <a href="{{ route('login') }}">Connecte-toi</a>.</p>@endguest
        @endif
        <a class="btn btn-ghost btn-block" target="_blank" rel="noopener"
           href="{{ wa_link(setting('whatsapp'), 'Bonjour, j\'ai une question sur la formation '.$course->code.' '.$course->title) }}">Poser une question sur WhatsApp</a>
    </aside>
</div>
@endsection
