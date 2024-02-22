<script>
    let addConvTrigger = document.querySelector(".new__conversation__trigger")
    let addConvPopup = document.querySelector(".new__conversation__popup")
    let closePopup = document.querySelector(".popup__close")
    // open popup
    document.addEventListener("click", ev => {
        if(ev.target.classList.contains("new__conversation__trigger")) {
            addConvPopup.classList.add("flex")
        }
    })
    closePopup.addEventListener("click", c => {
       addConvPopup.classList.remove("flex")
    })

    let cbs = document.querySelectorAll(".conversation__bookmark")
    for(let cb of cbs){
        cb.addEventListener("click", cb => {
            let xhttp = new XMLHttpRequest();
            let convId = cb.target.closest('.conv__container').getAttribute('data-post-id')
            let Params = 'convid=' + encodeURIComponent(convId)
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4) {
                    if (this.status === 200) {
                            cb.target.classList.toggle('bookmarked')
                        xhttp = null;
                    } else {
                        console.error("Error");
                    }
                }
            };
            // Deleting the parent comment and its associated replies
            xhttp.open("POST", `{{ route('conversation.bookmark') }}`, true);
            xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(Params);
        })
    }
</script>