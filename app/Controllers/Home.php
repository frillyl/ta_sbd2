<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function __construct()
    {
        helper('form');
    }

    public function index()
    {
        $data = [
            'title' => 'Klinik Pratama Medika'
        ];
        return view('v_home', $data);
    }
}
