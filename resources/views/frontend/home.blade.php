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
          <li class="nav-item active">
            <a class="nav-link waves-effect" href="{{URL::to('/')}}">Halaman Utama
            </a>
          </li>
          @if (Auth::check())
          <li class="nav-item">
            <input type="hidden" name="authid" id="authid" value="{{Auth::User()->id}}" />
            <a class="nav-link waves-effect" href="{{URL::to('peminjamanku')}}">Peminjamanku</a>
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
          <li class="nav-item" id="cart">
            <a class="nav-link waves-effect" >
              <span class="badge red z-depth-1 mr-1" id="notifcart"> 0 </span>
              <i class="fas fa-shopping-cart"></i>
              <span class="clearfix d-none d-sm-inline-block"> Cart </span>
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
                        <h5 class="modal-title" id="title"><b>Cart Peminjaman</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        {{-- <span aria-hidden="true">&times;</span> --}}
                        <div class="test rounded-circle bg-danger"></div>
                        </button>
                        
                    </div>
                    <br>
                        
                   
                        <div class="modal-body">
                          <input type="hidden" class="form-control" name="anggotaid" id="anggotaid" value="" />
                            <div id="dvpeminjaman">
                                <table id="tblcart" class="table">
                                  <thead>
                                    <tr>
                         
                                      <th>Nama Barang</th>
                                      <th>Lokasi</th>
                                      <th>Serial Number</th>
                                      <th>Kategori</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                   
                                    
                                  </tbody>
                                </table>
                            </div>
                            <hr>

                            <label><b>CC Peminjam :</b> </label> <button id="btntambah" type="submit" class="badge badge-primary">+</button>
                            <div id="dvanggota" class="row" style="margin-left:10px">
                              <select class="form-control col-md-5 " style="margin-bottom:5px;margin-left:5px;" name="selanggota" id="selanggota">
                                  <option value="-">-</option>
                              </select>
                            </div>
                        </div>        
                        <div class="modal-footer">
                           
                            <div class="col-md-3">
                            <label><b>Tanggal Kembali : </b></label>
                            </div>
                            <div class="col-md-4 offset-col-md-2">
                            <input type="datetime-local" id="tanggal_kembali" name="tanggal_kembali" class="form-control">
                            </div>
                            <div class="col-md-3">
                            <button id="btncheckout" type="submit" class="btn btn-success">Check Out</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
  {{-- ini end modal --}}


  <!--Carousel Wrapper-->
  <div id="carousel-example-1z" class="carousel slide carousel-fade pt-4" data-ride="carousel">

    <!--Indicators-->
    <ol class="carousel-indicators">
      <li data-target="#carousel-example-1z" data-slide-to="0" class="active"></li>
      <li data-target="#carousel-example-1z" data-slide-to="1"></li>
      <li data-target="#carousel-example-1z" data-slide-to="2"></li>
    </ol>
    <!--/.Indicators-->

    <!--Slides-->
    <div class="carousel-inner" role="listbox">

      <!--First slide-->
      <div class="carousel-item active">
        <div class="view" style="background-image: url('photos/slide1.jpg'); background-repeat: no-repeat; background-size: cover;background-attachment: fixed;">

          <!-- Mask & flexbox options-->
          <div class="mask rgba-black-strong d-flex justify-content-center align-items-center">

            <!-- Content -->
            <div class="text-center white-text mx-5 wow fadeIn">
              <h1 class="mb-4">
                <strong>MY SISTER SCHOOL</strong>
              </h1>

              <p>
                <strong>SISTEM INFENTORI SEKOLAH</strong>
              </p>

              <p class="mb-4 d-none d-md-block">
                <strong>" With technology, we can rise up together "</strong>
              </p>
              
            </div>
            <!-- Content -->

          </div>
          <!-- Mask & flexbox options-->

        </div>
      </div>
      <!--/First slide-->

      <!--Second slide-->
      <div class="carousel-item">
        <div class="view" style="background-image: url('photos/slide2.jpg'); background-repeat: no-repeat; background-size: cover;background-attachment: fixed;">

          <!-- Mask & flexbox options-->
          <div class="mask rgba-black-strong d-flex justify-content-center align-items-center">

            <!-- Content -->
            <div class="text-center white-text mx-5 wow fadeIn">
              <h1 class="mb-4">
                <strong>MY SISTER SCHOOL</strong>
              </h1>

              <p>
                <strong>SISTEM INFENTORI SEKOLAH</strong>
              </p>

              <p class="mb-4 d-none d-md-block">
                <strong>" With technology, we can rise up together "</strong>
              </p>
            </div>
            <!-- Content -->

          </div>
          <!-- Mask & flexbox options-->

        </div>
      </div>
      <!--/Second slide-->

      <!--Third slide-->
      <div class="carousel-item">
        <div class="view" style="background-image: url('photos/slide3.png'); background-repeat: no-repeat; background-size: cover;background-attachment: fixed;">

          <!-- Mask & flexbox options-->
          <div class="mask rgba-black-strong d-flex justify-content-center align-items-center">

            <!-- Content -->
            <div class="text-center white-text mx-5 wow fadeIn">
              <h1 class="mb-4">
                <strong>MY SISTER SCHOOL</strong>
              </h1>

              <p>
                <strong>SISTEM INFENTORI SEKOLAH</strong>
              </p>

              <p class="mb-4 d-none d-md-block">
                <strong>" With technology, we can rise up together "</strong>
              </p>
            </div>
            <!-- Content -->

          </div>
          <!-- Mask & flexbox options-->

        </div>
      </div>
      <!--/Third slide-->

    </div>
    <!--/.Slides-->

    <!--Controls-->
    <a class="carousel-control-prev" href="#carousel-example-1z" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carousel-example-1z" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
    <!--/.Controls-->

  </div>
  <!--/.Carousel Wrapper-->

  <!--Main layout-->
  <main>
    <div class="container">

      <!--Navbar-->
      <nav class="navbar navbar-expand-lg navbar-dark mdb-color lighten-3 mt-3 mb-5">

        <!-- Navbar brand -->
        <span class="navbar-brand">Categories:</span>

        <!-- Collapse button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
          aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="basicExampleNav">

          <!-- Links -->
          <ul id="mnkategori" class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link">All
              
              </a>
            </li>
            

          </ul>
          <!-- Links -->

          <form class="form-inline">
            <div class="md-form my-0">
              <input class="form-control mr-sm-2" type="text" name="cari" id="cari" placeholder="Search" aria-label="Search">
            </div>
          </form>
        </div>
        <!-- Collapsible content -->

      </nav>
      <!--/.Navbar-->

      <div class="card-body">
          @if (session('status'))
              <div class="alert alert-success" role="alert">
                  {{ session('status') }}
              </div>
          @endif
   
      </div>

      <!--Section: Products v.3-->
      <section class="text-center mb-4">

        <!--Grid row-->
        <div id="dvrow" class="row wow fadeIn">

         

        </div>
        <!--Grid row-->

      </section>
      <!--Section: Products v.3-->

      <!--Pagination-->
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
      <!--Pagination-->

    </div>
  </main>
  <!--Main layout-->

  <!--Footer-->
  <footer class="page-footer text-center font-small mt-4 wow fadeIn">

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
      <a href="" >Muhammad Dhzuhri Agistian</a>
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

      let menukategori = '';
      let databarang = [];
      // buat variabel utk menampung isi
      let rowproduct = '';
      let isi = [];
      let data_cart = '';
      let cc = [];
      let isianggota = '';
      // variabel u/ localstorage
      let crtlocaltemporary = [];
      let crttemp_data = '';
      

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      new WOW().init();

      function getcartLocalStorage(){
        // localStorage.removeItem('localcart');

        if (localStorage.getItem('localcart') == null) {
          console.log('kosong');
        } else {
          console.log('tampilkan isi cart pinjam');

          let crt = localStorage.getItem('localcart');
          // console.log(crt);

          JSON.parse(crt, (key, value) => {
            if ((typeof value == 'string') || (typeof value == 'number')){
              console.log(value);
              
            }
            // if ((key == 'idbarang') ) {
            //   crtlocaltemporary.push(value);
            // }
            

            switch (key) {
              
              case 'merk':
                crttemp_data +=`
                 <tr> <td>${value}</td>
                `;
                break;
             
              case 'lokasi':
                crttemp_data +=`
                  <td>${value}</td>
                `;
                break;
              case 'SN':
                crttemp_data +=`
                  <td>${value}</td>
                `;
                break;
              case 'idbarang':
                crttemp_data +=`
                  <td><input type="hidden" name="nr" value="${value}">
                `;
                crtlocaltemporary.push(value);
                break;
              case 'kategori':
                crttemp_data +=`
                  ${value}</td> </tr>
                `;
                break;
              
                 
            }
          });

          

          console.log(`jumlah data = ${crtlocaltemporary.length}`);

          $('#notifcart').html(crtlocaltemporary.length);

          $('#tblcart').append(crttemp_data);
            
        }
      }

      getcartLocalStorage();
      
      function getkategori() {
        const url = 'http://127.0.0.1:8000/home/kategori';
        $.ajax({
          type: "GET",
          url: url,
          dataType: "JSON",
          success: function (response) {
            // console.table(response);

            response.forEach(el => {
              menukategori +=`
                  <li class="nav-item">
                    <a class="nav-link">${el.kategori}</a>
                  </li>
              `;
            });

            $('#mnkategori').append(menukategori);
            
          }
        });
      }

      function getPeminjam() {
          const url ='http://127.0.0.1:8000/home/getpeminjam';

          $.ajax({
              type: "GET",
              url: url,
              dataType: "JSON",
              success: function (response) {
                  response.forEach(el => {
                      isianggota += `
                          <option value="${el.id}">${el.name}</option>
                      `;
                  });

                  $('#selanggota').append(isianggota);
              }
          });
      }

      function getbarang() {
        const url = 'http://127.0.0.1:8000/home/getbarang';

        $.ajax({
          type: "GET",
          url: url,
          dataType: "JSON",
          success: function (response) {
            // console.table(response);

            databarang = [...response];  //ini pakai shallow copy
            // console.log(databarang);

            rowproduct = '';

            databarang.forEach(item => {
              // console.log(item.merk);
              rowproduct +=`
              <div id="dvproduct" class="col-lg-3 col-md-6 mb-4">

                <!--Card-->
                <div class="card">

                  <!--Card image-->
                  <div class="view overlay" style="text-center">
                    <img src="photos/${item.foto}" style="height:225px;width:225px;display: block; margin: auto;">
                  </div>
                  <!--Card image-->

                  <!--Card content-->
                  <div class="card-body text-center">
                    <!--Category & Title-->
                    <input type="hidden" name="idbarang" id="idbarang" value="${item.idbarang}">
                    <a href="" class="grey-text">
                      <span class="badge badge-pill warning-color" id="SN">${item.SN}</span>
                    </a>
                    <br>
                   
                    <h4>
                      <strong>
                        <a href="" class="dark-grey-text" id="merk">${item.merk}</a>
                      </strong>
                    </h4>

                    <h5 class="font-weight-bold blue-text">
                      <strong id="lokasi">${item.lokasi}</strong>
                    </h5>
                    <br>
                    <button id="btnpinjam" type="submit" class="btn btn-success"><i class="fas fa-hand-point-right"></i> PINJAM</button>
                  </div>
                  <!--Card content-->

                </div>
                <!--Card-->

              </div>
            `;
            });

            $('#dvrow').empty();

            $('#dvrow').append(rowproduct);
          }
          
        });
      }

      $('#mnkategori').on('click', 'li', function () {
        // console.log($.trim(this.innerText));

        if ($.trim(this.innerText).includes('All')) {
          // console.log('tampil semua');
          getbarang();
        }else{

          const filter_barang = databarang.filter((brg) => {
          return brg.kategori === this.innerText
        });
        
        // console.table(filter_barang);

        // $('#dvrow').empty();

        rowproduct = '';

        filter_barang.forEach((item) => {
          rowproduct +=`
              <div id="dvproduct" class="col-lg-3 col-md-6 mb-4">

                <!--Card-->
                <div class="card">

                  <!--Card image-->
                  <div class="view overlay">
                    <img src="photos/${item.foto}" height="225px" width="225px">
                    <a>
                      <div class="mask rgba-white-slight"></div>
                    </a>
                  </div>
                  <!--Card image-->

                  <!--Card content-->
                  <div class="card-body text-center">
                    <!--Category & Title-->
                   <input type="hidden" name="idbarang" id="idbarang" value="${item.idbarang}">
                    <a href="" class="grey-text">
                      <span class="badge badge-pill warning-color" id="SN">${item.SN}</span>
                    </a>
                   <br>
                    
                    <h4>
                      <strong>
                        <a href="" class="dark-grey-text" id="merk">${item.merk}
                          
                        </a>
                      </strong>
                    </h4>

                    <h5 class="font-weight-bold blue-text">
                      <strong id="lokasi">${item.lokasi}</strong>
                    </h5>
                    <br>
                    <button id="btnpinjam" type="submit" class="btn btn-success"><i class="fas fa-hand-point-right"></i> PINJAM</button>

                  </div>
                  <!--Card content-->
                  
                    
                 

                </div>
                <!--Card-->

              </div>
            `;
        });
        // console.log(rowproduct);
        $('#dvrow').empty();
        $('#dvrow').append(rowproduct);

        }
      });

      $('#dvrow').on('click','#btnpinjam', function () {
        // alert('diklik');
      
        let idbarang = $(this).parent().find('#idbarang').val();
        //   let sn = $(this).parent().find('#SN').text();
        //   let merk = $(this).parent().find('#merk').text();
        //   let lokasi = $(this).parent().find('#lokasi').text();
        
        //  isi.push({
        //    'id' : id,
        //    'SN' : sn,
        //    'merk' : merk,
        //    'lokasi' : lokasi
        //  })

          const isi_cart = databarang.filter( x => x.idbarang == idbarang);

          isi.push(isi_cart);

        $('#notifcart').html(isi.length);
        

        //  console.log(isi);

       //  let no_urut = 1 ;
      
        isi.forEach(data => {
          data_cart = '';
          data.forEach(item => {
            data_cart +=`
              <tr>
                  
                  
                  <td><input type="hidden" name="nr" value="${item.idbarang}"> ${item.merk}</td>
                  <td>${item.lokasi}</td>
                  <td>${item.SN}</td>
                  <td>${item.kategori}</td>
              </tr>
            `;
            // no_urut += 1 ;
          });
        });
        $('#tblcart').append(data_cart);

        var loggedIn = {{  auth()->check() ? 'true' : 'false' }};
          if (loggedIn) {
            localStorage.setItem('localcart', JSON.stringify(isi));
          }
       
      });

      $('#cart').on('click', function () {
        // console.log(isi);
        $('#mdlcart').modal('show');
        // $('#jum').html(crtlocaltemporary.length);
      });


      $('#btncheckout').on('click', function (e) {
        e.preventDefault();
        // localStorage.setItem('keranjang', isi);
        var loggedIn = {{  auth()->check() ? 'true' : 'false' }};
          if (loggedIn) {
            console.log('ambil data dari localstorage');
            console.log( localStorage.getItem('localcart') );
            svpeminjaman();
          }else{
            localStorage.setItem('localcart', JSON.stringify(isi));
           
            window.location.href = 'http://127.0.0.1:8000/login';
          }
      });

      function svpeminjaman(){
        let anggotaId = $('#anggotaid').val();
        let tanggal_kembali = $('#tanggal_kembali').val();

        let today = new Date();
        let date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        let time = today.getHours()+":"+today.getMinutes()+ ":" + today.getSeconds();
        let dateTime = date+' '+time;

        // $('#dvanggota').find('option:selected').each(function () { 
        //   cc.push($(this).val());
        // });;

        // let ccx = JSON.stringify(cc);
        
        const urlpeminjaman = 'http://127.0.0.1:8000/'

        $.ajax({
          type: "POST",
          url: urlpeminjaman,
          data: {
             'tanggal_pinjam' : dateTime,
              'tanggal_kembali' : tanggal_kembali,
              'anggota_id' : anggotaId,
              // 'cc_anggota' : ccx.replace(/[""]/g, "")
          },
          dataType: "JSON",
          success: function (response) {
              console.log(response);
              idpeminjaman = response; 
              simpanPeminjamanDetail(idpeminjaman);
          } 
        });

      }

      function simpanPeminjamanDetail(idpeminjaman) {
        
        const urlpdetail = 'http://127.0.0.1:8000/savepeminjamandetail';
 
            // console.log('ini adalah variabel isi');
            // console.log(isi);
            // console.log(crt);

            const crt = localStorage.getItem('localcart');
            console.log(crt);
            JSON.parse(crt, (key, value) => {
              if (key == 'idbarang') {
                // let peminjaman_id = response;
                let barang_id = value;
                let keterangan = '-';

                $.ajax({
                  type: "POST",
                  url: urlpdetail,
                  data: {
                    'peminjaman_id' : idpeminjaman,
                    'barang_id' : barang_id,
                    'keterangan' : keterangan
                  },
                  dataType: "json",
                  success: function (response) {
                    console.log(response);
                    svccpeminjam(idpeminjaman);
                    
                  }
                });
              }
            });   
      }

      function svccpeminjam(idpeminjaman) {
        
        const urlcc = 'http://127.0.0.1:8000/svccpeminjaman';

        $('#dvanggota').find('option:selected').each(function () { 
          // cc.push($(this).val());
          let scctext = $(this).val();
          console.log(scctext);
          
            cc.push({
                'peminjaman_id' : idpeminjaman,
                'anggota_id' : scctext
            });
          
          // console.log('isi dari cc peminjam');
          // console.log(cc);
        });

        $.ajax({
            type: "POST",
            url: urlcc,
            data: JSON.stringify(cc),
            dataType: "json",
            contentType: "application/json",
            processData: false,
            success: function (response) {
             console.log(response);  
            $('#mdlcart').modal('hide');
            window.location.href = 'http://127.0.0.1:8000/peminjamanku';
            swal("Sukses!", "Berhasil Pinjam", "success");
            localStorage.removeItem('localcart');
            }
        });
      }

      function cariAnggota() {
            var id = $('#authid').val();
              
            const urlpin = 'http://127.0.0.1:8000/home/getanggotaid/' + id;

            $.ajax({
                type: "GET",
                url: urlpin,
                dataType: "JSON",
                success: function (response) {
                    console.log(response);
                    response.forEach(el => {
                      $('#anggotaid').val(el.id);
                    });
                   
                } 
            });

            

      }
      
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
            url = 'http://127.0.0.1:8000/home/getbarang';
            
        } else {
            url = 'http://127.0.0.1:8000/home/caribarang/' + merk;
            
        }

        $.ajax({
          type: "GET",
          url: url,
          dataType: "JSON",
          success: function (response) {
            // console.table(response);

            databarang = [...response];  //ini pakai shallow copy
            // console.log(databarang);

            rowproduct = '';

            databarang.forEach(item => {
              // console.log(item.merk);
              rowproduct +=`
              <div id="dvproduct" class="col-lg-3 col-md-6 mb-4">

                <!--Card-->
                <div class="card">

                  <!--Card image-->
                  <div class="view overlay">
                    <img src="photos/${item.foto}" height="225px" width="225px">
                    <a>
                      <div class="mask rgba-white-slight"></div>
                    </a>
                  </div>
                  <!--Card image-->

                  <!--Card content-->
                  <div class="card-body text-center">
                    <!--Category & Title-->
                    <input type="hidden" name="idbarang" id="idbarang" value="${item.idbarang}">
                    <a href="" class="grey-text">
                      <span class="badge badge-pill warning-color" id="SN">${item.SN}</span>
                    </a>
                    <br>
                   
                    <h4>
                      <strong>
                        <a href="" class="dark-grey-text" id="merk">${item.merk}</a>
                      </strong>
                    </h4>

                    <h5 class="font-weight-bold blue-text">
                      <strong id="lokasi">${item.lokasi}</strong>
                    </h5>
                    <br>
                    <button id="btnpinjam" type="submit" class="btn btn-success"><i class="fas fa-hand-point-right"></i> PINJAM</button>
                  </div>
                  <!--Card content-->

                </div>
                <!--Card-->

              </div>
            `;
            });

            $('#dvrow').empty();

            $('#dvrow').append(rowproduct);
          }
          
        });

                    
      }, 500));

      $('#btntambah').click(function (e) { 
        e.preventDefault();
        $('#selanggota').clone().appendTo('#dvanggota');
        
      });

      getPeminjam();
      cariAnggota();
      getbarang();
      getkategori();

    });

  </script>
</body>

</html>
