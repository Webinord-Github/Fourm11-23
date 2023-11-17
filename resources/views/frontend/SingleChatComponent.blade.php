
    
    <div id="chat" class="chat">
        <div class="top">
            <div id="receiver" class="auth__user" data-user-id="{{$otherUser->id}}">
                <img class="user__image" src="{{ asset('files/male-placeholder-300x300.jpg') }}" alt="">
                <div class="user__infos">
                    <p id="receiver__name">
                        {{$otherUser->name}}
                    </p>
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

    <script>
        function event_init() {
        const pusher = new Pusher('13540e8ba13a368c04f6', {
            cluster: 'us3'
        });
    
    
        const channel = pusher.subscribe('public');
    
        // receive messages
        let userId = document.querySelector("#receiver");
        let receiverId = userId.getAttribute('data-user-id');
        channel.unbind('chat');
        channel.bind('chat', function(data) {
            $.post("/receive", {
                    _token: '{{csrf_token()}}',
                    message: data.message,
                      receiverid: receiverId,
                })
                .done(function(res) {
                    $(".messages").append(res); // Append the sent message
                    // $(document).scrollTop($(document).height);
                  
                });
        });
    
        $("form").submit(function(event) {
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
                    receiverid: receiverId,
            
                }
            }).done(function(res) {
                $(".messages").append(res); // Append the sent message
                $("form #message").val('');
                console.log('true')
            });
        });
    } 
    </script>
