@extends('layouts.mainheader')
@section('content')
@if(auth()->check() && !auth()->user()->verified)
    <div class="warning__container">
        <p>Votre compte est actuellement en attente d'approbation.</p>
        <p>Dès que votre compte sera approuvé, un courriel vous sera envoyé et vous aurez ainsi accès aux différentes informations présentes sur le site.</p>
        <p>Merci de votre patience.</p>
    </div>
@endif
<div class="main_container">
    <div class="singleblogue-container">
        <div class="singleblogue-content">
            <div class="top-div">
            <div class="h1__container">
            <a href="/" class="arrow">&#8592;</a>
            <h1>{{$post->title}}<span>{{$post->title}}</span></h1>
        </div>
            </div>
            <div class="content ">
                <div class="single-post">
                    @if($post->media)
                        <div class="img-wrapper">
                            <img src="{{ $post->media->path . $post->media->name}}" alt="{{ $post->media->name }}">
                        </div>
                    @endif
        
                    <div class="text">
                        {!! $post->body !!}
                    </div>
            
                    <div class="thematiques">
                        <h3>Thématiques -</h3>
                        @foreach($post->thematiques()->get()->pluck('name')->toArray() as $thematique)
                            <p class="thematique">{{ $thematique }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection