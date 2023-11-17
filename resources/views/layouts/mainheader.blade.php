<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>La fourmilière</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>



    <!-- Scripts -->
    @vite([
    'resources/css/app.css',
    'resources/js/app.js',
    'resources/css/forum.css',
    'resources/css/main.css',
    'resources/css/messages.css',
    'resources/css/register.css',
    'resources/css/login.css',
    'resources/css/forgotpassword.css',
    'resources/css/header.css',
    ])
</head>
</head>

<body>
    <header id="main__header">
        <style>
            @font-face {
                font-family: 'fun-sized';
                src: url('{{asset("storage/medias/FunSized.ttf")}}');
                unicode-range: U+0020-007E, U+00A0-00FF, U+0100-017F, U+0180-024F, U+1E00-1EFF, U+2C60-2C7F; /* Latin-1 Supplement, Latin Extended-A, Latin Extended-B, Latin Extended Additional, Latin Extended-C */

            }

            #main__header {
                background-image: url('{{asset("storage/medias/header-v3.jpg")}}');
            }

            .slide__menu {
                background-image: url('{{asset("storage/medias/slide-menu-background.jpg")}}');
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
            <div class="auth__container">
                <div class="auth__content">
                    <div class="auth__routes">
                        <a id="login" href="mon-compte">Connexion</a>
                        <a id="register" href="sinscrire">Devenir membre</a>
                    </div>
                    <div class="icon__container">
                        <i id="icon" class="fa fa-user-circle-o"></i>
                    </div>
                </div>
            </div>
            @auth
            <!-- <div class="notif" data-idtrack="{{auth()->user()->id}}">
                <i class="fa fa-bell"></i>
                <p class="notif__int">
                    {{ $NotifsCount }}
                </p>
                <div class="notifications__center">
                    @foreach($notifications as $notification)
                    @php
                    $readNotification = $notificationRead->where('notif_id', $notification->id)->where('user_id', auth()->user()->id)->isNotEmpty();
                    @endphp
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
                    @endforeach
                </div>
            </div> -->
            <!-- <form method="POST" action="{{ route('logout') }}">
                @csrf

                <a href="logout" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                    {{ __('Log Out') }}
                </a>
            </form> -->
            <!-- <a href="/messages"><i style="color:white;font-size:30px" class="fa fa-comment"></i></a> -->

            <!-- <script>
            
                let notifsBell = document.querySelector(".notif")
                let notificationsCenter = document.querySelector(".notifications__center")
                let notifsInt = document.querySelector(".notif__int")
                let userNotifs = document.querySelectorAll(".user__notif")

                notifsBell.addEventListener("click", ev => {
                    notificationsCenter.classList.toggle('open__notif')
                    ev.currentTarget.classList.toggle('ajax__ready')
                    notifsInt.innerHTML = "0"
                    if (!ev.currentTarget.classList.contains('ajax__ready')) {
                        let xhttp = new XMLHttpRequest()
                        let userId = ev.currentTarget.getAttribute('data-idtrack')
                        let sParams = 'userId=' + encodeURIComponent(userId)
                        xhttp.onreadystatechange = function() {
                            if (this.readyState === 4) {
                                if (this.status === 200) {
                                    console.log('Notifications updated')

                                } else {
                                    console.error("Error updating notifications.");
                                }
                            }
                        };
                        xhttp.open("POST", `/update-notifs-check/${userId}`, true);
                        xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhttp.send(sParams);
                    }
                })

                for (let userNotif of userNotifs) {
                    userNotif.addEventListener("click", event => {
                        let xhttp = new XMLHttpRequest()
                        let user_id = "{{auth()->user()->id}}"
                        let notif_id = event.currentTarget.getAttribute("data-notifId")
                        let Params = 'user_id=' + encodeURIComponent(user_id) + '&notif_id=' + encodeURIComponent(notif_id)
                        xhttp.onreadystatechange = function() {
                            if (this.readyState === 4) {
                                if (this.status === 200) {
                                    console.log('Notifications updated')
                                    notifsInt.innerHTML = "0"
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
             @if(auth()->user()->isAdmin())
            <a href="/admin">Admin</a>
            @endif -->
            @endauth
        </div>

        <div class="slide__menu">
            <ul class="sortable__list parent__list">
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
        <div class="breadcrumb__container">

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
</body>