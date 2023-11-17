<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'image link',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | link',
        menubar: false
    });

    let emailsForm = document.querySelectorAll(".form__container form")

    document.addEventListener("click", event => {
        if(event.target.classList.contains("acc__toggle")){
            let elHeight = getComputedStyle(event.target.closest('.form__container').querySelector("form")).getPropertyValue('height')

            let noHeightEl = event.target.nextElementSibling.closest('.form__container').querySelector(".form__target")

            if (!noHeightEl.classList.contains('open')) {
                    noHeightEl.style.height = parseInt(elHeight) + 'px'
                    noHeightEl.style.overflow = 'hidden'
                
                    noHeightEl.classList.toggle('open')

                    
                } else {
                    noHeightEl.style.height = '0px'
        
                    noHeightEl.classList.toggle('open')
                }
        }
        if(event.target.classList.contains("fa-angle-down") || event.target.classList.contains("fa-envelope")){
            console.log('true')
            let elHeight = getComputedStyle(event.target.parentElement.closest('.form__container').querySelector("form")).getPropertyValue('height')

            let noHeightEl = event.target.parentElement.nextElementSibling.closest('.form__container').querySelector(".form__target")

            if (!noHeightEl.classList.contains('open')) {
                    noHeightEl.style.height = parseInt(elHeight) + 'px'
                    noHeightEl.style.overflow = 'hidden'
                
                    noHeightEl.classList.toggle('open')

                    
                } else {
                    noHeightEl.style.height = '0px'
        
                    noHeightEl.classList.toggle('open')
                }
        }
    })
</script>