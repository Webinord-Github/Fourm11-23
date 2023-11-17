<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
// Change Tabs
    let info_tab = document.querySelector('[data-tab="infos"]')
    let blocs_tab = document.querySelector('[data-tab="blocs"]')
    let options_tab = document.querySelector('[data-tab="options"]')

    info_tab.addEventListener('click', x => { changeTab(info_tab)})
    blocs_tab.addEventListener('click', x => { changeTab(blocs_tab)})
    options_tab.addEventListener('click', x => { changeTab(options_tab)})

    function changeTab(event) {
        let tab_div = document.querySelector(`#${event.dataset.tab}`)
        let old_actives = document.querySelectorAll('.actif')
        
        for(let old_actif of old_actives) {
            old_actif.classList.toggle('actif')
        }

        tab_div.classList.toggle('actif')
        event.classList.toggle('actif')
    }


// Elementor wanna be
    let blocs = document.querySelector('#blocs')
    let preview = document.querySelector('#preview')
    
    new Sortable(blocs, {
    group: {
        name: 'shared',
        pull: 'clone',
        put: false
    },
    sort: false,
    animation: 150
    });

    new Sortable(preview, {
        group: {
            name: 'shared',
            pull: 'clone'
        },
        animation: 150
    });

//  Set body input
    let input = document.querySelector('#body')
    let MutationObserver = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver
    let input_content_observer = new MutationObserver(bodyInputChange)

    input_content_observer.observe(preview, {
	  childList: true
    })

    function bodyInputChange() {
        input.value = preview.innerHTML
    }

// Select a bloc
    let select_observer = new MutationObserver(selectBloc)
    let margin_option = document.querySelector('.margin')

    select_observer.observe(preview, {
	  childList: true
    })

    function selectBloc() {
        let blocs = preview.querySelectorAll('.bloc')

        for(let bloc of blocs) {
            bloc.addEventListener('click', x => {
                let options_div = document.querySelector('#options ')
                let option_div = document.querySelector(`[data-option="${bloc.dataset.bloc}"]`)
                let old_option_div = options_div.querySelector('.selected')
                let old_selected_bloc = preview.querySelector('.selected')

                changeTab(options_tab)

                if(margin_option.classList.contains('hidden')) {
                    margin_option.classList.remove('hidden')
                }

                if(old_option_div != null) {
                    old_option_div.classList.toggle('selected')
                }
                option_div.classList.toggle('selected')

                if(old_selected_bloc != null) {
                    old_selected_bloc.classList.toggle('selected')
                }
                bloc.classList.toggle('selected')

                if(bloc.dataset.bloc == 'text') {
                    let content = bloc.querySelector('.text-wrapper').innerHTML
                    tinymce.get("text-editor").setContent(content);
                }
            })
        }
    }


    tinymce.init({
        selector: '#text-editor',
        setup: function (editor) {
            editor.on('change', function () {
                let content = editor.getContent();
                let selected_bloc = preview.querySelector('.selected')
                
                if(selected_bloc.dataset.bloc == 'text') {
                    let bloc_content = selected_bloc.querySelector('.text-wrapper')
                    bloc_content.innerHTML = content
                }
            });
        }
    });

</script>