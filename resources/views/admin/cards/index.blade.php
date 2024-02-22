@extends('layouts.admin')

@section('content')
    <div class="container" style="margin-top:75px;">

        <div class="pagesContainer">
        <h1 class="text-4xl font-bold pb-6">Fiches intimidations</h1>
        @if (session('status'))
            <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-8 my-6" role="alert">
                <p class="font-bold">{{ session('status') }}</p>
            </div>
        @endif
            <a href="/admin/cards/create" id="newpage-cta" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
               Ajouter une fiche
            </a>
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Titre</th>
                        <th scope="col" class="px-6 py-3">Description</th>
                        <th scope="col" class="px-6 py-3">Section</th>
                        <th scope="col" class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cards as $card)
                    <tr class="bg-white border-b">
                        <td class="px-6 py-4">
                            <a href="/admin/cards/update/{{ $card->id }}" class="underline">{{ $card->title }}</a>
                        </td>
                        <td class="px-6 py-4">
                            @if(strlen($card->desc)>50)
                            {{ substr_replace($card->desc, '...', 50) }}
                            @else
                            {{ $card->desc }}   
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $card->section()->first()->name }}</td>
                        <td class="px-6 py-4">
                            <div class="relative inline-block text-left dropdownHover">
                                <div class="relative inline-block text-left dropdownHover">
                                    <a href="/admin/cards/update/{{ $card->id }}" class="hover:bg-gray-200 py-1 px-4 dropdownHover cursor-pointer edit-cta"><i class="fa fa-pen-to-square mt-0.5" style="color: #000" aria-hidden="true"></i></a>
                                </div>
                                <div class="relative inline-block text-left dropdownHover">
                                    <a href="/admin/cards/destroy/{{ $card->id }}" onclick="return confirm('Supprimer cette fiche?');" class="hover:bg-gray-200 py-1 px-4 dropdownHover"><i class="fa fa-trash mt-0.5" style="color: #ff0000" aria-hidden="true"></i></a>
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
@include('admin.partials.scripts')
@endsection
