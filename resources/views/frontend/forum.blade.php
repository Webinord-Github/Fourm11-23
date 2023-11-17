@extends('layouts.app')

@section('content')

<div class="container">
    <div class="forum__container">
        @if(count($conversations) == 0) 
            <p>Aucune conversations à afficher présentement!</p>
        @endif
        @foreach($conversations as $conversation)
        <div class="forum__content">
            <div class="conv__container">
                <div class="conv__content">
                    <p id="author"><strong>Auteur: </strong>{{ $conversation->user->name }}</p>
                    <p id="conv__title"><strong>Sujet de la conversation:</strong> {{ $conversation->title }}</p>
                    <p id="conv__body">{{ $conversation->body }}</p>

                </div>
                <div class="reply__container">
                    <button id="conv__reply">Répondre</button>
                    <form class="forum__reply__form">
                        <input type="hidden" name="conversation_id" id="conversation_id" value="{{$conversation->id}}">
                        <textarea class="comments" name="body" id="body" cols="30" rows="5" placeholder="Envoyer un commentaire..."></textarea>
                        <div class="submit__container">
                            <input id="reply__submit" type="submit" value="Envoyer">
                        </div>
                    </form>
                </div>
                <div class="reply__container">
                    <strong style="font-size:25px;text-decoration:underline;">Commentaires</strong>
                    <!-- DISPLAY REPLIES HERE -->
                    @foreach($conversation->replies as $reply)
                    <p>{{$reply->body}}</p>
                    <form action="{{ route('replies.destroy', ['reply' => $reply->id]) }}" id="reply__delete__form" method="POST">
                        @csrf
                        {{method_field('DELETE')}}
                        <input id="reply__delete" type="submit" value="Delete" data-del="{{ $reply->id }}">
                        <p>{{ $reply->id }}</p>

                    </form>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
        <p>{!! $page->content !!}</p>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#reply__submit').click(function(e) {
            e.preventDefault(); // Prevent the default form submission
            // Get the input values
            var body = $('#body').val();
            var conversationId = $('#conversation_id').val();

            // Send an AJAX POST request
            $.ajax({
                type: 'POST',
                url: "{{ route('replies.store') }}", // Replace with the actual route
                data: {
                    body: body,
                    conversation_id: conversationId,
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    // Handle a successful response
                    console.log(response.message);
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(error);
                }
            });
        });
    });
</script>