@extends('layout.app')

@section('content')
<div class="content-wrapper pb-0" >

        <div class="row">
              <div class="col-md-12 stretch-card grid-margin">
                <div class="card">
                  <div class="card-body shadow">
                        <div class="row">
                            <div class="col-md-12">
                                <h1>CETAK LAPORAN PENGEMBALIAN BARANG</h1>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-1">
                                
                                <a href="{{URL::to('admin/report/cetakpdf')}}">
                                <button id="btnpdf" class="btn btn-danger mt-2 mt-sm-0 btn-icon-text shadow"><i class="mdi mdi-file-pdf"></i></button>
                                </a>
                            </div>
                            <div class="col-sm-1 ">
                                
                                <a href="{{URL::to('admin/export/pengembalian')}}">
                                <button id="btnexcel" class="btn btn-success mt-2 mt-sm-0 btn-icon-text shadow"><i class="mdi mdi-file-excel"></i></button>
                                </a>
                            </div>
                        </div>
                        <br>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Mulai Pinjam</th>
                                        <th>Batas Kembali</th>
                                        <th>Pengembalian</th>
                                        <th>Peminjam</th>
                                        <th>Kelas</th>
                                        <th>Barang</th>
                                        <th>Nomor Serial</th>
                                        <th>Status Pengembalian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($report as $rp)
                                    <tr>
                                        <td>{{ $rp->id }}</td>
                                        <td>{{ $rp->tanggal_pinjam }}</td>
                                        <td>{{ $rp->tanggal_harus_kembali }}</td>
                                        <td>{{ $rp->tanggal_kembali }}</td>
                                        <td>{{ $rp->name }}</td>
                                        <td>{{ $rp->kelas }} {{ $rp->jurusan }} {{ $rp->ruang }}</td>
                                        <td>{{ $rp->merk }}</td>
                                        <td>{{ $rp->SN }}</td>
                                        <td>{{ $rp->status == '1' ? 'Dikembalikan tepat waktu' : ($rp->status == '3' ? 'Dikembalikan tapi terlambat' : 'Belum dikembalikan')}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> 
                  </div>
                </div>
              </div>
        </div>
</div>
@endsection

