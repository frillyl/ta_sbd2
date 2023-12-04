<?php

namespace App\Controllers;

class Petugas extends BaseController
{
    public function __construct()
    {
        helper('form');
    }

    public function index()
    {
        $data = [
            'title' => 'Klinik Pratama Medika',
            'sub'   => 'Petugas',
            'isi'   => 'petugas/v_index'
        ];
        return view('layout/v_wrapper', $data);
    }
}
