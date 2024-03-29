<div class="main__container">
    @if(count($conversations) == 0)
    <p>Aucune conversations à afficher présentement!</p>
    @endif
    @if(count($conversations) > 0)
    @foreach($conversations as $conversation)
    <div class="forum__container">
        <div class="forum__content">
            <div class="conv__container" data-post-id="{{$conversation->id}}">
                <div class="conv__title__container">
                    <p id="conv__title"><i class="fa fa-comments"></i>{{ $conversation->title }}</p>
                    <i class="fa fa-bookmark"></i>
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
                        <a class="tags" href="">Adolescent.es</a>
                        <a class="tags" href="">Sexisme</a>
                        <a class="tags" href="">École secondaire</a>
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
                                <i class="fa fa-paper-plane reply__submit"></i>
                            </div>
                        </form>
                    </div>
                    <!-- USER REPLIES  -->

                    @foreach($conversation->replies as $reply)
                    @if($reply->parent_id == null)
                    <div class="single__reply__container parent__container" data-reply-id="{{$reply->id}}">
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
                                            <i class="fa fa-paper-plane user__reply__submit"></i>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @foreach($conversation->replies as $nestedReply)
                        @if($nestedReply->parent_id == $reply->id)
                        <div id="child__reply" class="single__reply__container" data-reply-id="{{$nestedReply->id}}" data-parent-id="{{$nestedReply->parent_id}}">
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
    @endforeach

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
            let conversationId = form.querySelector("#conversation__id").getAttribute('data-id');
            let body = form.querySelector("#autoExpand").value
            let Params = 'conversation_id=' + encodeURIComponent(conversationId) + '&body=' + encodeURIComponent(body)
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
                                        <i class="fa fa-paper-plane user__reply__submit"></i>
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

        }
    })

    // REPLY TO A USER COMMENT
    document.addEventListener("click", e => {
        if (e.target.classList.contains("user__reply__submit")) {
            let form = e.target.closest("form");

            let xhttp = new XMLHttpRequest()
            let conversationId = form.querySelector("#conversation__id").getAttribute('data-id');
            let parentId = form.querySelector("#parent__id").getAttribute('data-parent-id')
            let body = form.querySelector("#autoExpand").value
            console.log(form.query)
            let Params = 'conversation_id=' + encodeURIComponent(conversationId) + '&body=' + encodeURIComponent(body) + '&parent_id=' + encodeURIComponent(parentId)
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
</script>
@endif