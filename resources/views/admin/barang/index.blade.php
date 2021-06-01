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
                                <button style="margin-bottom: 10px" class="btn btn-danger delete_all" data-url="{{ url('barangDeleteAll') }}">Delete All Selected</button>
                            </div>
                        </div>
                        <br>
                        
                            <div class="table-responsive">
                                <table id="tblbarang" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <td>No</td>
                                            <td>ID</td>
                                            <td>SN</td>
                                            <td>Foto</td>
                                            <td>Merk</td>
                                            <td>Keterangan</td>
                                            <td>Jumlah</td>
                                            <td>Kondisi Barang</td>
                                            <td >Kategori</td>
                                            <td >Spesifikasi</td>
                                            <td >Lokasi</td>
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
        <div class="modal fade" id="mdlbarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="frmbarang" action="{{ URL::to('barang') }}" method="post" enctype="multipart/form-data">
                 @csrf
                    <div class="modal-body">

                        
                        <input type="hidden" class="form-control" name="id" id="id" readonly>
                        <br>

                        <label>SN</label>
                        <input type="text" class="form-control" name="SN" id="SN" >
                        <br>

                        <label>Merk</label>
                        <input type="text" class="form-control" name="merk" id="merk" >
                        <br>

                        <label>Satuan</label>
                        <input type="text" class="form-control" name="satuan" id="satuan" >
                        <br>

                        <label>Jumlah</label>
                        <input type="text" class="form-control" name="jumlah" id="jumlah" >
                        <br>

                        <label>Kondisi Barang</label>
                        <select class="form-control" name="selkondisi" id="selkondisi">
                        <option value="0">Baik</option>
                        <option value="1">Rusak</option>
                           
                        </select>
                        <br>

                        <label>Kategori</label>
                        <select class="form-control" name="selkategori" id="selkategori">
                           
                        </select>
                        <br>

                        <label>Spesifikasi</label>
                        <textarea class="form-control" name="spesifikasi" id="spesifikasi"></textarea>
                        <br>

                        <label>Lokasi</label>
                        <input type="text" class="form-control" name="lokasi" id="lokasi" >
                        <br>

                        <label>Keterangan</label>
                        <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
                        <br>

                        <label>Foto</label>
                        <input type="file" class="form-control" name="foto" id="foto" >
                        {{-- <input type="file" name="foto" id="foto" class="file-upload-default" /> --}}
                       
                        
                        
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
                let isikategori = '';

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                function getBarang() { 
                    const url = 'http://127.0.0.1:8000/getbarang';
                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType: "JSON",
                        success: function (response) {
                            isi = '';
                            let no_urut = 1;
                            response.forEach(el => {
                                isi += `
                                    <tr id="tr_${el.idbarang}">
                                        <td>${no_urut}</td>
                                        <td class="nr"> ${el.idbarang} </td>
                                        <td> ${el.SN} </td>
                                        <td><img src="/photos/${el.foto}" class="rounded-circle" height="60px" width="60px" alt=""> </td>
                                        <td> ${el.merk} </td>
                                        <td> ${el.keterangan} </td>
                                        <td> ${el.jumlah} ${el.satuan}</td>
                                        <td> ${el.status_barang == '0' ? '<span class="badge badge-primary">Baik</span>' : '<span class="badge badge-danger">Rusak</span>'} </td>
                                        <td> ${el.kategori} </td>
                                        <td> ${el.spesifikasi} </td>
                                        <td> ${el.lokasi} </td>
                                        <td> 
                                        <button id="btnedit" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                        <button id="btndelete" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
                                        <input type="checkbox" class="sub_chk" data-id="${el.idbarang}">
                                        </td>
                                    </tr>
                                `;
                                no_urut += 1;
                            });
                             $('#tblbarang').append(isi);
                        }
                    });
                 }

                function getKategori() {
                    const url = 'http://127.0.0.1:8000/getkategori';
                     $.ajax({
                         type: "GET",
                         url: url,
                         dataType: "JSON",
                         success: function (response) {
                            //  console.log(response);

                             response.forEach(el => {
                                 isikategori += `
                                    <option value="${el.id}">${el.kategori}</option>
                                 `;
                             });

                             $('#selkategori').append(isikategori);
                         }
                     }); 

                }

                 getBarang();
                 getKategori();

                 $('#btnnew').click(function (e) { 
                     e.preventDefault();
                     $('#mdlbarang').modal('show')
                     $('#title').text('Barang Baru');
                     $('#btnsimpan').text('Simpan');
                     $('#frmbarang')[0].reset();
                 });

                 $('#frmbarang').on('submit', function (e) {
                     e.preventDefault();
                     let frmbarang = new FormData(this);

                     if ($('#btnsimpan').text() === 'Simpan') {
                        //  console.log('panggil fungsi simpan');
                         simpanbarang(frmbarang)
                     } else {
                        // console.log('Panggil fungsi ubah');
                        
                        ubahbarang(frmbarang)
                     }

                     
                 });

                 function simpanbarang(frmbarang) {
                     $.ajax({
                         type: "POST",
                         url: "{{route('savebarang')}}",
                         data: frmbarang,
                         cache:false,
                        contentType: false,
                        processData: false,
                        complete: function(response){
                            if($.isEmptyObject(response.responseJSON.error)){
                                // console.log(response);
                                // $('#tblbarang').html("");
                                $('#tblbarang').find("tr:gt(0)").remove();
                                getBarang();
                                $('#mdlbarang').modal('hide')
                                swal("Sukses!", "Data ditambahkan", "success");

                            }
                        }
                     });
                 }

                 function ubahbarang(frmbarang) {
                     let idbarang = $('#id').val();
                    //  console.log(idbarang);

                     const url = 'http://127.0.0.1:8000/ubahbarang/' + $.trim(idbarang);

                     $.ajax({
                         type: "POST",
                         url: url,
                         data: frmbarang,
                         cache:false,
                        contentType: false,
                        processData: false,
                         success: function (response) {
                            // console.log(response);
                            $('#tblbarang').find("tr:gt(0)").remove();
                            getBarang();
                            $('#mdlbarang').modal('hide')
                            swal("Sukses!", "Data berhasil diperbarui", "success");
                            
                         }
                     });
                     
                     
                 }

                 $('#tblbarang').on('click', '#btndelete', function (e) {
                     var $id = $(this).closest("tr")   // Finds the closest row <tr> 
                       .find(".nr")     // Gets a descendent with class="nr"
                       .text();         // Retrieves the text within <td>

                   let url = 'http://127.0.0.1:8000/hapusbarang/' + $.trim($id);        // Outputs the answer

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

                     const url = 'http://127.0.0.1:8000/barang/' + $.trim($id) + '/edit';
                    // console.log(url);

                    $('#mdlbarang').modal('show')

                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType: "JSON",
                        success: function (response) {
                            
                            $('#title').text('Ubah Barang');
                            $('#btnsimpan').text('Ubah');
                            $.each(response, function (idx, val) { 
                            //    console.log(idx + ':' + val);  

                               if (idx === 'merk') {
                                   $('#merk').val(val);
                               } else if(idx === 'satuan'){
                                   $('#satuan').val(val);
                               } else if(idx === 'jumlah'){
                                  $('#jumlah').val(val);
                               }else if(idx === 'keterangan'){
                                  $('#keterangan').val(val);
                               }else if(idx === 'id'){
                                  $('#id').val(val);
                               }else if(idx === 'status_barang'){
                                   $('#selkondisi').val(val).change();
                               }else if(idx === 'kategori_id'){
                                   $('#selkategori').val(val).change();
                               }else if(idx === 'spesifikasi'){
                                  $('#spesifikasi').val(val);
                               }else if(idx === 'lokasi'){
                                  $('#lokasi').val(val);
                               }else if(idx === 'SN'){
                                  $('#SN').val(val);
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
                            url = 'http://127.0.0.1:8000/getbarang';
                            
                        } else {
                            url = 'http://127.0.0.1:8000/caribarang/' + merk;
                           
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
                                    isi += `
                                        <tr>
                                            <td>${no_urut}</td>
                                            <td class="nr"> ${el.idbarang} </td>
                                            <td> ${el.SN} </td>
                                            <td><img src="/photos/${el.foto}" class="rounded-circle" height="60px" width="60px" alt=""> </td>
                                            <td> ${el.merk} </td>
                                            <td> ${el.keterangan} </td>
                                            <td> ${el.jumlah} ${el.satuan}</td>
                                            <td> ${el.status_barang == '0' ? '<span class="badge badge-primary">Primary</span>' : '<span class="badge badge-danger">Rusak</span>'} </td>
                                            <td> ${el.kategori} </td>
                                            <td> ${el.spesifikasi} </td>
                                            <td> ${el.lokasi} </td>
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

