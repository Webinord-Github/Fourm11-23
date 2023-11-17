@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="pagesContainer">
        <h1 class="text-4xl font-bold pb-6">Users Guard</h1>
          @if (session('success'))
            <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-8 my-6" role="alert">
                <p class="font-bold">{{ session('success') }}</p>
            </div>
        @endif

        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">Nom</th>
                    <th scope="col" class="px-6 py-3">Courriel</th>
                    <th scope="col" class="px-6 py-3">Rôle</th>
                    <th scope="col" class="px-6 py-3">Vérifié</th>
                </tr>
            </thead>
            <form method="POST" action="{{ route('usersguard.store') }}">
                @csrf
                <tbody>
                    @foreach ($users as $user)
                    <tr class="bg-white border-b">
                        <td class="px-6 py-4">
                            <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="underline">{{ $user->name }}</a>
                        </td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">{{ $user->roles->first()->name }}</td>
                        <td class="px-6 py-4">
                        <input type="checkbox" name="checkbox_{{$user->id}}" id="toggle-{{$user->id}}" class="toggle-checkbox" {{ $user->verified == 1 ? 'checked' : '' }}>
                        <label for="toggle-{{$user->id}}" class="toggle-label"></label>
                            <input type="hidden" name="user_ids[]" value="{{$user->id}}">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <div>
                    <button class="form__submit" type="submit">SAUVEGARDER</button>
                </div>
            </form>
            
        </table>
        {{$users->links()}}
    </div>
</div>

@endsection
@section('scripts')

@include('admin.users.partials.scripts')

@endsection