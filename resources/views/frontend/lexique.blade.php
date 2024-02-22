@if(auth()->check() && !auth()->user()->verified)
    <div class="warning__container">
        <p>Votre compte est actuellement en attente d'approbation.</p>
        <p>Dès que votre compte sera approuvé, un courriel vous sera envoyé et vous aurez ainsi accès aux différentes informations présentes sur le site.</p>
        <p>Merci de votre patience.</p>
    </div>
@endif
<style>
    .bar-filter, .thematique-infos {
        background-image: url('{{asset("storage/medias/header-v3.jpg")}}');
    }
</style>
<div class="main_container">
    <div class="lexique-container">
        <div class="lexique-content">
            <div class="top-div">
                <span class="arrow">&#8592;</span>
                <h1>Lexique<span>Lexique</span></h1>
            </div>
            <div class="content">
                <div class="thematiques-ctn">
                    <div class="thematiques">
                        @foreach($thematiques as $thematique)
                            <p data-theme="{{ $thematique->name }}" class="thematique">{{ $thematique->name }}</p>
                         @endforeach
                    </div>
                    @foreach($thematiques as $thematique)
                        <div data-desc="{{ $thematique->name }}" class="thematique-infos">
                            <div>
                                <p class="name">{{ $thematique->name }}</p>
                                @if(auth()->check() && auth()->user()->verified)
                                    <?php
                                        $count = 0;
                                    ?>
                                    @foreach($thematique->bookmarksThematiques()->get()->pluck('user_id') as $mark)
                                        <?php
                                            if($mark == Auth::user()->id) {
                                                $count++;
                                            }
                                        ?>
                                    @endforeach
                                    <div data-themeid="{{ $thematique->id }}" @class(['buble', 'active' => $count>0])>
                                        <i class="fa fa-bookmark"></i>
                                    </div>
                                @endif
                            </div>
                            <p class="desc">{{ $thematique->desc }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="contenu-lie">
                    <div class="bar-filter">
                        <p>Contenu lié à la thématique - <span id="theme-selected">Intersectionnalité</span></p>
                        <div class="filters">
                            <div class="filter">
                                <div data-content="tools" class="checkbox checked"></div>
                                <p>Outils</p>
                            </div>
                            <div class="filter">
                                <div data-content="posts" class="checkbox"></div>
                                <p>Articles</p>
                            </div>
                            @if(auth()->check() && auth()->user()->verified)
                                <div class="filter">
                                    <div data-content="convos" class="checkbox"></div>
                                    <p>Conversations</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="contenu">
                        <div class="tools">
                            @foreach($tools as $tool)
                                <div class="tool element">
                                    <div class="top">
                                        <p>{{ $tool->title }}</p>
                                        @if(auth()->check() && auth()->user()->verified)
                                            <?php
                                                $count = 0;
                                            ?>
                                            @foreach($tool->signets()->get()->pluck('user_id') as $signet)
                                                <?php
                                                    if($signet == Auth::user()->id) {
                                                        $count++;
                                                    }
                                                ?>
                                            @endforeach
                                            <div data-toolid="{{ $tool->id }}" @class(['buble', 'active' => $count>0])>
                                                <i class="fa fa-bookmark"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="bottom">
                                        @if(strlen($tool->desc)>50)
                                            <p class="desc">{{ substr_replace($tool->desc, '...', 150) }}</p>
                                        @else
                                            <p class="desc">{{ $tool->desc }}</p>
                                        @endif
                                        <div class="tags">
                                            @foreach($tool->thematiques()->get()->pluck('name')->toArray() as $thematique)
                                                <p data-tag="{{ $thematique }}" class="tag">{{ $thematique }}</p>
                                            @endforeach
                                        </div>
                                        <a href="#">
                                            Voir plus
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="posts hidden">
                            @foreach($posts as $post)
                                <div class="post element">
                                    <div class="top">
                                        <p>{{ $post->title }}</p>
                                        @if(auth()->check() && auth()->user()->verified)
                                            <?php
                                                $count = 0;
                                            ?>
                                            @foreach($post->postmarks()->get()->pluck('user_id') as $signet)
                                                <?php
                                                    if($signet == Auth::user()->id) {
                                                        $count++;
                                                    }
                                                ?>
                                            @endforeach
                                            <div data-postid="{{ $post->id }}" @class(['buble', 'active' => $count>0])>
                                                <i class="fa fa-bookmark"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="bottom">
                                        @if(strlen($post->body)>50)
                                            <p class="desc">{{ substr_replace($post->body, '...', 150) }}</p>
                                        @else
                                            <p class="desc">{{ $post->body }}</p>
                                        @endif
                                        <div class="tags">
                                            @foreach($post->thematiques()->get()->pluck('name')->toArray() as $thematique)
                                                <p data-tag="{{ $thematique }}" class="tag">{{ $thematique }}</p>
                                            @endforeach
                                        </div>
                                        <a href="#">
                                            Voir plus
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if(auth()->check() && auth()->user()->verified)
                            <div class="convos  hidden">
                                @foreach($conversations as $convo)
                                    <div class="convo element">
                                        <div class="top">
                                            <p>{{ $convo->title }}</p>
                                            {{-- <?php
                                                $count = 0;
                                            ?>
                                            @Auth
                                                @foreach($post->signets()->get()->pluck('user_id') as $signet)
                                                    <?php
                                                        if($signet == Auth::user()->id) {
                                                            $count++;
                                                        }
                                                    ?>
                                                @endforeach
                                            @endAuth --}}
                                            <div data-tool-id="{{ $convo->id }}" @class(['buble', 'active' => $count>0])>
                                                <i class="fa fa-bookmark"></i>
                                            </div>
                                        </div>
                                        <div class="bottom">
                                            @if(strlen($convo->body)>50)
                                                <p class="desc">{{ substr_replace($convo->body, '...', 150) }}</p>
                                            @else
                                                <p class="desc">{{ $convo->body }}</p>
                                            @endif
                                            <div class="tags">
                                                @foreach($convo->thematiques()->get()->pluck('name')->toArray() as $thematique)
                                                    <p data-tag="{{ $thematique }}" class="tag">{{ $thematique }}</p>
                                                @endforeach
                                            </div>
                                            <a href="#">
                                                Voir plus
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let thematiques = document.querySelectorAll('.thematique')
    let thematiques_infos = document.querySelector('.thematique-infos')
    let checkboxes = document.querySelectorAll('.checkbox')

    thematiques[0].classList.toggle('selected')

    window.addEventListener('load', x => {
        let div = document.querySelector('[data-desc="Intersectionnalité"]')
        div.classList.toggle('actived')
    })
    
    for(let thematique of thematiques) {
        thematique.addEventListener('click', x=> {
            let old_thematique = document.querySelector('.selected')
            let old_desc = document.querySelector('.actived')
            let span = document.querySelector('#theme-selected')
            let new_desc = document.querySelector(`[data-desc="${thematique.dataset.theme}"]`)

            if(old_thematique != null) {
                old_thematique.classList.toggle('selected')
                old_desc.classList.toggle('actived')
            }

            thematique.classList.toggle('selected')
            new_desc.classList.toggle('actived')
            span.innerHTML = thematique.innerHTML   

            search(thematique.dataset.theme)
        })
    }

    for(let checkbox of checkboxes) {
        checkbox.addEventListener('click', x => {
            let old_checkbox = document.querySelector('.checked')
            let content = document.querySelector(`.${checkbox.dataset.content}`)

            if(old_checkbox) {
                old_checkbox.classList.toggle('checked')
                let old_content = document.querySelector(`.${old_checkbox.dataset.content}`)
                old_content.classList.toggle('hidden')
            }

            checkbox.classList.toggle('checked')
            content.classList.toggle('hidden')
        })
    }

    function search(theme) {
        let divs = document.querySelectorAll('.element')

        for(let div of divs) {
            div.style.display = 'none'
        }

        for(let div of divs) {
            let tags = div.querySelectorAll('.tag')
            
            for(let tag of tags) {
                tag.classList.remove('tagged')
                if(tag.dataset.tag == theme) {
                    div.style.display = 'block'
                    tag.classList.add('tagged')
                }
            }
        }
    }

    let all_thememarks = document.querySelectorAll('[data-themeid]')

    for(let bookmark of all_thememarks) {
        bookmark.addEventListener('click', x => {
            let xhttp = new XMLHttpRequest();
            let theme_id = bookmark.dataset.themeid
            let Params = 'theme_id=' + encodeURIComponent(theme_id);

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
            xhttp.open("POST", '/api/bookmark-theme')
            xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(Params);
        })
    }

    let all_postmarks = document.querySelectorAll('[data-postid]')

    for(let bookmark of all_postmarks) {
        bookmark.addEventListener('click', x => {
            let xhttp = new XMLHttpRequest();
            let post_id = bookmark.dataset.postid
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

    let all_toolmarks = document.querySelectorAll('[data-toolid]')

    for(let bookmark of all_toolmarks) {
        bookmark.addEventListener('click', x => {
            let xhttp = new XMLHttpRequest();
            let tool_id = bookmark.dataset.toolid
            let Params = 'tool_id=' + encodeURIComponent(tool_id);

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
            xhttp.open("POST", '/api/signet')
            xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(Params);
        })
    }

    console.log(all_postmarks)
</script>