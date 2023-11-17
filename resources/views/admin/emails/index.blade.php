@extends('layouts.admin')
@section('content')
<div class="automatic__emails__container">
    @include('admin.emails.partials.fields')
    @include('admin.emails.partials.scripts')
</div>
@endsection