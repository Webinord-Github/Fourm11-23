@extends('layouts.admin')

@section('content')
    <div class="container" style="margin-top:75px;">

        <div class="pagesContainer">
        <h1 class="text-4xl font-bold pb-6">Fiches saviez-vous</h1>
        @if (session('status'))
            <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-8 my-6" role="alert">
                <p class="font-bold">{{ session('status') }}</p>
            </div>
        @endif
            <a href="/admin/facts/create" id="newpage-cta" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
               Ajouter une fiche
            </a>
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Titre</th>
                        <th scope="col" class="px-6 py-3">Description</th>
                        <th scope="col" class="px-6 py-3">lien</th>
                        <th scope="col" class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($facts as $fact)
                    <tr class="bg-white border-b">
                        <td class="px-6 py-4">
                            <a href="/admin/facts/update/{{ $fact->id }}" class="underline">{{ $fact->title }}</a>
                        </td>
                        <td class="px-6 py-4">
                            @if(strlen($fact->desc)>50)
                            {{ substr_replace($fact->desc, '...', 50) }}
                            @else
                            {{ $fact->desc }}   
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $fact->url }}</td>
                        <td class="px-6 py-4">
                            <div class="relative inline-block text-left dropdownHover">
                                <div class="relative inline-block text-left dropdownHover">
                                    <a href="/admin/facts/update/{{ $fact->id }}" class="hover:bg-gray-200 py-1 px-4 dropdownHover cursor-pointer edit-cta"><i class="fa fa-pen-to-square mt-0.5" style="color: #000" aria-hidden="true"></i></a>
                                </div>
                                <div class="relative inline-block text-left dropdownHover">
                                    <a href="/admin/facts/destroy/{{ $fact->id }}" onclick="return confirm('Supprimer cette catégorie?');" class="hover:bg-gray-200 py-1 px-4 dropdownHover"><i class="fa fa-trash mt-0.5" style="color: #ff0000" aria-hidden="true"></i></a>
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
