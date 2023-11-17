@extends('layouts.admin')

@section('content')
    <div class="container" style="margin-top:75px;">

        <div class="pagesContainer">
        <h1 class="text-4xl font-bold pb-6">Thématiques</h1>
        @if (session('status'))
            <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-8 my-6" role="alert">
                <p class="font-bold">{{ session('status') }}</p>
            </div>
        @endif
            <p id="add-cta" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
               Ajouter une thématique
            </p>
            <form id="add-form" class="w-full flex justify-center" action="/admin/thematiques/store" method="post">
                @csrf
                <div class="px-12 pb-8 flex flex-col items-center w-10/12">
                    <div class="w-full mb-2">
                        <div class="flex justify-center flex-col">
                            <x-label for="name" :value="__('Nom')"></x-label>
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        </div>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <p class="cursor-pointer cancel-form">Annuler</p>
                        <x-button class="ml-4">
                            {{ __('Ajouter') }}
                        </x-button>
                    </div>
                </div>
             </form>
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nom</th>
                        <th scope="col" class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($thematiques as $thematique)
                    <tr class="bg-white border-b">
                        <td class="px-6 py-4">
                            <p data-category="edit-{{ strtolower($thematique->id) }}" class="underline">{{ $thematique->name }}</p>
                            <form data-category="edit-{{ strtolower($thematique->id) }}" class="w-full align-center flex edit-form hidden" action="/admin/thematiques/update/" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $thematique->id }}">
                                <div class="flex justify-center flex-col edit-input">
                                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $thematique->name }}" required autofocus />
                                </div>
                                <div class="flex items-center justify-end ml-4 edit-submit">
                                    <p class="cursor-pointer cancel-form edit-{{ strtolower($thematique->id) }}">Annuler</p>
                                    <x-button class="ml-4">
                                        {{ __('Modifier') }}
                                    </x-button>
                                </div>
                            </form>
                        </td>
                        <td class="px-6 py-4 flex justify-end items-center">
                            <div class="relative inline-block text-left dropdownHover">
                                <div class="relative inline-block text-left dropdownHover">
                                    <p id="edit-{{ strtolower($thematique->id) }}" class="hover:bg-gray-200 py-1 px-4 dropdownHover cursor-pointer edit-cta"><i class="fa fa-pen-to-square mt-0.5" style="color: #000" aria-hidden="true"></i></p>
                                </div>
                                <div class="relative inline-block text-left dropdownHover">
                                    <a href="/admin/thematiques/destroy/{{ $thematique->id }}" onclick="return confirm('Supprimer cette catégorie?');" class="hover:bg-gray-200 py-1 px-4 dropdownHover"><i class="fa fa-trash mt-0.5" style="color: #ff0000" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        </div>
@endsection
@section('scripts')

@include('admin.users.partials.scripts')
@include('admin.categories.partials.scripts')

@endsection
