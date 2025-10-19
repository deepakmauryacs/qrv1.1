document.addEventListener("DOMContentLoaded", function () {
    const descriptionField = document.querySelector("#description");
    
    if (descriptionField) { // Check if the element exists
        ClassicEditor
            .create(descriptionField, {
                toolbar: ["heading", "bold", "bulletedList", "numberedList", "italic", "link", "undo", "redo"]
            })
            .then(editor => {
                window.descriptionEditor = editor; // Store editor instance globally
            })
            .catch(error => {
                console.error("CKEditor Initialization Error:", error);
            });
    }
});
