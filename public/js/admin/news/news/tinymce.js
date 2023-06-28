tinymce.init({
    selector: '.text_tinymce',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | fontsize | bold italic underline | link image table | align | numlist bullist  ',
    buttons: "Upload ImgPen",
    a11y_advanced_options: true,
    menubar: false,
    height : "235",
    width : "100%",


    file_picker_types: 'file image media',
    image_uploadtab: true,
    images_file_types: 'jpg,png,svg,webp',

    image_title: true,
    automatic_uploads: true,

    file_picker_callback: function (cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');

        input.onchange = function () {
            var file = this.files[0];

            var reader = new FileReader();
            reader.onload = function () {

                var id = 'blobid' + (new Date()).getTime();
                var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);

                cb(blobInfo.blobUri(), { title: file.name });
            };
            reader.readAsDataURL(file);
        };

        input.click();
    },
});
