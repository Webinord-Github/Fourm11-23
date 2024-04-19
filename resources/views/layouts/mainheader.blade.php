<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @php
        $cookie = App\Models\Cookie::first();
        echo $cookie->cookie_script;
    @endphp
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>La fourmilière</title>

    <!-- Fonts -->
    <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('storage/medias/edo.ttf') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>


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
    'resources/css/members.css',
    'resources/css/intimidation.css',
    'resources/css/chatuser.css',
    ])
</head>
</head>

<body>

    @php
    @endphp
    <header id="main__header">
        @auth
        @php
        $notifsCount = 0;
        $notifsCheck = strtotime(auth()->user()->notifs_check);

        foreach($notifications as $notification) {
        if(strtotime($notification->updated_at) > $notifsCheck) {
        if($notification->type == 'BasicNotif')
        $notifsCount++;
        }

        if($notification->type == "Reply") {

        $targetConversation = $notification->conversation;
        $targetBookmarks = $conversationBookmarks->where('conversation_id', $targetConversation->id);

        if($targetBookmarks->count() > 0 && $notification->reply_author_id != auth()->user()->id) {
        foreach($targetBookmarks as $bookmark) {
        if(strtotime($notification->updated_at) > strtotime($bookmark->updated_at)) {
        if(strtotime($notification->updated_at) > $notifsCheck) {
        $notifsCount++;
        }
        }
        }
        }
        }
        }


        @endphp
        @endauth

        <style>
            @font-face {
                font-family: 'Edo';
                src: url('{{ asset("storage/medias/edo.ttf") }}') format('truetype');
                font-weight: normal;
                font-style: normal;
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
            @auth
            @if(auth()->user()->verified == true)
            <div class="desktop__ajax__search__bar">
                <form action="">
                    <input class="search__bar" type="search" placeholder="Rechercher...">
                    <i class="fa fa-search"></i>
                </form>
                <div class="desktop__search__results__container">
                </div>
            </div>
            @endif
            @endauth

            <div class="auth__container">
                <div class="auth__content">
                    @auth
                    @if(auth()->user()->verified == true)
                    <div class="notif" data-idtrack="{{auth()->user()->id}}">
                        <i class="fa fa-bell"></i>
                        <p class="notif__int">
                            @if($notifsCount > 99)
                            99+
                            @else
                            {{$notifsCount}}
                            @endif
                        </p>
                        <div class="notifications__center__container">

                            <div class="notifications__center">
                                @foreach($notifications as $notification)
                                @php
                                $readNotification = $notificationRead->where('notif_id', $notification->id)->where('user_id', auth()->user()->id)->isNotEmpty();
                                @endphp

                                @if($notification->type == "BasicNotif")
                                <a class="user__notif" href="{{$notification->notif_link}}" data-notifId="{{$notification->id}}">
                                    <div class="notification">
                                        <li class="notif__subject">
                                            {!! $notification->sujet !!}
                                        </li>
                                        <div class="unread__visual">
                                            @if(!$readNotification)
                                            <i class="unread__dot"></i>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                                <div class="notif__divider">
                                    <div class="divider"></div>
                                </div>
                                @endif
                                @if($notification->type == "Reply")
                                @php
                                $targetConversation = $notification->conversation;
                                $targetBookmarks = $conversationBookmarks->where('conversation_id', $targetConversation->id);
                                @endphp

                                @if($targetBookmarks->count() > 0 && $notification->reply_author_id != Auth::user()->id)
                                @foreach($targetBookmarks as $bookmark)
                                @if(strtotime($notification->updated_at) > strtotime($bookmark->updated_at))
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
                                <div class="notif__divider">
                                    <div class="divider"></div>
                                </div>
                                @endif
                                @endforeach
                                @endif
                                @endif

                                @endforeach
                            </div>
                        </div>
                    </div>

                    <script>
                        let notifsBell = document.querySelector(".notif")
                        let notificationsCenter = document.querySelector(".notifications__center__container")
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
                            xhttp.open("POST", `{{route("update-notifs-check")}}`, true);
                            xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                            xhttp.send(sParams);
                        })

                        document.addEventListener("click", w => {
                            if (w.target.classList.contains('fa-bell') || w.target.classList.contains('notif__int')) {
                                if (w.target.parentElement.classList.contains("notif") && !notificationsCenter.classList.contains("open__notif")) {
                                    notificationsCenter.classList.add("open__notif")
                                } else if (notificationsCenter.classList.contains("open__notif")) {
                                    notificationsCenter.classList.remove("open__notif")
                                }
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
                    @endif
                    @endauth
                    <div class="auth__routes">
                        @if(auth()->check())
                        <a id="login" href="{{ route('profile.show', ['id' => auth()->user()->id]) }}">
                            {{ auth()->user()->firstname }}
                        </a>

                        <form method="POST" action="{{route('logout')}}">
                            @csrf
                            <button type="submit" id="logout">Déconnexion</button>
                        </form>

                        @else
                        <a id="login" href="mon-compte">Connexion</a>
                        <a id="register" href="sinscrire">Devenir membre</a>
                        @endif
                    </div>
                    <div class="icon__container">
                        @if(!auth()->check())
                        <i id="icon" class="fa fa-user-circle-o"></i>
                        @else
                        <img id="profile__picture" src="{{auth()->user()->profilePicture->path . auth()->user()->profilePicture->name}}" alt="">
                        @endif
                    </div>
                </div>
            </div>

        </div>
        @auth
        @if(auth()->user()->verified == true)
        <div class="mobile__search__container">
            <div class="mobile__ajax__search__bar">
                <form action="">
                    <input class="search__bar" type="search" placeholder="Rechercher...">
                    <i class="fa fa-search"></i>
                </form>
                <div class="mobile__search__results__container">
                </div>
            </div>
        </div>
        @endif
        @endauth

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
                @if(auth()->check() && !auth()->user()->verified && $page->id != 5)
                @if ($hasChildren)
                <li class="sortable__item parent__item" data-page-id="{{ $page->id }}">
                    {{$page->title}}
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
                @if(auth()->check() && auth()->user()->verified)
                @if ($hasChildren)
                <li class="sortable__item parent__item" data-page-id="{{ $page->id }}">
                    {{$page->title}}
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
                @if(!auth()->check() && $page->id != 5)
                @if ($hasChildren)
                <li class="sortable__item parent__item" data-page-id="{{ $page->id }}">
                    {{$page->title}}
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
        @auth
        @if(auth()->user()->verified == true)
        <script>
            // desktop ajax search bar
            let searchBar = document.querySelector(".desktop__ajax__search__bar .search__bar");
            let resultsContainer = document.querySelector(".desktop__search__results__container");

            searchBar.addEventListener("keyup", k => {
                let xhttp = new XMLHttpRequest();
                let data = k.target.value;

                let Params = 'data=' + encodeURIComponent(data);
                xhttp.onreadystatechange = function() {
                    if (this.readyState === 4) {
                        if (this.status === 200) {
                            // Clear previous results before adding new ones
                            resultsContainer.innerHTML = "";

                            const responses = JSON.parse(xhttp.responseText);

                            for (const property in responses) {
                                if (property == "pages") {
                                    for (let res of responses.pages) {
                                        if (res !== undefined) {
                                            let ahref = document.createElement('a');
                                            ahref.classList.add('results');
                                            ahref.innerHTML = `
                                                ${res.title} <br><strong style="font-size:12px;">
                                                Catégorie -> Page</strong>
                                            `;
                                            ahref.href = res.url;
                                            resultsContainer.append(ahref);
                                        }
                                    }
                                }
                                if (property == "conversations") {
                                    for (let res of responses.conversations) {
                                        if (res !== undefined) {
                                            let ahref = document.createElement('a');
                                            ahref.classList.add('results');
                                            ahref.innerHTML = `
                                                ${res.title} <br><strong style="font-size:12px;">
                                                Catégorie -> Conversation</strong>
                                            `;
                                            ahref.href = `/forum#c${res.id}`;
                                            resultsContainer.append(ahref);
                                        }
                                    }
                                }
                                if (property == "events") {
                                    for (let res of responses.events) {
                                        if (res !== undefined) {
                                            let ahref = document.createElement('a');
                                            ahref.classList.add('results');
                                            ahref.innerHTML = `
                                                ${res.title} <br><strong style="font-size:12px;">
                                                Catégorie -> Événement</strong>
                                            `;
                                            ahref.href = `/evenements#e${res.id}`;
                                            resultsContainer.append(ahref);
                                        }
                                    }
                                }
                                // if (property == "users") {
                                //     for (let res of responses.users) {
                                //         if (res !== undefined) {

                                //             let ahref = document.createElement('a');
                                //             ahref.classList.add('results');
                                //             ahref.innerHTML = `
                                //                 ${res.firstname} ${res.lastname} <br><strong style="font-size:12px;">
                                //                 Catégorie -> Membre</strong>
                                //             `;
                                //             ahref.href = `/`;
                                //             resultsContainer.append(ahref);
                                //         }
                                //     }
                                // }
                            }
                            if (data === "") {
                                resultsContainer.innerHTML = ""
                            }
                        } else {
                            console.error("Error");
                        }
                    }
                };

                xhttp.open("POST", `{{ route('search') }}`, true);
                xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(Params);
            });
            // mobile ajax search bar
            let mobileSearchBar = document.querySelector(".mobile__ajax__search__bar .search__bar");
            let mobileResultsContainer = document.querySelector(".mobile__search__results__container");

            mobileSearchBar.addEventListener("keyup", k => {
                let xhttp = new XMLHttpRequest();
                let data = k.target.value;

                let Params = 'data=' + encodeURIComponent(data);
                xhttp.onreadystatechange = function() {
                    if (this.readyState === 4) {
                        if (this.status === 200) {
                            // Clear previous results before adding new ones
                            mobileResultsContainer.innerHTML = "";

                            const responses = JSON.parse(xhttp.responseText);

                            for (const property in responses) {
                                if (property == "pages") {
                                    for (let res of responses.pages) {
                                        if (res !== undefined) {
                                            let ahref = document.createElement('a');
                                            ahref.classList.add('results');
                                            ahref.innerHTML = `
                                                ${res.title} <br><strong style="font-size:12px;">
                                                Catégorie -> Page</strong>
                                            `;
                                            ahref.href = res.url;
                                            mobileResultsContainer.append(ahref);
                                        }
                                    }
                                }
                                if (property == "conversations") {
                                    for (let res of responses.conversations) {
                                        if (res !== undefined) {
                                            let ahref = document.createElement('a');
                                            ahref.classList.add('results');
                                            ahref.innerHTML = `
                                                ${res.title} <br><strong style="font-size:12px;">
                                                Catégorie -> Conversation</strong>
                                            `;
                                            ahref.href = `/forum#c${res.id}`;
                                            mobileResultsContainer.append(ahref);
                                        }
                                    }
                                }
                                if (property == "events") {
                                    for (let res of responses.events) {
                                        if (res !== undefined) {
                                            let ahref = document.createElement('a');
                                            ahref.classList.add('results');
                                            ahref.innerHTML = `
                                                ${res.title} <br><strong style="font-size:12px;">
                                                Catégorie -> Événement</strong>
                                            `;
                                            ahref.href = `/evenements#e${res.id}`;
                                            mobileResultsContainer.append(ahref);
                                        }
                                    }
                                }
                                if (property == "users") {
                                    for (let res of responses.users) {
                                        if (res !== undefined) {

                                            let ahref = document.createElement('a');
                                            ahref.classList.add('results');
                                            ahref.innerHTML = `
                                                ${res.firstname} ${res.lastname} <br><strong style="font-size:12px;">
                                                Catégorie -> Membre</strong>
                                            `;
                                            ahref.href = `/`;
                                            mobileResultsContainer.append(ahref);
                                        }
                                    }
                                }
                            }
                            if (data === "") {
                                mobileResultsContainer.innerHTML = ""
                            }
                        } else {
                            console.error("Error");
                        }
                    }
                };

                xhttp.open("POST", `{{ route('search') }}`, true);
                xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(Params);
            });
        </script>
        @endif
        @endauth
        @if(!auth()->check() || auth()->user()->verified == false)
        <style>
            @media screen and (min-width:600px) {
                header {
                    .logo__container {
                        display: block !important;
                    }
                }
            }
        </style>
        @endif
    </header>
    <main>
        @yield('content')
        @auth
        @php
            $chatbotactive = App\Models\ChatbotActive::where('id', 1)->first();
        @endphp
        @if(auth()->user()->verified && !auth()->user()->isAdmin() && $chatbotactive->active)
        <div class="main__chat__container" id="mainChat">
            <i class="fas fa-comment-dots chat__available" v-if="chatBubble" @click.prevent="openChat"></i>
            <div v-if="chatWindow" class="user__chat__container">
                <div class="chatbot__window">
                    <div class="minus__container">
                        @php
                        $admin = App\Models\User::where('id', 1)->firstOrFail();
                        @endphp
                        <div class="admin__infos">
                            <img src="{{$admin->ProfilePicture->path . $admin->ProfilePicture->name}}" alt="">
                            <p>L'Anonyme</p>
                        </div>
                        <i class="fa fa-minus minus__chat" @click.prevent="closeChat"></i>
                    </div>
                    <div class="messages__container" ref="chatWindowRef">
                        @php
                        $admin = App\Models\User::where('id', 1)->firstOrFail();
                        @endphp
                        <div class="message" v-for="message in messages">
                            <div v-if="message.sender === '{{auth()->user()->id}}'" class="right">
                                <div>
                                    <img src="{{auth()->user()->profilePicture->path . auth()->user()->profilePicture->name}}" alt="">
                                    <p class="right__message">@{{ message.body }}</p>
                                </div>
                                <p class="timestamp">@{{ message.timestamp }}</p>
                            </div>
                            <div v-else class="left">
                                <div>
                                    <img src="{{$admin->profilePicture->path . $admin->profilePicture->name}}" alt="">
                                    <p class="left__message">@{{ message.body }}</p>
                                </div>
                                <p class="timestamp">@{{ message.timestamp }}</p>
                            </div>
                        </div>


                    </div>
                    <form class="chat__form__ajax">
                        @csrf
                        <input class="message" v-model="newMessage" type="text" name="message" id="message" @keyup="enableSendForm">
                        <i class="fa fa-paper-plane ajax__send" v-if="send" @click.prevent="sendMessage"></i>
                        <i class="fa fa-paper-plane ajax__send disabled" v-if="disabled"></i>
                    </form>
                </div>
            </div>
        </div>
        <script>
            new Vue({
                el: '#mainChat',
                data: {
                    messages: [],
                    newMessage: '',
                    chatBubble: true,
                    chatWindow: false,
                    send: false,
                    disabled: true,
                },
                mounted() {
                    this.getNewMessageNotif();
                    setInterval(() => {
                        this.getNewMessageNotif();
                    }, 2000);
                },
                methods: {
                    openChat() {
                        clearInterval(this.intervalId);
                        this.chatBubble = false;
                        this.chatWindow = true;
                        this.messages = [];
                        let isManuallyScrolling = false;


                        let lastId;
                        // Fetch messages for the selected user from the controller
                        let xhttp = new XMLHttpRequest();
                        let Params;
                        xhttp.onreadystatechange = () => {
                            if (xhttp.readyState === 4) {
                                if (xhttp.status === 200) {
                                    // Update messages array with the fetched messages
                                    this.messages = JSON.parse(xhttp.responseText).messages.map(message => ({
                                        sender: message.sender,
                                        body: message.body,
                                        timestamp: new Date(message.created_at).toLocaleString(),
                                    }));
                                    if (!isManuallyScrolling) {
                                        this.$nextTick(() => {
                                            this.scrollToBottom();
                                        });
                                    }
                                } else {
                                    console.error("Error");
                                }
                            }
                        };

                        xhttp.open("POST", `{{ route('loadMessagesFromAdmin') }}`, true);
                        xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhttp.send(Params);

                        const fetchMessagesInterval = () => {
                            let xhttp = new XMLHttpRequest();
                            let Params;
                            xhttp.onreadystatechange = () => {
                                if (xhttp.readyState === 4) {
                                    if (xhttp.status === 200) {
                                        const response = JSON.parse(xhttp.responseText);
                                        const messages = response.messages;
                                        if (messages.length > 0) {
                                            let lastMessage = messages[messages.length - 1];
                                            for (let message of messages) {
                                                if (message.id > lastId) {
                                                    this.messages.push({
                                                        sender: message.sender,
                                                        body: message.body,
                                                        timestamp: new Date(message.created_at).toLocaleString(),
                                                    });
                                                }
                                            }
                                            lastId = lastMessage.id
                                            if (this.$refs.chatWindowRef) {
                                                this.$nextTick(() => {
                                                    this.scrollToBottom();
                                                });
                                            }
                                        }
                                    } else {
                                        console.error("Error");
                                    }
                                }
                            };

                            xhttp.open("POST", `{{ route('getInstantMessagesFromAdmin') }}`, true);
                            xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                            xhttp.send(Params);
                        }

                        fetchMessagesInterval();
                        this.intervalId = setInterval(fetchMessagesInterval, 2000);
                    },
                    scrollToBottom() {
                        const chatWindow = this.$refs.chatWindowRef;
                        chatWindow.scrollTop = chatWindow.scrollHeight;
                    },
                    closeChat() {

                        this.chatWindow = false;
                        this.chatBubble = true;

                    },
                    sendMessage() {
                        let xhttp = new XMLHttpRequest();
                        let Params = 'message=' + encodeURIComponent(this.newMessage);

                        xhttp.onreadystatechange = () => {
                            if (xhttp.readyState === 4) {
                                if (xhttp.status === 200) {
                                    // Update messages array with the sent message

                                    this.messages.push({
                                        sender: '{{auth()->user()->id}}',
                                        body: this.newMessage,
                                        timestamp: new Date().toLocaleString(), // Add timestamp to the message
                                    });

                                    // Clear the input field after sending the message
                                    this.newMessage = '';
                                    this.send = false
                                    this.disabled = true
                                } else {
                                    console.error("Error");
                                }
                            }
                        };

                        xhttp.open("POST", `{{ route('userStore') }}`, true);
                        xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhttp.send(Params);
                    },
                    enableSendForm() {
                        if (this.newMessage != "") {
                            this.send = true;
                            this.disabled = false
                        } else {
                            this.send = false;
                            this.disabled = true;
                        }
                    },
                    getNewMessageNotif() {
                        let xhttp = new XMLHttpRequest();
                        let Params;
                        xhttp.onreadystatechange = () => {
                            if (xhttp.readyState === 4) {
                                if (xhttp.status === 200) {
                                    const response = JSON.parse(xhttp.responseText);
                                    const messages = response.message;
                                    const chatBubble = document.querySelector(".chat__available")
                                    if (messages.length > 0) {
                                        if (this.chatBubble) {

                                            chatBubble.classList.add("newNotifBubble")
                                        }

                                    }

                                } else {
                                    console.error("Error");
                                }
                            }
                        };
                        xhttp.open("POST", `{{ route('getNewMessageNotifFromAdmin') }}`, true);
                        xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhttp.send(Params);
                    },

                },

            });
        </script>
        @endif
        @endauth
    </main>
    @if(auth()->check() && auth()->user()->verified == false)
            <style>
                @media screen and (max-width:767px) {
                    main {
                        padding-top: 100px;
                    }
                }
            </style>
    @else 
    <style>
                @media screen and (max-width:767px) {
                    main {
                        padding-top: 140px;
                    }
                }
            </style>
    @endif
    <footer>
        <div class="footer__content">
            <div class="ano__logo__container">
                <a href="https://anonyme.ca" target="_blank">
                    <img class="logo" src="{{asset('storage/medias/logo-ano-white.png')}}" alt="">
                </a>
            </div>
            <div class="infos__container">
                <div class="address">
                    <p><i class="fa fa-map-marker"></i> 5600, rue Hochelaga, suite 160 Montréal (Qc) H1N 3L7</p>
                </div>
                <div class="phone">
                    <a href="tel:1-855-236-6700"><i class="fa fa-phone"></i>1-855-236-6700</a>
                </div>
            </div>
            <div class="quebec__logo__container">
                <img src="{{asset('storage/medias/QUEBEC_blanc.png')}}" alt="">
            </div>
        </div>
    </footer>
</body>