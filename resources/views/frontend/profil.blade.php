@extends('layouts.mainheader')
@section('content')
@if(auth()->check() && !auth()->user()->verified)
    <div class="warning__container">
        <p>Votre compte est actuellement en attente d'approbation.</p>
        <p>Dès que votre compte sera approuvé, un courriel vous sera envoyé et vous aurez ainsi accès aux différentes informations présentes sur le site.</p>
        <p>Merci de votre patience.</p>
    </div>
@endif
@if (session('status') === 'updated-password')
    <div class="text-center bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-8 my-6" role="alert">
        <p class="font-bold">Mot de passe modifié</p>
    </div>
@endif
@if (session('status') === 'updated-infos')
    <div class="text-center bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-8 my-6" role="alert">
        <p class="font-bold">Vos informations ont modifiées</p>
    </div>
@endif
@if (!$errors->isEmpty())
<div role="alert" class="w-full pb-8">
    <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
        Erreurs
    </div>
    <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
        @foreach ($errors->all() as $message)
            <ul class="px-4">
                <li class="list-disc">{{$message}}</li>
            </ul>
        @endforeach
    </div>
</div>
@endif
<style>
    .profil {
        background-image: url('{{asset("storage/medias/slide-menu-background.jpg")}}');
    }

    #tools .top, #posts .top, #convos .top, #events .top, #themes .top, #members .top, #infos {
        background-image: url('{{asset("storage/medias/header-v3.jpg")}}');
    }
</style>
<div class="main_container">
    <div class="profile-container">
        <div class="profile-content">
            <div class="column">
                <div class="profil">
                    <div class="top">
                        <div class="header">
                            <div class="mon-profil">
                                <i id="icon" class="fa fa-user-circle-o"></i>
                                <p>mon profil</p>
                            </div>
                        </div>
                        <div class="img-name">
                            <div class="img">
                                <img src="{{ $user->profilePicture->path . $user->profilePicture->name }}">
                            </div>
                            <div class="name">
                                <p id="temps">Membre depuis {{ ($user->created_at)->diffInDays(Carbon\Carbon::now()) }} jours</p>
                                <p id="nom"> {{ $user->firstname . " " . $user->lastname}} </p>
                            </div>
                        </div>
                    </div>
                    <div class="bottom">
                        <div id="profile-left" class="left">
                            <div class="infos">

                                <div class="info">
                                    <p class="type">Ville de travail</p>
                                    @if($user->work_city == null)
                                        <p>Aucune information</p>
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
                            </div>
                            <div class="buttons">
                                <a id="edit-infos">modifier mes informations</a>
                                <a id="edit-password">modifier mon mot de passe</a>
                            </div>
                        </div>
                        <div id="profile-right" class="right">
                            <div class="infos">
                                <div class="info">
                                    <p class="type">Titre professionnel</p>
                                    @if($user->title == null)
                                        <p>Aucune information</p>
                                    @else
                                        <p>{{ $user->title }}</p>
                                    @endif
                                </div>
                                <div class="info">
                                    <p class="type">Organisme</p>
                                    @if($user->environment == null)
                                        <p>Aucune information</p>
                                    @else
                                        <p>{{ $user->environment }}</p>
                                    @endif
                                </div>
                                <div class="info">
                                    <p class="type">Vous travaillez principalement auprès de</p>
                                    <?php $audiences = explode(",", $user->audience); ?>
                                    @foreach($audiences as $audience)
                                        <li>{{ $audience }}</li>
                                    @endforeach
                                </div>
                                <div class="info">
                                    <p class="type">Que venez-vous chercher sur la platforme?</p>
                                    <?php $interests = explode(",", $user->interests); ?>
                                    @foreach($interests as $interest)
                                        <li>{{ $interest }}</li>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div id="infos">
                    <div class="top">
                        <div class="title">
                            <i class="fa-solid fa-shield-halved mr-4 mt-0.5" aria-hidden="true"></i>
                            <p>informations publiques</p>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="infos">
                            <div class="info">
                                <input class="checkbox" type="checkbox" id="title_show" @checked($user->title_show)>
                                <p>Titre professionne</p>
                            </div>
                            <div class="info">
                                <input class="checkbox" type="checkbox" id="environment_show" @checked($user->environment_show)>
                                <p>Organisme</p>
                            </div>
                            <div class="info">
                                <input class="checkbox" type="checkbox" id="birthdate_show" @checked($user->birthdate_show)>
                                <p>Date de naissance</p>
                            </div>
                            <div class="info">
                                <input class="checkbox" type="checkbox" id="years_xp_show" @checked($user->years_xp_show)>
                                <p>Nombre d’année de travail</p>
                            </div>
                            <div class="info">
                                <input class="checkbox" type="checkbox" id="work_city_show" @checked($user->work_city_show)>
                                <p>Ville de travail</p>
                            </div>
                            <div class="info">
                                <input class="checkbox" type="checkbox" id="gender_show" @checked($user->gender_show)>
                                <p>Genre</p>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div id="themes" class="bookmarks-ctn">
                    <div class="top">
                        <div class="title">
                            <i class="fa-solid fa-filter mr-4 mt-0.5" aria-hidden="true"></i>
                            <p>mes thématiques aimées</p>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="themes">
                            @if(count($themes) == 0)
                                <div class="empty">
                                    <p>Vous aimez aucune thématique pour l'instant</p>
                                </div>
                            @else
                                @foreach($themes as $theme)
                                    <p class="theme">{{ $theme->name }}</p>
                                @endforeach
                            @endif
                        </div>
                        <div class="voir-plus">
                            <a href="/lexique">Voir toutes les thématiques </a>
                        </div>
                    </div>
                </div>
                <div id="members" class="bookmarks-ctn">
                    <div class="top">
                        <div class="title">
                            <i class="fa fa-user mr-4 mt-0.5" aria-hidden="true"></i>
                            <p>membres suivis</p>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="users">
                            @if(count($users) == 0)
                                <div class="empty">
                                    <p>Vous suivez aucun membre pour l'instant</p>
                                </div>
                            @else
                                @foreach($users as $a_user)
                                    <div class="user">
                                        <div class="img-wrapper">
                                            <img src="{{ $a_user->profilePicture->path . $a_user->profilePicture->name }}">
                                        </div>
                                        <div class="nom">
                                            <p>{{ $a_user->firstname . ' ' . $a_user->lastname }}</p>
                                            <p>{{ $a_user->environment }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="voir-plus">
                            <a href="/">Voir tout les membres</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column">
                <div id="convos" class="bookmarks-ctn">
                    <div class="top">
                        <div class="title">
                            <i class="far fa-comments mr-4 mt-0.5" aria-hidden="true"></i>
                            <p>mes discussions en cours</p>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="convos">
                            @if(count($convos) == 0)
                                <div class="empty">
                                    <p>Vous aimez aucune conversation pour l'instant</p>
                                </div>
                            @else
                                @foreach($convos as $convo)
                                    <div class="convo">
                                        <div class="infos">
                                            <p class="title">{{ $convo->title }}</p>
                                            @if(strlen($convo->body)>50)
                                                <p class="desc">{{ substr_replace($convo->body, '...', 50) }}</p>
                                            @else
                                                <p class="desc">{{ $convo->body }}</p>
                                            @endif
                                        </div>
                                        <div class="button">
                                            <a href="/forum#{{ $convo->title }}">Voir</a>
                                        </div>
                                    </div>
                                    <div class="line"></div>
                                @endforeach
                            @endif
                        </div>
                        <div class="voir-plus">
                            <a href="/forum">Voir toutes les conversations</a>
                        </div>
                    </div>
                </div>
                <div id="events" class="bookmarks-ctn">
                    <div class="top">
                        <div class="title">
                            <i class="fa-solid fa-bell mr-4 mt-0.5" aria-hidden="true"></i>
                            <p>mes évènements aimés</p>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="events">
                            @if(count($events) == 0)
                                <div class="empty">
                                    <p>Vous aimez aucun évènement pour l'instant</p>
                                </div>
                            @else
                                @foreach($events as $event)
                                    <div class="event">
                                        <div class="left">
                                            <div class="infos">
                                                <p class="start">{{ $event->start_at }}</p>
                                                <p class="title">{{ $event->title }}</p>
                                                @if(strlen($event->desc)>50)
                                                    <p class="desc">{{ substr_replace($event->desc, '...', 50) }}</p>
                                                @else
                                                    <p class="desc">{{ $event->desc }}</p>
                                                @endif
                                            </div>
                                            <div class="button">
                                                <a href="/">Voir</a>
                                            </div>
                                        </div>
                                        <div class="right">
                                            <img src="{{ $event->image->path . $event->image->name }}" alt="{{ $event->image->name }}">
                                        </div>
                                    </div>
                                    <div class="line"></div>
                                @endforeach
                            @endif
                        </div>
                        <div class="voir-plus">
                            <a href="/evenements">Voir tout les évènements</a>
                        </div>
                    </div>
                </div>
                <div id="tools" class="bookmarks-ctn">
                    <div class="top">
                        <div class="title">
                            <i class="fa-solid fa-wrench mr-4 mt-0.5" aria-hidden="true"></i>
                            <p>mes outils aimés</p>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="tools">
                            @if(count($tools) == 0)
                                <div class="empty">
                                    <p>Vous aimez aucun outil pour l'instant</p>
                                </div>
                            @else
                                @foreach($tools as $tool)
                                    <div class="post">
                                        <div class="infos">
                                            <p class="title">{{ $tool->title }}</p>
                                            @if(strlen($tool->desc)>50)
                                                <p class="desc">{{ substr_replace($tool->desc, '...', 50) }}</p>
                                            @else
                                                <p class="desc">{{ $tool->desc }}</p>
                                            @endif
                                        </div>
                                        <div class="button">
                                            <a target="_blank" href="{{$tool->media()->first()->path . $tool->media()->first()->name}}">Voir</a>
                                        </div>
                                    </div>
                                    <div class="line"></div>
                                @endforeach
                            @endif 
                        </div>
                        <div class="voir-plus">
                            <a href="/boite-a-outils">Voir tout les outils</a>
                        </div>
                    </div>
                </div>
                <div id="posts" class="bookmarks-ctn">
                    <div class="top">
                        <div class="title">
                            <i class="fa-solid fa-newspaper mr-4 mt-0.5" aria-hidden="true"></i>
                            <p>billets de blogue</p>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="posts">
                            @if(count($posts) == 0)
                                <div class="empty">
                                    <p>Vous aimez aucun article pour l'instant</p>
                                </div>
                            @else
                                @foreach($posts as $post)
                                    <div class="post">
                                        <div class="infos">
                                            <p class="title">{{ $post->title }}</p>
                                            @if(strlen($post->body)>50)
                                                <p class="desc">{{ substr_replace($post->body, '...', 50) }}</p>
                                            @else
                                                <p class="desc">{{ $post->body }}</p>
                                            @endif
                                        </div>
                                        <div class="button">
                                            <a href="{{ route('post.show', ['post' => $post]) }}">Lire</a>
                                        </div>
                                    </div>
                                    <div class="line"></div>
                                @endforeach
                            @endif
                        </div>
                        <div class="voir-plus">
                            <a href="/blogue">Voir tout les articles</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="popup-ctn-password">
    <div class="popup">
        <div class="x">
            <a class="close-password">
                x
            </a>
        </div>
        <form method="POST" action="{{ route('users.update-password', ['user' => $user->id]) }}" class="w-full flex justify-center">
            <div class="px-12 pb-8 flex flex-col items-center w-10/12">
                @csrf
                @method('put')
                
                <h3 class="mb-4">Modifier mon mot de passe</h3>
                @if(auth()->user()->id === $user->id)
                    <div class="w-full mb-4"">
                        <x-input-label for="current_password" :value="__('Mot de passe actuel')" />
                        <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                    </div>
                @endif
                    
                <div class="w-full mb-4">
                    <x-input-label for="password" :value="__('Nouveau mot de passe')" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>
                
                <div class="w-full mb-4">
                    <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>
                
                
                <div class="flex items-center justify-end mt-4">
                    <a class="close-password mr-4">Fermer</a>
                    <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="popup-ctn-infos">
    <div class="popup">
        <div class="x">
            <a class="close-infos">
                x
            </a>
        </div>
        <form method="POST" action="{{ route('profile.update', ['user' => $user->id]) }}" class="w-full flex justify-center">
            <div class="px-12 pb-8 flex flex-col items-center w-10/12">
                @csrf
                @method('put')
                
                <h3 class="mb-4">Modifier mes informations</h3>
                    
                <div class="w-full mb-4"">
                    <x-input-label for="title" value="Titre professionnel" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ $user->title }}" />
                </div>
                <div class="w-full mb-4"">
                    <x-input-label for="environment" value="Organisme" />
                    <x-text-input id="environment" name="environment" type="text" class="mt-1 block w-full" value="{{ $user->environment }}" />
                </div>
                <div class="w-full mb-4"">
                    <x-input-label for="work_city" value="Ville de travail" />
                    <x-text-input id="work_city" name="work_city" type="text" class="mt-1 block w-full" value="{{ $user->work_city }}" />
                </div>
                <div class="w-full mb-4"">
                    <x-input-label class="text-lg font-bold" for="audience" value="Auprès de quel groupe d’âge travaillez-vous?" />
                        <?php $audiences = explode(",", $user->audience); ?>
                        <div class="flex__column w__fit">
                            <input type="checkbox" name="audience[]" id="audience1" value="Petite enfance" @checked(in_array("Petite enfance", $audiences))>
                            <label for="enfants">Petite enfance</label>
                        </div>
                        <div class="flex__column w__fit">
                            <input type="checkbox" name="audience[]" id="audience1" value="Enfance" @checked(in_array("Enfance", $audiences))>
                            <label for="enfants">Enfance</label>
                        </div>
                        <div class="flex__column w__fit">
                            <input type="checkbox" name="audience[]" id="audience1" value="Adolescence" @checked(in_array("Adolescence", $audiences))>
                            <label for="enfants">Adolescence</label>
                        </div>
                        <div class="flex__column w__fit">
                            <input type="checkbox" name="audience[]" id="audience2" value="Jeunes adultes" @checked(in_array("Jeunes adultes", $audiences))>
                            <label for="adultes">Jeunes adultes</label>
                        </div>
                        <div class="flex__column w__fit">
                            <input type="checkbox" name="audience[]" id="audience2" value="Adultes" @checked(in_array("Adultes", $audiences))>
                            <label for="adultes">Adultes</label>
                        </div>
                        <div class="flex__column w__fit">
                            <input type="checkbox" name="audience[]" id="audience3" value="Aîné·es" @checked(in_array("Aîné·es", $audiences))>
                            <label for="personnes_aines">Aîné·es</label>
                        </div>
                        <div class="flex items-center">
                            @if(end($audiences) === "Enfance" || end($audiences) === "Petite enfance" || end($audiences) === "Adolescence" || end($audiences) === "Jeunes adultes" || end($audiences) === "Adultes" || end($audiences) === "Aîné·es" )
                                <input class="mt-1 block w-full autres" type="text" name="other_audience" placeholder="Autres">
                            @else
                                <input class="mt-1 block w-full autres" type="text" name="other_audience" placeholder="Autres" value="{{ end($audiences) }}">
                            @endif
                        </div>
                </div>
                <div class="w-full mb-4"">
                    <x-input-label class="text-lg font-bold" for="interests" value="Que venez-vous chercher sur la plateforme?" />
                    <?php $interests = explode(",", $user->interests); ?>
                    <div class="flex__column w__fit">
                        <input class="text-sm font-thin" type="checkbox" name="interests[]" id="interests1" value="Partager votre expérience" @checked(in_array("Partager votre expérience", $interests))>
                        <label for="interests">Partager votre expérience</label>
                    </div>
                    <div class="flex__column w__fit">
                        <input class="text-sm font-thin" type="checkbox" name="interests[]" id="interests2" value="Lire sur le sujet" @checked(in_array("Lire sur le sujet", $interests))>
                        <label for="interests">Lire sur le sujet</label>
                    </div>
                    <div class="flex__column w__fit">
                        <input class="text-sm font-thin" type="checkbox" name="interests[]" id="interest3" value="Chercher des réponses à vos questions" @checked(in_array("Chercher des réponses à vos questions", $interests))>
                        <label for="interests">Chercher des réponses à vos questions</label>
                    </div>
                    <div class="flex__column w__fit">
                        <input class="text-sm font-thin" type="checkbox" name="interests[]" id="interests4" value="Chercher des outils pour vous aider" @checked(in_array("Chercher des outils pour vous aider", $interests))>
                        <label for="interest">Chercher des outils pour vous aider</label>
                    </div>
                    <div class="flex__column w__fit">
                        @if(end($interests) === "Lire sur le sujet" || end($interests) === "Lire sur le sujet" || end($interests) === "Lire sur le sujet" || end($interests) === "Lire sur le sujet")
                            <input class="mt-1 block w-full autres" type="text" name="other_interests" placeholder="Autres">
                        @else
                            <input class="mt-1 block w-full autres" type="text" name="other_interests" placeholder="Autres" value="{{ end($interests) }}">
                        @endif
                    </div>
                </div>
                
                <div class="flex items-center justify-end mt-4">
                    <a class="close-infos mr-4">Fermer</a>
                    <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    let right_div = document.querySelector('#profile-right')
    let left_div = document.querySelector('#profile-left')

    if(window.innerWidth > 700) {
        left_div.style.height = `${right_div.offsetHeight}px`
    }

    let checkboxes = document.querySelectorAll('.checkbox')

    for(let checkbox of checkboxes) {
        checkbox.addEventListener('click', x => {
            let info = checkbox.id
            let value = false

            if(checkbox.checked) {
                value = true
            } else {
                value = false
            }

            let xhttp = new XMLHttpRequest();
            let Params = 'info=' + encodeURIComponent(info) + '&value=' + encodeURIComponent(value)


            console.log(info)

            xhttp.onreadystatechange = function() {
                if (this.readyState === 4) {
                    if (this.status === 200) {
                        console.log(xhttp.response)
                        xhttp = null;
                    } else {
                        console.error("Error");
                    }
                }
            };
            xhttp.open("POST", '/api/profile-infos')
            xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(Params);
        })
    }

    let edit_password = document.querySelector('#edit-password')
    let popup_password = document.querySelector('.popup-ctn-password')

    edit_password.addEventListener('click', x => {
        popup_password.style.display = 'flex'
    })

    let close_btns_password = document.querySelectorAll('.close-password')

    for(let button of close_btns_password) {
        button.addEventListener('click', x => {
            popup_password.style.display = 'none'
        })
    }

    let edit_infos= document.querySelector('#edit-infos')
    let popup_infos = document.querySelector('.popup-ctn-infos')

    edit_infos.addEventListener('click', x => {
        popup_infos.style.display = 'flex'
    })

    let close_btns_infos = document.querySelectorAll('.close-infos')

    for(let button of close_btns_infos) {
        button.addEventListener('click', x => {
            popup_infos.style.display = 'none'
        })
    }
</script>
@endsection