@extends('layouts.admin')

@section('content')

<div class="container flex flex-col items-end justify-start mt-10 py-8">
    <div class="formContainer flex flex-col items-center">
        <h1 class="px-12 py-4 w-10/12 text-2xl pb-12 font-bold">Créer un nouvelle évènement</h1>
        <form class="w-full flex justify-center" action="{{ route('events.store') }}" method="post" enctype="multipart/form-data">
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
                        <x-label for="address" :value="__('Adresse')"></x-label>
                        <x-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autofocus />
                    </div>
                </div>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="link" :value="__('Lien')"></x-label>
                        <x-input id="link" class="block mt-1 w-full" type="url" name="link" :value="old('link')" required autofocus />
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
                        <x-label for="nb_places" :value="__('Nombre de places')" />
                        <input type="number" id="nb_places" name="nb_places" min="1">
                    </div>
                </div>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="start_at" :value="__('Date du début')"></x-label>
                        <x-input id="start_at" class="block mt-1 w-full form-control" type="datetime-local" name="start_at" :value="old('start_at')" required autofocus />
                    </div>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <a href="/admin/events">Retour</a>
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
@endsection
