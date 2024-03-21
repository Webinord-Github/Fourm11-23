@if(auth()->check() && !auth()->user()->verified)
    <div class="warning__container">
        <p>Votre compte est actuellement en attente d'approbation.</p>
        <p>Dès que votre compte sera approuvé, un courriel vous sera envoyé et vous aurez ainsi accès aux différentes informations présentes sur le site.</p>
        <p>Merci de votre patience.</p>
    </div>
@endif
<div class="main_container">
    <div class="blogue-container">
        <div class="blogue-content">
            <div class="top-div">
                {{-- <a href="/" class="arrow">&#8592;</a> --}}
                <h1>Blogue</h1>
                <p>Blogue</p>
            </div>
            <div class="content ">
                <div class="posts">
                    @if(count($posts) == 0)
                        <div class="empty">
                            <h3>Aucun article disponible pour le moment</h3>
                        </div>
                    @endif
                    @foreach($posts as $post)
                    <div class="post" id="p{{$post->id}}">
                        <div class="image">
                            <img src="{{ $post->media->path . $post->media->name }}" alt="{{ $post->media->name }}">
                        </div>
                        <div class="title">
                            <h3>{{ $post->title }}</h3>
                            @if(auth()->check() && auth()->user()->verified)
                                <?php
                                    $count = 0;
                                ?>
                                @foreach($post->postmarks()->get()->pluck('user_id') as $bookmark)
                                    <?php
                                        if($bookmark == Auth::user()->id) {
                                            $count++;
                                        }
                                    ?>
                                @endforeach
                                <div data-id="{{ $post->id }}" @class(['buble', 'active' => $count>0])>
                                    <i class="fa fa-bookmark"></i>
                                </div>
                            @endif
                        </div>
                        <div class="desc">
                            @if(strlen($post->body)>250)
                                <p class="desc">{{ substr_replace($post->body, '...', 250) }}</p>
                            @else
                                <p class="desc">{{ $post->body }}</p>
                            @endif
                        </div>
                        <div class="tags">
                            @foreach($post->thematiques()->get()->pluck('name')->toArray() as $thematique)
                                <p data-tag="{{ $thematique }}" class="tag">{{ $thematique }}</p>
                            @endforeach
                        </div>
                        <div class="more">
                            <a  href="{{ route('post.show', ['post' => $post]) }}">Lire</a>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let all_bookmarks = document.querySelectorAll('.buble')

    for(let bookmark of all_bookmarks) {
        bookmark.addEventListener('click', x => {
            let xhttp = new XMLHttpRequest();
            let post_id = bookmark.dataset.id
            let Params = 'post_id=' + encodeURIComponent(post_id);

            xhttp.onreadystatechange = function() {
                if (this.readyState === 4) {
                    if (this.status === 200) {
                        bookmark.classList.toggle('active')
                        console.log(xhttp.response)
                        xhttp = null;
                    } else {
                        console.error("Impossible d'ajouter l'outil aux favoris.");
                    }
                }
            };
            xhttp.open("POST", '/api/bookmark-post')
            xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(Params);
        })
    }
</script>