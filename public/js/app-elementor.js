const app = {

    data() {
        return {

        }
    },

    mounted() {
        this.elementDrag()
    },

    methods: {
        changeTab(event) {
            let tab_div = document.querySelector(`#${event.target.dataset.tab}`)
            let old_actives = document.querySelectorAll('.actif')
            
            for(let old_actif of old_actives) {
                old_actif.classList.toggle('actif')
            }
    
            tab_div.classList.toggle('actif')
            event.target.classList.toggle('actif')
        },

        elementDrag() {
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
        },

        createPost() {
            const content = document.querySelector('#preview')
            const url = "/admin/test/store"
            const form = document.forms.elementor
            const params_post = new FormData(form)
            params_post.set("content", content)

            const options = {
                method: "POST",
                body: params_post,
                cors: true
            }

            fetch(url, options).then(resp => resp.json()).then(data => {
                if(data == true) {
                    console.log('Noyce!')
                }
            })
        },
    }
}

Vue.createApp(app).mount("#app-elementor")