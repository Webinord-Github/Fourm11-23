<script>
    let formButtons = document.querySelectorAll(".form__button")
    for(let formButton of formButtons){
        formButton.addEventListener("click", f => {
          document.querySelector(".loading__container").classList.add("flex")

        })
    }
</script>