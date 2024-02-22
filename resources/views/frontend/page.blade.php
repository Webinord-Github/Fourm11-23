@extends('layouts.mainheader')

@section('content')

<!-- PAGE ACCUEIL -->
@if($page->id == 1)
@include('frontend.homepage')
@include('frontend.partials.homescripts')
@endif

<!-- PAGE FOURMILIÈRE -->
@if($page->id == 3)
@include('frontend.fourmiliere')
@endif

<!-- PAGE Lexique  -->
@if($page->id == 4)
@include('frontend.lexique')
@include('frontend.partials.scripts')
@endif

<!-- PAGE FORUM  -->
@if($page->id == 5)
@include('frontend.forum')
@include('frontend.partials.forumscripts')
@endif

<!-- PAGE Outils  -->
@if($page->id == 6)
@include('frontend.tools')
@include('frontend.partials.scripts')
@endif

<!-- PAGE ÉVÉNEMENTS  -->
@if($page->id == 7)
@include('frontend.events')
@include('frontend.partials.eventscripts')
@endif

<!-- PAGE Blogue  -->
@if($page->id == 8)
@include('frontend.blogue')
@include('frontend.partials.scripts')
@endif

<!-- PAGE Facts  -->
@if($page->id == 9)
@include('frontend.facts')
@include('frontend.partials.scripts')
@endif

<!-- PAGE Intimidation  -->
@if($page->id == 10)
@include('frontend.intimidation')

@endif

<!-- Pages les membres  -->
@if($page->id == 11)
@include('frontend.members')
@endif

<!-- PAGE Source  -->
@if($page->id == 12)
@include('frontend.source')
@include('frontend.partials.scripts')
@endif

@endsection