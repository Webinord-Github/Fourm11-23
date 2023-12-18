<script>
    document.addEventListener("DOMContentLoaded", function() {
    // Your TinyMCE initialization script here
    var textareas = document.querySelectorAll('.editor');

    textareas.forEach(function(textarea) {
        tinymce.init({
            selector: "#editor", 
            plugins: 'image link',
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | link',
            menubar: false
        });
    });
});
</script>