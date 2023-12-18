@extends('layouts.elementor')

@section('content')

<div class="elementor-container">
    <h1 class="title">Article builder</h1>
    <div id="preview">
    </div>
</div>
@endsection

@section('scripts')
    {{-- @include('admin.blog.partials.scripts') --}}
    @include('admin.blog.partials.scripts')
@endsection
