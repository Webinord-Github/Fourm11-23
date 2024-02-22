@extends('layouts.admin')

@section('content')

<div class="container mt-20">
    <div class="formContainer flex flex-col items-center">
        <h1 class="px-12 py-4 w-10/12 text-2xl pb-12 font-bold">Edit Media</h1>
        <form class="w-full flex justify-center" action="{{ route('medias.update', ['media' => $model->id]) }}" method="post" enctype="multipart/form-data">
        {{ method_field('PUT') }}
            @include('admin.medias.partials.edit-fields')
        </form>
        <form class="w-full flex justify-center" action="{{ route('medias.destroy', ['media' => $model->id]) }}" method="POST">
            @include('admin.medias.partials.edit-fields-delete')
        </form>
    </div>
</div>

@endsection
@section('scripts')
@include('admin.medias.partials.edit-scripts')
@include('admin.partials.scripts')
@endsection