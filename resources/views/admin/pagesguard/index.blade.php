@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="pagesContainer">
        <h1 class="text-4xl font-bold pb-6">Pages Guard</h1>
          @if (session('success'))
            <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-8 my-6" role="alert">
                <p class="font-bold">{{ session('success') }}</p>
            </div>
        @endif

        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">Titre de la page</th>
                    <th scope="col" class="px-6 py-3">Url de la page</th>
                    <th scope="col" class="px-6 py-3">Page principale</th>
                </tr>
            </thead>
            <form method="POST" action="{{ route('pagesguard.store') }}">
                @csrf
                <tbody>
                    @foreach ($pages as $page)
                    <tr class="bg-white border-b">
                        <td class="px-6 py-4">
                            <a href="{{ route('pages.edit', ['page' => $page->id]) }}" class="underline">{{ $page->title }}</a>
                        </td>
                        <td class="px-6 py-4">/{{ $page->url }}</td>
                        <td class="px-6 py-4">
                        <input type="checkbox" name="checkbox_{{$page->id}}" id="toggle-{{$page->id}}" class="toggle-checkbox" {{ $page->categorie == 1 ? 'checked' : '' }}>
                        <label for="toggle-{{$page->id}}" class="toggle-label"></label>
                            <input type="hidden" name="page_ids[]" value="{{$page->id}}">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <div>
                    <button class="form__submit" type="submit">SAUVEGARDER</button>
                </div>
            </form>
            
        </table>
        {{$pages->links()}}
    </div>
</div>

@endsection
@section('scripts')
@include('admin.users.partials.scripts')
@include('admin.partials.scripts')
@endsection