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
                                <table id="tblanggota" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <td>No</td>
                                            <td>ID</td>
                                            <td>Foto</td>
                                            <td>Nama Anggota</td>
                                            <td>Alamat</td>
                                            <td>JK</td>
                                            <td >Kelas</td>
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
        <div class="modal fade" id="mdlanggota" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="frmanggota" action="{{ URL::to('anggota') }}" method="post" enctype="multipart/form-data">
                 @csrf
                    <div class="modal-body">
                       
                        <input type="hidden" class="form-control" name="id" id="id" readonly>
                        <br>
                        <label>Nama User</label>
                        <select class="form-control" name="seluser" id="seluser">
                        
                        </select>
                        <br>

                        <label>Kelas</label>
                        <select class="form-control" name="selkelas" id="selkelas">
                           
                        </select>
                        <br>

                        <label>Alamat</label>
                        <textarea class="form-control" name="alamat" id="alamat"></textarea>
                        <br>

                        <label>No Telp</label>
                        <input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="Masukkan No Telp">
                        <br>

                        <label>Jenis Kelamin</label>
                        <br>
                            <input class="form-controller" type="radio" id="male" name="jk" value="0">
                            <label for="male">Male</label>
                            <input class="form-controller" type="radio" id="female" name="jk" value="1">
                            <label for="female">Female</label>
                        <br>

                        <label>Foto</label>
                        <input type="file" class="form-control" name="foto" id="foto" >
                        
                        
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
                let isiuser = '';
                let isikelas = '';

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                

                

                function getanggota() { 
                    const url = 'http://127.0.0.1:8000/getanggota';
                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType: "JSON",
                        success: function (response) {
                            // $.each(response, function (idx, val) { 
                            //     console.log("Nama = " + val.name);
                                 
                            // });
                            // console.log(response);
                            isi = '';
                            let no_urut = 1 ;
                            response.forEach(el => {
                                isi += `
                                    <tr>
                                        <td>${no_urut}</td>
                                        <td class="nr"> ${el.id} </td>
                                        <td><img src="/photos/${el.foto}" class="img-thumbnail" height="100px" width="100px" alt=""> </td>
                                        <td> ${el.name} </td>
                                        <td> ${el.alamat} </td>
                                        <td>${el.jk == '1' ? 'P' : 'L'}</td>
                                        <td> ${el.kelas} ${el.jurusan} ${el.ruang} </td>
                                        <td> 
                                        <button id="btnedit" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                        <button id="btndelete" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></td>
                                    </tr>
                                `;
                                no_urut += 1;
                            });
                             $('#tblanggota').append(isi);
                        }
                    });
                 }

                function getuser() {
                     const url = 'http://127.0.0.1:8000/getuser';
                     $.ajax({
                         type: "GET",
                         url: url,
                         dataType: "JSON",
                         success: function (response) {
                            //  console.log(response);

                             response.forEach(el => {
                                 isiuser += `
                                    <option value="${el.id}">${el.name}</option>
                                 `;
                             });

                             $('#seluser').append(isiuser);
                         }
                     });
                 }

                 function getkelas() {
                     const url = 'http://127.0.0.1:8000/getkelas';
                     $.ajax({
                         type: "GET",
                         url: url,
                         dataType: "JSON",
                         success: function (response) {
                            //  console.log(response);

                             response.forEach(el => {
                                 isikelas += `
                                    <option value="${el.id}">${el.kelas} ${el.jurusan} ${el.ruang}</option>
                                    
                                 `;
                             });

                             $('#selkelas').append(isikelas);
                         }
                     });
                 }


                 getanggota();
                 getuser();
                 getkelas();

                 $('#btnnew').click(function (e) { 
                     e.preventDefault();
                     $('#mdlanggota').modal('show')
                     $('#title').text('Anggota Baru');
                     $('#btnsimpan').text('Simpan');
                     $('#frmanggota')[0].reset();
                 });

                 $('#frmanggota').on('submit', function (e) {
                     e.preventDefault();
                     let frmanggota = new FormData(this);

                     if ($('#btnsimpan').text() === 'Simpan') {
                        //  console.log('panggil fungsi simpan');
                         simpananggota(frmanggota)
                     } else {
                        // console.log('Panggil fungsi ubah');
                        
                        ubahanggota(frmanggota)
                     }
                 });

                 function simpananggota(frmanggota) {
                      

                     $.ajax({
                         type: "POST",
                         url: "{{route('saveanggota')}}",
                         data: frmanggota,
                         cache:false,
                        contentType: false,
                        processData: false,
                        complete: function(response){
                            if($.isEmptyObject(response.responseJSON.error)){
                                // console.log(response);
                                $('#tblanggota').find("tr:gt(0)").remove();
                                getanggota();
                                $('#mdlanggota').modal('hide')
                                swal("Sukses!", "Data ditambahkan", "success");
                                

                            }
                        }
                     });
                 }

                 function ubahanggota(frmanggota) {
                     let idanggota = $('#id').val();
                     console.log(idanggota);

                     const url = 'http://127.0.0.1:8000/ubahanggota/' + $.trim(idanggota);

                     $.ajax({
                         type: "POST",
                         url: url,
                         data: frmanggota,
                         cache:false,
                        contentType: false,
                        processData: false,
                         success: function (response) {
                            // console.log(response);
                            $('#tblanggota').find("tr:gt(0)").remove();
                            getanggota();
                            $('#mdlanggota').modal('hide')
                            swal("Sukses!", "Data berhasil diperbarui", "success");
                            

                        
                         }
                     });
                 }

                 $('#tblanggota').on('click', '#btndelete', function (e) {
                     var $id = $(this).closest("tr")   // Finds the closest row <tr> 
                       .find(".nr")     // Gets a descendent with class="nr"
                       .text();         // Retrieves the text within <td>

                   let url = 'http://127.0.0.1:8000/hapusanggota/' + $.trim($id);        // Outputs the answer

                    $.ajax({
                        type: "GET",
                        url: url,
                        success: function (response) {
                            // $('#tblanggota').find("tr:gt(0)").remove();
                            // getanggota()
                        }
                    });
                    swal("Sukses!", "Data berhasil dihapus", "success");
                    $(this).closest('tr').remove();
                 });

                 $('#tblanggota').on('click', '#btnedit', function (e) {
                     var $id = $(this).closest("tr")   // Finds the closest row <tr> 
                       .find(".nr")     // Gets a descendent with class="nr"
                       .text();         // Retrieves the text within <td>

                     const url = 'http://127.0.0.1:8000/anggota/' + $.trim($id) + '/edit';
                    // console.log(url);

                    $('#mdlanggota').modal('show')

                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType: "JSON",
                        success: function (response) {
                            console.log(response);
                            $('#title').text('Ubah Anggota');
                            $('#btnsimpan').text('Ubah');
                            $.each(response, function (idx, val) { 
                               console.log(idx + ':' + val);  

                               if (idx === 'no_telp') {
                                   $('#no_telp').val(val);
                               } else if(idx === 'alamat'){
                                   $('#alamat').val(val);
                               } else if(idx === 'kelas_id'){
                                   $('#selkelas').val(val).change();
                               }else if(idx === 'user_id'){
                                   $('#seluser').val(val).change();
                               }else if(idx === 'jk'){
                                   $('input[name=jk][value='+ val +']').prop('checked', true);
                               }else if(idx === 'id'){
                                   $('#id').val(val);
                               }
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
                        let anggota = this.value;
                        
                        
                        if (anggota === "") {
                            url = 'http://127.0.0.1:8000/getanggota';
                            
                        } else {
                            url = 'http://127.0.0.1:8000/carianggota/' + anggota;
                           
                        }

                        $.ajax({
                            type: "GET",
                            url: url,
                            dataType: "JSON",
                            success: function (response) {
                                // console.log(response);

                                $('#tblanggota').find("tr:gt(0)").remove();
                                isi = '';
                                let no_urut = 1 ;
                                response.forEach(el => {
                                    isi += `
                                    <tr>
                                        <td>${no_urut}</td>
                                        <td class="nr"> ${el.id} </td>
                                        <td><img src="/photos/${el.foto}" class="img-thumbnail" height="100px" width="100px" alt=""> </td>
                                        <td> ${el.name} </td>
                                        <td> ${el.alamat} </td>
                                        <td>${el.jk == '1' ? 'P' : 'L'}</td>
                                        <td> ${el.kelas} ${el.jurusan} ${el.ruang} </td>
                                        <td> 
                                        <button id="btnedit" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                        <button id="btndelete" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></td>
                                    </tr>
                                    `;
                                    no_urut += 1;
                                });
                                $('#tblanggota').append(isi);
                            }
                        });
                        }, 500));

            });
        </script>    
@endsection
