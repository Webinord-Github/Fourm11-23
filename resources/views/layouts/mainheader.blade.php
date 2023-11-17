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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <!-- Scripts -->
    @vite([
    'resources/css/app.css',
    'resources/js/app.js',
    'resources/css/forum.css',
    'resources/css/main.css',
    'resources/css/messages.css',
    ])
</head>

<body>
    <header id="main__header">
        <div class="header__container">

            <div class="logo">
                <img src="{{ asset('files/logo-webinord-clair.png') }}" alt="">
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
                    <a class="user__notif" href="{{$notification->notif_link}}" data-notifId="{{$notification->id}}">
                        <div class="notification">
                            <li class="notif__subject">
                                {{ $notification->sujet }} <!-- Assuming 'message' is the field you want to display -->
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
            </div>
            <a href="/messages"><i style="color:white;font-size:30px" class="fa fa-comment"></i></a>
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            <script>
                let notifsBell = document.querySelector(".notif")
                let notificationsCenter = document.querySelector(".notifications__center")
                let notifsInt = document.querySelector(".notif__int")
                let userNotifs = document.querySelectorAll(".user__notif")

                notifsBell.addEventListener("click", ev => {
                    notificationsCenter.classList.toggle('open__notif')
                    ev.currentTarget.classList.toggle('ajax__ready')
                    if (!ev.currentTarget.classList.contains('ajax__ready')) {
                        let xhttp = new XMLHttpRequest()
                        let userId = ev.currentTarget.getAttribute('data-idtrack')
                        let sParams = 'userId=' + encodeURIComponent(userId)
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
            @endauth

        </div>

    </header>
    <main>
        @yield('content')
    </main>
</body>