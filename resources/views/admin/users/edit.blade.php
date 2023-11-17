@extends('layouts.dashboard')

@section('content')

<div class="container mt-20">
    <div class="formContainer flex flex-col items-center">
        <h1 class="px-12 py-4 w-10/12 text-2xl pb-12 font-bold">Edit User</h1>
        <form class="w-full flex justify-center" action="{{ route('users.update', ['user' => $model->id]) }}" method="post">
        {{ method_field('PUT') }}
            @include('admin.users.partials.editfields')
        </form>
        <form method="POST" action="{{ route('users.update-password', ['user' => $model->id]) }}" class="w-full flex justify-center">
            @include('admin.users.partials.update-password')
        </form>
    </div>
</div>
@endsection
