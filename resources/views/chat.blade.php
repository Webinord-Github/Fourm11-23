@extends('layouts.mainheader')

@section('content')
<div class="chat__container">
    <div class="chat__users__list__container">
        <div class="chat__users__list">
            @foreach($users as $user)
            <li data-chatid="{{$user->id}}">{{$user->name}}</li>
            @endforeach
        </div>
    </div>
    <div class="chat">
        <div class="top">
            <div id="sender" class="auth__user">
                <img class="user__image" src="{{ asset('files/male-placeholder-300x300.jpg') }}" alt="">
                <div class="user__infos">
                    <p>{{auth()->user()->name}}</p>
                    <small>Online</small>
                    <p>You</p>
                </div>
            </div>
            <div id="receiver" class="auth__user" data-user-id="">
                <img class="user__image" src="{{ asset('files/male-placeholder-300x300.jpg') }}" alt="">
                <div class="user__infos">
                    <p id="receiver__name">{{auth()->user()->name}}</p>
                    <small>Online</small>
                    <p>Receiver</p>
                </div>
            </div>
        </div>
        <div class="messages">
            @foreach($messages as $message)
            @if($message->sender_id == Auth::user()->id)
            @include('broadcast', ['message' => $message->content])
            @elseif($message->receiver_id == Auth::user()->id)
            @include('receive', ['message' => $message->content])
            @endif
            @endforeach

        </div>

        <div class="bottom">
            <form>
                <input type="text" id="message" name="message" placeholder="Enter message">
                <button type="submit"></button>
            </form>
        </div>
    </div>
</div>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
    let userId;
    const pusher = new Pusher('{{config("13540e8ba13a368c04f6")}}', {
        cluster: 'us3'
    });
    const channel = pusher.subscribe('public');


    document.addEventListener('DOMContentLoaded', function() {
        let singleusers = document.querySelectorAll(".chat__users__list li");
        let receiverName = document.querySelector("#receiver__name");
        let userId = document.querySelector("#receiver");

        let storedUserId = localStorage.getItem('selectedUserId');
        if (storedUserId) {
            userId.setAttribute('data-user-id', storedUserId);
        }
        let storedUserName = localStorage.getItem('selectedUserName');
        if (storedUserName) {
            receiverName.innerHTML = storedUserName
        }


        for (let singleuser of singleusers) {
            singleuser.addEventListener("click", e => {
                let selectedUserName = e.target.innerHTML;
                receiverName.innerHTML = selectedUserName;
                localStorage.setItem('selectedUserName', selectedUserName)
                let selectedUserId = e.target.getAttribute('data-chatid');
                userId.setAttribute('data-user-id', selectedUserId);
                localStorage.setItem('selectedUserId', selectedUserId);
            });
        }

        // receive messages
        channel.bind('chat', function(data) {
            $.post("/receive", {
                    _token: '{{csrf_token()}}',
                    message: data.message,
                    receiver_id: userId.getAttribute('data-user-id')
                })
                .done(function(res) {
                    $(".messages > .message").last().after(res);
                    $(document).scrollTop($(document).height);
                });
        });
        $("form").submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: "/broadcast",
                method: 'POST',
                header: {
                    'X-Socket-Id': pusher.connection.socket_id
                },
                data: {
                    _token: '{{csrf_token()}}',
                    message: $("form #message").val(),
                    receiver_id: userId.getAttribute('data-user-id')
                }
            }).done(function(res) {
                $(".messages > .message").last().after(res);
                $("form #message").val('');
                $(document).scrollTop($(document).height());
            });
        });
    });
</script>
@endsection