@extends('layouts.mainheader')

@section('content')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<div class="chat__container">
    <div id="chat__content">
        <div id="chat" class="chat">
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
                <form class="chatbot__submit">
                    <input type="text" id="message" name="message" placeholder="Enter message">
                    <input id="data__user" type="hidden" data-user-id="{{Auth::user()->id}}">
                    <button type="submit">click</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    event_init();

    function event_init() {
        const pusher = new Pusher('13540e8ba13a368c04f6', {
            cluster: 'us3'
        });

        const channel = pusher.subscribe('public');

        let userId = document.querySelector("#data__user").getAttribute('data-user-id')
        channel.unbind('chat');
        channel.bind('chat', function(data) {
            $.post("/receive", {
                _token: '{{csrf_token()}}',
                message: data.message,
                receiverid: userId,
            }).done(function(res) {
                $(".messages").append(res); // Append the received message
            });
        });

        $(".chatbot__submit").submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: "/broadcast",
                method: 'POST',
                headers: {
                    'X-Socket-Id': pusher.connection.socket_id
                },
                data: {
                    _token: '{{csrf_token()}}',
                    message: $("form #message").val(),
                    receiverid: 1, // Send messages to the admin (ID 1)
                }
            }).done(function(res) {
                $(".messages").append(res); // Append the sent message
                $("form #message").val('');
            });
        });
    }
</script>

@endsection