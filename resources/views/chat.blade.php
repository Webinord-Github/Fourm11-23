@extends('layouts.mainheader')

@section('content')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<div class="chat__container">
    <div class="chat__users__list__container">
        <div class="chat__users__list">
            @foreach($users as $user)
            <a href="{{ route('messages.show', ['userId' => $user->id]) }}" class="ajax-link" data-chatid="{{$user->id}}">{{$user->name}}</a>
            @endforeach
        </div>
    </div>

    <div id="chat__content">
        <p>Débuter une conversation</p>
    </div>
    <div id="single__chat__content"></div>
</div>
<script>
    $(document).ready(function() {

        var noChatContent = $('#chat__content').html(); // Store the initial content
        var initialContent = "" // Store the initial content
        var nextContent = ""; // Variable to store the next content
        var pushedContent = ""; // Variable to store the pushed content

        function loadContent(url) {

            $('#chat__content').hide(); // Hide the page content when loading new content
            pushedContent = $('#single__chat__content').html(); // Save the current content before loading new content
            $('#single__chat__content').empty(); // Clear the current content
            $('#single__chat__content').load(url, function() {
                event_init();
            }); // Load the new content
        }

        $('.ajax-link').click(function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            loadContent(url);
            history.pushState({
                content: initialContent,
                url: url
            }, '', url); // Store the current content before loading new content
        });

        $(window).on('popstate', function(event) {
            if (event.originalEvent.state === null) {
                $('#single__chat__content').empty(); // Clear the content if there is no state
                $('#chat__content').show(); // Show the initial content when there is no state
            } else {
                if (nextContent !== "") {
                    $('#single__chat__content').html(nextContent); // Retrieve and set the next content
                    nextContent = ""; // Clear the next content after using it
                } else if (pushedContent !== "") {
                    $('#single__chat__content').html(pushedContent); // Retrieve and set the pushed content
                    pushedContent = ""; // Clear the pushed content after using it
                } else {
                    $('#chat__content').html(event.originalEvent.state.content); // Retrieve and set the previous content
                    $('#single__chat__content').show(); // Show the retrieved content
                }
            }
        });
    });
</script>

@endsection