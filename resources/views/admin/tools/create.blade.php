@extends('layouts.admin')

@section('content')

<div class="container flex flex-col items-end justify-start mt-10 py-8">
    <div class="formContainer flex flex-col items-center">
        <h1 class="px-12 py-4 w-10/12 text-2xl pb-12 font-bold">Créé un nouvel outil</h1>
        <form class="w-full flex justify-center" action="/admin/tools/store" method="post" enctype="multipart/form-data">
            @csrf
            <div class="px-12 pb-8 flex flex-col items-center w-10/12">
                @if (!$errors->isEmpty())
                <div role="alert" class="w-full pb-8">
                    <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                        Erreurs
                    </div>
                    <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                        @foreach ($errors->all() as $message)
                            <ul class="px-4">
                                <li class="list-disc">{{$message}}</li>
                            </ul>
                        @endforeach
                    </div>
                </div>
                @endif
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="title" :value="__('Titre')"></x-label>
                        <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                    </div>
                </div>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="desc" :value="__('Description')"></x-label>
                        <textarea style="resize: none; border-radius: 5px;height:100px" name="desc">{{ old('desc') }}</textarea>
                    </div>
                </div>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="media" :value="__('Fichier: pdf, docx')" />
                        <input type="file" id="media" name="media">
                    </div>
                </div>
                <div class="w-full mb-2">
                    <x-label :value="__('Thématiques')"></x-label>
                    @foreach ($thematiques as $thematique)
                        <div class="flex items-center">
                            <input type="checkbox" id="{{ $thematique->name }}" name="thematiques[]" value="{{ $thematique->id }}">
                            <label class="ml-1" for="{{ $thematique->name }}">{{ ucfirst($thematique->name) }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="status" :value="__('Status')"></x-label>
                        <select style="border-radius:5px;" name="status" id="status">
                            <option value="brouillon" @if ('brouillon' == old('status')) selected @endif>Brouillon</option>
                            <option value="publié" @if ('publié' == old('status')) selected @endif>Publié</option>
                            <option value="archivé" @if ('archivé' == old('status')) selected @endif>Archivé</option>
                        </select>
                    </div>
                </div>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="published_at" :value="__('Date de publication')"></x-label>
                        <x-input id="published_at" class="block mt-1 w-full form-control" type="datetime-local" name="published_at" :value="old('published_at')" required autofocus />
                    </div>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <a href="/admin/tools">Retour</a>
                    <x-button class="ml-4">
                        {{ __('Créer') }}
                    </x-button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
    @include('admin.blog.partials.scripts')
    @include('admin.partials.scripts')
@endsection
