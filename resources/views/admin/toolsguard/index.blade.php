@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="pagesContainer">
        <h1 class="text-4xl font-bold pb-6">Vérification des outils</h1>
        @if (session('success'))
        <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-8 my-6" role="alert">
            <p class="font-bold">{{ session('success') }}</p>
        </div>
        @endif

        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">Titre</th>
                    <th scope="col" class="px-6 py-3">Créateur</th>
                    <th scope="col" class="px-6 py-3">Outil</th>
                    <th scope="col" class="px-6 py-3">Vérifié</th>
                    <th scope="col" class="px-6 py-3"></th>
                </tr>
            </thead>
            <form method="POST" action="{{ route('toolsguard.store') }}">
                @csrf
                <tbody>
                    @foreach ($tools as $tool)
                    <tr class="bg-white border-b">
                        <td class="px-6 py-4">
                            <a href="/admin/tools/update/{{ $tool->id }}" class="underline">{{ $tool->title }}</a>
                        </td>
                        <td class="px-6 py-4">{{ $tool->user->firstname . $tool->user->lastname }}</td>
                        <td class="px-6 py-4"><a target="_blank" href="{{$tool->media()->first()->path . $tool->media()->first()->name}}">Voir l'outil</a></td>
                        <td class="px-6 py-4">
                            <input type="checkbox" name="checkbox_{{$tool->id}}" id="toggle-{{$tool->id}}" class="toggle-checkbox" {{ $tool->verified == true ? 'checked' : '' }}>
                            <label for="toggle-{{$tool->id}}" class="toggle-label"></label>
                            <input type="hidden" name="tool_ids[]" value="{{$tool->id}}">
                        </td>
                        <td class="px-6 py-4">
                            <button class="user__ban">
                                <a href="/admin/tools/destroy/{{ $tool->id }}" onclick="return confirm('Supprimer cet outil?');">Supprimer</a>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <div>
                    <button class="form__submit" type="submit">SAUVEGARDER</button>
                </div>
            </form>
        </table>
    </div>
</div>
</div>
<div class="ban__container">
    <div class="ban__popup">
        <h2>Voulez-vous supprimer l'outil suivant?</h2>
        <p class="user__info" id="user__name"></p>
        <p class="user__info" id="user__id"></p>
        <div class="ban__ctas">
            <button id="yes">Oui</button>
            <button id="no">Non</button>
        </div>
    </div>
</div>
@endsection
@section('scripts')

@include('admin.users.partials.scripts')

@endsection