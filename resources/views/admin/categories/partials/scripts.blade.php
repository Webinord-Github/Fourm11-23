<script>
    let add_btn = document.querySelector('#add-cta')
    let add_form = document.querySelector('#add-form')
    let add_form_cancel = add_form.querySelector('.cancel-form')
    let edit_btns = document.querySelectorAll('.edit-cta')

    add_btn.addEventListener('click', x=> {
        add_form.style.display = 'flex'
    })

    add_form_cancel.addEventListener('click', y=> {
        add_form.style.display = 'none'
    })

    for(let edit_btn of edit_btns) {
        let edit_form = document.querySelectorAll(`[data-category= ${edit_btn.id}]`)
        let cancel_btn =document.querySelector(`.${edit_btn.id}`)

        edit_btn.addEventListener('click', z=> {
            for(let input of edit_form) {
                input.classList.toggle('hidden')
            }
        })

        cancel_btn.addEventListener('click', z=> {
            for(let input of edit_form) {
                input.classList.toggle('hidden')
            }
        })
    }

</script>