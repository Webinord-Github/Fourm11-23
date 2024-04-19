@if(auth()->check() && !auth()->user()->verified)
<div class="warning__container">
    <p>Votre compte est actuellement en attente d'approbation.</p>
    <p>Dès que votre compte sera approuvé, un courriel vous sera envoyé et vous aurez ainsi accès aux différentes informations présentes sur le site.</p>
    <p>Merci de votre patience.</p>
</div>
@endif
@if (!$errors->isEmpty())
<div role="alert" class="w-full pb-8">
    <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
        Erreurs
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
@if (session('status'))
<div class="text-center bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-8 my-6" role="alert">
    <p class="font-bold">{{ session('status') }}</p>
</div>
@endif
<div class="main_container">
    <div class="blogue-container">
        <div class="blogue-content">
            <div class="top-div">
                <div class="h1__container">
                    <a href="/" class="arrow">&#8592;</a>
                    <h1>Blogue<span>Blogue</span></h1>
                </div>
            </div>
            <div class="content">
                @if(auth()->check() && auth()->user()->verified)
                <div class="intro">
                    <h4>
                        Une communauté de pratique exceptionnelle
                    </h4>

                    <p>
                        Bienvenue dans la section Blogue de la plateforme sur la communauté de pratique en prévention de l’intimidation, La Fourmilière, financée par ministère de la Famille et mis en œuvre par L’Anonyme.
                    </p>

                    <p>
                        Dans cette section, nous vous invitons à soumettre des textes liés à votre réalité ou vos expériences. Vos textes peuvent prendre la forme d’une réflexion émanant de vos observations d’enjeux ou de problématiques qui touchent à l’intimidation (racisme, transphobie, capacitisme, etc.). C’est aussi l’occasion de nous présenter les pratiques que vous avez implantées dans votre milieu qui contribuent à prévenir ou à intervenir lors de situations d’intimidation. Il s’agit là de quelques exemples, mais vous êtes libre de choisir votre angle. Qui sait, il est possible que votre texte fasse l’objet d’un fil de discussion dans notre forum ou soit le sujet d’une de nos prochaines capsules.
                    </p>

                    <p>
                        Cette communauté se veut inclusive, ouverte et accessible à tous·tes, nous favorisons l’utilisation d’une rédaction inclusive et respectueuse. Avant de publier votre texte sur la plateforme, assurez-vous d’avoir fait une relecture et une correction de votre texte. Les blogues ont pour objectif de partager des points de vue, de stimuler la réflexion et d’informer sur des bonnes pratiques.
                    </p>

                    <p style="margin-bottom: 0">
                        Afin de vous aider dans la rédaction, voici quelques éléments à considérer :
                    </p>

                    <ul>
                        <li>
                            Le texte devra faire un maximum d’environ 1000 mots
                        </li>

                        <li>
                            Trouvez un titre accrocheur
                        </li>

                        <li>
                            Vous pouvez y insérer une photo ou une image
                        </li>

                        <li>
                            Nous nous réservons le droit de ne pas publier un texte, s’il y a lieu nous vous informerons des causes.
                        </li>

                    </ul>

                    <p>
                        Chaque membre de la communauté possède une valeur précieuse en termes d'expérience, de connaissances et de compétences, et chacun·e contribue à prévenir et intervenir lors de situations d’intimidation grâce à des échanges collectifs.
                    </p>

                    <p>
                        N'hésitez pas à nous contacter si vous avez des questions, des propositions de collaboration ou simplement besoin de renseignements. Nous sommes ravi∙es d'établir une relation avec vous et nous nous engageons à répondre à toutes vos interrogations et à discuter de potentielles collaborations. Votre opinion et vos suggestions sont essentielles pour nous, alors n'hésitez pas à nous écrire à <a target="_blank" href="mailto:lafourmiliere@anonyme.ca">lafourmiliere@anonyme.ca</a>.
                    </p>

                    <p>
                        Nous avons hâte d'entendre ce que vous avez à dire !
                    </p>

                    <div class="btn-container">
                        <button id="add-post">
                            proposer un article
                        </button>
                    </div>

                </div>
                @endif
                <div class="posts">
                    @if(count($posts) == 0)
                    <div class="empty">
                        <h3>Aucun article disponible pour le moment</h3>
                    </div>
                    @endif
                    @foreach($posts as $post)

                    <div class="post" id="p{{$post->id}}">
                        @if($post->media)
                        <div class="image">
                            <img src="{{ $post->media->path . $post->media->name }}" alt="{{ $post->media->name }}">
                        </div>

                        @endif
                        <div class="title">
                            <h3>{!! $post->title !!}</h3>
                            @if(auth()->check() && auth()->user()->verified)
                            <?php
                            $count = 0;
                            ?>
                            @foreach($post->postmarks()->get()->pluck('user_id') as $bookmark)
                            <?php
                            if ($bookmark == Auth::user()->id) {
                                $count++;
                            }
                            ?>
                            @endforeach
                            <div data-id="{{ $post->id }}" @class(['buble', 'active'=> $count>0])>
                                <i class="fa fa-bookmark"></i>
                            </div>
                            @endif
                        </div>
                        <div class="desc">
                            @if(strlen($post->body)>250)
                            <div class="desc">{!! substr_replace($post->body, '...', 50) !!}</div>
                            @else
                            <div class="desc">{!!$post->body !!}</div>
                            @endif
                        </div>
                        <div class="tags">
                            @foreach($post->thematiques()->get()->pluck('name')->toArray() as $thematique)
                            <p data-tag="{{ $thematique }}" class="tag">{{ $thematique }}</p>
                            @endforeach
                        </div>
                        <div class="more">
                            <a href="{{ route('post.show', ['post' => $post]) }}">Lire</a>
                        </div>
                    </div>
                    @endforeach
                    <div class="ghost__post"></div>
                    <div class="ghost__post"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="popup-ctn">
    <div class="popup">
        <div class="close-btn x">
            <a>
                x
            </a>
        </div>
        <form class="w-full flex justify-center" action="/blogue/send" method="post" enctype="multipart/form-data">
            @csrf
            <div class="px-12 pb-8 flex flex-col items-center w-10/12">
                <h3>Proposer un article</h3>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="title" :value="__('Titre')"></x-label>
                        <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                    </div>
                </div>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="body" :value="__('Contenu')"></x-label>
                        <textarea style="resize: none; border-radius: 5px;height:100px" name="body">{{ old('body') }}</textarea>
                    </div>
                </div>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="image" :value="__('Image: jpeg, png, jpg, webp')" />
                        <input type="file" id="image" name="image">
                    </div>
                </div>
                <div class="w-full mb-2">
                    <x-label :value="__('Thématiques (Max 3)')"></x-label>
                    @foreach ($thematiques as $thematique)
                    <div class="flex items-center">
                        <input class="thematiques__checkbox" type="checkbox" id="{{ $thematique->name }}" name="thematiques[]" value="{{ $thematique->id }}">
                        <label class="ml-1" for="{{ $thematique->name }}">{{ ucfirst($thematique->name) }}</label>
                    </div>
                    @endforeach
                </div>
                <div class="flex items-center justify-end mt-4">
                    <a class="close-btn">Fermer</a>
                    <x-button id="send" class="ml-4">
                        {{ __('Envoyer') }}
                    </x-button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    let all_bookmarks = document.querySelectorAll('.buble')

    for (let bookmark of all_bookmarks) {
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

    let add_button = document.querySelector('#add-post')
    let popup = document.querySelector('.popup-ctn')

    add_button.addEventListener('click', x => {
        popup.style.display = 'flex'
    })

    let close_btns = document.querySelectorAll('.close-btn')

    for (let button of close_btns) {
        button.addEventListener('click', x => {
            popup.style.display = 'none'
        })
    }

    // max checkbox 3 
    document.addEventListener("click", e => {
        if (e.target.classList.contains("thematiques__checkbox")) {
            let checkedThematiques = document.querySelectorAll(".thematiques__checkbox:checked");

            if (checkedThematiques.length > 2) {
                let allThematiques = document.querySelectorAll(".thematiques__checkbox")
                for (let checkbox of allThematiques) {
                    if (!checkbox.checked) {
                        checkbox.disabled = true
                        checkbox.style.cursor = "not-allowed"
                        checkbox.style.opacity = "0.3"
                    }
                }
            }
            if (checkedThematiques.length < 3) {
                let allThematiques = document.querySelectorAll(".thematiques__checkbox")
                console.log('true')
                for (let checkbox of allThematiques) {
                    if (!checkbox.checked) {
                        checkbox.disabled = false
                        checkbox.style.cursor = "pointer"
                        checkbox.style.opacity = 1
                    }
                }
            }
        }
    })
</script>