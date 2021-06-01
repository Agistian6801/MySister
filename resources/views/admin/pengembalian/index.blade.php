@extends('layout.app')

@section('content')
<div class="content-wrapper pb-0" >

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
                        
                        <div class="container" id="container">
                           <div class="row" id="dvrow">
                               
                           </div>
                        </div>
                        
                        
                  </div>
                </div>
              </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="mdlpinjam" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="frmpinjam" action="{{ URL::to('peminjamandetail') }}" method="post" enctype="multipart/form-data">
                 @csrf
                    <div class="modal-body">
                        <div id="dvpeminjaman">
                            <label>ID</label>
                            <input type="text" class="form-control" name="id" id="id" readonly>
                            <br>
                            <label>Nama Peminjam</label>
                            <select class="form-control" name="selanggota" id="selanggota">
                            
                            </select>
                            <br>

                            <label>Tanggal Pinjam</label>
                            <input type="datetime-local" class="form-control" name="tanggal_pinjam" id="tanggal_pinjam" >
                            <br>

                            <label>Tanggal Kembali</label>
                            <input type="datetime-local" class="form-control" name="tanggal_kembali" id="tanggal_kembali" >
                            <br>

                            <div style="width: 100%; height: 20px; border-bottom: 1px solid grey; text-align: center">
                                <span style="font-size: 17; background-color: white;">
                                    <i>Tambahkan Barang</i> <!--Padding is optional-->
                                </span>
                            </div>
                            <br>
                        </div>

                            <div id ="dvpdetail">
                                        
                                    <label id='ttlbar'>Barang</label>
                                    <select class="form-control" name="selbarang" id="selbarang">
                                    
                                    </select>
                                    
                            
                    
                                    <label id='ttlket'>Keterangan</label>
                                    <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
                                    
                            
                            {{-- <div class="col-md-1" style="padding-top:50px">
                                <button id="btndelete" class="btn btn-danger" ><i class="fa fa-trash-o"></i></button>
                            </div> --}}
                            </div>
                    <br>

                    </div>
                    <div class="modal-footer">
                        <button id="btntambah" type="submit" class="btn btn-warning">More</button>
                        <button id="btngetpinjam" class="btn btn-danger">Get Peminjaman</button>
                        <button id="btnget" type="submit" class="btn btn-primary">Get Element</button>
                        <button id="btnsimpan" type="submit" class="btn btn-success"></button>
                    </div>
                </form>
            </div>
            
        </div>
        </div>
</div>
        
@endsection

@section('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" crossorigin="anonymous"></script>
        <script type="text/javascript">
            $(function () {

                let isi = '';
            
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                function makeTimer(waktu, hari, jam, menit, detik) {

                    
                    var endTime = new Date(waktu);			
                    endTime = (Date.parse(endTime) / 1000);

                    var now = new Date();
                    now = (Date.parse(now) / 1000);

                    var timeLeft = endTime - now;

                    var days = Math.floor(timeLeft / 86400); 
                    var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
                    var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
                    var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));
        
                    if (hours < "10") { hours = "0" + hours; }
                    if (minutes < "10") { minutes = "0" + minutes; }
                    if (seconds < "10") { seconds = "0" + seconds; }

                    $(hari).html(days + "<span> Hari</span>");
                    $(jam).html(hours + "<span> Jam</span>");
                    $(menit).html(minutes + "<span> Menit</span>");
                    $(detik).html(seconds + "<span> Detik</span>");		

                }

                function getpeminjaman() {
                    const url = 'http://127.0.0.1:8000/admin/getdatapeminjaman';

                    $('#dvrow').empty();

                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType: "JSON",
                        success: function (response) {
                            // console.log(tanggal_pinjam);
                            // console.log(tanggal_kembali);
                            isi = '';
                            for (const key in response) {
                                if (response.hasOwnProperty(key) && (typeof response[key] === "object")) {
                                    const element = response[key];

                                        isi += `
                                        <div class="col-md-4">
                                        <div class="card text-white bg-info shadow" style="width:18rem">
                                            <div class="card-header">
                                                    <button class="btn btn-primary btn-block" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2"><h5>ID Peminjaman : <h5 id="title">${element.idpeminjaman}</h5></h5></button>
                                            </div>
                                            <div class="collapse multi-collapse" id="multiCollapseExample2">
                                                <div class="card-body">
                                                    <input type="hidden" name="tanggal_pinjam" id="tanggal_pinjam" value="${element.tanggal_pinjam}">
                                                    <input type="hidden" name="tanggal_kembali" id="tanggal_kembali" value="${element.tanggal_kembali}">
                                                    <div id="timer" style="text-align:center;color:yellow;">
                                                        <span class="days" id="days"></span>
                                                        <span class="hours" id="hours"></span>
                                                        <span class="minutes" id="minutes"></span>
                                                        <span class="seconds" id="seconds"></span>
                                                    </div>
                                                    <br>
                                                    <h5 class="card-title">Nama Peminjam : ${element.name}</h5>
                                                    <ul class="list-group list-group-flush">
                                        `;

                                        element.peminjamandetail.forEach(el => {
                                        isi += `
                                                        <li class="list-group-item bg-info"><b style="color:black">Barang :</b> ${el.barang.merk}</li>
                                                        <li class="list-group-item bg-info" style="color:darkgreen"><b style="color:black">Keterangan :</b> ${el.keterangan}</li>
                                        `;
                                        });
                                        isi += `
                                                        </ul>
                                                        <br>
                                                        <span class="card-title" >Status : ${element.status == '1' ? '<span class="badge badge-success">Returned</span>': element.status == '2' ? '<span class="badge badge-danger">Late</span>' : '<span class="badge badge-warning">On Borrowed</span>'} </span>
                                                    </div>
                                                </div>
                                            
                                                    <button class="btn btn-danger" id="btnkembalikan">Kembalikan</button>
                                            
                                            </div>
                                        </div>
                                        `;

                                        
                                        
                                }
                            }
                            // <span id="status" style="color:red">${element.status == '1' ? '<span class="badge badge-success">Returned</span>': element.status == '2' ? '<span class="badge badge-danger">Late</span>' : '<span class="badge badge-warning">On Borrowed</span>'}</span>

                            $('#dvrow').append(isi);

                            $('#dvrow').children().each(function (index, element) {
                                // console.log(index);
                                // console.log(element);
                                
                                let tanggal_kembali = $(element).find('#tanggal_kembali').val();
                                let days = $(element).find('#days');
                                let hours = $(element).find('#hours');
                                let minutes = $(element).find('#minutes');
                                let seconds = $(element).find('#seconds');
                                
                                setInterval(function() { 
                                makeTimer(tanggal_kembali, days, hours, minutes, seconds ); 
                                }, 1000);
                                
                                let a = $(element).find('#tanggal_pinjam').val();
                                let b = $(element).find('#tanggal_kembali').val();
                                let d = $(element).find('#title').text();
                                // console.log(c);
                                denda(a,b,d);


                            });
                            
                        }
                    });
                }

                function denda(a,b,d) { 
                        var return_time = moment(b);
                        var borrow_time = moment(a);
                        var c = new Date();
                        var current_time = moment(c);

                        console.log(borrow_time);
                        console.log(return_time);
                        console.log(current_time);

                        console.log("dibawah ini aksi");

                        let menit = return_time.diff(borrow_time, 'minutes');
                        let jam = return_time.diff(borrow_time, 'hours');
                        let hari = return_time.diff(borrow_time, 'days');

                        console.log(hari);
                        console.log(`Selisih 1 : ${hari} hari , ${jam} jam, ${menit} menit`);

                        let menit2 = current_time.diff(borrow_time, 'minutes');
                        let jam2 = current_time.diff(borrow_time, 'hours');
                        let hari2 = current_time.diff(borrow_time, 'days');

                        console.log(`Selisih 2 : ${hari2} hari , ${jam2} jam, ${menit2} menit`);
                        console.log(hari2);

                        console.log('if else');

                        
                        console.log(d);

                        if ((hari2 > hari) || (menit2 > menit) || (jam2 > jam)) {
                            console.log('Terlambat');
                            const urlh = 'http://127.0.0.1:8000/admin/ubahstatus/' + $.trim(d);

                            $.ajax({
                                type: "POST",
                                url: urlh,
                                cache:false,
                                contentType: false,
                                processData: false,
                                success: function (response) {
                                    console.log(response);
                                    // console.log('hhh');
                                    $('#denda').show();
                                }
                            });
                            
                        }else{
                                $('#denda').hide();
                                console.log('Masih dipinjam');
                                // $('#isianstatus').val('Masih dipinjam');
                        }

                       
                 }

                $('#dvrow').on('click', '#btnkembalikan', function () {
                    // alert('diklik');
                    let id = $.trim($(this).parent().find('#title').text());

                    const url = 'http://127.0.0.1:8000/admin/pengembalian';
                    
                    let today = new Date();
                    let date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                    let time = today.getHours()+":"+today.getMinutes()+":"+today.getSeconds();
                    let dateTime = date+' '+time;

                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            'peminjaman_id'   : id,
                            'tanggal_kembali' : dateTime,
                            'keterangan'      : 'ini sudah dikembalikan'
                        },
                        success: function (response) {
                            console.log(response);
                            swal("Sukses!", "Data berhasil dikembalikan", "success");
                            getpeminjaman();
                        }
                    });
                });

                getpeminjaman();

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

                $('#tcari').keyup(delay(function (e) {
                    let merk = this.value;
                    
                    
                    if (merk === "") {
                        url = 'http://127.0.0.1:8000/admin/getdatapeminjaman';
                        
                    } else {
                        url = 'http://127.0.0.1:8000/admin/caridatapeminjaman/' + merk;
                        
                    }

                    

                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType: "JSON",
                        success: function (response) {
                            $('#dvrow').empty();
                            isi = '';
                            for (const key in response) {
                                if (response.hasOwnProperty(key) && (typeof response[key] === "object")) {
                                    const element = response[key];

                                        isi += `
                                        <div class="col-md-4">
                                        <div class="card text-white bg-info shadow" style="width:18rem">
                                            <div class="card-header">
                                                    <button class="btn btn-primary btn-block" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2"><h5>ID Peminjaman : <h5 id="title">${element.idpeminjaman}</h5></h5></button>
                                            </div>
                                            <div class="collapse multi-collapse" id="multiCollapseExample2">
                                                <div class="card-body">
                                                    
                                                    <input type="hidden" name="tanggal_kembali" id="tanggal_kembali" value="${element.tanggal_kembali}">
                                                    <div id="timer" style="text-align:center;color:yellow;">
                                                        <span class="days" id="days"></span>
                                                        <span class="hours" id="hours"></span>
                                                        <span class="minutes" id="minutes"></span>
                                                        <span class="seconds" id="seconds"></span>
                                                    </div>
                                                    <br>
                                                    <h5 class="card-title">Nama Peminjam : ${element.name}</h5>
                                                    <ul class="list-group list-group-flush">
                                        `;

                                        element.peminjamandetail.forEach(el => {
                                        isi += `
                                                        <li class="list-group-item bg-info"><b style="color:black">Barang :</b> ${el.barang.merk}</li>
                                                        <li class="list-group-item bg-info" style="color:darkgreen"><b style="color:black">Keterangan :</b> ${el.keterangan}</li>
                                        `;
                                        });
                                        isi += `
                                                        </ul>
                                                        <br>
                                                        <span class="card-title" >Status : ${element.status == '1' ? '<span class="badge badge-success">Returned</span>': element.status == '2' ? '<span class="badge badge-danger">Late</span>' : '<span class="badge badge-warning">On Borrowed</span>'} </span>
                                                    </div>
                                                </div>
                                            
                                                    <button class="btn btn-danger" id="btnkembalikan">Kembalikan</button>
                                            
                                            </div>
                                        </div>
                                        `;

                                        
                                        
                                }
                            }

                            $('#dvrow').append(isi);

                            $('#dvrow').children().each(function (index, element) {
                                // console.log(index);
                                // console.log(element);
                                
                                let tanggal_kembali = $(element).find('#tanggal_kembali').val();
                                let days = $(element).find('#days');
                                let hours = $(element).find('#hours');
                                let minutes = $(element).find('#minutes');
                                let seconds = $(element).find('#seconds');
                                
                                setInterval(function() { 
                                makeTimer(tanggal_kembali, days, hours, minutes, seconds ); 
                                }, 1000);
                            });
                            
                        }
                    });

                    
                }, 500));


            });
        </script>
    
@endsection
