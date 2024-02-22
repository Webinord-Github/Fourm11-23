@if(auth()->check() && !auth()->user()->verified)
    <div class="warning__container">
        <p>Votre compte est actuellement en attente d'approbation.</p>
        <p>Dès que votre compte sera approuvé, un courriel vous sera envoyé et vous aurez ainsi accès aux différentes informations présentes sur le site.</p>
        <p>Merci de votre patience.</p>
    </div>
@endif
<div class="main__forum__container">
    <div class="thematiques__container">
        <h2>Thématiques des discussions</h2>
        <div class="thematiques__list">
            <div class="thematique__li__container">
                <li class="all__thematique">Toutes les conversations</li>
                <span class="conversation-count all__thematique__count">({{$conversations->where('published', true)->count()}})</span>
            </div>
            @foreach($thematiques as $thematique)
            @php
            $conversationCount = $thematique->conversations()->where('published', 1)->count();
            @endphp

            @if($conversations->count() == $conversations->where('published', false)->count() || $conversations->count() < 1) <div class="thematique__li__container">
                <li>{{$thematique->name}}</li>
                <span class="conversation-count">({{$conversationCount}})</span>
        </div>
        <style>
            .all__thematique,
            .all__thematique__count {
                display: none;
            }
        </style>
        @else
        <div class="thematique__li__container">
            <li class="thematique" data-thematique-id="{{$thematique->id}}">{{$thematique->name}}</li>
            <span class="conversation-count">({{$conversationCount}})</span>
        </div>
        @endif
        @endforeach

        <div class="submit__conversation__container">
            <button class="new__conversation__trigger">Soumettre une nouvelle conversation</button>
        </div>
    </div>
</div>
<div class="chalk__container">
    <!-- S'il y a des bookmarks  -->
    @if($conversationBookmarks)
        @foreach($conversationBookmarks as $bookmark)
            @php
                $conversationsTarget = $conversations->where('id', $bookmark->conversation_id)
            @endphp
            @foreach($conversationsTarget as $convTarget)
                @foreach($convTarget->replies as $reply)
                    @if($reply->created_at > Auth::user()->notifs_check && $reply->user_id != Auth::user()->id)
                        <p>{{$reply->body}}</p>
                    @endif
                @endforeach
            @endforeach
        @endforeach  
    @endif

    <div class="conversations__main__container">
        @if (session('status'))
        <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-8 my-6" role="alert">
            <p class="font-bold">{{ session('status') }}</p>
        </div>
        @endif
        @if($conversations->count() == $conversations->where('published', false)->count() || $conversations->count() < 1) <div class="no__conversations__container">
            <p>Aucune conversation à afficher pour l'instant!</p>
    </div>
    @endif

    @if($conversations->count() > 0) @foreach($conversations as $conversation) @if($conversation->published == true)
    <div class="forum__container" id="c{{$conversation->id}}">
        <div class="forum__content">
            <div class="conv__container" data-post-id="{{$conversation->id}}">
                <div class="conv__title__container">
                    <p id="conv__title"><i class="fa fa-comments"></i>{{ $conversation->title }}</p>
                        @if(App\Models\ConversationBookmarks::where('conversation_id', $conversation->id)->where('user_id', auth()->user()->id)->first())
                        <i class="fa fa-bookmark conversation__bookmark bookmarked"></i>
                        @else 
                    <i class="fa fa-bookmark conversation__bookmark"></i>
                    @endif
                </div>
                <div class="conv__content">
                    <div class="conv__author__info">
                        <p id="author">{{$conversation->user->firstname}}</p>
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
                        @foreach($conversation->thematiques()->get() as $thematique)
                        <a class="tags" href="" data-thematique-id="{{ $thematique->id }}">{{ $thematique->name }}</a>
                        @endforeach
                    </div>
                    <div class="actions__container">
                        <div class="pivot__actions">
                            <div class="like">
                                @if($conversation->likes->contains('user_id', auth()->user()->id))
                                <div class="likes__iteration hasliked"><span id="conversation__likes__count">{{$conversation->likes->count()}}</span><i id="conversation__like" class="fa fa-heart" aria-hidden="true"></i>
                                    <div class="likeHover">Je n'aime plus</div>
                                </div>


                                @else
                                <div class="likes__iteration hasnotliked"><span id="conversation__likes__count">{{$conversation->likes->count()}}</span><i id="conversation__like" class="fa fa-heart-o" aria-hidden="true"></i>
                                    <div class="likeHover">J'aime</div>
                                </div>

                                @endif
                            </div>
                            <div class="comments">
                                @php
                                $comments = count($conversation->replies);
                                @endphp
                                <div id="conversation__comments">{{$comments}}<i class="fa fa-comment-o" aria-hidden="true"></i></div>
                            </div>
                        </div>
                        <div class="instant__actions">
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
                                <i class="fa fa-paper-plane reply__submit disabled"></i>
                            </div>
                        </form>
                    </div>
                    <!-- USER REPLIES  -->
                    @if(count($conversation->replies) > 0)
                    <div class="parent__more__comments__container">
                        <p class="parent__see__more__trigger">Montrer les réponses
                        </p>
                        <i class="fa fa-angle-down parent-angle-down"></i>
                    </div>
                    @endif
                    @foreach($conversation->replies as $reply)
                    @if($reply->parent_id == null)
                    <div class="single__reply__container parent__container" style="display:none" data-reply-id="{{$reply->id}}">
                        <div class="reply__container">
                            <div class="user__icon">
                                <img src="{{asset($reply->user->image)}}" alt="">
                                <div class="divider"></div>
                            </div>
                            <div class="single__reply__content">
                                <div class="user__reply__info">
                                    <p id="user__reply__name" data-user-id="{{$reply->user->id}}">{{$reply->user->firstname}}</p>
                                    <p id="timestamp">{{$reply->created_at}}</p>
                                </div>
                                <div class="user__reply__body">
                                    <p>{!! $reply->body !!}</p>
                                </div>
                                <div class="actions__container">
                                    <div class="pivot__actions">
                                        <div class="like">
                                            @if($reply->likes->contains('user_id', auth()->user()->id))
                                            <div class="likes__iteration hasliked"><span id="conversation__likes__count">{{$reply->likes->count()}}</span><i id="reply__like" class="fa fa-heart" aria-hidden="true"></i>
                                                <div class="likeHover">Je n'aime plus</div>
                                            </div>

                                            @else
                                            <div class="likes__iteration hasnotliked"><span id="conversation__likes__count">{{$reply->likes->count()}}</span><i id="reply__like" class="fa fa-heart-o" aria-hidden="true"></i>
                                                <div class="likeHover">J'aime</div>
                                            </div>

                                            @endif
                                        </div>
                                        <div class="comments">
                                            @php
                                            $comments = count($reply->children);
                                            @endphp
                                            <div id="reply__comments">{{$comments}}<i class="fa fa-comment-o" aria-hidden="true"></i></div>
                                        </div>
                                    </div>
                                    <div class="instant__actions">
                                        @if(auth()->user()->id == $reply->user_id)
                                        <div class="delete">
                                            <p class="delete__reply parent__delete" id="delete">supprimer <i class="fa fa-trash delete__reply"></i></p>
                                        </div>
                                        @endif

                                        <div class="report">
                                            <p class="report__trigger">signaler <i class="fa fa-exclamation report__trigger" aria-hidden="true"></i></p>
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
                                            <input type="hidden" name="parent__id" id="parent__id" data-parent-id="{{$reply->id}}">
                                            <textarea id="autoExpand" rows="1" placeholder="Écrire un commentaire..."></textarea>
                                        </div>
                                        <div class="submit__container">
                                            <i class="fa fa-paper-plane user__reply__submit disabled"></i>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @if(count($conversation->replies->where('parent_id', $reply->id)) > 0)
                        <div class="child__more__comments__container">
                            <p class="child__see__more__trigger">Montrer les réponses</p>
                            <i class="fa fa-angle-down child-angle-down"></i>
                        </div>
                        @endif
                        @foreach($conversation->replies as $nestedReply)
                        @if($nestedReply->parent_id == $reply->id)
                        <div id="child__reply" style="display:none" class="single__reply__container child__reply__container" data-reply-id="{{$nestedReply->id}}" data-parent-id="{{$nestedReply->parent_id}}">
                            <div class="reply__container">
                                <div class="user__icon">
                                    <img src="{{asset($reply->user->image)}}" alt="">
                                    <div class="divider"></div>
                                </div>
                                <div class="single__reply__content">
                                    <div class="user__reply__info">
                                        <p id="user__reply__name" data-user-id="{{$reply->user->id}}">{{$reply->user->firstname}}</p>
                                        <p id="timestamp">{{$reply->created_at}}</p>
                                    </div>
                                    <div class="user__reply__body">
                                        <p>{!! $nestedReply->body !!}</p>
                                    </div>
                                    <div class="actions__container">
                                        <div class="pivot__actions">
                                            <div class="like">
                                                @if($nestedReply->likes->contains('user_id', auth()->user()->id))
                                                <div class="likes__iteration hasliked"><span id="conversation__likes__count">{{$nestedReply->likes->count()}}</span><i id="reply__like" class="fa fa-heart" aria-hidden="true"></i>
                                                    <div class="likeHover">Je n'aime plus</div>
                                                </div>


                                                @else
                                                <div class="likes__iteration hasnotliked"><span id="conversation__likes__count">{{$nestedReply->likes->count()}}</span><i id="reply__like" class="fa fa-heart-o" aria-hidden="true"></i>
                                                    <div class="likeHover">J'aime</div>
                                                </div>

                                                @endif
                                            </div>
                                        </div>
                                        <div class="instant__actions">
                                            @if(auth()->user()->id == $nestedReply->user_id)
                                            <div class="delete">
                                                <p class="delete__reply child__delete" id="delete">supprimer <i class="fa fa-trash delete__reply"></i></p>
                                            </div>
                                            @endif
                                            <div class="report">
                                                <p class="report__trigger">signaler <i class="fa fa-exclamation report__trigger" aria-hidden="true"></i></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="report__popup__container">
            <div class="report__popup">
                <h3>SIGNALEMENT</h3>
                <div class="report__infos__container">
                    <p style="opacity:0;height:0;display:none;" id="author__id"></p>
                    <p id="report__author"></p>
                    <p id="report__reply"></p>
                </div>
                <form id="report__form">
                    <div class="checkbox__container">
                        <input type="checkbox" name="signalement1" id="signalement">
                        <label for="signalement1">SIGNALEMENT 1</label>
                    </div>
                    <div class="checkbox__container">
                        <input type="checkbox" name="signalement2" id="signalement">
                        <label for="signalement2">SIGNALEMENT 2</label>
                    </div>
                    <div class="checkbox__container">
                        <input type="checkbox" name="signalement3" id="">
                        <label for="signalement3">SIGNALEMENT 3</label>
                    </div>
                    <div class="checkbox__container">
                        <input type="checkbox" name="signalement4" id="">
                        <label for="signalement4">SIGNALEMENT 4</label>
                    </div>
                    <div class="checkbox__container">
                        <input type="checkbox" name="signalement5" id="">
                        <label for="signalement 5">SIGNALEMENT 5</label>
                    </div>
                    <div class="checkbox__container">
                        <input type="checkbox" name="signalement6" id="">
                        <label for="signalement 6">SIGNALEMENT 6</label>
                    </div>
                    <div class="report__textarea__container">
                        <label for="">Autres</label>
                        <textarea name="" id="" cols="30" rows="3"></textarea>
                    </div>
                    <div class="submit__form__container">
                        <input id="report__submit" type="submit">
                    </div>
                </form>
                <div class="close__container">
                    <i class="fa fa-close report__form__close"></i>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
    <script>
        // Function to auto expand textarea height
        document.addEventListener('input', function(event) {
            if (event.target && event.target.id === 'autoExpand') {
                const textarea = event.target;
                textarea.style.height = 'auto';
                textarea.style.height = textarea.scrollHeight + 'px';
                if (event.target.value != "") {
                    event.target.closest('form').querySelector(".fa-paper-plane").classList.remove('disabled')
                    event.target.closest('form').querySelector(".fa-paper-plane").classList.add('enabled')

                } else {
                    event.target.closest('form').querySelector(".fa-paper-plane").classList.remove('enabled')
                    event.target.closest('form').querySelector(".fa-paper-plane").classList.add('disabled')
                }
            }
        });
        // DROPDOWN FORM REPLY
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('reply__toggle')) {
                let nextEl = event.target.closest(".actions__container").nextElementSibling
                nextEl.classList.toggle('open')
            }
        });

        // REPLY TO THE MAIN CONVERSAIION
        document.addEventListener("click", event => {
            if (event.target.classList.contains("reply__submit")) {
                let xhttp = new XMLHttpRequest()
                let form = event.target.closest("form");
                let convTitle = event.target.closest(".conv__container").querySelector("#conv__title").innerText
                let conversationId = form.querySelector("#conversation__id").getAttribute('data-id');
                let body = form.querySelector("#autoExpand").value
                let Params = 'conversation_id=' + encodeURIComponent(conversationId) + '&body=' + encodeURIComponent(body) + '&title=' + encodeURIComponent(convTitle)
                if (!body == "") {
                    xhttp.onreadystatechange = function() {
                        if (this.readyState === 4) {
                            if (this.status === 200) {
                                form.querySelector("#autoExpand").value = ""
                                let commentsElement = event.target.closest(".conv__content").querySelector("#conversation__comments")
                                let currentNumber = parseInt(commentsElement.innerHTML);
                                let newNumber = currentNumber + 1;
                                commentsElement.innerHTML = newNumber + '<i class="fa fa-comment-o" aria-hidden="true"></i>';
                                let responseData = JSON.parse(this.responseText)
                                let newReplyContainer = document.createElement('div')
                                newReplyContainer.classList.add('single__reply__container')
                                newReplyContainer.classList.add('parent__container')
                                newReplyContainer.setAttribute('data-reply-id', responseData.id)
                                newReplyContainer.style.display = "block!important"
                                let AuthUserImg = responseData.image
                                newReplyContainer.innerHTML = `
                        <div class="reply__container">
                            <div class='user__icon'>
                                <img src="${AuthUserImg}" alt="">
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
                                            <div class="likes__iteration hasnotliked"><span id="conversation__likes__count">0</span><i id="reply__like" class="fa fa-heart-o" aria-hidden="true"></i>
                                                <div class="likeHover">J'aime</div>
                                            </div>
                                        </div>
                                        <div class="comments">
                                            <div id="reply__comments">0<i class="fa fa-comment-o" aria-hidden="true"></i></div>
                                        </div>
                                    </div>
                                    <div class="instant__actions">
                        
                                        <div class="delete">
                                            <p class="delete__reply parent__delete" id="delete">supprimer <i class="fa fa-trash delete__reply"></i></p>
                                        </div>
                                    
                                        <div class="report">
                                            <p class="report__trigger">signaler <i class="fa fa-exclamation report__trigger" aria-hidden="true"></i></p>
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
                                    
                                            <input type="hidden" name="parent__id" id="parent__id" data-parent-id="${responseData.id}">
                                            
                                            <textarea id="autoExpand" rows="1" placeholder="Écrire un commentaire..."></textarea>
                                        </div>
                                        <div class="submit__container">
                                        <i class="fa fa-paper-plane user__reply__submit disabled"></i>
                                        </div>
                                    </form>
                                </div>
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
                } else {
                    return false;
                }
            }
        })

        // REPLY TO A USER COMMENT
        document.addEventListener("click", e => {
            if (e.target.classList.contains("user__reply__submit")) {
                let form = e.target.closest("form");

                let xhttp = new XMLHttpRequest()
                let convTitle = event.target.closest(".conv__container").querySelector("#conv__title").innerText
                let conversationId = form.querySelector("#conversation__id").getAttribute('data-id');
                let parentId = form.querySelector("#parent__id").getAttribute('data-parent-id')
                let body = form.querySelector("#autoExpand").value

                let Params = 'conversation_id=' + encodeURIComponent(conversationId) + '&body=' + encodeURIComponent(body) + '&parent_id=' + encodeURIComponent(parentId) + '&title=' + encodeURIComponent(convTitle)
                if (!body == "") {


                    xhttp.onreadystatechange = function() {
                        if (this.readyState === 4) {
                            if (this.status === 200) {
                                form.querySelector("#autoExpand").value
                                let commentsElement = e.target.closest(".conv__content").querySelector("#conversation__comments")
                                let replyCommentsElement = e.target.closest(".single__reply__container").querySelector("#reply__comments")
                                let ConversationCurrentNumber = parseInt(commentsElement.innerHTML);
                                let ReplyCurrentNumber = parseInt(replyCommentsElement.innerHTML);
                                let ConversationNewNumber = ConversationCurrentNumber + 1;
                                let replyNewNumber = ReplyCurrentNumber + 1;
                                commentsElement.innerHTML = ConversationNewNumber + '<i class="fa fa-comment-o" aria-hidden="true"></i>';
                                replyCommentsElement.innerHTML = replyNewNumber + '<i class="fa fa-comment-o" aria-hidden="true"></i>';
                                let responseData = JSON.parse(this.responseText)
                                let newReplyContainer = document.createElement('div')
                                newReplyContainer.classList.add('single__reply__container')
                                newReplyContainer.id = "child__reply"
                                newReplyContainer.setAttribute('data-reply-id', responseData.id)
                                newReplyContainer.setAttribute('data-parent-id', responseData.reply_id)
                                newReplyContainer.style.display = "block!important"
                                let AuthUserImg = responseData.image
                                newReplyContainer.innerHTML = `
                        <div class="reply__container">
                            <div class='user__icon'>
                                <img src='${AuthUserImg}' alt=''>
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
                                        <div class="likes__iteration hasnotliked"><span id="conversation__likes__count">0</span><i id="reply__like" class="fa fa-heart-o" aria-hidden="true"></i>
                                                <div class="likeHover">J'aime</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="instant__actions">
                                        <div class="delete">
                                            <p class="delete__reply child__delete" id="delete">supprimer <i class="fa fa-trash delete__reply"></i></p>
                                        </div>
                                    
                                        <div class="report">
                                            <p class="report__trigger">signaler <i class="fa fa-exclamation report__trigger" aria-hidden="true"></i></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            `
                                e.target.closest('.single__reply__container').appendChild(newReplyContainer);
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

                    xhttp.open("POST", "{{route('user-reply')}}", true);
                    xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.send(Params);
                } else {
                    return false;
                }
            }
        })

        // CONVERSATION LIKE
        document.addEventListener("click", e => {
            if (e.target.id == "conversation__like") {
                let xhttp = new XMLHttpRequest();
                let conversationId = e.target.closest('.conv__container').getAttribute('data-post-id')
                let Params = 'conversation_id=' + encodeURIComponent(conversationId);

                xhttp.onreadystatechange = function() {
                    if (this.readyState === 4) {
                        if (this.status === 200) {
                            let likesCount = e.target.closest(".likes__iteration").childNodes[0]

                            if (e.target.classList.contains('fa-heart-o')) {
                                e.target.classList.replace('fa-heart-o', 'fa-heart')
                                likesCount.innerHTML++
                                e.target.closest(".likes__iteration").childNodes[3].innerHTML = "Je n'aime plus"

                            } else {
                                e.target.classList.replace('fa-heart', 'fa-heart-o')
                                likesCount.innerHTML--
                                e.target.closest(".likes__iteration").childNodes[3].innerHTML = "J'aime"

                            }
                            // replyContainer.remove();
                            xhttp = null;
                        } else {
                            console.error("Unable to like conversation.");
                        }
                    }
                };
                // Deleting the parent comment and its associated replies
                xhttp.open("POST", `{{ route('conversation-like')}}`)
                xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(Params);
            }
        });
        // REPLY LIKE
        document.addEventListener("click", e => {
            if (e.target.id == "reply__like") {
                let xhttp = new XMLHttpRequest();
                let replyId = e.target.closest('.single__reply__container').getAttribute('data-reply-id')
                let Params = 'reply_id=' + encodeURIComponent(replyId);
                xhttp.onreadystatechange = function() {
                    if (this.readyState === 4) {
                        if (this.status === 200) {
                            let likesCount = e.target.closest(".likes__iteration").childNodes[0]


                            if (e.target.classList.contains('fa-heart-o')) {
                                e.target.classList.replace('fa-heart-o', 'fa-heart')
                                likesCount.innerHTML++
                                e.target.closest(".likes__iteration").childNodes[3].innerHTML = "Je n'aime plus"

                            } else {
                                e.target.classList.replace('fa-heart', 'fa-heart-o')
                                likesCount.innerHTML--
                                e.target.closest(".likes__iteration").childNodes[3].innerHTML = "J'aime"

                            }
                            // replyContainer.remove();
                            xhttp = null;
                        } else {
                            console.error("Unable to like conversation.");
                        }
                    }
                };
                xhttp.open("POST", `{{ route('reply-like')}}`)
                xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(Params);
            }
        });
        // DELETE A REPLY
        document.addEventListener("click", e => {
            if (e.target.classList.contains("delete__reply")) {
                let xhttp = new XMLHttpRequest();
                // the parent container 
                let parentContainer = e.target.closest('.single__reply__container')
                // id of the reply
                let replyId = parentContainer.getAttribute("data-reply-id")
                // reply comments element
                let replyComments = e.target.closest('.parent__container').querySelector("#reply__comments")
                //  conversation's comment element
                let conversationComments = e.target.closest(".conv__container").querySelector("#conversation__comments")
                // number of user reply comments
                let replyCommentsInt = parseInt(e.target.closest('.parent__container').querySelector("#reply__comments").innerHTML)
                // number of conversation comments 
                let conversationCommentsInt = parseInt(e.target.closest('.conv__container').querySelector("#conversation__comments").innerHTML)
                // params sent in the xhr request
                let Params = 'reply_id=' + encodeURIComponent(replyId)
                xhttp.onreadystatechange = function() {
                    if (this.readyState === 4) {
                        if (this.status === 200) {
                            if (e.target.classList.contains("child__delete")) {
                                replyComments.innerHTML = replyCommentsInt - 1 + ` <i class="fa fa-comment-o"></i>`
                                conversationComments.innerHTML = conversationCommentsInt - 1 + ` <i class="fa fa-comment-o"></i>`
                            }
                            if (e.target.classList.contains("parent__delete")) {
                                let childElements = e.target.closest(".parent__container").querySelectorAll("#child__reply").length
                                conversationComments.innerHTML = conversationCommentsInt - (childElements + 1) + ` <i class="fa fa-comment-o"></i>`
                            }
                            parentContainer.classList.add('remove')
                            setTimeout(() => {
                                parentContainer.remove()
                            }, 210);
                            xhttp = null;
                        } else {
                            console.error("Reply not deleted.");
                        }
                    }
                };
                // Deleting the parent comment and its associated replies
                xhttp.open("POST", `{{ route('replies.destroy', ['reply' => ':replyId']) }}`.replace(':replyId', replyId), true);
                xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(Params);
            }
        });

        // report pop-up
        document.addEventListener("click", e => {
            if (e.target.classList.contains('report__trigger')) {
                document.querySelector(".report__popup__container").classList.add("flex")
                let replyAuthor = e.target.closest('.single__reply__content').querySelector(".user__reply__info #user__reply__name").innerText
                let replyComment = e.target.closest('.single__reply__content').querySelector(".user__reply__body").innerText
                let authorId = e.target.closest('.single__reply__content').querySelector(".user__reply__info #user__reply__name").getAttribute('data-user-id');
                let reportAuthorId = document.querySelector("#author__id")
                let reportAuthor = document.querySelector("#report__author")
                let reportReply = document.querySelector("#report__reply")
                reportAuthor.innerHTML = "<strong>Nom de l'utilisateur</strong>: " + replyAuthor
                reportReply.innerHTML = "<strong>Commentaire</strong>: " + '"' + replyComment + '"'
                reportAuthorId.setAttribute('user-data-id', authorId)
            }
            if (e.target.classList.contains('report__form__close')) {
                e.target.closest('.report__popup__container').classList.remove("flex")
            }
        })

        // report pop-up submit
        document.addEventListener("click", e => {
            if (e.target.id === "report__submit") {
                e.preventDefault();
                let xhttp = new XMLHttpRequest();
                let checkedCheckboxes = [];
                let authorId = document.querySelector("#author__id").getAttribute('user-data-id')
                document.querySelectorAll('.checkbox__container input[type="checkbox"]:checked').forEach(checkbox => {
                    checkedCheckboxes.push(checkbox.nextElementSibling.textContent.trim());
                });
                let textareaValue = document.querySelector('.report__textarea__container textarea').value.trim();

                let Params = `checkboxes=${JSON.stringify(checkedCheckboxes)}&textareaValue=${textareaValue}&authorid=${authorId}`;
                xhttp.onreadystatechange = function() {
                    if (this.readyState === 4) {
                        if (this.status === 200) {
                            console.log("Signalement envoyé")
                            document.querySelectorAll('.checkbox__container input[type="checkbox"]:checked').forEach(checkbox => {
                                checkbox.checked = false;
                            });
                            document.querySelector('.report__textarea__container textarea').value = '';
                            xhttp = null;

                        } else {
                            console.error('Signalement non envoyé')
                        }
                    }
                };
                // Deleting the parent comment and its associated replies
                xhttp.open("POST", `{{ route('reply-report')}}`, true);
                xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(Params);
            }
        })

        // see conversation replies trigger 
        document.addEventListener("click", e => {
            if (e.target.classList.contains("parent__see__more__trigger") || e.target.classList.contains("parent-angle-down")) {
                let angledown = e.target.closest('.parent__more__comments__container').querySelector(".parent-angle-down")
                let parent = e.target.closest(".conv__content")
                let replies = parent.querySelectorAll(".parent__container")
                e.target.closest(".parent__more__comments__container").classList.toggle("viewmore")
                if (e.target.closest(".parent__more__comments__container").classList.contains("viewmore")) {
                    e.target.closest(".parent__more__comments__container").querySelector(".parent__see__more__trigger").innerHTML = "Masquer les réponses"
                    for (let reply of replies) {
                        reply.style.display = "block"
                    }
                    angledown.style.transform = "Rotate(180deg)"
                } else {
                    e.target.closest(".parent__more__comments__container").querySelector(".parent__see__more__trigger").innerHTML = "Montrer les réponses"
                    for (let reply of replies) {
                        reply.style.display = "none"
                    }
                    angledown.style.transform = "Rotate(0deg)"
                }
            }
        })
        // see user replies trigger 
        document.addEventListener("click", e => {
            if (e.target.classList.contains("child__see__more__trigger") || e.target.classList.contains("child-angle-down")) {
                let angledown = e.target.closest('.child__more__comments__container').querySelector(".child-angle-down")
                let parent = e.target.closest(".parent__container")
                let replies = parent.querySelectorAll(".child__reply__container")
                e.target.closest(".child__more__comments__container").classList.toggle("viewmore")
                if (e.target.closest(".child__more__comments__container").classList.contains("viewmore")) {
                    e.target.closest(".child__more__comments__container").querySelector(".child__see__more__trigger").innerHTML = "Masquer les réponses"
                    for (let reply of replies) {
                        reply.style.display = "block"
                    }
                    angledown.style.transform = "Rotate(180deg)"
                } else {
                    e.target.closest(".child__more__comments__container").querySelector(".child__see__more__trigger").innerHTML = "Montrer les réponses"
                    for (let reply of replies) {
                        reply.style.display = "none"
                    }
                    angledown.style.transform = "Rotate(0deg)"
                }
            }
        })


        let thematiques = document.querySelectorAll(".thematique");
        let forumContainer = document.querySelectorAll(".forum__container");

        for (let thematique of thematiques) {
            thematique.addEventListener("click", t => {
                const thematiqueId = t.target.getAttribute('data-thematique-id');
                filterConversations(thematiqueId);
            });
        }

        function filterConversations(thematiqueId) {
            // Get all conversation containers
            for (let conv of forumContainer) {
                // Extract thematique ids from conversation tags
                const conversationTags = Array.from(conv.querySelectorAll('.tags')).map(tag => tag.getAttribute('data-thematique-id'));

                // Check if thematiqueId is part of any conversationTags array
                if (!conversationTags.some(tagId => tagId === thematiqueId)) {
                    conv.style.display = "none"
                    const associatedTags = conv.querySelectorAll(".tags");
                    for (let tag of associatedTags) {
                        tag.style.background = "#1d3e77"
                    }

                } else {
                    conv.style.display = "block"
                    const associatedTags = conv.querySelectorAll('.tags[data-thematique-id="' + thematiqueId + '"]');
                    const nonAssociatedTags = conv.querySelectorAll('.tags');
                    for (let nonAssociatedTag of nonAssociatedTags) {
                        nonAssociatedTag.style.background = "#1d3e77"
                    }
                    for (let tag of associatedTags) {
                        tag.style.background = "#edb200"
                    }
                }
            }
        }
        let allThematique = document.querySelector(".all__thematique")
        allThematique.addEventListener("click", e => {
            for (let conv of forumContainer) {
                conv.style.display = "block"
                let tags = conv.querySelectorAll(".tags")
                for (let tag of tags) {
                    tag.style.background = "#1d3e77"
                }
            }
        })
    </script>
    @endif

</div>


<div class="conversations__widget__container">
    <div class="widget__title">
        <h3>Dernières conversations</h3>
    </div>
    <div class="widget__conversations">
        @if($recentConversations->count() == $conversations->where('published', false)->count() || $conversations->count() < 1) <p class="no__conversations">Aucune conversation à afficher!</p>
            @else
            @foreach($recentConversations as $conv)
            @if($conv->published == true)
            <div class="single__conversation">
                <div class="border"></div>
                <div class="text__content">
                    @php
                    $lastConvTitle = $conv->title;
                    $lastConvBody = $conv->body;
                    $truncatedConvTitle = Str::limit($lastConvTitle, 40, '...');
                    $truncatedConvBody = Str::limit($lastConvBody, 60, '...');
                    @endphp
                    <h4>{{$truncatedConvTitle}}</h4>
                    <p>{{$truncatedConvBody}}</p>
                </div>
            </div>
            @endif
            @endforeach
            @endif
    </div>
</div>
<style>
    .conversations__widget__container .widget__title {
        background-image: url('{{asset("storage/medias/chalk-800x300.jpg")}}');
        background-repeat: no-repeat;
        background-size: cover;
    }

    .main__forum__container .chalk__container {
        background-image: url('{{asset("storage/medias/yellow-chalk-1920x1080.jpg")}}');
        background-size: cover;
        background-repeat: no-repeat;

    }
</style>
</div>

<div class="new__conversation__popup">
    <div class="popup">
        <form class="w-full flex justify-center" action="{{ route('new.conversation.by.user') }}" method="post">
            @csrf
            <div class="px-12 pb-8 flex flex-col items-center w-10/12">
                @if (!$errors->isEmpty())
                <div role="alert" class="w-full pb-8">
                    <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                        Empty Fields
                    </div>
                    <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                        @foreach ($errors->all() as $message)
                        <ul class="px-4">
                            <li class="list-disc">{{$message}}</li>
                        </ul>
                        @endforeach
                    </div>
                </div>
                @endif
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <label for="title">Titre</label>
                        <input type='text' class="w-full border rounded py-2 text-gray-700 focus:outline-none items-center" name="title" id="title">
                    </div>
                </div>
                <div class="w-full mb-2 justify-center">
                    <div class="flex justify-center flex-col">
                        <label for="body">Contenu</label>
                        <textarea class="editor w-full border rounded py-2 text-gray-700 focus:outline-none" name="body" id="editor" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="w-full mb-2">
                    <x-label :value="__('Thématiques')"></x-label>
                    @foreach ($thematiques as $thematique)
                    <div class="flex items-center">
                        <input type="checkbox" id="{{ $thematique->name }}" name="thematiques[]" value="{{ $thematique->id }}">
                        <label class="ml-1" for="{{ $thematique->name }}">{{ ucfirst($thematique->name) }}</label>
                    </div>
                    @endforeach
                </div>
                <div class="w-full flex justify-start submit__container">
                    <input type="submit" class="w-60 py-2 rounded bg-blue-500 hover:bg-blue-700 text-gray-100 focus:outline-none font-bold cursor-pointer" value="Soumettre">
                </div>
            </div>
        </form>
        <i class="fa fa-close popup__close"></i>
    </div>
</div>
</div>