@if(auth()->check() && !auth()->user()->verified)
<div class="warning__container">
    <p>Votre compte est actuellement en attente d'approbation.</p>
    <p>Dès que votre compte sera approuvé, un courriel vous sera envoyé et vous aurez ainsi accès aux différentes informations présentes sur le site.</p>
    <p>Merci de votre patience.</p>
</div>
@endif
<style>
    .thematiques-half {
        background-image: url('{{asset("storage/medias/slide-menu-background.jpg")}}');
    }
</style>
@if (session('status'))
<div class="text-center bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-8 my-6" role="alert">
    <p class="font-bold">{{ session('status') }}</p>
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
<div class="main_container">
    <div class="tools-container">
        <div class="tools-content">
            <div class="top-div">
                <h1>Boîte à outils</h1>
                <p>Boîte à outils</p>
            </div>
            <div class="content ">
                <div class="thematiques-half">
                    <div class="searchbar-container">
                        <input id="searchbar" name="searchbar" type="text" placeholder="chercher un outil">
                        <i class="fa fa-search"></i>
                    </div>
                    <div class="thematiques">
                        @foreach($thematiques as $thematique)
                        <p data-theme="{{ $thematique->name }}" class="thematique">{{ $thematique->name }}</p>
                        @endforeach
                    </div>
                    <div class="dropdown__container">
                        <div class="dropdown__content">
                            <div class="dropdown drop__trigger__parent">
                                <h3 class="drop__trigger">Thématiques</h3>
                                <i class="fa fa-angle-down drop__trigger"></i>
                            </div>
                            <div class="drop__content">
                                <div class="text">
                                    @foreach($thematiques as $thematique)
                                        <h3 data-theme="{{ $thematique->name }}" class="thematique">{{ $thematique->name }}</h3>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(auth()->check() && auth()->user()->verified)
                    <div class="btn-container">
                        <button id="add-tool">
                            proposer un outil
                        </button>
                    </div>
                    @endif
                </div>
                <div class="tools-half">
                    @if(count($tools) == 0)
                    <div class="empty">
                        <h3>Aucun outil disponible en ce moment</h3>
                    </div>
                    @endif
                    @foreach($tools as $tool)
                        <div class="tool" data-id="{{ $tool->id }}" id="t{{$tool->id}}">
                            <div class="top">
                                <h3 class="title">{{ $tool->title }}</h3>
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
                                    <div data-tool-id="{{ $tool->id }}" @class(['black-buble', 'active' => $count>0])>
                                        <i class="fa fa-bookmark"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="desc">
                                <p class="source">{{ $tool->source }}</p>
                            </div>
                            <div class="tags">
                                @foreach($tool->thematiques()->get()->pluck('name')->toArray() as $thematique)
                                    <p class="tag" data-theme="{{ $thematique }}">{{ $thematique }}</p>
                                @endforeach
                            </div>
                            <div class="btn-container">
                                @if($tool->media_id)
                                    <a target="_blank" href="{{$tool->media()->first()->path . $tool->media()->first()->name}}">Télécharger</a>
                                @elseif($tool->site_link != 'null')
                                    <a target="_blank" href="{{$tool->site_link}}">Voir l'outil</a>
                                @endif
                            </div>
                            
                        </div>
                        <div class="desc">
                            <p>{{ $tool->desc }}</p>
                        </div>
                        <div class="tags">
                            @foreach($tool->thematiques()->get()->pluck('name')->toArray() as $thematique)
                            <p class="tag" data-theme="{{ $thematique }}">{{ $thematique }}</p>
                            @endforeach
                        </div>
                        <div class="btn-container">
                            <a target="_blank" href="{{$tool->media()->first()->path . $tool->media()->first()->name}}">télécharger</a>
                        </div>
                    </div>
                    @endforeach
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
        <form class="w-full flex justify-center" action="/boite-a-outils/send" method="post" enctype="multipart/form-data">
            @csrf
            <div class="px-12 pb-8 flex flex-col items-center w-10/12">
                <h3>Proposer un outil</h3>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="title" :value="__('Titre')"></x-label>
                        <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                    </div>
                </div>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="desc" :value="__('Description')"></x-label>
                        <textarea style="resize: none; border-radius: 5px;height:100px" name="desc">{{ old('desc') }}</textarea>
                    </div>
                </div>
                <div class="w-full mb-2">
                    <div class="flex justify-center flex-col">
                        <x-label for="media" :value="__('Fichier: pdf, docx')" />
                        <input type="file" id="media" name="media">
                    </div>
                </div>
                <div class="w-full mb-2">
                    <x-label :value="__('Thématiques (Max 3)')"></x-label>
                    @foreach ($thematiques as $thematique)
                    <div class="flex items-center">
                        <input type="checkbox" id="{{ $thematique->name }}" name="thematiques[]" value="{{ $thematique->id }}">
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

    window.addEventListener("click", e => {
        if (e.target.classList.contains("drop__trigger")) {
            let dropContent = e.target.parentElement.nextElementSibling
            let heightEl = getComputedStyle(dropContent.childNodes[1]).getPropertyValue('height')
            dropContent.classList.toggle('open')
            if (dropContent.classList.contains('open')) {
                dropContent.style.height = parseInt(heightEl) + "px"
                dropContent.style.transition = "height 0.2s linear"
            } else {
                dropContent.style.height = "0px"
                dropContent.style.transition = "height 0.2s linear"
            }
            e.target.parentElement.childNodes[3].classList.toggle('rotate')
        }
        if (e.target.classList.contains("drop__trigger__parent")) {
            let dropContent = e.target.nextElementSibling
            dropContent.classList.toggle('open')
            let heightEl = getComputedStyle(dropContent.childNodes[1]).getPropertyValue('height')
            if (dropContent.classList.contains('open')) {
                dropContent.style.height = parseInt(heightEl) + "px"
                dropContent.style.transition = "height 0.2s linear"
            } else {
                dropContent.style.height = "0px"
                dropContent.style.transition = "height 0.2s linear"
            }
            e.target.childNodes[3].classList.toggle('rotate')
        }

    })

    let thematiques = document.querySelectorAll('.thematique')
    let search_bar = document.querySelector('#searchbar')

    for (let thematique of thematiques) {
        thematique.addEventListener('click', x => {
            let thematiques_ctn = document.querySelector('.thematiques')
            let old_actif = thematiques_ctn.querySelector('.actif')
            let mobile_filter = document.querySelector('.drop__trigger')

            if (old_actif != null) {
                old_actif.classList.toggle('actif')
            }

            thematique.classList.toggle('actif')
            search_bar.value = thematique.dataset.theme
            mobile_filter.innerText = thematique.dataset.theme
            search()
        })
    }

    let all_signets = document.querySelectorAll('.black-buble')

    for (let signet of all_signets) {
        signet.addEventListener('click', x => {
            let xhttp = new XMLHttpRequest();
            let tool_id = signet.dataset.toolId
            let Params = 'tool_id=' + encodeURIComponent(tool_id);

            xhttp.onreadystatechange = function() {
                if (this.readyState === 4) {
                    if (this.status === 200) {
                        signet.classList.toggle('active')
                        xhttp = null;
                    } else {
                        console.error("Impossible d'ajouter l'outil aux favoris.");
                    }
                }
            };
            // Deleting the parent comment and its associated replies
            xhttp.open("POST", '/api/signet')
            xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(Params);
        })
    }

    let tags = document.querySelectorAll('.tag')

    for (let tag of tags) {
        tag.addEventListener('click', x => {
            search_bar.value = tag.dataset.theme
            let thematiques_ctn = document.querySelector('.thematiques')
            let old_actif = thematiques_ctn.querySelector('.actif')
            let mobile_filter = document.querySelector('.drop__trigger')

            mobile_filter.innerText = tag.dataset.theme

            if (old_actif != null) {
                old_actif.classList.toggle('actif')
            }
            search()
        })
    }

    let loupe = document.querySelector('.fa-search')
    loupe.addEventListener('click', x => {
        search()
    })

    search_bar.addEventListener('keyup', x => {
        let thematiques_ctn = document.querySelector('.thematiques')
        let old_actif = thematiques_ctn.querySelector('.actif')
        let mobile_filter = document.querySelector('.drop__trigger')

        if (old_actif != null) {
            old_actif.classList.toggle('actif')
        }
        mobile_filter.innerText = 'Thématiques'
        search()
    })

    function search() {
        let search_value = (search_bar.value).toLowerCase()
        let tools = document.querySelectorAll('.tool')
        let dropContent = document.querySelector('.drop__content')
        let heightEl = getComputedStyle(dropContent.childNodes[1]).getPropertyValue('height')
        console.log(dropContent)
        console.log(heightEl)

        for(let tool of tools) {
            tool.style.display = 'none'
        }

        if(search_value == '') {
            for(let tool of tools) {
                tool.style.display = 'flex'
            }
        }

        for(let tool of tools) {
            let tool_title = tool.querySelector('.title')
            let tool_tags = tool.querySelectorAll('.tag')
            let tool_source = tool.querySelector('.source')

            if(((tool_title.innerText).toLowerCase()).includes(search_value) || ((tool_source.innerText).toLowerCase()).includes(search_value)) {
                tool.style.display = 'flex'
            }

            for(let tag of tool_tags) {
                if(((tag.dataset.theme).toLowerCase()).includes(search_value)) {
                    tool.style.display = 'flex'
                }
            }
        }

        if (dropContent.classList.contains('open')) {
            dropContent.classList.toggle('open')
            dropContent.style.height = "0px"
            dropContent.style.transition = "height 0.2s linear"
            document.querySelector('.fa-angle-down').classList.toggle('rotate')
        }
    }

    let add_tool = document.querySelector('#add-tool')
    let popup_ctn = document.querySelector('.popup-ctn')

    add_tool.addEventListener('click', x => {
        popup_ctn.style.display = 'flex'
    })

    let close_btns = document.querySelectorAll('.close-btn')

    for (let button of close_btns) {
        button.addEventListener('click', x => {
            popup_ctn.style.display = 'none'
        })
    }
</script>