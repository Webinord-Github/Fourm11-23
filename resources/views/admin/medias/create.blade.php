@extends('layouts.admin')

@section('content')

<div class="container mt-20">
    <div class="formContainer flex flex-col items-center">
        <h1 class="px-12 py-4 w-10/12 text-2xl pb-12 font-bold">Créer un nouveau média</h1>
        <form class="w-full flex justify-center" action="{{ route('medias.store') }}" method="post" enctype="multipart/form-data">
            @include('admin.medias.partials.fields')
        </form>
    </div>
</div>

@endsection

@section('scripts')

@include('admin.medias.partials.scripts')
@include('admin.partials.scripts')
@endsection