<script>
    let toolBookmarks = document.querySelectorAll(".tool__bookmark__container")
    for (let bookmark of toolBookmarks) {
        bookmark.addEventListener("click", e => {
            let xhttp = new XMLHttpRequest()
            let toolId = e.target.closest('.single__tool').dataset.toolId
            let Params = "tool_id=" + encodeURIComponent(toolId)
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4) {
                    if (this.status === 200) {
                        e.target.classList.toggle('bookmarked')
                        if (e.target.nextElementSibling.innerHTML == "Sauvegarder") {
                            e.target.nextElementSibling.innerHTML = "Retirer"
                        } else {
                            e.target.nextElementSibling.innerHTML = "Sauvegarder"
                        }
                        console.log('Outil sauvegardé dans les favoris')

                        xhttp = null;
                    } else {
                        console.error("Erreur lors de la sauvegarde de l'outil");
                    }
                }
            };
            xhttp.open("POST", `{{route('signet-tool')}}`, true);
            xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(Params)
        })
    }
    let blogBookmarks = document.querySelectorAll(".post__bookmark__container")
    for (let bookmark of blogBookmarks) {
        bookmark.addEventListener("click", e => {
            let xhttp = new XMLHttpRequest()
            let blogId = e.target.closest('.single__blog').id
            console.log(blogId)
            let Params = "blog_id=" + encodeURIComponent(blogId)
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4) {
                    if (this.status === 200) {
                        e.target.classList.toggle('bookmarked')
                        // if (e.target.nextElementSibling.innerHTML == "Sauvegarder") {
                        //     e.target.nextElementSibling.innerHTML = "Retirer"
                        // } else {
                        //     e.target.nextElementSibling.innerHTML = "Sauvegarder"
                        // }
                        console.log('Outil sauvegardé dans les favoris')

                        xhttp = null;
                    } else {
                        console.error("Erreur lors de la sauvegarde de l'outil");
                    }
                }
            };
            xhttp.open("POST", `{{route('blog-bookmarks')}}`, true);
            xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(Params)
        })
    }

</script>