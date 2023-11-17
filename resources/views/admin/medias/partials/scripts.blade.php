<script>
    let media_file = document.querySelector("#file")
    let preview_file = document.querySelector("#preview_file_link")
    let delete_file_value = document.querySelector("#delete_file_value")

    file.addEventListener("change", c => {
        const [file] = media_file.files
        if(media_file){
            let url_media_file = URL.createObjectURL(file)
            preview_file.href = url_media_file
            preview_file.innerHTML = url_media_file.replace('blob:', '')
        }
    })

    delete_file_value.addEventListener("click", e => {
        media_file.value = ""
        preview_file.href = ""
        preview_file.innerHTML = ""
    })

    media_file.addEventListener('change', d => {
        let file_size = media_file.files[0].size / 1024
        if(file_size > 8092) {
            alert('File size must be less than 8MB')
            media_file.value = ""
            preview_file.href = ""
            preview_file.innerHTML = ""
        }
        
    })


</script>