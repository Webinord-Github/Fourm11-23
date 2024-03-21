@extends('layouts.admin')

@section('content')
<div class="chatbot__container" id="app">
    <div class="users__container">
        @foreach($users as $user)
        @if(!$user->isAdmin())
        <div class="user__infos" @click="loadMessagesForUser({{ $user->id }}, $event.target)" data-id="{{$user->id}}">
            <img class="user__image" src="{{ $user->profilePicture->path . $user->profilePicture->name }}" alt="">
            <p class="user__name">{{ $user->firstname . " " . $user->lastname }}</p>
            <p class="newMessagesCount count__{{$user->id}}"></p>
        </div>
        @endif
        @endforeach
    </div>
    <div class="chat__container">
        <div class="messages__container" ref="chatWindowRef">
            <div class="message" v-for="message in messages">
                <div v-if="message.sender != 1" class="left">
                    <div>
                        <img src="{{$user->profilePicture->path . $user->profilePicture->name}}" alt="">
                        <p class="left__message">@{{ message.body }}</p>
                    </div>
                    <p class="timestamp">@{{ message.timestamp }}</p>
                </div>
                <div v-else class="right">
                    <div>
                        <img src="{{auth()->user()->profilePicture->path . auth()->user()->profilePicture->name}}" alt="">
                        <p class="right__message">@{{ message.body }}</p>
                    </div>
                    <p class="timestamp">@{{ message.timestamp }}</p>
                </div>
            </div>
            <div v-if="noconversation" class="no__conversation">
                <p>Choisir une conversation</p>
            </div>
        </div>
        <div v-if="loading" class="loading__animation">
            <p>Loading ...</p>
        </div>
        <form v-if="chatform" class="chat__form__ajax">
            @csrf
            <input class="message" v-model="newMessage" type="text" name="message" id="message" @keyup="enableSendForm">
            <i class="fa fa-paper-plane ajax__send" v-if="send" @click.prevent="sendMessage"></i>
            <i class="fa fa-paper-plane ajax__send disabled" v-if="disabled"></i>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>

<script>
    new Vue({
        el: '#app',
        data: {
            messages: [],
            newMessage: '',
            authenticatedUserId: "{{ auth()->check() ? auth()->user()->id : null }}",
            userId: null, // Assuming this is the user's ID
            loading: false,
            chatform: false,
            noconversation: true,
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
            sendMessage() {
                if (!this.authenticatedUserId) {
                    console.error("User not authenticated.");
                    return;
                }

                let xhttp = new XMLHttpRequest();
                let Params = 'user_id=' + encodeURIComponent(this.userId) + '&message=' + encodeURIComponent(this.newMessage);

                xhttp.onreadystatechange = () => {
                    if (xhttp.readyState === 4) {
                        if (xhttp.status === 200) {
                            // Update messages array with the sent message

                            this.messages.push({
                                sender: 1,
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

                // Ensure that this.userId is correctly set before sending the message
                if (!this.userId) {
                    console.error("User ID not set.");
                    return;
                }

                xhttp.open("POST", `{{ route('chatbot.store') }}`, true);
                xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(Params);
            },
            loadMessagesForUser(user_id, target) {
                clearInterval(this.intervalId);

                this.userId = user_id; // Update userId with the selected user_id
                this.messages = []; // Clear existing messages
                this.loading = true;

                let lastId;
                // Fetch messages for the selected user from the controller
                let xhttp = new XMLHttpRequest();
                let Params = 'user_id=' + encodeURIComponent(user_id);
                xhttp.onreadystatechange = () => {
                    if (xhttp.readyState === 4) {
                        if (xhttp.status === 200) {
                            target.classList.remove('newNotif')
                            this.chatform = true;
                            this.loading = false;
                            this.noconversation = false;
                            // Update messages array with the fetched messages
                            this.messages = JSON.parse(xhttp.responseText).messages.map(message => ({
                                sender: message.sender,
                                body: message.body,
                                timestamp: new Date(message.created_at).toLocaleString(),
                            }));
                            this.$nextTick(() => {
                                this.scrollToBottom();
                            });
                        } else {
                            console.error("Error");
                        }
                    }
                };

                xhttp.open("POST", `{{ route('getMessagesForUser') }}`, true);
                xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(Params);

                const fetchMessagesInterval = () => {
                    let xhttp = new XMLHttpRequest();
                    let Params = 'user_id=' + encodeURIComponent(user_id);
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
                                    this.$nextTick(() => {
                                        this.scrollToBottom();
                                    });
                                }
                            } else {
                                console.error("Error");
                            }
                        }
                    };

                    xhttp.open("POST", `{{ route('getNewMessages') }}`, true);
                    xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.send(Params);
                }


                fetchMessagesInterval();
                this.intervalId = setInterval(fetchMessagesInterval, 2000);
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
            scrollToBottom() {
                const chatWindow = this.$refs.chatWindowRef;
                chatWindow.scrollTop = chatWindow.scrollHeight;
            },
            getNewMessageNotif() {
                let xhttp = new XMLHttpRequest();
                let Params;
                let chatbotMenu = document.querySelector("#chatbot__menu")
                xhttp.onreadystatechange = () => {
                    if (xhttp.readyState === 4) {
                        if (xhttp.status === 200) {
                            const response = JSON.parse(xhttp.responseText);
                            const messages = response.message;
                            let divs = document.querySelectorAll(".user__infos")
                            console.log(messages.length)
                            if (messages.length > 0) {
                                chatbotMenu.classList.add("newNotif")
                                for (let message of messages) {
                                    for (let div of divs) {
                                        if (div.getAttribute('data-id') == message.sender) {
                                            div.parentNode.prepend(div);
                                            div.classList.add("newNotif")
                                        }
                                    }
                                }
                            } else {
                                chatbotMenu.classList.remove("newNotif")
                                for (let div of divs) {
                                    div.classList.remove('newNotif')
                                }
                            }

                        } else {
                            console.error("Error");
                        }
                    }
                };
                xhttp.open("POST", `{{ route('getNewMessageNotif') }}`, true);
                xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(Params);
            },

        },

    });
</script>
@endsection
@section('scripts')
@include('admin.users.partials.scripts')
@include('admin.partials.scripts')
@endsection