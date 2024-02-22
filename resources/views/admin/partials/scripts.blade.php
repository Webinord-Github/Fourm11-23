<script>
    document.addEventListener("click", e => {
        if(e.target.classList.contains("dropdown__trigger")) {
            let parent = e.target.closest(".navLink")
            let hiddenContent = parent.querySelector(".admin__menu__dropdown__container")
            let heightContent = hiddenContent.querySelector(".admin__menu__dropdown__content")
            let hCalc = getComputedStyle(heightContent).getPropertyValue("height")
            let heightValue = parseInt(hCalc)
            e.target.classList.toggle("openDropdown")
            if(e.target.classList.contains("openDropdown")){
                hiddenContent.style.height = heightValue + "px"
                hiddenContent.style.transition = "height 0.2s linear"
                parent.querySelector(".fa-angle-down").style.transform = "rotate(180deg)"
                parent.querySelector(".fa-angle-down").style.transition = "transform 0.2s linear"
            } else {
                hiddenContent.style.height = "0px"
                hiddenContent.style.transition = "height 0.2s linear"
                parent.querySelector(".fa-angle-down").style.transform = "rotate(0deg)"
                parent.querySelector(".fa-angle-down").style.transition = "transform 0.2s linear"
            }
        }
    })
</script>