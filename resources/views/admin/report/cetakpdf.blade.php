<!DOCTYPE html>
<html lang="en">
  <head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" integrity="sha512-P5MgMn1jBN01asBgU0z60Qk4QxiXo86+wlFahKrsQf37c9cro517WzVSPPV1tDKzhku2iJ2FVgL67wG03SGnNA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    
      .a1{
          
          font-size : 12px;
      }
    </style>
  </head>
  <body>
  <header class="a1">
    <h3>DATA PENGEMBALIAN BARANG SEKOLAH</h3>
  </header>
  
  <br>
  <section class="a1">
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Mulai Pinjam</th>
          <th>Batas Kembali</th>
          <th>Pengembalian</th>
          <th>Peminjam</th>
          <th>Barang</th>
          <th>Nomor Serial</th>
          <th>Kelas</th>
          <th>Status</th>
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
          <td>{{ $rp->merk }}</td>
          <td>{{ $rp->SN }}</td>
          <td>{{ $rp->kelas }} {{ $rp->jurusan }} {{ $rp->ruang }}</td>
          <td>{{ $rp->status == '1' ? 'Dikembalikan tepat waktu' : ( $rp->status == '3' ? 'Dikembalikan tapi terlambat' : 'Sedang dipinjam' )}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </section>

  </body>
</html>