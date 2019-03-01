<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Drag&Drop sortable image upload</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.5.1/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
        <!-- if using RTL (Right-To-Left) orientation, load the RTL CSS file after fileinput.css by uncommenting below -->
        <!-- link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.5.1/css/fileinput-rtl.min.css" media="all" rel="stylesheet" type="text/css" /-->
        <!-- the font awesome icon library if using with `fas` theme (or Bootstrap 4.x). Note that default icons used in the plugin are glyphicons that are bundled only with Bootstrap 3.x. -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
        <link rel="stylesheet" href="/css/main.css">
        <!-- Styles -->

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Drag&Drop sortable image upload
                </div>
                    <form action="">
                        {{ csrf_field() }}
                        <input id="input-id" type="file" class="file"  name="images" multiple data-preview-file-type="text" >
                    </form>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
        <!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you
            wish to resize images before upload. This must be loaded before fileinput.min.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.5.1/js/plugins/piexif.min.js" type="text/javascript"></script>
        <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview.
            This must be loaded before fileinput.min.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.5.1/js/plugins/sortable.min.js" type="text/javascript"></script>
        <!-- purify.min.js is only needed if you wish to purify HTML content in your preview for
            HTML files. This must be loaded before fileinput.min.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.5.1/js/plugins/purify.min.js" type="text/javascript"></script>
        <!-- bootstrap.min.js below is needed if you wish to zoom and preview file content in a detail modal
            dialog. bootstrap 4.x is supported. You can also use the bootstrap js 3.3.x versions. -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <!-- the main fileinput plugin file -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.5.1/js/fileinput.min.js"></script>
        <script>
            $("#input-id").fileinput({
                showUpload: true,
                overwriteInitial:false,
                maxFileCount: 25,
                initialPreviewAsData: true,
                maxFileSize: 100000,
                allowedFileTypes: ["image"],
                initialPreview: [
                    @foreach($imagesPreview as $preview)
                    {!! '"'.$preview .'"'. ',' !!}
                    @endforeach
                ],
                initialPreviewConfig: [
                    @foreach($imagesConfig as $config)
                    {!! $config . ','!!}
                    @endforeach
                ],
                uploadUrl: 'upload-image',
                uploadExtraData: function() {
                    console.log($("input[name='_token']").val());
                    return {
                        _token: $("input[name='_token']").val()
                    };
                },
                deleteExtraData: function() {
                    return {
                        _token: $("input[name='_token']").val()
                    };
                }
            }).on('filesorted', function(e, params) {
                $.ajax({
                    url: "sort-image",
                    type: "POST",
                    data: {"images":params},
                    success: function (message) {
                        toastr.success(message);
                    }
                });
            }).on('filedeleted', function(message) {
                console.log(message);
                toastr.success(message);
            });
        </script>
    </body>
</html>
