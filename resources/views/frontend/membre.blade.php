@extends('layouts.mainHeader')
@section('content')
@if(auth()->check() && !auth()->user()->verified)
    <div class="warning__container">
        <p>Votre compte est actuellement en attente d'approbation.</p>
        <p>Dès que votre compte sera approuvé, un courriel vous sera envoyé et vous aurez ainsi accès aux différentes informations présentes sur le site.</p>
        <p>Merci de votre patience.</p>
    </div>
@endif
<style>
    .profil {
        background-image: url('{{asset("storage/medias/slide-menu-background.jpg")}}');
    }
</style>
<div class="main_container">
    <div class="member-container">
        <div class="member-content">
            <div class="profil">
                <div class="top">
                    <div class="header">
                        <div class="mon-profil">
                            <i id="icon" class="fa fa-user-circle-o"></i>
                            <p>profile du membre</p>
                        </div>
                    </div>
                    <div class="img-name">
                        <div class="img">
                            <img src="{{ $user->profilePicture->path . $user->profilePicture->name }}">
                        </div>
                        <div class="name">
                            <p id="temps">Membre depuis {{ ($user->created_at)->diffInDays(Carbon\Carbon::now()) }} jours</p>
                            <p id="nom"> {{ $user->firstname . " " . $user->lastname}} @if($user->pronoun == !null)<span id="pronom">({{ $user->pronoun }})</span>@endif</p>
                            <p id="desc">{{ $user->description }}</p>
                        </div>
                    </div>
                </div>
                <div class="bottom">
                    <div id="profile-left" class="left">
                        <div class="infos">
                            <div class="info">
                                <p class="type">Date de naissance</p>
                                @if($user->birthdate == null || $user->birthdate_show == 0)
                                    <p>Information cachée</p>
                                @else
                                    <p>{{ $user->birthdate }}</p>
                                @endif
                            </div>
                            <div class="info">
                                <p class="type">Genre</p>
                                @if($user->gender == null || $user->gender_show == 0)
                                    <p>Information cachée</p>
                                @else
                                    <p>{{ $user->gender }}</p>
                                @endif
                            </div>
                            <div class="info">
                                <p class="type">Accord utilisés</p>
                                @if($user->used_agreements == null)
                                    <p>Aucune information</p>
                                @else
                                    <p>{{ $user->used_agreements }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="buttons">
                            <a id="follow">Suivre</a>
                        </div>
                    </div>
                    <div id="profile-right" class="right">
                        <div class="infos">
                            <div class="info">
                                <p class="type">Titre professionnel</p>
                                @if($user->title == null || $user->title_show == 0)
                                    <p>Information cachée</p>
                                @else
                                    <p>{{ $user->title }}</p>
                                @endif
                            </div>
                            <div class="info">
                                <p class="type">Organisme</p>
                                @if($user->environment == null || $user->environment_show == 0)
                                    <p>Information cachée</p>
                                @else
                                    <p>{{ $user->environment }}</p>
                                @endif
                            </div>
                            <div class="info">
                                <p class="type">Nombre d'années de travail</p>
                                @if($user->years_xp == null || $user->years_xp_show == 0)
                                    <p>Information cachée</p>
                                @else
                                    <p>{{ $user->years_xp }}</p>
                                @endif
                            </div>
                            <div class="info">
                                <p class="type">Ville de travail</p>
                                @if($user->work_city == null || $user->work_city_show == 0)
                                    <p>Information cachée</p>
                                @else
                                    <p>{{ $user->work_city }}</p>
                                @endif
                            </div>
                            <div class="info">
                                <p class="type">Courriel</p>
                                @if($user->email == null)
                                    <p>Aucune information</p>
                                @else
                                    <p>{{ $user->email }}</p>
                                @endif
                            </div>
                            <div class="info">
                                <p class="type">Téléphone de travail</p>
                                @if($user->work_phone == null)
                                    <p>Aucune information</p>
                                @else
                                <p>{{ $user->work_phone }}</p>
                                @endif
                            </div>
                            <div class="info">
                                <p class="type">Vous travaillez principalement auprès de</p>
                                @if($user->audience == null)
                                    <p>Aucune information</p>
                                @else
                                    <p>{{ $user->audience }}</p>
                                @endif
                            </div>
                            <div class="info">
                                <p class="type">Que venez-vous chercher sur la platforme?</p>
                                @if($user->interests == null)
                                    <p>Aucune information</p>
                                @else
                                    <p>{{ $user->interests }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let right_div = document.querySelector('#profile-right')
    let left_div = document.querySelector('#profile-left')

    if(window.innerWidth > 700) {
        left_div.style.height = `${right_div.offsetHeight}px`
    }
</script>
@endsection