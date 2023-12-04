<?php

namespace App\Controllers;

use App\Models\ModelJadwal;
use App\Models\ModelDokter;

class Jadwal extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelJadwal = new ModelJadwal();
        $this->ModelDokter = new ModelDokter();
    }

    public function index_dokter()
    {
        $data = [
            'title' => 'Klinik Pratama Medika',
            'sub'   => 'Petugas',
            'isi'   => 'jadwal/v_jadwal',
            'jadwal' => $this->ModelJadwal->allData(),
            'dokter' => $this->ModelDokter->allData()
        ];
        return view('layout/v_wrapper', $data);
    }
}
