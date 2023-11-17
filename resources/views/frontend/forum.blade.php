@extends('layouts.mainHeader')

@section('content')
<div class="main__container">
    <div class="forum__container">
        @if(count($conversations) == 0)
        <p>Aucune conversations à afficher présentement!</p>
        @endif
        @foreach($conversations as $conversation)
        <div class="forum__content">
            <div class="conv__container">
                <div class="conv__title__container">
                    <p id="conv__title"><i class="fa fa-comments"></i>{{ $conversation->title }}</p>
                    <i class="fa fa-bookmark"></i>
                </div>
                <div class="conv__content">
                    <div class="conv__author__info">
                        <p id="author">{{$conversation->user->name}}</p>
                        <p id="timestamp">{{$conversation->created_at}}</p>
                    </div>
                    <div class="conv__body">
                        @php
                        $body = $conversation->body;
                        $truncatedText = Str::limit($body, 600, '...');
                        @endphp
                        <p>{{$truncatedText}}</p>
                    </div>
                    <div class="tags__container">
                        <a class="tags" href="">Adolescent.es</a>
                        <a class="tags" href="">Sexisme</a>
                        <a class="tags" href="">École secondaire</a>
                    </div>
                    <div class="actions__container">
                        <div class="pivot__actions">
                            <div class="like">
                                <p>0 <i class="fa fa-heart-o" aria-hidden="true"></i></p>
                            </div>
                            <div class="comments">
                                @php
                                $comments = count($conversation->replies);
                                @endphp
                                <p id="comments">{{$comments}}<i class="fa fa-comment-o" aria-hidden="true"></i></p>
                            </div>
                        </div>
                        <div class="instant__actions">
                            <div class="report">
                                <p id="report">signaler <i class="fa fa-exclamation" aria-hidden="true"></i></p>
                            </div>
                            <div class="reply">
                                <button class="reply__toggle">répondre</button>
                            </div>
                        </div>
                    </div>
                    <div class="reply__form">
                        <form>
                            <div class="textarea__container">
                                <input type="hidden" name="conversation__id" id="conversation__id" data-id="{{$conversation->id}}">
                                <textarea id="autoExpand" rows="1" placeholder="Écrire un commentaire..."></textarea>
                            </div>
                            <div class="submit__container">
                                <i class="fa fa-paper-plane reply__submit"></i>
                            </div>
                        </form>
                    </div>
                    <!-- USER REPLIES  -->
                    @foreach($conversation->replies as $reply)
                    <div class="single__reply__container" data-reply-id="{{$reply->id}}">
                        <div class="user__icon">
                            <img src="{{asset('storage/medias/male-placeholder-300x300.jpg')}}" alt="">
                            <div class="divider"></div>
                        </div>
                        <div class="single__reply__content">
                            <div class="user__reply__info">
                                <p id="user__reply__name">{{$reply->user->name}}</p>
                                <p id="timestamp">{{$reply->created_at}}</p>
                            </div>
                            <div class="user__reply__body">
                                <p>{{$reply->body}}</p>
                            </div>
                            <div class="actions__container">
                                <div class="pivot__actions">
                                    <div class="like">
                                        <p>0 <i class="fa fa-heart-o" aria-hidden="true"></i></p>
                                    </div>
                                    <div class="comments">
                                        <p>0 <i class="fa fa-comment-o" aria-hidden="true"></i></p>
                                    </div>
                                </div>
                                <div class="instant__actions">
                                    @if(auth()->user()->id == $reply->user_id)
                                    <div class="delete">
                                        <p class="delete__reply" id="delete">supprimer <i class="fa fa-trash delete__reply"></i></p>
                                    </div>
                                    @endif
                                    <div class="report">
                                        <p id="report">signaler <i class="fa fa-exclamation" aria-hidden="true"></i></p>
                                    </div>
                                    <div class="reply">
                                        <button class="reply__toggle">répondre</button>
                                    </div>
                                </div>
                            </div>
                            <div class="reply__form">
                                <form>
                                    <div class="textarea__container">
                                        <input type="hidden" name="conversation__id" id="conversation__id" data-id="{{$conversation->id}}">
                                        <textarea id="autoExpand" rows="1" placeholder="Écrire un commentaire..."></textarea>
                                    </div>
                                    <div class="submit__container">
                                        <i class="fa fa-paper-plane reply__submit"></i>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
        <p>{!! $page->content !!}</p>
    </div>
</div>
<script>
    // Function to auto expand textarea height


    document.addEventListener('input', function(event) {
        if (event.target && event.target.id === 'autoExpand') {
            const textarea = event.target;
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        }
    });
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('reply__toggle')) {
            let nextEl = event.target.closest(".actions__container").nextElementSibling
            nextEl.classList.toggle('open')
        }
    });

    document.addEventListener("click", event => {
        if (event.target.classList.contains("reply__submit")) {
            let xhttp = new XMLHttpRequest()
            let form = event.target.closest("form");
            let conversationId = form.querySelector("#conversation__id").getAttribute('data-id');
            let body = form.querySelector("#autoExpand").value

            let Params = 'conversation_id=' + encodeURIComponent(conversationId) + '&body=' + encodeURIComponent(body)
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4) {
                    if (this.status === 200) {
                        let commentsElement = event.target.closest(".conv__content").querySelector("#comments")
                        let currentNumber = parseInt(commentsElement.innerHTML);
                        let newNumber = currentNumber + 1;
                        commentsElement.innerHTML = newNumber + '<i class="fa fa-comment-o" aria-hidden="true"></i>';
                        let responseData = JSON.parse(this.responseText)
                        let newReplyContainer = document.createElement('div')
                        newReplyContainer.classList.add('single__reply__container')
                        newReplyContainer.setAttribute('data-reply-id', responseData.id)
                        newReplyContainer.innerHTML = `
                        <div class='user__icon'>
                            <img src='{{asset("storage/medias/male-placeholder-300x300.jpg")}}' alt=''>
                            <div class='divider'></div>
                        </div>
                        <div class="single__reply__content">
                            <div class="user__reply__info">
                                <p id="user__reply__name">${responseData.name}</p>
                                <p id="timestamp">${responseData.created_at}</p>
                            </div>
                            <div class="user__reply__body">
                                <p>${responseData.body}</p>
                            </div>
                            <div class="actions__container">
                                <div class="pivot__actions">
                                    <div class="like">
                                        <p>0 <i class="fa fa-heart-o" aria-hidden="true"></i></p>
                                    </div>
                                    <div class="comments">
                                        <p>0 <i class="fa fa-comment-o" aria-hidden="true"></i></p>
                                    </div>
                                </div>
                                <div class="instant__actions">
                      
                                    <div class="delete">
                                        <p class="delete__reply" id="delete">supprimer <i class="fa fa-trash delete__reply"></i></p>
                                    </div>
                                
                                    <div class="report">
                                        <p id="report">signaler <i class="fa fa-exclamation" aria-hidden="true"></i></p>
                                    </div>
                                    <div class="reply">
                                        <button class="reply__toggle">répondre</button>
                                    </div>
                                </div>
                            </div>
                            <div class="reply__form">
                                <form>
                                    <div class="textarea__container">
                                        <input type="hidden" name="conversation__id" id="conversation__id" data-id="{{$conversation->id}}">
                                        <textarea id="autoExpand" rows="1" placeholder="Écrire un commentaire..."></textarea>
                                    </div>
                                    <div class="submit__container">
                                        <i class="fa fa-paper-plane reply__submit"></i>
                                    </div>
                                </form>
                            </div>
                        </div>
               
                            `
                        event.target.closest('.conv__content').appendChild(newReplyContainer);
                        newReplyContainer.scrollIntoView({
                            behavior: 'smooth',
                            block: 'end'
                        });

                        xhttp = null;
                    } else {
                        console.error("reply not sent.");
                    }
                }
            };
            xhttp.open("POST", "{{route('replies.store')}}", true);
            xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(Params);

        }
    })

    document.addEventListener("click", e => {
        if (e.target.classList.contains("delete__reply")) {
            let xhttp = new XMLHttpRequest()
            let commentsElement = e.target.closest(".conv__content").querySelector("#comments")
            let currentNumber = parseInt(commentsElement.innerHTML);
            console.log(e.target.closest('.single__reply__container'))
            let newNumber = currentNumber - 1;
            commentsElement.innerHTML = newNumber + '<i class="fa fa-comment-o" aria-hidden="true"></i>';
            let replyId = e.target.closest(".single__reply__container").getAttribute('data-reply-id')
            let Params = 'reply_id=' + encodeURIComponent(replyId)
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4) {
                    if (this.status === 200) {
                        e.target.closest('.single__reply__container').remove()
                        xhttp = null;
                    } else {
                        console.error("reply not delete.");
                    }
                }
            };
            xhttp.open("POST", `{{ route('replies.destroy', ['reply' => ':replyId']) }}`.replace(':replyId', replyId), true);
            xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(Params);


        }
    })



    // Event listener for input changes

    // Initial call to set the initial height
</script>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>