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
                        
                            <div class="table-responsive">
                                <table id="tblbarang" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <td>No</td>
                                            <td>ID</td>
                                            <td>Kelas</td>
                                            <td>Jurusan</td>
                                            <td>Ruang</td>
                                            <td >Aksi</td>
                                            
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
        <div class="modal fade" id="mdlbarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="frmbarang" action="{{ URL::to('kelas') }}" method="post">
                 @csrf
                    <div class="modal-body">

                        
                        <input type="hidden" class="form-control" name="id" id="id" readonly>
                        <br>

                        <label>Kelas</label>
                        <input type="text" class="form-control" name="kelas" id="kelas" >
                        <br>

                        <label>Jurusan</label>
                        <input type="text" class="form-control" name="jurusan" id="jurusan" >
                        <br>

                        <label>Ruang</label>
                        <input type="text" class="form-control" name="ruang" id="ruang" >
                        <br>
                        
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="btnsimpan" type="submit" class="btn btn-success"></button>
                    </div>
                </form>
            </div>
            
        </div>
        </div>
</div>
@endsection

@section('js')
        <script type="text/javascript">
            $(function () {
                let isi = '';
                let url = '';
              

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                    function getKelas() { 
                        const url = 'http://127.0.0.1:8000/getkelas';
                        $.ajax({
                            type: "GET",
                            url: url,
                            dataType: "JSON",
                            success: function (response) {
                                // console.log(response);
                                isi = '';
                                let no_urut = 1;
                                response.forEach(el => {
                                    isi +=`
                                        <tr>
                                            <td>${no_urut}</td>
                                            <td class="nr"> ${el.id} </td>
                                            <td> ${el.kelas} </td>
                                            <td> ${el.jurusan} </td>
                                            <td> ${el.ruang} </td>
                                            <td> 
                                            <button id="btnedit" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                            <button id="btndelete" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></td>
                                        </tr>
                                    `;
                                    no_urut += 1;
                                });

                                $('#tblbarang').append(isi);
                            }
                        });
                    }

               

                 getKelas();

                 $('#btnnew').click(function (e) { 
                     e.preventDefault();
                     $('#mdlbarang').modal('show')
                     $('#title').text('Kelas Baru');
                     $('#btnsimpan').text('Simpan');
                     $('#frmbarang')[0].reset();
                 });

                 $('#frmbarang').on('submit', function (e) {
                     e.preventDefault();
                     let frmkelas = new FormData(this);

                     if ($('#btnsimpan').text() === 'Simpan') {
                        //  console.log('panggil fungsi simpan');
                         simpanbarang(frmkelas)
                     } else {
                        // console.log('Panggil fungsi ubah');
                        
                        ubahbarang(frmkelas)
                     }

                     
                 });

                 function simpanbarang(frmkelas) {
                     $.ajax({
                         type: "POST",
                         url: "{{route('savekelas')}}",
                         data: frmkelas,
                         cache:false,
                        contentType: false,
                        processData: false,
                        complete: function(response){
                            if($.isEmptyObject(response.responseJSON.error)){
                                // console.log(response);
                                // $('#tblbarang').html("");
                                $('#tblbarang').find("tr:gt(0)").remove();
                                getKelas();
                                $('#mdlbarang').modal('hide')
                                swal("Sukses!", "Data ditambahkan", "success");

                            }
                        }
                     });
                 }

                 function ubahbarang(frmkelas) {
                     let idkelas = $('#id').val();
                    //  console.log(idbarang);

                     const url = 'http://127.0.0.1:8000/ubahkelas/' + $.trim(idkelas);

                     $.ajax({
                         type: "POST",
                         url: url,
                         data: frmkelas,
                         cache:false,
                        contentType: false,
                        processData: false,
                         success: function (response) {
                            // console.log(response);
                            $('#tblbarang').find("tr:gt(0)").remove();
                            getKelas();
                            $('#mdlbarang').modal('hide')
                            swal("Sukses!", "Data berhasil diperbarui", "success");
                            
                         }
                     });
                     
                     
                 }

                 $('#tblbarang').on('click', '#btndelete', function (e) {
                     var $id = $(this).closest("tr")   // Finds the closest row <tr> 
                       .find(".nr")     // Gets a descendent with class="nr"
                       .text();         // Retrieves the text within <td>

                   let url = 'http://127.0.0.1:8000/hapuskelas/' + $.trim($id);        // Outputs the answer

                    $.ajax({
                        type: "GET",
                        url: url, 
                        success: function (response) {
                            // console.log(response);
                            // $('#tblbarang').find("tr:gt(0)").remove();
                            // getBarang()
                        }
                    });
                    swal("Sukses!", "Data berhasil dihapus", "success");
                    $(this).closest('tr').remove();
                 });

                 $('#tblbarang').on('click', '#btnedit', function (e) {
                     var $id = $(this).closest("tr")   // Finds the closest row <tr> 
                       .find(".nr")     // Gets a descendent with class="nr"
                       .text();         // Retrieves the text within <td>

                     const url = 'http://127.0.0.1:8000/kelas/' + $.trim($id) + '/edit';
                    // console.log(url);

                    $('#mdlbarang').modal('show')

                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType: "JSON",
                        success: function (response) {
                            
                            $('#title').text('Ubah Kelas');
                            $('#btnsimpan').text('Ubah');
                            $.each(response, function (idx, val) { 
                            //    console.log(idx + ':' + val);  

                               if (idx === 'kelas') {
                                   $('#kelas').val(val);
                               } else if(idx === 'jurusan'){
                                   $('#jurusan').val(val);
                               } else if(idx === 'ruang'){
                                  $('#ruang').val(val);
                               }else if(idx === 'id'){
                                  $('#id').val(val);
                               }

                                // $('#merk').val($(response)[0] ['merk']);
                                // $('#keterangan').val($(response)[0] ['keterangan']);
                                // $('#satuan').val($(response)[0] ['satuan']);
                                // $('#jumlah').val($(response)[0] ['jumlah']);
                                // $('#id').val($(response)[0] ['id']);
                            
                            
                            
                            });
                        }
                    });
                 });

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
                            url = 'http://127.0.0.1:8000/getkelas';
                            
                        } else {
                            url = 'http://127.0.0.1:8000/carikelas/' + merk;
                           
                        }

                        $.ajax({
                            type: "GET",
                            url: url,
                            dataType: "JSON",
                            success: function (response) {
                                // console.log(response);

                                $('#tblbarang').find("tr:gt(0)").remove();
                                isi = '';
                                let no_urut = 1;
                                response.forEach(el => {
                                    isi +=`
                                        <tr>
                                            <td>${no_urut}</td>
                                            <td class="nr"> ${el.id} </td>
                                            <td> ${el.kelas} </td>
                                            <td> ${el.jurusan} </td>
                                            <td> ${el.ruang} </td>
                                            <td> 
                                            <button id="btnedit" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                            <button id="btndelete" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></td>
                                        </tr>
                                    `;
                                    no_urut += 1;
                                });
                                $('#tblbarang').append(isi);
                            }
                        });
                    }, 500));


            
            });
        </script>
@endsection

