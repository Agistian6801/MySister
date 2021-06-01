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
                                <button style="margin-bottom: 10px" class="btn btn-danger delete_all" data-url="{{ url('myproductsDeleteAll') }}">Delete All Selected</button>
                            </div>
                        </div>
                        <br>
                        
                            <div class="table-responsive">
                                <table id="tblbarang" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <td>ID</td>
                                            <td>Kategori</td>
                                            <td>Keterangan</td>
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
                <form id="frmbarang" action="{{ URL::to('kategori') }}" method="post">
                 @csrf
                    <div class="modal-body">

                        
                        <input type="hidden" class="form-control" name="id" id="id" readonly>
                        <br>

                        <label>Kategori</label>
                        <input type="text" class="form-control" name="kategori" id="kategori" >
                        <br>

                        <label>Keterangan</label>
                        <input type="text" class="form-control" name="ketkategori" id="ketkategori" >
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

                function getKategori() { 
                    const url = 'http://127.0.0.1:8000/getkategori';
                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType: "JSON",
                        success: function (response) {
                            isi = '';
                            response.forEach(el => {
                                isi += `
                                    <tr id="tr_${el.id}">
                                        
                                        <td class="nr"> ${el.id} </td>
                                        <td> ${el.kategori} </td>
                                        <td> ${el.ketkategori} </td>
                                        <td> 
                                        <button id="btnedit" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                        <button id="btndelete" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
                                        <input type="checkbox" class="sub_chk" data-id="${el.id}">
                                        </td>
                                    </tr>
                                `;
                            });
                             $('#tblbarang').append(isi);
                        }
                    });
                 }

              
                 getKategori();

                 $('#btnnew').click(function (e) { 
                     e.preventDefault();
                     $('#mdlbarang').modal('show')
                     $('#title').text('Kategori Baru');
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
                         url: "{{route('savekategori')}}",
                         data: frmbarang,
                         cache:false,
                        contentType: false,
                        processData: false,
                        complete: function(response){
                            if($.isEmptyObject(response.responseJSON.error)){
                                // console.log(response);
                                // $('#tblbarang').html("");
                                $('#tblbarang').find("tr:gt(0)").remove();
                                getKategori();
                                $('#mdlbarang').modal('hide')
                                swal("Sukses!", "Data ditambahkan", "success");

                            }
                        }
                     });
                 }

                 function ubahbarang(frmbarang) {
                     let idkat = $('#id').val();
                    //  console.log(idbarang);

                     const url = 'http://127.0.0.1:8000/ubahkategori/' + $.trim(idkat);

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
                            getKategori();
                            $('#mdlbarang').modal('hide')
                            swal("Sukses!", "Data berhasil diperbarui", "success");
                            
                         }
                     });
                     
                     
                 }

                 $('#tblbarang').on('click', '#btndelete', function (e) {
                     var $id = $(this).closest("tr")   // Finds the closest row <tr> 
                       .find(".nr")     // Gets a descendent with class="nr"
                       .text();         // Retrieves the text within <td>

                   let url = 'http://127.0.0.1:8000/hapuskategori/' + $.trim($id);        // Outputs the answer

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

                     const url = 'http://127.0.0.1:8000/kategori/' + $.trim($id) + '/edit';
                    // console.log(url);

                    $('#mdlbarang').modal('show')

                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType: "JSON",
                        success: function (response) {
                            
                            $('#title').text('Ubah Kategori');
                            $('#btnsimpan').text('Ubah');
                            $.each(response, function (idx, val) { 
                            //    console.log(idx + ':' + val);  

                               if (idx === 'kategori') {
                                   $('#kategori').val(val);
                               } else if(idx === 'ketkategori'){
                                   $('#ketkategori').val(val);
                               } else if(idx === 'id'){
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
                            url = 'http://127.0.0.1:8000/getkategori';
                            
                        } else {
                            url = 'http://127.0.0.1:8000/carikategori/' + merk;
                           
                        }

                        $.ajax({
                            type: "GET",
                            url: url,
                            dataType: "JSON",
                            success: function (response) {
                                // console.log(response);

                                $('#tblbarang').find("tr:gt(0)").remove();
                                isi = '';
                                response.forEach(el => {
                                    isi += `
                                        <tr id="tr_${el.id}">
                                        
                                        <td class="nr"> ${el.id} </td>
                                        <td> ${el.kategori} </td>
                                        <td> ${el.ketkategori} </td>
                                        <td> 
                                        <button id="btnedit" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                        <button id="btndelete" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
                                        <input type="checkbox" class="sub_chk" data-id="${el.id}">
                                        </td>
                                    </tr>
                                    `;
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
                                });
                                }
                            }
                    });

            });
        </script>
@endsection

