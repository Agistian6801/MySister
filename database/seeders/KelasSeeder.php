<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kelas = Kelas::create([
            'kelas'      => 'X',
            'jurusan'=> 'SIJA',
            'ruang'    => '1',
            
        ]);
        $kelas = Kelas::create([
            'kelas'      => 'XI',
            'jurusan'=> 'MM',
            'ruang'    => '2',
            
        ]);
        $kelas = Kelas::create([
            'kelas'      => 'XII',
            'jurusan'=> 'RPL',
            'ruang'    => '1',
            
        ]);
        $kelas = Kelas::create([
            'kelas'      => 'XI',
            'jurusan'=> 'APH',
            'ruang'    => '2',
            
        ]);
        $kelas = Kelas::create([
            'kelas'      => 'XII',
            'jurusan'=> 'JB',
            'ruang'    => '3',
            
        ]);
    }
}
