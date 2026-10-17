<article class="card" style="--dom: {{ $course->category->color }}">
    <div class="band"></div>
    <div class="body">
        <div class="row"><span class="dom">{{ $course->category->name }}</span><span class="ref">{{ $course->code }}</span></div>
        <h3><a href="{{ route('catalog.show', $course) }}">{{ $course->title }}</a></h3>
        <p class="muted">{{ $course->description }}</p>
        <div class="facts">
            <span>{{ $course->level }}</span>
            @if($course->hours)<span class="num">{{ $course->hours }} h de vidéo</span>@endif
            @if($course->lessons)<span class="num">{{ $course->lessons }} leçons</span>@endif
            <span>PDF inclus</span>
        </div>
    </div>
    <div class="foot">
        <span class="price num">{{ gnf($course->price) }}</span>
        @if(in_array($course->id, $cart ?? []))
            <form method="post" action="{{ route('cart.remove', $course) }}">@csrf @method('delete')
                <button class="btn btn-ghost btn-sm">✓ Ajoutée</button></form>
        @else
            <form method="post" action="{{ route('cart.add', $course) }}">@csrf
                <button class="btn btn-main btn-sm">@auth Ajouter @else Obtenir @endauth</button></form>
        @endif
    </div>
</article>
