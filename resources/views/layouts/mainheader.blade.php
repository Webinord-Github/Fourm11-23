<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>La fourmilière</title>

    <!-- Fonts -->
    <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>



    <!-- Scripts -->
    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/css/forum.css',
        'resources/css/tools.css',
        'resources/css/lexique.css',
        'resources/css/source.css',
        'resources/css/blogue.css',
        'resources/css/main.css',
        'resources/css/chatbot.css',
        'resources/css/register.css',
        'resources/css/login.css',
        'resources/css/forgotpassword.css',
        'resources/css/header.css',
        'resources/css/member-card.css',
        'resources/css/invalid-reset-password.css',
        'resources/css/calendar.css',
        'resources/css/home.css',
        'resources/css/fourmiliere.css',
        'resources/css/events.css',
        'resources/css/singleblog.css',
        'resources/css/facts.css',
        'resources/css/profil.css',
        'resources/css/membre.css',
    ])
</head>
</head>
<body>
    <header id="main__header">
        <style>
            @font-face {
                font-family: 'fun-sized';
                src: url('{{asset("storage/medias/FunSized.ttf")}}');
                unicode-range: U+0020-007E, U+00A0-00FF, U+0100-017F, U+0180-024F, U+1E00-1EFF, U+2C60-2C7F;
                /* Latin-1 Supplement, Latin Extended-A, Latin Extended-B, Latin Extended Additional, Latin Extended-C */
            }

            #main__header {
                background-image: url('{{asset("storage/medias/header-v3.jpg")}}');
            }
        </style>
        <div class="header__container">

            <div class="left">
                <div class="hbgrContainer">
                    <div id="nav-icon1">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <div class="logo__container">
                    <p id="lafourmiliere">LA FOURMILIERE</p>
                </div>
            </div>
            <div class="ajax__search__bar">
                <form action="">
                    <input class="search__bar" type="search" placeholder="Rechercher...">
                    <i class="fa fa-search"></i>
                </form>
            </div>
            @auth
            <div class="notif" data-idtrack="{{auth()->user()->id}}">
                <i class="fa fa-bell"></i>
                <p class="notif__int">
                    {{ $NotifsCount }}
                </p>
                <div class="notifications__center">
                    @foreach($notifications as $notification)
                    @php
                    $readNotification = $notificationRead->where('notif_id', $notification->id)->where('user_id', auth()->user()->id)->isNotEmpty();
                    @endphp
                    @if($notification->type == 'Conversation')
                    <a class="user__notif" href="{{$notification->notif_link}}" data-notifId="{{$notification->id}}">
                        <div class="notification">
                            <li class="notif__subject">
                                {{ $notification->sujet }}
                            </li>
                            <div class="unread__visual">
                                @if(!$readNotification)
                                <i class="unread__dot"></i>
                                @endif
                            </div>
                        </div>
                    </a>
                    @endif
                    @if($notification->type == "Reply")
                    @php
                    $mostRecentReply = App\Models\Reply::where('conversation_id', $notification->conversation_id)
                    ->orderBy('created_at', 'desc')
                    ->first();
                    @endphp

                    @if ($mostRecentReply && $mostRecentReply->user_id == auth()->user()->id)
                    <p style="color:#fff">{{ $mostRecentReply->id }}</p>
                    @endif

                    @endif
                    @endforeach
                </div>
            </div>

            <script>
                let notifsBell = document.querySelector(".notif")
                let notificationsCenter = document.querySelector(".notifications__center")
                let notifsInt = document.querySelector(".notif__int")
                let userNotifs = document.querySelectorAll(".user__notif")
                notifsBell.addEventListener("click", ev => {
                    ev.currentTarget.classList.toggle('ajax__ready')
                    notifsInt.innerHTML = "0"
                    let xhttp = new XMLHttpRequest()
                    let sParams;
                    xhttp.onreadystatechange = function() {
                        if (this.readyState === 4) {
                            if (this.status === 200) {
                                xhttp = null;
                            } else {
                                console.error("Error updating notifications.");
                            }
                        }
                    };
                    xhttp.open("POST", `/update-notifs-check/`, true);
                    xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.send(sParams);
                })

                window.addEventListener("click", w => {
                    if (w.target.parentElement.classList.contains("notif") && !notificationsCenter.classList.contains("open__notif")) {
                        notificationsCenter.classList.add("open__notif")
                    } else if (notificationsCenter.classList.contains("open__notif")) {
                        notificationsCenter.classList.remove("open__notif")
                    }

                })


                for (let userNotif of userNotifs) {
                    userNotif.addEventListener("click", event => {
                        let xhttp = new XMLHttpRequest()
                        let notif_id = event.currentTarget.getAttribute("data-notifId")
                        let Params = 'notif_id=' + encodeURIComponent(notif_id)
                        xhttp.onreadystatechange = function() {
                            if (this.readyState === 4) {
                                if (this.status === 200) {
                                    xhttp = null;
                                } else {
                                    console.error("Error updating notifications.");
                                }
                            }
                        };
                        xhttp.open("POST", `/singleNotifsReadUpdate`, true);
                        xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhttp.send(Params);
                    })
                }
            </script>
            @endauth
            <div class="auth__container">
                <div class="auth__content">
                    <div class="auth__routes">
                        @if(auth()->check())
                        <a id="login" href="{{ route('profile.show', ['id' => auth()->user()->id]) }}">
                            {{ auth()->user()->firstname }}
                        </a>

                        <form method="POST" action="{{route('logout')}}">
                            @csrf
                            <button type="submit" id="register">Déconnexion</button>
                        </form>

                        @else
                        <a id="login" href="mon-compte">Connexion</a>
                        <a id="register" href="sinscrire">Devenir membre</a>
                        @endif
                    </div>
                    <div class="icon__container">
                        <i id="icon" class="fa fa-user-circle-o"></i>
                    </div>
                </div>
            </div>

        </div>

        <div class="slide__menu">
            <ul class="sortable__list parent__list">
                @auth
                @if(auth()->user()->isAdmin())
                <a class="no__child__item" href="/admin">Administration</a>
                @endif
                @endauth
                @foreach($navPages as $page)
                @if ($page->parent_id === null)
                {{-- Check if the current page has children --}}
                @php
                $hasChildren = false;
                foreach($navPages as $nestedPage) {
                if ($nestedPage->parent_id === $page->id) {
                $hasChildren = true;
                break;
                }
                }
                @endphp

                {{-- Render parent item based on children presence --}}
                @if ($hasChildren)
                {{-- Render as <li> if it has children --}}
                <li class="sortable__item parent__item" data-page-id="{{ $page->id }}">
                    {{ $page->title }}
                    <i class="fa fa-angle-down child__list__trigger"></i>
                    <ul class="sortable__list child__list">
                        {{-- Render children --}}
                        @foreach($navPages as $nestedPage)
                        @if ($nestedPage->parent_id === $page->id)
                        <a href="{{$nestedPage->url}}" class="sortable__item child__item" data-page-id="{{ $nestedPage->id }}" data-parent-id="{{ $page->id }}">
                            {{ $nestedPage->title }}
                        </a>
                        @endif
                        @endforeach
                    </ul>
                </li>
                @else
                {{-- Render as <a> if it doesn't have children --}}
                <a class="no__child__item" href="{{ $page->url }}"> {{ $page->title }} </a>
                @endif
                @endif
                @endforeach

            </ul>
        </div>
        <script>
            document.querySelector(".hbgrContainer").addEventListener("click", e => {
                document.querySelector("#nav-icon1").classList.toggle("open")
                if (document.querySelector("#nav-icon1").classList == "open") {
                    document.querySelector(".slide__menu").classList.add('translate')
                } else {
                    document.querySelector(".slide__menu").classList.remove('translate')
                }
            })
        </script>

    </header>
    <main>
        @yield('content')
   
    </main>
    <footer>
        <div class="footer__content">
            <div class="address">
                <p><i class="fa fa-map-marker"></i> 5600, rue Hochelaga, suite 160 Montréal (Qc) H1N 3L7</p>
            </div>
            <div class="phone">
                <a href="tel:1-855-236-6700"><i class="fa fa-phone"></i>1-855-236-6700</a>
            </div>
            <div class="ano__logo__container">
                <img class="logo" src="{{asset('storage/medias/logo-ano-white.png')}}" alt="">
            </div>
            <div class="quebec__logo__container">
                <img src="{{asset('storage/medias/QUEBEC_blanc.png')}}" alt="">
            </div>
        </div>
    </footer>
</body>