<!DOCTYPE html>
<html>
<head>
    <title>Laravel 7 Ajax Image Upload</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha256-WqU1JavFxSAMcLP2WIOI+GB2zWmShMI82mTpLDcqFUg=" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style type="text/css">
        .mt-5{
            margin-top: 150px !important; 
        }
        body{
            background: #423E3D;
        }
    </style>
</head>
<body class="bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-3 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h5>Laravel 7 Ajax Image Upload - NiceSnippets.com</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <div class="success alert alert-success">
                            Image Upload Successfully
                        </div>
                        <form enctype="multipart/form-data" id="imageUpload">
                            <div class="form-group">

                                <label><strong>Image : </strong></label>
                                <input type="file" name="image" class="form-control">

                                <label><strong>Keterangan : </strong></label>
                                <textarea class="form-control" name="ket" id="ket"></textarea>
                               
                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-success">Save</button>
                            </div>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    <script type="text/javascript">
        $(document).ready(function () {
            $('.success').hide();// or fade, css display however you'd like.
        });

        $('#imageUpload').on('submit',(function(e) {
            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
             
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
               type:'POST',
               url: "{{ route('simpangambar')}}",
               data:formData,
               cache:false,
               contentType: false,
               processData: false,
             
                 complete: function(response) 
                {
                    if($.isEmptyObject(response.responseJSON.error)){
                            $('.success').show();
                           setTimeout(function(){
                           $('.success').hide();
                        }, 5000);
                    }else{
                        printErrorMsg(response.responseJSON.error);
                    }
                }

            });
        }));
       function printErrorMsg(msg){
               $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
       }
    </script>
</body>
</html>