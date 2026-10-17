@extends('layouts.admin', ['title' => 'Formations'])

@section('content')
<div class="row">
    <h1>Formations</h1>
    <div class="row">
        <form method="get" class="search" style="min-width:220px"><input type="search" name="q" value="{{ $q }}" placeholder="Code ou titre"></form>
        <a class="btn btn-main" href="{{ route('admin.courses.create') }}">+ Nouvelle formation</a>
    </div>
</div>
<div class="table-wrap"><table>
    <thead><tr><th>Code</th><th>Formation</th><th>Domaine</th><th class="r">Prix</th><th>Lien Drive</th><th>Visible</th><th></th></tr></thead>
    <tbody>
    @forelse($courses as $course)
        <tr style="--dom: {{ $course->category->color }}">
            <td class="ref">{{ $course->code }}</td>
            <td>{{ $course->title }}</td>
            <td><span class="swatch"></span> {{ $course->category->name }}</td>
            <td class="r num">{{ gnf($course->price) }}</td>
            <td>@if($course->drive_url)<span class="tag ok">Oui</span>@else<span class="tag no">À ajouter</span>@endif</td>
            <td>{{ $course->is_published ? 'Oui' : 'Masquée' }}</td>
            <td class="r"><a class="btn btn-ghost btn-sm" href="{{ route('admin.courses.edit', $course) }}">Modifier</a></td>
        </tr>
    @empty
        <tr><td colspan="7" class="muted">Aucune formation.</td></tr>
    @endforelse
    </tbody>
</table></div>
@endsection
