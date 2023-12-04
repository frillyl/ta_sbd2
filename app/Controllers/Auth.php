<?php

namespace App\Controllers;

use App\Models\ModelAuth;

class Auth extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelAuth = new ModelAuth();
    }

    public function index()
    {
        $data = [
            'title' => 'Klinik Pratama Medika',
            'sub'   => 'Masuk',
        ];
        return view('v_login', $data);
    }

    public function cek_login()
    {
        if ($this->validate([
            'level' => [
                'label' => 'Hak Akses',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Dipilih!'
                ]
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
        ])) {
            $hak_akses = $this->request->getPost('level');
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            if ($hak_akses == 1) {
                $cek_petugas = $this->ModelAuth->login_petugas($username);
                if ($cek_petugas != '') {
                    if (password_verify($password, $cek_petugas['password'])) {
                        session()->set('nama', $cek_petugas['nama']);
                        session()->set('username', $cek_petugas['username']);
                        session()->set('email', $cek_petugas['email']);
                        session()->set('posisi', $cek_petugas['posisi']);
                        session()->set('pasfoto', $cek_petugas['pasfoto']);
                        session()->set('level', $hak_akses);

                        return redirect()->to(base_url('petugas'));
                    } else {
                        session()->setFlashdata('pesan', 'Gagal Login! Username Atau Password Yang Anda Masukkan Salah!');
                        return redirect()->to(base_url('login'));
                    }
                } else {
                    session()->setFlashdata('pesan', 'Gagal Login! Akun Anda Tidak Ditemukan!');
                    return redirect()->to(base_url('login'));
                }
            }
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('login'));
        }
    }

    public function logout()
    {
        session()->remove('log');
        session()->remove('nama');
        session()->remove('username');
        session()->remove('no_str');
        session()->remove('no_rm');
        session()->remove('no_akses');
        session()->remove('email');
        session()->remove('posisi');
        session()->remove('pasfoto');
        session()->remove('level');
        return redirect()->to(base_url());
    }
}
