@extends('layouts.admin')

@section('content')

<div class="container flex flex-col items-end justify-start mt-10 py-8">
    <div class="formContainer flex flex-col items-center">
        <h1 class="px-12 py-4 w-10/12 text-2xl pb-12 font-bold">Éditer un article</h1>
        <form class="w-full flex justify-center" action="{{ route('posts.update', ['post' => $post->id]) }}" method="post" enctype="multipart/form-data">
            {{ method_field('PUT') }}
            @csrf
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
                        <x-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ $post->title }}" required autofocus />
                    </div>
                </div>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="slug" :value="__('Slug')"></x-label>
                        <x-input id="slug" class="block mt-1 w-full" type="text" name="slug" value="{{ $post->slug }}" required autofocus />
                    </div>
                </div>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="body" :value="__('Contenu')"></x-label>
                        <textarea style="resize: none; border-radius: 5px;height:100px" name="body">{{ $post->body }}"</textarea>
                    </div>
                </div>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="image" :value="__('Image: jpeg, png, jpg, webp')" />
                        <input type="file" id="image" name="image">
                    </div>
                </div>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label :value="__('Thématiques')"></x-label>
                        @foreach ($thematiques as $thematique)
                            <div class="flex items-center">
                                <?php $i = 0 ?>
                                @foreach ($thematiques_selected as $thematique_selected)
                                    @if ($thematique_selected->id == $thematique->id)
                                        <?php $i++ ?>
                                    @endif
                                @endforeach
                                @if ($i > 0)
                                    <input type="checkbox" id="{{ $thematique->name }}" name="thematiques[]" value="{{ $thematique->id }}" checked>
                                @else
                                    <input type="checkbox" id="{{ $thematique->name }}" name="thematiques[]" value="{{ $thematique->id }}">
                                @endif
                                <label class="mx-1 text-sm" for="{{ $thematique->name }}">{{ ucfirst($thematique->name) }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="status" :value="__('Status')"></x-label>
                        <select style="border-radius:5px;" name="status" id="status">
                            <option value="brouillon" @selected('brouillon' == $post->status)>Brouillon</option>
                            <option value="publié" @selected('publié' == $post->status)>Publié</option>
                            <option value="archivé" @selected('archivé' == $post->status)>Archivé</option>
                        </select>
                    </div>
                </div>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="published_at" :value="__('Date de publication')"></x-label>
                        <x-input id="published_at" class="block mt-1 w-full form-control" type="datetime-local" name="published_at" value="{{ $post->published_at }}" required autofocus />
                    </div>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('posts.index') }}">Retour</a>
                    <x-button class="ml-4">
                        {{ __('Éditer') }}
                    </x-button>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection
@section('scripts')
    @include('admin.blog.partials.scripts')
@endsection
