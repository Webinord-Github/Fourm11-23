@extends('layouts.admin')

@section('content')

<div class="container flex flex-col items-end justify-start mt-10 py-8">
    <div class="formContainer flex flex-col items-center">
        <h1 class="px-12 py-4 w-10/12 text-2xl pb-12 font-bold">Modifer un outil</h1>
        <form class="w-full flex justify-center" action="/admin/tools/update/" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $tool->id }}">
            <div class="px-12 pb-8 flex flex-col items-center w-10/12">
                @if (!$errors->isEmpty())
                <div role="alert" class="w-full pb-8">
                    <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                        Empty Fields
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
                        <x-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ $tool->title }}" required autofocus />
                    </div>
                </div>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="desc" :value="__('Description')"></x-label>
                        <textarea style="resize: none; border-radius: 5px;height:100px" name="desc">{{ $tool->desc }}"</textarea>
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
                        <?php
                            $i = 0
                        ?>
                        <div class="flex items-center">
                            @foreach ($thematiques_selected as $thematique_selected)
                                @if($thematique->id == $thematique_selected->id)
                                    <?php
                                        $i++
                                    ?>
                                @endif
                            @endforeach
                            <input type="checkbox" id="{{ $thematique->name }}" name="thematiques[]" value="{{ $thematique->id }}" @checked($i > 0)>
                            <label class="ml-1" for="{{ $thematique->name }}">{{ ucfirst($thematique->name) }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="status" :value="__('Status')"></x-label>
                        <select style="border-radius:5px;" name="status" id="status">
                            <option value="brouillon" @if ('brouillon' == $tool->status) selected @endif>Brouillon</option>
                            <option value="publié" @if ('publié' == $tool->status) selected @endif>Publié</option>
                            <option value="archivé" @if ('archivé' == $tool->status) selected @endif>Archivé</option>
                        </select>
                    </div>
                </div>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="published_at" :value="__('Date de publication')"></x-label>
                        <x-input id="published_at" class="block mt-1 w-full form-control" type="datetime-local" name="published_at" value="{{ $tool->published_at }}" required autofocus />
                    </div>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <a href="/admin/tools">Retour</a>
                    <x-button class="ml-4">
                        {{ __('Modifier') }}
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
