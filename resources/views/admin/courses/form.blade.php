@extends('layouts.admin', ['title' => $course->exists ? 'Modifier '.$course->code : 'Nouvelle formation'])

@section('content')
<div class="row"><h1>{{ $course->exists ? 'Modifier '.$course->code : 'Nouvelle formation' }}</h1><a href="{{ route('admin.courses.index') }}">← Retour</a></div>

<form method="post" action="{{ $course->exists ? route('admin.courses.update', $course) : route('admin.courses.store') }}" class="panel form">
    @csrf
    @if($course->exists) @method('put') @endif
    <div class="f full"><label for="title">Titre *</label><input id="title" name="title" value="{{ old('title', $course->title) }}" required maxlength="190" placeholder="Ex. Excel du débutant au pro"></div>
    <div class="f"><label for="code">Code *</label><input id="code" name="code" value="{{ old('code', $course->code) }}" required maxlength="20" placeholder="Ex. INF-04"><small>Lettres, chiffres et tirets. Le client le cite sur WhatsApp.</small></div>
    <div class="f"><label for="category_id">Domaine *</label>
        <select id="category_id" name="category_id" required>
            @foreach($categories as $cat)<option value="{{ $cat->id }}" @selected(old('category_id', $course->category_id) == $cat->id)>{{ $cat->name }}</option>@endforeach
        </select><small><a href="{{ route('admin.categories.index') }}">Gérer les domaines</a></small></div>
    <div class="f full"><label for="description">Description courte *</label><input id="description" name="description" value="{{ old('description', $course->description) }}" required maxlength="500" placeholder="Ce que l'élève saura faire"></div>
    <div class="f"><label for="price">Prix (GNF) *</label><input id="price" name="price" type="number" min="0" step="500" value="{{ old('price', $course->price) }}" required></div>
    <div class="f"><label for="level">Niveau</label>
        <select id="level" name="level">@foreach(\App\Models\Course::LEVELS as $l)<option @selected(old('level', $course->level) === $l)>{{ $l }}</option>@endforeach</select></div>
    <div class="f"><label for="hours">Heures de vidéo</label><input id="hours" name="hours" type="number" min="0" value="{{ old('hours', $course->hours) }}"></div>
    <div class="f"><label for="lessons">Nombre de leçons</label><input id="lessons" name="lessons" type="number" min="0" value="{{ old('lessons', $course->lessons) }}"></div>
    <div class="f full"><label for="program">Programme (un chapitre par ligne)</label><textarea id="program" name="program">{{ old('program', implode("\n", $course->program ?? [])) }}</textarea></div>
    <div class="f full"><label for="drive_url">Lien Google Drive du dossier (privé)</label>
        <input id="drive_url" name="drive_url" type="url" value="{{ old('drive_url', $course->drive_url) }}" placeholder="https://drive.google.com/drive/folders/…">
        <small>Jamais affiché sur le site public : seuls les clients qui ont payé cette formation peuvent l'ouvrir depuis leur compte. Le lien est chiffré dans la base de données.</small></div>
    <label class="check f full"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $course->is_published))> Visible dans le catalogue</label>
    <div class="f full row">
        <button class="btn btn-main">Enregistrer la formation</button>
    </div>
</form>

@if($course->exists)
<form method="post" action="{{ route('admin.courses.destroy', $course) }}" data-confirm="Supprimer définitivement cette formation ? Les clients qui l'ont achetée n'y auront plus accès. Pour la retirer du catalogue seulement, décochez « Visible ».">
    @csrf @method('delete')
    <button class="linkbtn" style="color:var(--bad)">Supprimer cette formation</button>
</form>
@endif
@endsection
