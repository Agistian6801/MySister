<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $barang = Barang::create([
                'merk'      => 'Bulpoint',
                'keterangan'=> 'sjdefnvjdkekfs',
                'satuan'    => 'pack',
                'foto'      => 'abc.jpg',
                'jumlah'    => '5',
                

                
        ]);
        $barang = Barang::create([
                'merk'      => 'Meja',
                'keterangan'=> 'sjdefnvjdkekfs',
                'satuan'    => 'pcs',
                'foto'      => 'meja.jpg',
                'jumlah'    => '7'
        ]);
        $barang = Barang::create([
                'merk'      => 'Papan',
                'keterangan'=> 'sjdefnvjdkekfs',
                'satuan'    => 'pcs',
                'foto'      => 'papan.jpg',
                'jumlah'    => '3'
    ]);
    }
}
