@extends('layouts.app')
@section('style')
    <!-- jQuery -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>

@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-8 ">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item"><a href="/albums">Albums</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
            @include('layouts.message')
            <div class="bg-white p-5 rounded">
                <form method="POST" action="/albums">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Name</label>
                        <input type="text" required class="form-control" name="name" value="{{old('name')}}" >
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Pictures</label>
                        <input  type="hidden" id="pictures" name="pictures" value="{{old('pictures')}}">

                        <div>
                            <div id="myDropzone" class="dropzone"></div>

                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
@section('script')
    <script>

        var pictures_files=[]

        Dropzone.autoDiscover = false;

        var myDropzone
        function dropOnInit(){
            var myDropzone = new Dropzone(".dropzone", {
                url: "/upload-picture",
                method: "POST",
                paramName: "file",
                autoProcessQueue : true,
                acceptedFiles: "image/*",
                maxFiles: 5,
                maxFilesize: 50, // MB
                uploadMultiple: false,
                parallelUploads: 100, // use it with uploadMultiple
                createImageThumbnails: true,
                thumbnailWidth: 120,
                thumbnailHeight: 120,
                addRemoveLinks: true,
                timeout: 180000,
                dictRemoveFileConfirmation: "Are you Sure?", // ask before removing file
                // Language Strings
                dictFileTooBig: "Max size 50M",
                dictInvalidFileType: "Invalid File Type",
                dictCancelUpload: "Cancel",
                dictRemoveFile: "Remove",
                dictMaxFilesExceeded: "Only  files are allowed",
                dictDefaultMessage: "Drop files here to upload",
            });
            myDropzone.on("addedfile", function(file) {
                console.log(file);
            });

            myDropzone.on("removedfile", function(file) {
                var result = arrayRemove(pictures_files, parseInt(file.xhr.responseText));
                pictures_files=result
                $('#pictures').val(pictures_files)
                if(pictures_files.length>0){
                    deletePicture(file)
                }
            });

// Add mmore data  (optional)
            myDropzone.on("sending", function(file, xhr, formData) {
                formData.append("dropzone", "1"); // $_POST["dropzone"]
                formData.append("_token", "{{ csrf_token() }}");
            });

            myDropzone.on("error", function(file, response) {
                console.log(response);
            });

// on success
            myDropzone.on("successmultiple", function(file, response) {
                console.log(response);
            });
            myDropzone.on("complete", function(file) {
                // alert('a')
                // console.log(file);
            });
            myDropzone.on("success", function(file,responseText) {
                pictures_files.push(parseInt(responseText))
                $('#pictures').val(pictures_files)

            });

        }
        function arrayRemove(arr, value) {

            return arr.filter(function(geeks){
                return geeks != value;
            });

        }
        function deletePicture(file){

            var form_data = {
                id : file.xhr.responseText,
            }

            var resp_data_format="";
            $.ajax({
                url:"/delete-picture",
                data : form_data,
                method : "POST",
                dataType : "json",
                headers:{'X-CSRF-TOKEN': "{{csrf_token()}}"},
                success : function(response) {

                    // alert('deleted')
                }
            });
        }
        dropOnInit()
    </script>
@endsection
