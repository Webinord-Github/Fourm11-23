<script>
    let adminDropdowns = document.querySelectorAll(".admin-dropdown")
    for (let i = 0; i < adminDropdowns.length; i++) {
        adminDropdowns[i].addEventListener("click", e => {
            for (let adminDropdown of adminDropdowns) {
                adminDropdown.parentElement.childNodes[3].classList.remove("openDropdown")
            }
            e.currentTarget.parentElement.childNodes[3].classList.toggle("openDropdown")
        })
    }


    document.addEventListener("click", a => {
        if (!a.target.className.toString().includes('admin-dropdown')) {
            for (let i = 0; i < adminDropdowns.length; i++) {
                adminDropdowns[i].parentElement.childNodes[3].classList.remove("openDropdown");
            }
        }
    })
</script>

<style>
    .openDropdown {
        height: auto;
    }
</style>