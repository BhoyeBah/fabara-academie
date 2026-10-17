@extends('layouts.admin', ['title' => 'Domaines'])

@section('content')
<h1>Domaines</h1>
<div class="table-wrap"><table>
    <thead><tr><th>Domaine</th><th>Couleur</th><th>Ordre</th><th>Formations</th><th></th></tr></thead>
    <tbody>
    @foreach($categories as $cat)
        <tr>
            <td colspan="3">
                <form method="post" action="{{ route('admin.categories.update', $cat) }}" class="row" style="flex-wrap:nowrap">
                    @csrf @method('put')
                    <input name="name" value="{{ $cat->name }}" aria-label="Nom" required style="flex:1;padding:8px;border-radius:8px;border:1.5px solid var(--line);background:var(--card)">
                    <input name="color" type="color" value="{{ $cat->color }}" aria-label="Couleur">
                    <input name="position" type="number" min="0" value="{{ $cat->position }}" aria-label="Ordre" style="width:70px;padding:8px;border-radius:8px;border:1.5px solid var(--line);background:var(--card)">
                    <button class="btn btn-ghost btn-sm">Enregistrer</button>
                </form>
            </td>
            <td class="num">{{ $cat->courses_count }}</td>
            <td class="r">
                @if($cat->courses_count === 0)
                <form method="post" action="{{ route('admin.categories.destroy', $cat) }}" data-confirm="Supprimer ce domaine ?">@csrf @method('delete')<button class="linkbtn" style="color:var(--bad)">Supprimer</button></form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table></div>

<form method="post" action="{{ route('admin.categories.store') }}" class="panel form">
    @csrf
    <div class="f"><label for="name">Nouveau domaine</label><input id="name" name="name" required maxlength="80" placeholder="Ex. Couture & Mode"></div>
    <div class="f"><label for="color">Couleur</label><input id="color" name="color" type="color" value="#0b6e55"></div>
    <div class="f full"><button class="btn btn-main">Ajouter le domaine</button></div>
</form>
@endsection
