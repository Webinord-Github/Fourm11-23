<script>
    document.querySelector("#title").addEventListener("blur", e => {
    let title = document.querySelector("#title")
    let slug = document.querySelector("#url")

    slug.value = e.currentTarget.value
        .toLowerCase()
        .replace(/[^a-z0-9-]+/g, '-')
        .replace(/^-+|-+$/g, '')
    })

    let slug = document.querySelector("#url")

    slug.addEventListener("blur" , ku => {
        slug.value = hu.currentTarget.value
        .toLowerCase()
        .replace(/[^a-z0-9-]+/g, '-')
        .replace(/^-+|-+$/g, '')
    })

    tinymce.init({
        selector: 'textarea',
        plugins: 'image link',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | link',
        menubar: false
    });
</script>

