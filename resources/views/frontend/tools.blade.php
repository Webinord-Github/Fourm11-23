<div class="main_container">
    <div class="tools-container">
        <div class="tools-content">
            <div class="top-div">
                <span class="arrow">&#8592;</span>
                <p>Boîte à outils<span>Boîte à outils</span></p>
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
                    <div class="btn-container">
                        <button>
                            proposer un outil
                        </button>
                    </div>
                </div>
                <div class="tools-half">
                    @foreach($tools as $tool)
                        <div class="tool" data-id="{{ $tool->id }}">
                            <div class="title">
                                <h3>{{ $tool->title }}</h3>
                                <?php
                                    $count = 0;
                                ?>
                                @Auth
                                    @foreach($tool->signets()->get()->pluck('user_id') as $signet)
                                        <?php
                                            if($signet == Auth::user()->id) {
                                                $count++;
                                            }
                                        ?>
                                    @endforeach
                                @endAuth
                                <div data-tool-id="{{ $tool->id }}" @class(['black-buble', 'active' => $count>0])>
                                    <i class="fa fa-bookmark"></i>
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
<script>
    let tools = []

    window.addEventListener('load', x => {
        const url = "/get/tools"
        const options = {
            method: "GET",
            CORS: true
        }

        fetch(url, options).then(resp => resp.json()).then(data => {
            tools = data
        })
    })

    let thematiques = document.querySelectorAll('.thematique')
    let search_bar = document.querySelector('#searchbar')
    
    for(let thematique of thematiques) {
        thematique.addEventListener('click', x => {
            let thematiques_ctn = document.querySelector('.thematiques')
            let old_actif = thematiques_ctn.querySelector('.actif')

            if(old_actif != null) {
                old_actif.classList.toggle('actif')
            }

            thematique.classList.toggle('actif')
            search_bar.value = thematique.dataset.theme
            search()
        })
    }

    let all_signets = document.querySelectorAll('.black-buble')

    for(let signet of all_signets) {
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
            xhttp.open("POST", `{{ route('signet-tool')}}`)
            xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(Params);
        })
    }

    let tags = document.querySelectorAll('.tag')

    for(let tag of tags) {
        tag.addEventListener('click', x => {
            search_bar.value = tag.dataset.theme
            let thematiques_ctn = document.querySelector('.thematiques')
            let old_actif = thematiques_ctn.querySelector('.actif')

            if(old_actif != null) {
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

        if(old_actif != null) {
            old_actif.classList.toggle('actif')
        }
        search()
    })
    
    function search() {   
        let search_value = (search_bar.value).toLowerCase()
        let divs = document.querySelectorAll('.tool')

        for(let div of divs) {
            div.style.display = 'none'
        }

        if(search_value == '') {
            console.log('yay')
            for(let div of divs) {
                div.style.display = 'flex'
            }
        }

        for(let tool of tools) {
            let tool_div = document.querySelector(`[data-id='${tool.id}']`)

            if(((tool.title).toLowerCase()).includes(search_value) || ((tool.desc).toLowerCase()).includes(search_value)) {
                tool_div.style.display = 'flex'
            }

            let tool_tags = tool_div.querySelectorAll('.tag')

            for(let tag of tool_tags) {
                if(((tag.dataset.theme).toLowerCase()).includes(search_value)) {
                    tool_div.style.display = 'flex'
                }
            }
        }
    }
</script>