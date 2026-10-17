@extends('layouts.app')

@section('content')
<div class="wrap hero">
    <div>
        <h1>Apprends un métier. <span>Télécharge tes cours</span> dès aujourd'hui.</h1>
        <p class="lead">Formations vidéo complètes en français, avec supports PDF et exercices. Tu paies par Mobile Money et tu retrouves tes cours dans ton compte, sur Google Drive.</p>
    </div>
    <div class="howto" aria-label="Comment commander">
        <div><span class="ref">01</span><strong>Choisis</strong><small>Ajoute une ou plusieurs formations</small></div>
        <div><span class="ref">02</span><strong>Paie</strong><small>Orange Money, MTN MoMo ou Wave</small></div>
        <div><span class="ref">03</span><strong>Télécharge</strong><small>Tes cours dans « Mon compte »</small></div>
    </div>
</div>

<div class="wrap">
    <nav class="filters" aria-label="Domaines">
        <a class="chip {{ $domain === '' ? 'on' : '' }}" href="{{ route('catalog.index', array_filter(['q' => $q])) }}">Toutes <span>{{ $total }}</span></a>
        @foreach($categories as $cat)
            <a class="chip {{ $domain === $cat->slug ? 'on' : '' }}" href="{{ route('catalog.index', array_filter(['domaine' => $cat->slug, 'q' => $q])) }}">{{ $cat->name }} <span>{{ $cat->courses_count }}</span></a>
        @endforeach
    </nav>
    <p class="muted" style="padding-bottom:14px">{{ $courses->count() }} formation{{ $courses->count() > 1 ? 's' : '' }}@if($q) pour « {{ $q }} »@endif</p>

    <div class="grid">
        @forelse($courses as $course)
            @include('partials.course-card', ['course' => $course, 'cart' => $cart])
        @empty
            <div class="empty">Aucune formation ne correspond à votre recherche.<br>
                <a href="{{ wa_link(setting('whatsapp'), 'Bonjour, je cherche une formation sur : '.$q) }}" target="_blank" rel="noopener">Écrivez-nous sur WhatsApp</a> : on l'a peut-être déjà.</div>
        @endforelse
    </div>
</div>
@endsection
