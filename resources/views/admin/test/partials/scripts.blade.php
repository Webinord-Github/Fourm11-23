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
    let padding_option = document.querySelector('.padding')
    let delete_option = document.querySelector('.delete-button')
    let input_mtop = document.querySelector('#m-top')
    let input_mleft = document.querySelector('#m-left')
    let input_mbottom = document.querySelector('#m-bottom')
    let input_mright = document.querySelector('#m-right')
    let input_ptop = document.querySelector('#p-top')
    let input_pleft = document.querySelector('#p-left')
    let input_pbottom = document.querySelector('#p-bottom')
    let input_pright = document.querySelector('#p-right')
    let margin_inputs = document.querySelectorAll('.margin-inputs')
    let padding_inputs = document.querySelectorAll('.padding-inputs')
    let preview_bloc_img  = document.querySelector('#preview-bloc-img')
    let delete_bloc = document.querySelector('.delete-bloc')
    let close_bloc_options = document.querySelector('.close-options')

    delete_bloc.addEventListener('click', x => {
        let options_div = document.querySelector('#options')
        let old_option_div = options_div.querySelector('.selected')
        let selected_bloc = preview.querySelector('.selected')
        let default_option = options_div.querySelector('.default')

        selected_bloc.remove()
        old_option_div.classList.toggle('selected')
        margin_option.classList.add('hidden')
        padding_option.classList.add('hidden')
        delete_option.classList.add('hidden')
        default_option.classList.toggle('selected')
    })

    close_bloc_options.addEventListener('click', x => {
        let options_div = document.querySelector('#options')
        let old_option_div = options_div.querySelector('.selected') 
        let default_option = options_div.querySelector('.default')

        old_option_div.classList.toggle('selected')
        margin_option.classList.add('hidden')
        padding_option.classList.add('hidden')
        delete_option.classList.add('hidden')
        default_option.classList.toggle('selected')
    })

    select_observer.observe(preview, {
	  childList: true
    })

    function selectBloc() {
        let blocs = preview.querySelectorAll('.bloc')

        for(let bloc of blocs) {
            bloc.addEventListener('click', x => {
                let options_div = document.querySelector('#options')
                let option_div = document.querySelector(`[data-option="${bloc.dataset.bloc}"]`)
                let old_option_div = options_div.querySelector('.selected')
                let old_selected_bloc = preview.querySelector('.selected')
                let bloc_content = bloc.querySelector('.content')

                changeTab(options_tab)

                if(margin_option.classList.contains('hidden')) {
                    margin_option.classList.remove('hidden')
                    padding_option.classList.remove('hidden')
                    delete_option.classList.remove('hidden')
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
                    let content = bloc.querySelector('.content').firstElementChild
                    tinymce.get("text-editor").setContent(content.innerHTML);
                }

                if(bloc.dataset.bloc == 'image') {
                    let content = bloc.querySelector('.content').firstElementChild
                    getImage(content)
                }

                setMargin(bloc_content.firstElementChild)
                setPadding(bloc_content.firstElementChild)
            })
        }
    }

    function setMargin(element) {
        let mtop = (window.getComputedStyle(element).marginTop).substring(0, (window.getComputedStyle(element).marginTop).length - 2)
        let mleft = (window.getComputedStyle(element).marginLeft).substring(0, (window.getComputedStyle(element).marginLeft).length - 2)
        let mbottom = (window.getComputedStyle(element).marginBottom).substring(0, (window.getComputedStyle(element).marginBottom).length - 2)
        let mright = (window.getComputedStyle(element).marginRight).substring(0, (window.getComputedStyle(element).marginRight).length - 2)

        input_mtop.value = mtop
        input_mleft.value = mleft
        input_mbottom.value = mbottom
        input_mright.value = mright
    }

    function setPadding(element) {
        let ptop = (window.getComputedStyle(element).paddingTop).substring(0, (window.getComputedStyle(element).paddingTop).length - 2)
        let pleft = (window.getComputedStyle(element).paddingLeft).substring(0, (window.getComputedStyle(element).paddingLeft).length - 2)
        let pbottom = (window.getComputedStyle(element).paddingBottom).substring(0, (window.getComputedStyle(element).paddingBottom).length - 2)
        let pright = (window.getComputedStyle(element).paddingRight).substring(0, (window.getComputedStyle(element).paddingRight).length - 2)

        input_ptop.value = ptop
        input_pleft.value = pleft
        input_pbottom.value = pbottom
        input_pright.value = pright
    }

    function getImage(element) {
        let image = element.firstElementChild
        preview_bloc_img.setAttribute('src', image.src)
    }

    for(let input of margin_inputs) {
        input.addEventListener('change', x=> {
            let selected_bloc = preview.querySelector('.selected')
            selected_bloc = selected_bloc.querySelector('.content').firstElementChild

            if(input.id == 'm-top') {
                selected_bloc.style.marginTop = `${input.value}px`
            } else if(input.id == 'm-left') {
                selected_bloc.style.marginLeft = `${input.value}px`
            } else if(input.id == 'm-bottom') {
                selected_bloc.style.marginBottom = `${input.value}px`
            } else {
                selected_bloc.style.marginRight = `${input.value}px`
            }
        })
    }

    for(let input of padding_inputs) {
        input.addEventListener('change', x=> {
            let selected_bloc = preview.querySelector('.selected')
            selected_bloc = selected_bloc.querySelector('.content').firstElementChild

            if(input.id == 'p-top') {
                selected_bloc.style.paddingTop = `${input.value}px`
            } else if(input.id == 'p-left') {
                selected_bloc.style.paddingLeft = `${input.value}px`
            } else if(input.id == 'p-bottom') {
                selected_bloc.style.paddingBottom = `${input.value}px`
            } else {
                selected_bloc.style.paddingRight = `${input.value}px`
            }
        })
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

// Medias Library
    let medias = []
    let medias_btn = document.querySelector('#medias')
    let close_btn = document.querySelector('.close-btn')
    let popup = document.querySelector('.popup')
    let library = document.querySelector('#library')
    let images = []

    medias_btn.addEventListener('click', x => { 
        popup.style.display = 'flex'
        getMedias()
    })

    close_btn.addEventListener('click', x => {
        popup.style.display = 'none'
        medias = []
        library.innerHTML = ''
    })

    function getMedias() {
        const url = "/elementor/medias"
        const option = {
            method: "GET",
            CORS: true
        }

        fetch(url, options).then(resp => resp.json()).then(data => {
            medias = data
            showMedias(medias)

            images = library.querySelectorAll('.media')
            selectImage(images)
        })
    }

    function showMedias(array) {
        let i = 0
        for(let item of array) {

            let div = document.createElement('div')
            library.appendChild(div)
            div.classList.add('media')
            div.dataset.index = item.id

            let img_wrapper = document.createElement('div')
            img_wrapper.classList.add('img-wrapper')
            div.appendChild(img_wrapper)

            let img = document.createElement('img')
            img_wrapper.appendChild(img)
            img.setAttribute('src', `${window.location.origin}${item.path}${item.name}`)

            let name = document.createElement("p")
            name.classList.add('name')
            div.appendChild(name)

            if(item.name.length > 23) {
                name.innerHTML = `${item.name.substring(0,23)}...`
            } else {
                name.innerHTML = item.name
            }
        }
    }

    function selectImage(array) {
        let name = document.querySelector('.image-name') 
        let size = document.querySelector('.size') 
        let extension = document.querySelector('.extension')
        let dimensions = document.querySelector('.dimensions')
        let select_button = document.querySelector('#chosen-one')

        for(let image of array) {
            
            image.addEventListener('click', x => {
                let element_img = image.querySelector('img')
                let image_options = document.querySelector('.image-options')
                let library_options = document.querySelector('.library-options')
                let image_infos = medias.find(item => item.id === image.dataset.index)
                console.log(image_infos)

                if(image_options.classList.contains('hidden')) {
                    image_options.classList.toggle('hidden')
                    library_options.querySelector('.default').style.display = 'none'
                }

                let old_image = library.querySelector('.selected')

                if(old_image != null) {
                    old_image.classList.toggle('selected')
                }

                name.innerHTML = `Nom de l'image: ${image_infos.name}`
                size.innerHTML = `Poid de l'image: ${image_infos.size}KB`
                extension.innerHTML = `Extension de l'image: ${image_infos.provider}`
                dimensions.innerHTML = `Dimensions de l'image: ${element_img.naturalWidth}x${element_img.naturalHeight}`

                image.classList.toggle('selected')
            })
        }
        select_button.addEventListener('click', x => {
            changeImage()
        })
        
    }

    function changeImage() {
        let selected_image = library.querySelector('.selected')
        let image_infos = medias[parseInt(selected_image.dataset.id)]
        let src = `${window.location.origin}${item.path}${item.name}`
        let selected_bloc = (preview.querySelector('.selected')).querySelector('img')
        
        selected_bloc.setAttribute('src', src)
        preview_bloc_img.setAttribute('src', src)
        popup.style.display = 'none'
        medias = []
        library.innerHTML = ''
    }
    
 // Drag & Drop
    let file_input = document.querySelector('#drop-file');
    let drop_area = document.querySelector('#drop-area')
    let drop_over = document.querySelector('#drop-over')
    let drop_input = document.querySelector('#drop-input')

    drop_area.addEventListener('dragenter', x => {
        drop_over.classList.toggle('active')
    })

    drop_area.addEventListener('dragleave', x => {
        drop_over.classList.toggle('active')
    })

    window.addEventListener('dragover', x => {
        x.preventDefault()
    })

    drop_area.addEventListener('drop', e => {
        e.preventDefault()
        drop_over.classList.remove('active')
        let upload_file = e.dataTransfer.files[0]
        
        if (upload_file.type.split('/')[0] == 'image') {
            let xhttp = new XMLHttpRequest()
            let form_data = new FormData()

            form_data.append('image', upload_file)
            
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4) {
                    if (this.status === 200) {
                        medias.push(JSON.parse(xhttp.responseText))
                        createMedia(JSON.parse(xhttp.responseText))
                        console.log(medias)
                        xhttp = null;
                    } else {
                        console.error("Need an image.")
                    }
                }
            };
            xhttp.open("POST", `{{ route('elementor.upload') }}`, true)
            xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
            xhttp.send(form_data)
        }
    })

    function createMedia(file) {
        let div = document.createElement('div')
        library.appendChild(div)
        div.classList.add('media')
        div.dataset.index = file.id

        let img_wrapper = document.createElement('div')
        img_wrapper.classList.add('img-wrapper')
        div.appendChild(img_wrapper)

        let img = document.createElement('img')
        img_wrapper.appendChild(img)
        img.setAttribute('src', `${window.location.origin}${file.path}${file.name}`)

        let name = document.createElement("p")
        name.classList.add('name')
        div.appendChild(name)

        if(file.name > 23) {
            name.innerHTML = `${file.name.substring(0,23)}...`
        } else {
            name.innerHTML = file.name
        }
    }

</script>