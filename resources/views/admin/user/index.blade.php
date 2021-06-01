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
                                            <td>Nama</td>
                                            <td>Email</td>
                                            <td>Status</td>
                                            <td>Aksi</td>
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
                <form id="frmanggota" action="{{ URL::to('admin/user') }}" method="post">
                 @csrf
                    <div class="modal-body">
                        
                        <input type="hidden" class="form-control" name="id" id="id" readonly>
                        <label>Nama User</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="masukkan nama lengkap" Required >
                        <br>

                        <label>Email</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="masukkan alamat email" Required>
                        <br>

                        <label>Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="masukkan password" Required>
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
                let isiuser = '';
                let isikelas = '';

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                

                

                function getanggota() { 
                    const url = 'http://127.0.0.1:8000/admin/getuser';
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
                                        <td> ${el.name} </td>
                                        <td> ${el.email} </td>
                                        <td> ${el.is_admin == '1' ? '<span class="badge badge-success">Admin</span>' : '<span class="badge badge-warning">User</span>'}</td>
                                        <td>
                                        <button id="btnchange" class="btn btn-primary"><i class="mdi mdi-power-settings"></i></button> 
                                        <button id="btnedit" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                        <button id="btndelete" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></td>
                                    </tr>
                                `;
                                no_urut += 1 ;
                            });
                             $('#tblanggota').append(isi);
                        }
                    });
                }



                getanggota();

                $('#btnnew').click(function (e) { 
                    e.preventDefault();
                    $('#mdlanggota').modal('show')
                    $('#title').text('User Baru');
                    $('#btnsimpan').text('Simpan');
                    $('#frmanggota')[0].reset();
                });

                $('#frmanggota').on('submit', function (e) {
                    e.preventDefault();
                    let frmuser = new FormData(this);

                    if ($('#btnsimpan').text() === 'Simpan') {
                    //  console.log('panggil fungsi simpan');
                        simpananggota(frmuser)
                    } else {
                    // console.log('Panggil fungsi ubah');
                    
                    ubahanggota(frmuser)
                    }
                });

                function simpananggota(frmuser) {
                    

                    $.ajax({
                        type: "POST",
                        url: "{{route('saveuser')}}",
                        data: frmuser,
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

                function ubahanggota(frmuser) {
                    let iduser = $('#id').val();
                    // console.log(iduser);

                    const url = 'http://127.0.0.1:8000/admin/ubahuser/' + $.trim(iduser);

                    $.ajax({
                        type: "POST",
                        url: url,
                        data: frmuser,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                        // console.log(response);
                        $('#tblanggota').find("tr:gt(0)").remove();
                        getanggota();
                        $('#mdlanggota').modal('hide')
                        swal("Sukses!", "Data berhasil diubah", "success");
                        

                    
                        }
                    });
                }

                 $('#tblanggota').on('click', '#btndelete', function (e) {
                     var $id = $(this).closest("tr")   // Finds the closest row <tr> 
                       .find(".nr")     // Gets a descendent with class="nr"
                       .text();         // Retrieves the text within <td>

                   let url = 'http://127.0.0.1:8000/admin/hapususer/' + $.trim($id);        // Outputs the answer

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

                     const url = 'http://127.0.0.1:8000/admin/user/' + $.trim($id) + '/edit';
                    // console.log(url);

                    $('#mdlanggota').modal('show')

                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType: "JSON",
                        success: function (response) {
                            // console.log(response);
                            $('#title').text('Ubah User');
                            $('#btnsimpan').text('Ubah');
                            $.each(response, function (idx, val) { 
                            //    console.log(idx + ':' + val);  

                               if (idx === 'id') {
                                   $('#id').val(val);
                               } else if(idx === 'name'){
                                   $('#name').val(val);
                               } else if(idx === 'email'){
                                   $('#email').val(val);
                               }
                            //    else if(idx === 'password'){
                            //         $('#password').val(val);
                            //    }
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
                            url = 'http://127.0.0.1:8000/admin/getuser';
                            
                        } else {
                            url = 'http://127.0.0.1:8000/admin/cariuser/' + anggota;
                           
                        }

                            $.ajax({
                                type: "GET",
                                url: url,
                                dataType: "JSON",
                                success: function (response) {
                                    // console.log(response);

                                    $('#tblanggota').find("tr:gt(0)").remove();
                                    isi = '';
                                    let no_urut = 1;
                                    response.forEach(el => {
                                        isi += `
                                        <tr>
                                            <td>${no_urut}</td>
                                            <td class="nr"> ${el.id} </td>
                                            <td> ${el.name} </td>
                                            <td> ${el.email} </td>
                                            <td> ${el.is_admin == '1' ? '<span class="badge badge-success">Admin</span>' : '<span class="badge badge-warning">User</span>'}</td>
                                            <td>
                                            <button id="btnchange" class="btn btn-primary"><i class="mdi mdi-power-settings"></i></button> 
                                            <button id="btnedit" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                            <button id="btndelete" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></td>
                                        </tr>
                                        `;
                                        no_urut += 1 ;
                                    });
                                    $('#tblanggota').append(isi);
                                }
                            });
                    }, 500));

                    $('#tblanggota').on('click', '#btnchange', function (e) {
                        e.preventDefault();
                        var $id = $(this).closest("tr")   // Finds the closest row <tr> 
                       .find(".nr")     // Gets a descendent with class="nr"
                       .text();         // Retrieves the text within <td>

                        const url = 'http://127.0.0.1:8000/admin/user/' + $.trim($id) + '/change';
                        // console.log(url);

                        $.ajax({
                            type: "GET",
                            url: url,
                            dataType: "JSON",
                            success: function (response) {
                                // console.log(response);
                                $('#tblanggota').find("tr:gt(0)").remove();
                                getanggota();
                                swal("Sukses!", "Status dirubah", "success");
                            }
                        });
                        
                        
                    });

                });
        </script>    
@endsection
