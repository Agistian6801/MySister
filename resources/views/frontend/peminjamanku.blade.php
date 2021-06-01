<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>MY SISTER SCHOOL</title>
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
    html,
    body,
    header,
    .carousel {
      height: 60vh;
    }

    @media (max-width: 740px) {

      html,
      body,
      header,
      .carousel {
        height: 100vh;
      }
    }

    @media (min-width: 800px) and (max-width: 850px) {

      html,
      body,
      header,
      .carousel {
        height: 100vh;
      }
    }

    .test {
    width: 20px;
    height: 20px;
    background-color: yellow;
    }

    #pjmku {
      margin-top: 125px;
      margin-bottom: 125px;
    }

  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
    <div class="container">

      <!-- Brand -->
     <img src="{{asset('photos/logo.png')}}" alt="logo"  style="height:7%;width:7%;">
      <!-- Collapse -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Links -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <!-- Left -->
        <ul class="navbar-nav mr-auto">
          <li class="nav-item ">
            <a class="nav-link waves-effect" href="{{URL::to('/')}}">Halaman Utama
            </a>
          </li>
          @if (Auth::check())
          <li class="nav-item active">
            <a class="nav-link waves-effect" href="{{URL::to('/peminjamanku')}}" target="_blank">Peminjamanku</a>
          </li>
          @endif
        </ul>

        <!-- Right -->
        <ul class="navbar-nav nav-flex-icons">
          <li class="nav-item">
            <a  class="nav-link waves-effect">
              {{-- {{ Auth::user()->name }} --}}
            </a>
          </li>
          
          @guest
          @if (Route::has('login'))
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
              </li>
          @endif
          
          @if (Route::has('register'))
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
              </li>
          @endif
          @else
          <li class="nav-item">
            <a  class="nav-link waves-effect">
              <b>{{ Auth::user()->name }} |</b>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link waves-effect" href="{{ route('logout') }}" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">Logout</a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
          </li>
          @endguest
        </ul>

      </div>

    </div>
  </nav>
  <!-- Navbar -->

  {{-- ini modal --}}
  <div class="modal fade" id="mdlcart" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg  modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="title">Cart Peminjaman</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        {{-- <span aria-hidden="true">&times;</span> --}}
                        <div class="test rounded-circle bg-danger"></div>
                        </button>
                    </div>
                    <form id="frmpinjam" action="{{ URL::to('') }}" method="post" >
                    @csrf
                        <div class="modal-body">
                            <div id="dvpeminjaman">
                                <table id="tblcart" class="table">
                                  <thead>
                                    <tr>
                                      <th>No</th>
                                      <th>Serial Number</th>
                                      <th>Nama Barang</th>
                                      <th>Lokasi</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                   
                                    
                                  </tbody>
                                </table>
                            </div>
                        </div>        
                        <div class="modal-footer">
                           
                            <div class="col-md-3">
                            <label>Tanggal Kembali : </label>
                            </div>
                            <div class="col-md-4 offset-col-md-2">
                            <input type="datetime-local" id="tanggal_kembali" name="tanggal_kembali" class="form-control">
                            </div>
                            <div class="col-md-3">
                            <button id="btncheckout" type="submit" class="btn btn-success">Check Out</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
  {{-- ini end modal --}}


  {{-- Modal lihat anggota peminjam --}}
        
        <div class="modal fade" id="mdllihat" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Anggota Peminjam</h5>
                        <button type="button" id="closecc" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                  
                        <div class="modal-body">
                            <div id="dvlihat">
                                
                            </div>
                        </div>
                   
                </div>
            </div>
        </div>


  <!--Main layout-->
  <main>
    <div class="container" id="pjmku">
  
      <div class="row">
              <div class="col-md-12 stretch-card grid-margin">
                <div class="card">
                  <div class="card-body shadow">
                        <div class="row">
                            
                            <div class="col-sm-8 offset-sm-2 ">
                                <form id="frmcari" class="d-flex align-items-center shadow">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <i class="input-group-text border-0 mdi mdi-magnify"></i>
                                        </div>
                                        <input type="text" class="form-control border-0" id="tcari" name="tcari" placeholder="Search" />
                                    </div>
                                </form>
                            </div>
                        </div>
                        <br>
                            
                            <div class="table-responsive" id="cltbl">
                            {{-- <input type="text" class="form-control" name="anggotaid" id="anggotaid" value="" /> --}}
                                <table id="tblpj" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <td>No</td>
                                            <td>ID Peminjaman</td>
                                            <td> Tanggal Pinjam</td>
                                            <td>Tanggal Kembali</td>
                                            <td>Kode SN Barang</td>
                                            <td >Barang</td>
                                            <td>Anggota Peminjam</td>
                                            <td >Status</td>
                                            
                                        </tr>
                                        </thead>
                                        <tbody>
                                        
                                        </tbody>
                                </table>
                            </div>
                        
                        
                  </div>
                </div>
              </div>
        </div>

      <!--Section: Products v.3-->
      <section class="text-center mb-4">

        <!--Grid row-->
        <div id="dvrow" class="row wow fadeIn">

         

        </div>
        <!--Grid row-->

      </section>
      <!--Section: Products v.3-->

      {{-- <!--Pagination-->
      <nav class="d-flex justify-content-center wow fadeIn">
        <ul class="pagination pg-blue">

          <!--Arrow left-->
          <li class="page-item disabled">
            <a class="page-link" href="#" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
              <span class="sr-only">Previous</span>
            </a>
          </li>

          <li class="page-item active">
            <a class="page-link" href="#">1
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">2</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">3</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">4</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">5</a>
          </li>

          <li class="page-item">
            <a class="page-link" href="#" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
              <span class="sr-only">Next</span>
            </a>
          </li>
        </ul>
      </nav>
      <!--Pagination--> --}}

    </div>
  </main>
  <!--Main layout-->

  <!--Footer-->
  <footer class="page-footer fixed-bottom text-center font-small mt-4 wow fadeIn" >

    <!--Call to action-->
    <div class="pt-4">
      <p>
        Human made technology, but it's technology help people more.
      </p>
    </div>
    <!--/.Call to action-->

    <!--Copyright-->
    <div class="footer-copyright py-3">
      © 2021 Copyright:
      <a href="">Muhammad Dhzuhri Agistian</a>
    </div>
    <!--/.Copyright-->

  </footer>
  <!--/.Footer-->

  <!-- SCRIPTS -->
  <!-- JQuery -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
    
    // 

    $(function () {

      let isi = '';
      let isicc = '';

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      new WOW().init();
      
      function delay(callback, ms) {
          var timer = 0;
          return function() {
              var context = this, args = arguments;
              clearTimeout(timer);
              timer = setTimeout(function () {
              callback.apply(context, args);
              }, ms || 0);
          };
      }

      $('#cari').keyup(delay(function (e) {
        let merk = this.value;
        
        
        if (merk === "") {
            url = '';
            
        } else {
            url = '' + merk;
            
        }

        

                    
      }, 500));

      function cariAnggota() {
            var id = {!! auth()->id() !!};

              
            const urlpin = 'http://127.0.0.1:8000/home/getanggotaid/' + id;

            $.ajax({
                type: "GET",
                url: urlpin,
                dataType: "JSON",
                success: function (response) {
                    // console.log(response);
                    response.forEach(el => {
                      // $('#anggotaid').val(el.id);
                      // console.log(el);
                      idpeminjaman = el.id;
                      getpeminjaman(idpeminjaman)
                    });
                   
                } 
            });

            

      }

      cariAnggota();

      function getpeminjaman(idpeminjaman) {
          
          // let id = $('#anggotaid').text();
          console.log(idpeminjaman);

           const url = 'http://127.0.0.1:8000/getpeminjamans/'+ idpeminjaman;

          console.log(url);

          $.ajax({
              type: "GET",
              url: url,
              dataType: "JSON",
              success: function (response) {
                  console.log(response);
                   $('#tblpj').find("tr").slice(1).remove()
                                
                                isi = '';
                                let no_urut = 1;
                                response.forEach(el => {
                                    isi +=`
                                        <tr>
                                            <td>${no_urut}</td>
                                            <td class="nr">${el.idpj}</td>
                                            <td> ${el.tanggal_pinjam}</td>
                                            <td>${el.tanggal_kembali}</td>
                                            <td >${el.SN}</td>
                                            <td >${el.merk}</td>
                                            <td><button id="btnlihat" class="btn btn-primary"><i class="fa fa-eye"></i></button></td>
                                            <td >${el.status == '1' ? '<span class="badge badge-success">Returned</span>': el.status == '2' ? '<span class="badge badge-danger">Late</span>' :  el.status == '3' ? '<span class="badge badge-danger">Returned</span>' : '<span class="badge badge-warning">On Borrowed</span>'}</td>
                                            
                                        </tr>
                                    `;
                                    no_urut += 1;
                                });

                                $('#tblpj').append(isi);
                                // $("#tblpj").rowspanizer({vertical_align: 'middle'});
                  // $("#tblpj").rowspanizer({vertical_align: 'middle'});
              }
          });
      }

      getpeminjaman();

      $("#mdllihat").on("hidden.bs.modal", function(){
          $("#dvlihat").html("");
      });
                    
      $('#tblpj').on('click', '#btnlihat', function (e) {
          var $id = $(this).closest("tr")   // Finds the closest row <tr> 
          .find(".nr")     // Gets a descendent with class="nr"
          .text();         // Retrieves the text within <td>
          // console.log($id);
          const url = 'http://127.0.0.1:8000/lihat/' + $.trim($id) + '/cc';
          // console.log(url);

          
          $('#mdllihat').modal('show')
          // isicc = '';
          $.ajax({
              type: "GET",
              url: url,
              dataType: "JSON",
              success: function (response) {
                  // console.log(response);
                  isicc = '';
                  response.forEach(el => {
                      isicc +=`
                          <input type="text" class="form-control" value="${el.name}" readonly>
                          <br>
                      `;

                  });

                  $('#dvlihat').append(isicc);
              }
          });
      });

    });

  </script>
</body>

</html>

