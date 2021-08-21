

<div id="contenutoimmagini"></div>



<form enctype="multipart/form-data" id="form-id" method="post">
    @csrf
    <input name="nomefile" type="file" />
    <input class="button" type="button" value="Upload" />
</form>
<progress value="0"></progress>

    <br>

<script>
    $(document).ready(function(){

    //html5 uploader
    $('.button').click(function(){
        var formx = document.getElementById('form-id');
        var formData = new FormData(formx);
        $.ajax({
            url: '{{url("admin/upload-images-for-pattern")}}',  //Server script to process data
            type: 'POST',
            xhr: function() {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){ // Check if upload property exists
                    myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
                }
                return myXhr;
            },
            //Ajax events
            success: completeHandler,
            error: errorHandler,
            // Form data
            data: formData,
            //Options to tell jQuery not to process data or worry about content-type.
            cache: false,
            contentType: false,
            processData: false
        });

        function completeHandler(){
            loadimages();
        }
        function errorHandler(){
            alert('errore caricamento');
        }
        function progressHandlingFunction(e){
            if(e.lengthComputable){
                $('progress').attr({value:e.loaded,max:e.total});
            }
        }
    });

        loadimages();

    });

    function inserisci(elemento){
        var link = $(elemento);
        var image = link.data('image');

        $('#img-url').val(image);
        $('#imgContent').children('img').attr('src', image);
        $('#mediagallery').slideUp();
        $('#thepref').slideDown();
    }

    function loadimages(){

        var request = $.ajax({
            url: "{{url('admin/show-all-images')}}",
            method: "POST",
            data: { _token : '{{csrf_token()}}' },
            dataType: "html"
        });

        request.done(function( msg ) {
            $( "#contenutoimmagini" ).html( msg );
        });

    }
</script>
