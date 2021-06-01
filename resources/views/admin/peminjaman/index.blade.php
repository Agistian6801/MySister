@extends('layout.app')

@section('content')
<div class="content-wrapper pb-0" >

        <div class="row">
              <div class="col-md-12 stretch-card grid-margin">
                <div class="card">
                  <div class="card-body shadow">
                        <div class="row">
                            <div class="col-sm-1">
                                <button id="btnnew" class="btn btn-primary mt-2 mt-sm-0 btn-icon-text shadow">
                                <i class="mdi mdi-plus-circle"></i></button>
                            </div>
                            <div class="col-sm-8 offset-sm-1 ">
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
                        <div class="row">
                            <div class="col-md-5">
                                <button style="margin-bottom: 10px" class="btn btn-danger delete_all" data-url="{{ url('peminjamanDeleteAll') }}">Delete All Selected</button>
                            </div>
                        </div>
                        <br>
                        
                            <div class="table-responsive">
                                <table id="tblpj" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <td>No</td>
                                            <td>ID Peminjaman</td>
                                            <td>Peminjam</td>
                                            <td> Tanggal Pinjam</td>
                                            <td>Tanggal Kembali</td>
                                            <td>Kode SN Barang</td>
                                            <td >Barang</td>
                                            <td>Anggota Peminjam</td>
                                            <td >Status</td>
                                            <td >Aksi <input type="checkbox" id="master"></td>
                                            
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

        <!-- Modal -->
        <div class="modal fade" id="mdlpinjam" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
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
                               
                                <input type="hidden" class="form-control" name="id" id="id" readonly>
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
                            <div style="width: 100%; height: 20px; border-bottom: 1px solid grey; text-align: center">
                                    <span style="font-size: 17; background-color: white;">
                                        <i>Tambahkan CC Peminjam</i> <!--Padding is optional-->
                                    </span>
                            </div>
                            <br>
                            
                                <label><b>CC Peminjam :</b> </label> <button id="btncc" type="submit" class="badge badge-primary">+</button>
                                <div id="dvcc" class="row" style="margin-left:5px;margin-right:5px;">
                                <select class="form-control col-md-5" style="margin-bottom:5px;margin-left:5px;" name="selcc" id="selcc">
                                    <option value="-">-</option>
                                </select>
                                </div>
                        

                        </div>
                        <div class="modal-footer">
                            <button id="btntambah" type="submit" class="btn btn-warning">More</button>
                            {{-- <button id="btngetpinjam" class="btn btn-danger">Get Peminjaman</button>
                            <button id="btnget" type="submit" class="btn btn-primary">Get Element</button> --}}
                            <button id="btnsimpan" type="submit" class="btn btn-success"></button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>

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
</div>
        
@endsection

@section('js')
        <script type="text/javascript">
            $(function () {
               
                    let isi = '';
                    let isianggota = '';
                    let selbarang = '';
                    let databarang = [];
                    let idpeminjaman = '';
                    let isicc = '';
                    let ccanggota = '';
                    let cc = [];


                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    

                    function getpeminjaman() {
                        const url = 'http://127.0.0.1:8000/getpeminjaman';

                        $.ajax({
                            type: "GET",
                            url: url,
                            dataType: "JSON",
                            success: function (response) {
                                // console.log(response);
                                
                                $('#tblpj').find("tr").slice(1).remove()
                                
                                isi = '';
                                let no_urut = 1;
                                response.forEach(el => {
                                    isi +=`
                                        <tr id="tr_${el.idpj}">
                                            <td>${no_urut}</td>
                                            <td class="nr">${el.idpj}</td>
                                            <td>${el.name}</td>
                                            <td> ${el.tanggal_pinjam}</td>
                                            <td>${el.tanggal_kembali}</td>
                                            <td >${el.SN}</td>
                                            <td >${el.merk}</td>
                                            <td><button id="btnlihat" class="btn btn-primary"><i class="fa fa-eye"></i></button></td>
                                            <td >${el.status == '1' ? '<span class="badge badge-success">Returned</span>': el.status == '2' ? '<span class="badge badge-danger">Late</span>' :  el.status == '3' ? '<span class="badge badge-danger">Returned</span>' : '<span class="badge badge-warning">On Borrowed</span>'}</td>
                                            <td >
                                                <button id="btndelete" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
                                                <input type="checkbox" class="sub_chk" data-id="${el.idpj}">
                                            </td>
                                            
                                        </tr>
                                    `;
                                    no_urut += 1;
                                });

                                $('#tblpj').append(isi);
                                // $("#tblpj").rowspanizer({vertical_align: 'middle'});
                            }
                        });
                    }

                    function getBarang() {
                        const url = 'http://127.0.0.1:8000/getbarang';

                        $.ajax({
                            type: "GET",
                            url: url,
                            dataType: "JSON",
                            success: function (response) {
                                // console.log(response);

                                response.forEach(el => {
                                    selbarang += `
                                        <option value="${el.id}">${el.merk}</option>
                                    `;
                                    
                                });

                                $('#selbarang').append(selbarang);
                                // $(barang).append(selbarang);
                            }
                        });
                    }

                    function getPeminjam() {
                        const url ='http://127.0.0.1:8000/getpeminjam';

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

                    // $('#dvlihat').remove();
                    $("#mdllihat").on("hidden.bs.modal", function(){
                        $("#dvlihat").html("");
                    });
                    
                    $('#tblpj').on('click', '#btnlihat', function (e) {
                        var $id = $(this).closest("tr")   // Finds the closest row <tr> 
                        .find(".nr")     // Gets a descendent with class="nr"
                        .text();         // Retrieves the text within <td>
                        // console.log($id);
                        const url = 'http://127.0.0.1:8000/lihat/' + $.trim($id) + '/anggota';
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
                    

                    $('#tblpj').on('click', '#btndelete', function (e) {
                        var $id = $(this).closest("tr")   // Finds the closest row <tr> 
                        .find(".nr")     // Gets a descendent with class="nr"
                        .text();         // Retrieves the text within <td>

                        let url = 'http://127.0.0.1:8000/hapuspeminjaman/' + $.trim($id);        // Outputs the answer
                            // console.log(url);
                            $.ajax({
                                type: "GET",
                                url: url, 
                                success: function (response) {
                                    // console.log(response);
                                    swal("Sukses!", "Data berhasil dihapus", "success");
                                    $('#tblpj').find("tr:gt(0)").remove();
                                    // $(this).closest('tr').remove();
                                    getpeminjaman();
                                    // $(this).closest('tr').remove();
                                }
                            });
                        // $(this).closest('tr').remove();
                    });
                
                    $('#btnnew').click(function (e) { 
                        e.preventDefault();
                        $('#mdlpinjam').modal('show')
                        $('#title').text('Formulir Peminjaman Barang');
                        $('#btnsimpan').text('Simpan');
                        $('#frmpinjam')[0].reset();
                    });

                    $('#btntambah').click(function (e) { 
                        e.preventDefault();
                        $('#ttlbar').clone().appendTo('#dvpdetail');
                        $('#selbarang').clone().appendTo('#dvpdetail');
                        $('#ttlket').clone().appendTo('#dvpdetail');
                        $('#keterangan').clone().appendTo('#dvpdetail');
                        
                        
                    });

                    $('#btnget').click(function (e) { 
                        e.preventDefault();
                        databarang = [];
                        $('#dvpdetail').find("select, textarea").each(function () {
                            let sbtext = $(this).val();
                            // console.log(sbtext);

                            if (this.id == 'selbarang') {
                                databarang.push({
                                    'merk' : sbtext,
                                    'keterangan' : $(this).nextAll().eq(1).val()
                                });
                            }

                            console.log(databarang);
                            
                        });
                        
                    });

                    $('#btngetpinjam').click(function (e) { 
                        e.preventDefault();
                        let tanggal_pinjam = $('#tanggal_pinjam').val();
                        let tanggal_kembali = $('#tanggal_kembali').val();
                        let selanggota = $('#selanggota').val();

                        console.log(selanggota);


                    });

                    $('#btnsimpan').click( function (e) { 
                        e.preventDefault();
                        const urlpeminjaman ='http://127.0.0.1:8000/peminjamandetail';
                        
                        
                        let tanggal_pinjam = $('#tanggal_pinjam').val();
                        let tanggal_kembali = $('#tanggal_kembali').val();
                        let selanggota = $('#selanggota').val();
                        
                        
                        $.ajax({
                            type: "POST",
                            url: urlpeminjaman,
                            data: {
                                'tanggal_pinjam' : tanggal_pinjam,
                                'tanggal_kembali' : tanggal_kembali,
                                'anggota_id' : selanggota
                            },
                            success: function (response) {
                                // console.log(response);
                                idpeminjaman = response; 
                                simpanPeminjamanDetail();
                            } 
                        });
                    });

                    function simpanPeminjamanDetail() {
                        const urlpdetail = 'http://127.0.0.1:8000/svpeminjamandetail';
                        
                        databarang = [];

                        $('#dvpdetail').find("select, textarea").each(function () {
                            let sbtext = $(this).val();
                            // console.log(sbtext);

                            if (this.id == 'selbarang') {
                                databarang.push({
                                    'peminjaman_id' : idpeminjaman,
                                    'barang_id' : sbtext,
                                    'keterangan' : $(this).nextAll().eq(1).val()
                                });
                            }

                            // console.log("isi dari detail");
                            console.log(JSON.stringify(databarang));
                            
                        });

                            $.ajax({
                                type: "POST",
                                url: urlpdetail,
                                data: JSON.stringify(databarang),
                                dataType: "json",
                                contentType: "application/json",
                                processData: false,
                                success: function (response) {
                                //  console.log(response);  
                                // $('#mdlpinjam').modal('hide');
                                // getpeminjaman();
                                svccpeminjam(idpeminjaman);

                                }
                            });
                        
                    }

                    $('#btncc').click(function (e) { 
                        e.preventDefault();
                        $('#selcc').clone().appendTo('#dvcc');
                        
                    });

                    function getCcPeminjam() {
                        const url ='http://127.0.0.1:8000/getpeminjam';

                        $.ajax({
                            type: "GET",
                            url: url,
                            dataType: "JSON",
                            success: function (response) {
                                response.forEach(el => {
                                    ccanggota += `
                                        <option value="${el.id}">${el.name}</option>
                                    `;
                                });

                                $('#selcc').append(ccanggota);
                            }
                        });
                    }

                    function svccpeminjam(idpeminjaman) {
        
                        const urlcc = 'http://127.0.0.1:8000/svccpeminjaman';

                        $('#dvcc').find('option:selected').each(function () { 
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
                                // console.log(response);  
                                $('#mdlpinjam').modal('hide');
                                swal("Sukses!", "Berhasil Pinjam", "success");
                                getpeminjaman();
                            }
                        });
                    }

                    getpeminjaman();
                    getPeminjam();
                    getBarang();
                    getCcPeminjam();

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
                            url = 'http://127.0.0.1:8000/getpeminjaman';
                            
                        } else {
                            url = 'http://127.0.0.1:8000/caripeminjaman/' + merk;
                           
                        }

                        $.ajax({
                            type: "GET",
                            url: url,
                            dataType: "JSON",
                            success: function (response) {
                                console.log(response);

                                $('#tblpj').find("tr:gt(0)").remove();
                                isi = '';
                                let no_urut = 1;
                                response.forEach(el => {
                                    isi += `
                                        <tr id="tr_${el.idpj}">
                                            <td>${no_urut}</td>
                                            <td class="nr">${el.idpj}</td>
                                            <td>${el.name}</td>
                                            <td> ${el.tanggal_pinjam}</td>
                                            <td>${el.tanggal_kembali}</td>
                                            <td >${el.SN}</td>
                                            <td >${el.merk}</td>
                                            <td><button id="btnlihat" class="btn btn-primary"><i class="fa fa-eye"></i></button></td>
                                            <td >${el.status == '1' ? '<span class="badge badge-success">Returned</span>': el.status == '2' ? '<span class="badge badge-danger">Late</span>' :  el.status == '3' ? '<span class="badge badge-danger">Returned</span>' : '<span class="badge badge-warning">On Borrowed</span>'}</td>
                                            <td >
                                                <button id="btndelete" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
                                                <input type="checkbox" class="sub_chk" data-id="${el.idpj}">
                                            </td>
                                            
                                        </tr>
                                    `;
                                    no_urut += 1;
                                });
                                $('#tblpj').append(isi);
                            }
                        });
                    }, 500));

                    $('#master').on('click', function(e) {
                        if($(this).is(':checked',true))
                        {
                            $(".sub_chk").prop('checked', true);
                        } else {
                            $(".sub_chk").prop('checked',false);
                        }
                        });


                        $('.delete_all').on('click', function(e) {


                            var allVals = [];
                            $(".sub_chk:checked").each(function() {
                                allVals.push($(this).attr('data-id'));
                            });


                            if(allVals.length <=0)
                            {
                                alert("Please select row.");
                            }  else {


                                var check = confirm("Are you sure you want to delete this row?");
                                if(check == true){


                                    var join_selected_values = allVals.join(",");


                                    $.ajax({
                                        url: $(this).data('url'),
                                        type: 'DELETE',
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        data: 'ids='+join_selected_values,
                                        success: function (data) {
                                            if (data['success']) {
                                                $(".sub_chk:checked").each(function() {
                                                    $(this).parents("tr").remove();
                                                });
                                                // alert(data['success']);
                                                swal("Sukses!", "Data berhasil dihapus", "success");
                                            } else if (data['error']) {
                                                alert(data['error']);
                                            } else {
                                                alert('Whoops Something went wrong!!');
                                            }
                                        },
                                        error: function (data) {
                                            alert(data.responseText);
                                        }
                                    });


                                $.each(allVals, function( index, value ) {
                                    $('table tr').filter("[data-row-id='" + value + "']").remove();
                                    getpeminjaman();
                                });
                                }
                            }
                    });
               
            });
        </script>
    
@endsection
