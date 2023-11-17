@extends('layouts.admin')

@section('content')

<div class="container mt-20">
    <div class="formContainer flex flex-col items-center">
        <h1 class="px-12 py-4 w-10/12 text-2xl pb-12 font-bold">Edit Page</h1>
        <form class="w-full flex justify-center" action="{{ route('pages.update', ['page' => $model->id]) }}" method="post">
        {{ method_field('PUT') }}
            @include('admin.pages.partials.editfields')
        </form>
    </div>
</div>

@endsection
@section('scripts')
    @include('admin.pages.partials.scripts')
@endsection