<script>
    // open add new event
    document.addEventListener("click", e => {
        if(e.target.classList.contains("add__new__event") || e.target.classList.contains("fa-plus")) {
            document.querySelector(".new__event__container").classList.add("flex")
            document.querySelector("body").style.overflowY = "hidden"
        }
    })
    
    // close add new event
    document.addEventListener("click", c => {
        if(c.target.classList.contains("fa-close") || c.target.classList.contains("close__container")) {
            document.querySelector(".new__event__container").classList.remove("flex")
            document.querySelector("body").style.overflowY = "auto"
        }
    })
</script>