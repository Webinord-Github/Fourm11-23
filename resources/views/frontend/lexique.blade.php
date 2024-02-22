<div class="main_container">
    <div class="lexique-container">
        <div class="lexique-content">
            <div class="top-div">
                <span class="arrow">&#8592;</span>
                <p>Lexique<span>Lexique</span></p>
            </div>
            <div class="content ">
                <div class="thematiques-ctn">
                    <div class="thematiques">
                        @foreach($thematiques as $thematique)
                            <p data-theme="{{ $thematique->name }}" class="thematique">{{ $thematique->name }}</p>
                         @endforeach
                    </div>
                    <div class="thematique-infos">
                        <p class="name">Intersectionnalité</p>
                        <p class="desc">Prise en compte du cumul de plusieurs facteurs d’inégalité ou de discrimination, génér. l’assignation à une origine raciale ou ethnique supposée, l’identité sexuelle et le milieu social.</p>
                    </div>
                </div>
                <div class="contenu-lie">
                    <div class="bar-filter">
                        <p>Contenu lié à la thématique - <span id="theme-selected"></span></p>
                        <div class="filter"></div>
                    </div>
                    <div class="contenu"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let thematiques = document.querySelectorAll('.thematique')
    let thematiques_infos = document.querySelector('.thematique-infos')
    
    for(let thematique of thematiques) {
        thematique.addEventListener('click', x=> {
            let old_thematique = document.querySelector('.selected')
            let span = document.querySelector('#theme-selected')
            let thematique_name = thematiques_infos.querySelector('.name')
            let thematique_desc = thematiques_infos.querySelector('.desc')

            if(old_thematique != null) {
                old_thematique.classList.toggle('selected')
            }

            thematique.classList.toggle('selected')
            span.innerHTML = thematique.innerHTML
            thematique_name.innerHTML = thematique.innerHTML
        })
    }
</script>