@extends('layouts.admin')

@section('content')

<div class="container mt-20">
    <div class="formContainer flex flex-col items-center">
        <h1 class="px-12 py-4 w-10/12 text-2xl pb-12 font-bold">Ajouter un utilisateur</h1>
        <form class="w-full flex justify-center" action="{{ route('users.store') }}" method="post">
            @include('admin.users.partials.createfields')
        </form>
    </div>
</div>

@endsection

@section('scripts')
@include('admin.partials.scripts')
@endsection
