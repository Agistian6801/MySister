<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>MY SISTER SCHOOL | DAFTAR DULU</title>
  {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha512-tDXPcamuZsWWd6OsKFyH6nAqh/MjZ/5Yk88T5o+aMfygqNFPan1pLyPFAndRzmOWHKT+jSDzWpJv8krj6x1LMA==" crossorigin="anonymous" /> --}}
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
  <!-- Bootstrap core CSS -->
  {{-- <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet"> --}}
  <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet">
  
  <!-- Material Design Bootstrap -->
  <link href="{{asset('css/mdb.min.css')}}" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="{{asset('css/style.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style type="text/css">
    body{
        /* background-color:lightgrey; */
        background:transparent url("photos/bkg.jpg") no-repeat;
        background-size:cover;
        width: 100%;
        height: 100%;
        /* background-repeat: no-repeat; */
    }

    #content{
        margin-top:50px;
        /* box-shadow:20px; */
    }
  </style>
</head>

<body>
    
<div class="container-scroller" >

    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="row justify-content-center" >
        <div class="col-md-8" id="content">
            <div class="card">
                <div class="card-header">Lanjut Daftar Sebagai Anggota !</div>

                <div class="card-body">
                    <form name="frmanggota" method="POST" action="{{ URL::to('svanggota') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="user_id" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="user_id" type="hidden" class="form-control @error('user_id') is-invalid @enderror" name="user_id" value="{{ Auth::User()->id }}" readonly>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::User()->name }}" readonly>

                                @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="alamat" class="col-md-4 col-form-label text-md-right">{{ __('Alamat') }}</label>

                            <div class="col-md-6">
                                <textarea id="alamat" type="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" required ></textarea>

                                @error('alamat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="jk" class="col-md-4 col-form-label text-md-right">{{ __('Jenis Kelamin') }}</label>
                            <div class="col-md-6">
                                
                                <input class="form-controller @error('jk') is-invalid @enderror" type="radio" id="male" name="jk" value="0" required>
                                <label for="male">Male</label>
                                <input class="form-controller @error('jk') is-invalid @enderror" type="radio" id="female" name="jk" value="1" required>
                                <label for="female">Female</label>

                                @error('jk')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="selkelas" class="col-md-4 col-form-label text-md-right">{{ __('Kelas') }}</label>

                            <div class="col-md-6">
                               
                                <select class="form-control" name="selkelas" id="selkelas">
                           
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="no_telp" class="col-md-4 col-form-label text-md-right">{{ __('No Telp') }}</label>

                            <div class="col-md-6">
                             
                                <input id="no_telp" type="text" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp" required autocomplete="new-no_telp">

                                @error('no_telp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-3 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Selesai
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
      <!-- content-wrapper ends -->
    </div>
		<!-- page-body-wrapper ends -->
    </div>
     <!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="{{asset('js/jquery-3.4.1.min.js')}}"></script>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha512-Ah5hWYPzDsVHf9i2EejFBFrG2ZAPmpu4ZJtW4MfSgpZacn+M9QHDt+Hd/wL1tEkk1UgbzqepJr6KnhZjFKB+0A==" crossorigin="anonymous"></script> --}}
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="{{asset('js/popper.min.js')}}"></script>
    <!-- Bootstrap core JavaScript -->
    
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="{{asset('js/mdb.min.js')}}"></script>
    <!-- Initializations -->

     <script type="text/javascript">
        $(function () {

            let isikelas = '';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            new WOW().init();

            function getkelas() {
                const url = 'http://127.0.0.1:8000/getKelas';
                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: "JSON",
                    success: function (response) {
                    //  console.log(response);

                        response.forEach(el => {
                            isikelas +=`
                            <option value="${el.id}">${el.kelas} ${el.jurusan} ${el.ruang}</option>
                            
                            `;
                        });

                        $('#selkelas').append(isikelas);
                    }
                });
            }

            $('#frmanggota').on('submit', function (e) {
                e.preventDefault();
                let frmanggota = new FormData(this);

                $.ajax({
                         type: "POST",
                         url: "{{route('svanggota')}}",
                         data: frmanggota,
                         cache:false,
                        contentType: false,
                        processData: false,
                        complete: function(response){
                            if($.isEmptyObject(response.responseJSON.error)){
                              console.log(response);
                                

                            }
                        }
                     });
            });

            getkelas();
        });
     </script>
</body>

</html>

