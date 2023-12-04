<?php

namespace App\Controllers;

use App\Models\ModelDokter;
use App\Models\ModelNakes;
use App\Models\ModelPasien;
use App\Models\ModelPemilik;
use App\Models\ModelPetugas;
use App\Models\ModelObat;
use App\Models\ModelLab;
use App\Models\ModelRs;
use App\Models\ModelPoli;

class Master extends BaseController
{
    public function __construct()
    {
        helper('form');
        helper('text');
        $this->ModelDokter = new ModelDokter();
        $this->ModelNakes = new ModelNakes();
        $this->ModelPasien = new ModelPasien();
        $this->ModelPemilik = new ModelPemilik();
        $this->ModelPetugas = new ModelPetugas();
        $this->ModelObat = new ModelObat();
        $this->ModelLab = new ModelLab();
        $this->ModelRs = new ModelRs();
        $this->ModelPoli = new ModelPoli();
    }

    // CONTROLLER DOKTER
    public function index_dokter()
    {
        $data = [
            'title' => 'Klinik Pratama Medika',
            'sub'   => 'Petugas',
            'isi'   => 'master/v_dokter',
            'dokter' => $this->ModelDokter->allData()
        ];
        return view('layout/v_wrapper', $data);
    }

    public function add_dokter()
    {
        if ($this->validate([
            'spesialis' => [
                'label' => 'Spesialis',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'no_str' => [
                'label' => 'Nomor STR',
                'rules' => 'required|is_unique[tb_dokter.no_str]|min_length[5]|max_length[5]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'is_unique' => '{field} Telah Terdaftar!',
                    'min_length' => 'Masukan 5 Digit Terakhir {field}!',
                    'max_length' => 'Masukan 5 Digit Terakhir {field}!'
                ]
            ],
            'nama' => [
                'label' => 'Nama Dokter',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'j_kel' => [
                'label' => 'Jenis Kelamin',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required|is_unique[tb_dokter.username]|max_length[25]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'is_unique' => '{field} Telah Terdaftar!',
                    'max_length' => '{field} Maksimal 25 Karakter!'
                ]
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|is_unique[tb_dokter.email]|valid_email',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'is_unique' => '{field} Telah Terdaftar!',
                    'valid_email' => '{field} Tidak Valid!'
                ]
            ],
            'no_hp' => [
                'label' => 'Nomor Ponsel',
                'rules' => 'required|is_unique[tb_dokter.no_hp]|max_length[12]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'is_unique' => '{field} Telah Digunakan!',
                    'max_length' => '{field} Tidak Valid!'
                ]
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'max_length' => '{field} Maksimal 100 Karakter!'
                ]
            ],
            'ktp' => [
                'label' => 'KTP',
                'rules' => 'uploaded[foto]|max_size[foto,1024]|mime_in[foto,image/png,image/jpg]',
                'errors' => [
                    'uploaded' => '{field} Wajib Diupload!',
                    'max_size' => 'Ukuran File {field} Maksimal 1 MB!',
                    'mime_in'  => 'Format File {field} Harus JPG/PNG!'
                ]
            ],
            'foto' => [
                'label' => 'Foto',
                'rules' => 'uploaded[foto]|max_size[foto,1024]|mime_in[foto,image/png,image/jpg]',
                'errors' => [
                    'uploaded' => '{field} Wajib Diupload!',
                    'max_size' => 'Ukuran File {field} Maksimal 1 MB!',
                    'mime_in'  => 'Format File {field} Harus JPG/PNG!'
                ]
            ],
        ])) {
            $foto = $this->request->getFile('foto');
            $ktp = $this->request->getFile('ktp');
            $nm_file = $foto->getRandomName();
            $nm_file2 = $ktp->getRandomName();
            $data = array(
                'spesialis' => $this->request->getPost('spesialis'),
                'no_str' => $this->request->getPost('no_str'),
                'nama' => $this->request->getPost('nama'),
                'j_kel' => $this->request->getPost('j_kel'),
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'no_hp' => $this->request->getPost('no_hp'),
                'alamat' => $this->request->getPost('alamat'),
                'up_ktp' => $nm_file2,
                'pasfoto' => $nm_file
            );
            $foto->move('assets/images/pasfoto', $nm_file);
            $ktp->move('assets/images/ktp', $nm_file2);
            $this->ModelDokter->add($data);
            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');
            return redirect()->to(base_url('master/dokter'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('master/dokter'));
        }
    }

    public function edit_dokter($id_dokter)
    {
        if ($this->validate([
            'spesialis' => [
                'label' => 'Spesialis',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'no_str' => [
                'label' => 'Nomor STR',
                'rules' => 'required|min_length[5]|max_length[5]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'min_length' => 'Masukan 5 Digit Terakhir {field}!',
                    'max_length' => 'Masukan 5 Digit Terakhir {field}!'
                ]
            ],
            'nama' => [
                'label' => 'Nama Dokter',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'j_kel' => [
                'label' => 'Jenis Kelamin',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required|max_length[25]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'max_length' => '{field} Maksimal 25 Karakter!'
                ]
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'valid_email' => '{field} Tidak Valid!'
                ]
            ],
            'no_hp' => [
                'label' => 'Nomor Ponsel',
                'rules' => 'required|max_length[12]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'is_unique' => '{field} Telah Digunakan!',
                    'max_length' => '{field} Tidak Valid!'
                ]
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'max_length' => '{field} Maksimal 100 Karakter!'
                ]
            ],
            'ktp' => [
                'label' => 'KTP',
                'rules' => 'max_size[foto,1024]|mime_in[foto,image/png,image/jpg]',
                'errors' => [
                    'max_size' => 'Ukuran File {field} Maksimal 1 MB!',
                    'mime_in'  => 'Format File {field} Harus JPG/PNG!'
                ]
            ],
            'foto' => [
                'label' => 'Foto',
                'rules' => 'max_size[foto,1024]|mime_in[foto,image/png,image/jpg]',
                'errors' => [
                    'max_size' => 'Ukuran File {field} Maksimal 1 MB!',
                    'mime_in'  => 'Format File {field} Harus JPG/PNG!'
                ]
            ],
        ])) {
            $ktp = $this->request->getFile('ktp');
            $foto = $this->request->getFile('foto');
            if ($foto->getError() == 4 && $ktp->getError() == 4) {
                $data = array(
                    'id_dokter' => $id_dokter,
                    'spesialis' => $this->request->getPost('spesialis'),
                    'no_str' => $this->request->getPost('no_str'),
                    'nama' => $this->request->getPost('nama'),
                    'j_kel' => $this->request->getPost('j_kel'),
                    'username' => $this->request->getPost('username'),
                    'email' => $this->request->getPost('email'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'alamat' => $this->request->getPost('alamat'),
                );
                $this->ModelDokter->edit($data);
            } elseif ($foto->getError() == 4 && $ktp->getError() != 4) {
                $dokter = $this->ModelDokter->detailData($id_dokter);
                if ($dokter['up_ktp'] != "") {
                    unlink('assets/images/ktp/' . $dokter['up_ktp']);
                }
                $nm_file2 = $ktp->getRandomName();
                $data = array(
                    'id_dokter' => $id_dokter,
                    'spesialis' => $this->request->getPost('spesialis'),
                    'no_str' => $this->request->getPost('no_str'),
                    'nama' => $this->request->getPost('nama'),
                    'j_kel' => $this->request->getPost('j_kel'),
                    'username' => $this->request->getPost('username'),
                    'email' => $this->request->getPost('email'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'alamat' => $this->request->getPost('alamat'),
                    'up_ktp'   => $nm_file2,
                );
                $ktp->move('assets/images/ktp', $nm_file2);
                $this->ModelDokter->edit($data);
            } elseif ($foto->getError() != 4 && $ktp->getError() == 4) {
                $dokter = $this->ModelDokter->detailData($id_dokter);
                if ($dokter['pasfoto'] != "") {
                    unlink('assets/images/pasfoto/' . $dokter['pasfoto']);
                }
                $nm_file = $foto->getRandomName();
                $data = array(
                    'id_dokter' => $id_dokter,
                    'spesialis' => $this->request->getPost('spesialis'),
                    'no_str' => $this->request->getPost('no_str'),
                    'nama' => $this->request->getPost('nama'),
                    'j_kel' => $this->request->getPost('j_kel'),
                    'username' => $this->request->getPost('username'),
                    'email' => $this->request->getPost('email'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'alamat' => $this->request->getPost('alamat'),
                    'pasfoto'  => $nm_file
                );
                $foto->move('assets/images/pasfoto/', $nm_file);
                $this->ModelDokter->edit($data);
            } else {
                $dokter = $this->ModelDokter->detailData($id_dokter);
                if ($dokter['pasfoto'] != "") {
                    if ($dokter['up_ktp'] != "") {
                        unlink('assets/images/pasfoto/' . $dokter['pasfoto']);
                        unlink('assets/images/ktp/' . $dokter['up_ktp']);
                    }
                }
                $nm_file = $foto->getRandomName();
                $nm_file2 = $ktp->getRandomName();
                $data = array(
                    'id_dokter' => $id_dokter,
                    'spesialis' => $this->request->getPost('spesialis'),
                    'no_str' => $this->request->getPost('no_str'),
                    'nama' => $this->request->getPost('nama'),
                    'j_kel' => $this->request->getPost('j_kel'),
                    'username' => $this->request->getPost('username'),
                    'email' => $this->request->getPost('email'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'alamat' => $this->request->getPost('alamat'),
                    'up_ktp'   => $nm_file2,
                    'pasfoto'  => $nm_file
                );
                $foto->move('assets/images/pasfoto/', $nm_file);
                $ktp->move('assets/images/ktp/', $nm_file2);
                $this->ModelDokter->edit($data);
            }
            session()->setFlashdata('pesan', 'Data Berhasil Diubah!');
            return redirect()->to(base_url('master/dokter'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('master/dokter'));
        }
    }

    public function delete_dokter($id_dokter)
    {
        $dokter = $this->ModelDokter->detailData($id_dokter);
        if ($dokter['pasfoto'] != "") {
            unlink('assets/images/pasfoto/' . $dokter['pasfoto']);
            unlink('assets/images/ktp/' . $dokter['up_ktp']);
        }

        $data = [
            'id_dokter' => $id_dokter,
        ];
        $this->ModelDokter->delete_data($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus!');
        return redirect()->to(base_url('master/dokter'));
    }

    // CONTROLLER NAKES
    public function index_nakes()
    {
        $data = [
            'title' => 'Klinik Pratama Medika',
            'sub'   => 'Petugas',
            'isi'   => 'master/v_nakes',
            'nakes' => $this->ModelNakes->allData()
        ];
        return view('layout/v_wrapper', $data);
    }

    public function add_nakes()
    {
        if ($this->validate([
            'posisi' => [
                'label' => 'Posisi',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'no_str' => [
                'label' => 'Nomor STR',
                'rules' => 'required|is_unique[tb_nakes.no_str]|min_length[5]|max_length[5]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'is_unique' => '{field} Telah Terdaftar!',
                    'min_length' => 'Masukan 5 Digit Terakhir {field}!',
                    'max_length' => 'Masukan 5 Digit Terakhir {field}!'
                ]
            ],
            'nama' => [
                'label' => 'Nama Tenaga Kesehatan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'j_kel' => [
                'label' => 'Jenis Kelamin',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required|is_unique[tb_nakes.username]|max_length[25]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'is_unique' => '{field} Telah Terdaftar!',
                    'max_length' => '{field} Maksimal 25 Karakter!'
                ]
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|is_unique[tb_nakes.email]|valid_email',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'is_unique' => '{field} Telah Terdaftar!',
                    'valid_email' => '{field} Tidak Valid!'
                ]
            ],
            'no_hp' => [
                'label' => 'Nomor Ponsel',
                'rules' => 'required|is_unique[tb_nakes.no_hp]|max_length[12]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'is_unique' => '{field} Telah Digunakan!',
                    'max_length' => '{field} Tidak Valid!'
                ]
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'max_length' => '{field} Maksimal 100 Karakter!'
                ]
            ],
            'ktp' => [
                'label' => 'KTP',
                'rules' => 'uploaded[foto]|max_size[foto,1024]|mime_in[foto,image/png,image/jpg]',
                'errors' => [
                    'uploaded' => '{field} Wajib Diupload!',
                    'max_size' => 'Ukuran File {field} Maksimal 1 MB!',
                    'mime_in'  => 'Format File {field} Harus JPG/PNG!'
                ]
            ],
            'foto' => [
                'label' => 'Foto',
                'rules' => 'uploaded[foto]|max_size[foto,1024]|mime_in[foto,image/png,image/jpg]',
                'errors' => [
                    'uploaded' => '{field} Wajib Diupload!',
                    'max_size' => 'Ukuran File {field} Maksimal 1 MB!',
                    'mime_in'  => 'Format File {field} Harus JPG/PNG!'
                ]
            ],
        ])) {
            $foto = $this->request->getFile('foto');
            $ktp = $this->request->getFile('ktp');
            $nm_file = $foto->getRandomName();
            $nm_file2 = $ktp->getRandomName();
            $data = array(
                'posisi' => $this->request->getPost('posisi'),
                'no_str' => $this->request->getPost('no_str'),
                'nama' => $this->request->getPost('nama'),
                'j_kel' => $this->request->getPost('j_kel'),
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'no_hp' => $this->request->getPost('no_hp'),
                'alamat' => $this->request->getPost('alamat'),
                'up_ktp' => $nm_file2,
                'pasfoto' => $nm_file
            );
            $foto->move('assets/images/pasfoto', $nm_file);
            $ktp->move('assets/images/ktp', $nm_file2);
            $this->ModelNakes->add($data);
            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');
            return redirect()->to(base_url('master/nakes'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('master/nakes'));
        }
    }

    public function edit_nakes($id_nakes)
    {
        if ($this->validate([
            'posisi' => [
                'label' => 'posisi',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'no_str' => [
                'label' => 'Nomor STR',
                'rules' => 'required|min_length[5]|max_length[5]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'min_length' => 'Masukan 5 Digit Terakhir {field}!',
                    'max_length' => 'Masukan 5 Digit Terakhir {field}!'
                ]
            ],
            'nama' => [
                'label' => 'Nama Tenaga Kesehatan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'j_kel' => [
                'label' => 'Jenis Kelamin',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required|max_length[25]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'max_length' => '{field} Maksimal 25 Karakter!'
                ]
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'valid_email' => '{field} Tidak Valid!'
                ]
            ],
            'no_hp' => [
                'label' => 'Nomor Ponsel',
                'rules' => 'required|max_length[12]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'is_unique' => '{field} Telah Digunakan!',
                    'max_length' => '{field} Tidak Valid!'
                ]
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'max_length' => '{field} Maksimal 100 Karakter!'
                ]
            ],
            'ktp' => [
                'label' => 'KTP',
                'rules' => 'max_size[foto,1024]|mime_in[foto,image/png,image/jpg]',
                'errors' => [
                    'max_size' => 'Ukuran File {field} Maksimal 1 MB!',
                    'mime_in'  => 'Format File {field} Harus JPG/PNG!'
                ]
            ],
            'foto' => [
                'label' => 'Foto',
                'rules' => 'max_size[foto,1024]|mime_in[foto,image/png,image/jpg]',
                'errors' => [
                    'max_size' => 'Ukuran File {field} Maksimal 1 MB!',
                    'mime_in'  => 'Format File {field} Harus JPG/PNG!'
                ]
            ],
        ])) {
            $ktp = $this->request->getFile('ktp');
            $foto = $this->request->getFile('foto');
            if ($foto->getError() == 4 && $ktp->getError() == 4) {
                $data = array(
                    'id_nakes' => $id_nakes,
                    'posisi' => $this->request->getPost('posisi'),
                    'no_str' => $this->request->getPost('no_str'),
                    'nama' => $this->request->getPost('nama'),
                    'j_kel' => $this->request->getPost('j_kel'),
                    'username' => $this->request->getPost('username'),
                    'email' => $this->request->getPost('email'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'alamat' => $this->request->getPost('alamat'),
                );
                $this->ModelNakes->edit($data);
            } elseif ($foto->getError() == 4 && $ktp->getError() != 4) {
                $nakes = $this->ModelNakes->detailData($id_nakes);
                if ($nakes['up_ktp'] != "") {
                    unlink('assets/images/ktp/' . $nakes['up_ktp']);
                }
                $nm_file2 = $ktp->getRandomName();
                $data = array(
                    'id_nakes' => $id_nakes,
                    'posisi' => $this->request->getPost('posisi'),
                    'no_str' => $this->request->getPost('no_str'),
                    'nama' => $this->request->getPost('nama'),
                    'j_kel' => $this->request->getPost('j_kel'),
                    'username' => $this->request->getPost('username'),
                    'email' => $this->request->getPost('email'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'alamat' => $this->request->getPost('alamat'),
                    'up_ktp'   => $nm_file2,
                );
                $ktp->move('assets/images/ktp', $nm_file2);
                $this->ModelNakes->edit($data);
            } elseif ($foto->getError() != 4 && $ktp->getError() == 4) {
                $nakes = $this->ModelNakes->detailData($id_nakes);
                if ($nakes['pasfoto'] != "") {
                    unlink('assets/images/pasfoto/' . $nakes['pasfoto']);
                }
                $nm_file = $foto->getRandomName();
                $data = array(
                    'id_nakes' => $id_nakes,
                    'posisi' => $this->request->getPost('posisi'),
                    'no_str' => $this->request->getPost('no_str'),
                    'nama' => $this->request->getPost('nama'),
                    'j_kel' => $this->request->getPost('j_kel'),
                    'username' => $this->request->getPost('username'),
                    'email' => $this->request->getPost('email'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'alamat' => $this->request->getPost('alamat'),
                    'pasfoto'  => $nm_file
                );
                $foto->move('assets/images/pasfoto/', $nm_file);
                $this->ModelNakes->edit($data);
            } elseif ($foto->getError() != 4 && $ktp->getError() != 4) {
                $nakes = $this->ModelNakes->detailData($id_nakes);
                if ($nakes['pasfoto'] != "") {
                    if ($nakes['up_ktp'] != "") {
                        unlink('assets/images/pasfoto/' . $nakes['pasfoto']);
                        unlink('assets/images/ktp/' . $nakes['up_ktp']);
                    }
                }
                $nm_file = $foto->getRandomName();
                $nm_file2 = $ktp->getRandomName();
                $data = array(
                    'id_nakes' => $id_nakes,
                    'posisi' => $this->request->getPost('posisi'),
                    'no_str' => $this->request->getPost('no_str'),
                    'nama' => $this->request->getPost('nama'),
                    'j_kel' => $this->request->getPost('j_kel'),
                    'username' => $this->request->getPost('username'),
                    'email' => $this->request->getPost('email'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'alamat' => $this->request->getPost('alamat'),
                    'up_ktp'   => $nm_file2,
                    'pasfoto'  => $nm_file
                );
                $foto->move('assets/images/pasfoto/', $nm_file);
                $ktp->move('assets/images/ktp/', $nm_file2);
                $this->ModelNakes->edit($data);
            }
            session()->setFlashdata('pesan', 'Data Berhasil Diubah!');
            return redirect()->to(base_url('master/nakes'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('master/nakes'));
        }
    }

    public function delete_nakes($id_nakes)
    {
        $nakes = $this->ModelNakes->detailData($id_nakes);
        if ($nakes['pasfoto'] != "") {
            unlink('assets/images/pasfoto/' . $nakes['pasfoto']);
            unlink('assets/images/ktp/' . $nakes['up_ktp']);
        }

        $data = [
            'id_nakes' => $id_nakes,
        ];
        $this->ModelNakes->delete_data($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus!');
        return redirect()->to(base_url('master/nakes'));
    }

    // CONTROLLER PASIEN
    public function index_pasien()
    {
        $data = [
            'title' => 'Klinik Pratama Medika',
            'sub'   => 'Petugas',
            'isi'   => 'master/v_pasien',
            'pasien' => $this->ModelPasien->allData()
        ];
        return view('layout/v_wrapper', $data);
    }

    public function add_pasien()
    {
        if ($this->validate([
            'no_rm' => [
                'label' => 'Nomor Rekam Medis',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'nama' => [
                'label' => 'Nama Pasien',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'j_kel' => [
                'label' => 'Jenis Kelamin',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'valid_email' => '{field} Tidak Valid!'
                ]
            ],
            'no_hp' => [
                'label' => 'Nomor Ponsel',
                'rules' => 'required|max_length[12]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'max_length' => '{field} Tidak Valid!'
                ]
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'max_length' => '{field} Maksimal 100 Karakter!'
                ]
            ],
            'ktp' => [
                'label' => 'KTP',
                'rules' => 'max_size[foto,1024]|mime_in[foto,image/png,image/jpg]',
                'errors' => [
                    'max_size' => 'Ukuran File {field} Maksimal 1 MB!',
                    'mime_in'  => 'Format File {field} Harus JPG/PNG!'
                ]
            ],
            'foto' => [
                'label' => 'Foto',
                'rules' => 'max_size[foto,1024]|mime_in[foto,image/png,image/jpg]',
                'errors' => [
                    'max_size' => 'Ukuran File {field} Maksimal 1 MB!',
                    'mime_in'  => 'Format File {field} Harus JPG/PNG!'
                ]
            ],
        ])) {
            $ktp = $this->request->getFile('ktp');
            $foto = $this->request->getFile('foto');
            if ($foto->getError() == 4 && $ktp->getError() == 4) {
                $data = array(
                    'no_rm' => $this->request->getPost('no_rm'),
                    'nama' => $this->request->getPost('nama'),
                    'j_kel' => $this->request->getPost('j_kel'),
                    'email' => $this->request->getPost('email'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'alamat' => $this->request->getPost('alamat'),
                );
                $this->ModelPasien->add($data);
            } elseif ($foto->getError() == 4 && $ktp->getError() != 4) {
                $nm_file2 = $ktp->getRandomName();
                $data = array(
                    'no_rm' => $this->request->getPost('no_rm'),
                    'nama' => $this->request->getPost('nama'),
                    'j_kel' => $this->request->getPost('j_kel'),
                    'email' => $this->request->getPost('email'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'alamat' => $this->request->getPost('alamat'),
                    'up_ktp'   => $nm_file2,
                );
                $ktp->move('assets/images/ktp', $nm_file2);
                $this->ModelPasien->add($data);
            } elseif ($foto->getError() != 4 && $ktp->getError() == 4) {
                $nm_file = $foto->getRandomName();
                $data = array(
                    'no_rm' => $this->request->getPost('no_rm'),
                    'nama' => $this->request->getPost('nama'),
                    'j_kel' => $this->request->getPost('j_kel'),
                    'email' => $this->request->getPost('email'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'alamat' => $this->request->getPost('alamat'),
                    'pasfoto'  => $nm_file
                );
                $foto->move('assets/images/pasfoto/', $nm_file);
                $this->ModelPasien->add($data);
            } elseif ($foto->getError() != 4 && $ktp->getError() != 4) {
                $nm_file = $foto->getRandomName();
                $nm_file2 = $ktp->getRandomName();
                $data = array(
                    'no_rm' => $this->request->getPost('no_rm'),
                    'nama' => $this->request->getPost('nama'),
                    'j_kel' => $this->request->getPost('j_kel'),
                    'email' => $this->request->getPost('email'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'alamat' => $this->request->getPost('alamat'),
                    'up_ktp'   => $nm_file2,
                    'pasfoto'  => $nm_file
                );
                $foto->move('assets/images/pasfoto/', $nm_file);
                $ktp->move('assets/images/ktp/', $nm_file2);
                $this->ModelPasien->add($data);
            }
            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');
            return redirect()->to(base_url('master/pasien'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('master/pasien'));
        }
    }

    public function edit_pasien($id_pasien)
    {
        if ($this->validate([
            'no_rm' => [
                'label' => 'Nomor Rekam Medis',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'nama' => [
                'label' => 'Nama Pasien',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'j_kel' => [
                'label' => 'Jenis Kelamin',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'valid_email' => '{field} Tidak Valid!'
                ]
            ],
            'no_hp' => [
                'label' => 'Nomor Ponsel',
                'rules' => 'required|max_length[12]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'max_length' => '{field} Tidak Valid!'
                ]
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'max_length' => '{field} Maksimal 100 Karakter!'
                ]
            ],
            'ktp' => [
                'label' => 'KTP',
                'rules' => 'max_size[foto,1024]|mime_in[foto,image/png,image/jpg]',
                'errors' => [
                    'max_size' => 'Ukuran File {field} Maksimal 1 MB!',
                    'mime_in'  => 'Format File {field} Harus JPG/PNG!'
                ]
            ],
            'foto' => [
                'label' => 'Foto',
                'rules' => 'max_size[foto,1024]|mime_in[foto,image/png,image/jpg]',
                'errors' => [
                    'max_size' => 'Ukuran File {field} Maksimal 1 MB!',
                    'mime_in'  => 'Format File {field} Harus JPG/PNG!'
                ]
            ],
        ])) {
            $ktp = $this->request->getFile('ktp');
            $foto = $this->request->getFile('foto');
            if ($foto->getError() == 4 && $ktp->getError() == 4) {
                $data = array(
                    'id_pasien' => $id_pasien,
                    'no_rm' => $this->request->getPost('no_rm'),
                    'nama' => $this->request->getPost('nama'),
                    'j_kel' => $this->request->getPost('j_kel'),
                    'email' => $this->request->getPost('email'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'alamat' => $this->request->getPost('alamat'),
                );
                $this->ModelPasien->edit($data);
            } elseif ($foto->getError() == 4 && $ktp->getError() != 4) {
                $pasien = $this->ModelPasien->detailData($id_pasien);
                if ($pasien['up_ktp'] != "") {
                    unlink('assets/images/ktp/' . $pasien['up_ktp']);
                }
                $nm_file2 = $ktp->getRandomName();
                $data = array(
                    'id_pasien' => $id_pasien,
                    'no_rm' => $this->request->getPost('no_rm'),
                    'nama' => $this->request->getPost('nama'),
                    'j_kel' => $this->request->getPost('j_kel'),
                    'email' => $this->request->getPost('email'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'alamat' => $this->request->getPost('alamat'),
                    'up_ktp'   => $nm_file2,
                );
                $ktp->move('assets/images/ktp', $nm_file2);
                $this->ModelPasien->edit($data);
            } elseif ($foto->getError() != 4 && $ktp->getError() == 4) {
                $pasien = $this->ModelPasien->detailData($id_pasien);
                if ($pasien['pasfoto'] != "") {
                    unlink('assets/images/pasfoto/' . $pasien['pasfoto']);
                }
                $nm_file = $foto->getRandomName();
                $data = array(
                    'id_pasien' => $id_pasien,
                    'no_rm' => $this->request->getPost('no_rm'),
                    'nama' => $this->request->getPost('nama'),
                    'j_kel' => $this->request->getPost('j_kel'),
                    'email' => $this->request->getPost('email'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'alamat' => $this->request->getPost('alamat'),
                    'pasfoto'  => $nm_file
                );
                $foto->move('assets/images/pasfoto/', $nm_file);
                $this->ModelPasien->edit($data);
            } elseif ($foto->getError() != 4 && $ktp->getError() != 4) {
                $pasien = $this->ModelPasien->detailData($id_pasien);
                if ($pasien['pasfoto'] != "") {
                    if ($pasien['up_ktp'] != "") {
                        unlink('assets/images/pasfoto/' . $pasien['pasfoto']);
                        unlink('assets/images/ktp/' . $pasien['up_ktp']);
                    }
                }
                $nm_file = $foto->getRandomName();
                $nm_file2 = $ktp->getRandomName();
                $data = array(
                    'id_pasien' => $id_pasien,
                    'no_rm' => $this->request->getPost('no_rm'),
                    'nama' => $this->request->getPost('nama'),
                    'j_kel' => $this->request->getPost('j_kel'),
                    'email' => $this->request->getPost('email'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'alamat' => $this->request->getPost('alamat'),
                    'up_ktp'   => $nm_file2,
                    'pasfoto'  => $nm_file
                );
                $foto->move('assets/images/pasfoto/', $nm_file);
                $ktp->move('assets/images/ktp/', $nm_file2);
                $this->ModelPasien->edit($data);
            }
            session()->setFlashdata('pesan', 'Data Berhasil Diubah!');
            return redirect()->to(base_url('master/pasien'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('master/pasien'));
        }
    }

    public function delete_pasien($id_pasien)
    {
        $pasien = $this->ModelPasien->detailData($id_pasien);
        if ($pasien['pasfoto'] != "") {
            unlink('assets/images/pasfoto/' . $pasien['pasfoto']);
            unlink('assets/images/ktp/' . $pasien['up_ktp']);
        }

        $data = [
            'id_pasien' => $id_pasien,
        ];
        $this->ModelPasien->delete_data($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus!');
        return redirect()->to(base_url('master/pasien'));
    }

    public function index_pemilik()
    {
        $data = [
            'title' => 'Klinik Pratama Medika',
            'sub'   => 'Petugas',
            'isi'   => 'master/v_pemilik',
            'pemilik' => $this->ModelPemilik->allData()
        ];
        return view('layout/v_wrapper', $data);
    }

    public function add_pemilik()
    {
        if ($this->validate([
            'nama' => [
                'label' => 'Nama Pemilik',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'j_kel' => [
                'label' => 'Jenis Kelamin',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|is_unique[tb_nakes.email]|valid_email',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'is_unique' => '{field} Telah Terdaftar!',
                    'valid_email' => '{field} Tidak Valid!'
                ]
            ],
            'no_hp' => [
                'label' => 'Nomor Ponsel',
                'rules' => 'required|is_unique[tb_nakes.no_hp]|max_length[12]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'is_unique' => '{field} Telah Digunakan!',
                    'max_length' => '{field} Tidak Valid!'
                ]
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'max_length' => '{field} Maksimal 100 Karakter!'
                ]
            ],
            'ktp' => [
                'label' => 'KTP',
                'rules' => 'uploaded[foto]|max_size[foto,1024]|mime_in[foto,image/png,image/jpg]',
                'errors' => [
                    'uploaded' => '{field} Wajib Diupload!',
                    'max_size' => 'Ukuran File {field} Maksimal 1 MB!',
                    'mime_in'  => 'Format File {field} Harus JPG/PNG!'
                ]
            ],
            'foto' => [
                'label' => 'Foto',
                'rules' => 'uploaded[foto]|max_size[foto,1024]|mime_in[foto,image/png,image/jpg]',
                'errors' => [
                    'uploaded' => '{field} Wajib Diupload!',
                    'max_size' => 'Ukuran File {field} Maksimal 1 MB!',
                    'mime_in'  => 'Format File {field} Harus JPG/PNG!'
                ]
            ],
        ])) {
            $foto = $this->request->getFile('foto');
            $ktp = $this->request->getFile('ktp');
            $nm_file = $foto->getRandomName();
            $nm_file2 = $ktp->getRandomName();
            $data = array(
                'posisi' => $this->request->getPost('posisi'),
                'no_str' => $this->request->getPost('no_str'),
                'nama' => $this->request->getPost('nama'),
                'j_kel' => $this->request->getPost('j_kel'),
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'no_hp' => $this->request->getPost('no_hp'),
                'alamat' => $this->request->getPost('alamat'),
                'up_ktp' => $nm_file2,
                'pasfoto' => $nm_file
            );
            $foto->move('assets/images/pasfoto', $nm_file);
            $ktp->move('assets/images/ktp', $nm_file2);
            $this->ModelPemilik->add($data);
            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');
            return redirect()->to(base_url('master/pemilik'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('master/pemilik'));
        }
    }

    public function edit_pemilik($id_pemilik)
    {
        if ($this->validate([
            'nama' => [
                'label' => 'Nama Tenaga Kesehatan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'j_kel' => [
                'label' => 'Jenis Kelamin',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'valid_email' => '{field} Tidak Valid!'
                ]
            ],
            'no_hp' => [
                'label' => 'Nomor Ponsel',
                'rules' => 'required|max_length[12]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'is_unique' => '{field} Telah Digunakan!',
                    'max_length' => '{field} Tidak Valid!'
                ]
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'max_length' => '{field} Maksimal 100 Karakter!'
                ]
            ],
            'ktp' => [
                'label' => 'KTP',
                'rules' => 'max_size[foto,1024]|mime_in[foto,image/png,image/jpg]',
                'errors' => [
                    'max_size' => 'Ukuran File {field} Maksimal 1 MB!',
                    'mime_in'  => 'Format File {field} Harus JPG/PNG!'
                ]
            ],
            'foto' => [
                'label' => 'Foto',
                'rules' => 'max_size[foto,1024]|mime_in[foto,image/png,image/jpg]',
                'errors' => [
                    'max_size' => 'Ukuran File {field} Maksimal 1 MB!',
                    'mime_in'  => 'Format File {field} Harus JPG/PNG!'
                ]
            ],
        ])) {
            $ktp = $this->request->getFile('ktp');
            $foto = $this->request->getFile('foto');
            if ($foto->getError() == 4 && $ktp->getError() == 4) {
                $data = array(
                    'id_pemilik' => $id_pemilik,
                    'nama' => $this->request->getPost('nama'),
                    'j_kel' => $this->request->getPost('j_kel'),
                    'email' => $this->request->getPost('email'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'alamat' => $this->request->getPost('alamat'),
                );
                $this->ModelPemilik->edit($data);
            } elseif ($foto->getError() == 4 && $ktp->getError() != 4) {
                $pemilik = $this->ModelPemilik->detailData($id_pemilik);
                if ($pemilik['up_ktp'] != "") {
                    unlink('assets/images/ktp/' . $pemilik['up_ktp']);
                }
                $nm_file2 = $ktp->getRandomName();
                $data = array(
                    'id_pemilik' => $id_pemilik,
                    'nama' => $this->request->getPost('nama'),
                    'j_kel' => $this->request->getPost('j_kel'),
                    'email' => $this->request->getPost('email'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'alamat' => $this->request->getPost('alamat'),
                    'up_ktp'   => $nm_file2,
                );
                $ktp->move('assets/images/ktp', $nm_file2);
                $this->ModelPemilik->edit($data);
            } elseif ($foto->getError() != 4 && $ktp->getError() == 4) {
                $pemilik = $this->ModelPemilik->detailData($id_pemilik);
                if ($pemilik['pasfoto'] != "") {
                    unlink('assets/images/pasfoto/' . $pemilik['pasfoto']);
                }
                $nm_file = $foto->getRandomName();
                $data = array(
                    'id_pemilik' => $id_pemilik,
                    'nama' => $this->request->getPost('nama'),
                    'j_kel' => $this->request->getPost('j_kel'),
                    'email' => $this->request->getPost('email'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'alamat' => $this->request->getPost('alamat'),
                    'pasfoto'  => $nm_file
                );
                $foto->move('assets/images/pasfoto/', $nm_file);
                $this->ModelPemilik->edit($data);
            } elseif ($foto->getError() != 4 && $ktp->getError() != 4) {
                $pemilik = $this->ModelPemilik->detailData($id_pemilik);
                if ($pemilik['pasfoto'] != "") {
                    if ($pemilik['up_ktp'] != "") {
                        unlink('assets/images/pasfoto/' . $pemilik['pasfoto']);
                        unlink('assets/images/ktp/' . $pemilik['up_ktp']);
                    }
                }
                $nm_file = $foto->getRandomName();
                $nm_file2 = $ktp->getRandomName();
                $data = array(
                    'id_pemilik' => $id_pemilik,
                    'nama' => $this->request->getPost('nama'),
                    'j_kel' => $this->request->getPost('j_kel'),
                    'email' => $this->request->getPost('email'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'alamat' => $this->request->getPost('alamat'),
                    'up_ktp'   => $nm_file2,
                    'pasfoto'  => $nm_file
                );
                $foto->move('assets/images/pasfoto/', $nm_file);
                $ktp->move('assets/images/ktp/', $nm_file2);
                $this->ModelPemilik->edit($data);
            }
            session()->setFlashdata('pesan', 'Data Berhasil Diubah!');
            return redirect()->to(base_url('master/pemilik'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('master/pemilik'));
        }
    }

    public function delete_pemilik($id_pemilik)
    {
        $pemilik = $this->ModelPemilik->detailData($id_pemilik);
        if ($pemilik['pasfoto'] != "") {
            unlink('assets/images/pasfoto/' . $pemilik['pasfoto']);
            unlink('assets/images/ktp/' . $pemilik['up_ktp']);
        }

        $data = [
            'id_pemilik' => $id_pemilik,
        ];
        $this->ModelPemilik->delete_data($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus!');
        return redirect()->to(base_url('master/pemilik'));
    }

    // CONTROLLER PETUGAS
    public function index_petugas()
    {
        $data = [
            'title' => 'Klinik Pratama Medika',
            'sub'   => 'Petugas',
            'isi'   => 'master/v_petugas',
            'petugas' => $this->ModelPetugas->allData()
        ];
        return view('layout/v_wrapper', $data);
    }

    public function add_petugas()
    {
        if ($this->validate([
            'posisi' => [
                'label' => 'Posisi',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'nama' => [
                'label' => 'Nama Tenaga Kesehatan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'j_kel' => [
                'label' => 'Jenis Kelamin',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required|is_unique[tb_nakes.username]|max_length[25]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'is_unique' => '{field} Telah Terdaftar!',
                    'max_length' => '{field} Maksimal 25 Karakter!'
                ]
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|is_unique[tb_nakes.email]|valid_email',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'is_unique' => '{field} Telah Terdaftar!',
                    'valid_email' => '{field} Tidak Valid!'
                ]
            ],
            'no_hp' => [
                'label' => 'Nomor Ponsel',
                'rules' => 'required|is_unique[tb_nakes.no_hp]|max_length[12]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'is_unique' => '{field} Telah Digunakan!',
                    'max_length' => '{field} Tidak Valid!'
                ]
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'max_length' => '{field} Maksimal 100 Karakter!'
                ]
            ],
            'ktp' => [
                'label' => 'KTP',
                'rules' => 'uploaded[foto]|max_size[foto,1024]|mime_in[foto,image/png,image/jpg]',
                'errors' => [
                    'uploaded' => '{field} Wajib Diupload!',
                    'max_size' => 'Ukuran File {field} Maksimal 1 MB!',
                    'mime_in'  => 'Format File {field} Harus JPG/PNG!'
                ]
            ],
            'foto' => [
                'label' => 'Foto',
                'rules' => 'uploaded[foto]|max_size[foto,1024]|mime_in[foto,image/png,image/jpg]',
                'errors' => [
                    'uploaded' => '{field} Wajib Diupload!',
                    'max_size' => 'Ukuran File {field} Maksimal 1 MB!',
                    'mime_in'  => 'Format File {field} Harus JPG/PNG!'
                ]
            ],
        ])) {
            $foto = $this->request->getFile('foto');
            $ktp = $this->request->getFile('ktp');
            $nm_file = $foto->getRandomName();
            $nm_file2 = $ktp->getRandomName();
            $data = array(
                'posisi' => $this->request->getPost('posisi'),
                'nama' => $this->request->getPost('nama'),
                'j_kel' => $this->request->getPost('j_kel'),
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'no_hp' => $this->request->getPost('no_hp'),
                'alamat' => $this->request->getPost('alamat'),
                'up_ktp' => $nm_file2,
                'pasfoto' => $nm_file
            );
            $foto->move('assets/images/pasfoto', $nm_file);
            $ktp->move('assets/images/ktp', $nm_file2);
            $this->ModelPetugas->add($data);
            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');
            return redirect()->to(base_url('master/petugas'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('master/petugas'));
        }
    }

    public function edit_petugas($id_petugas)
    {
        if ($this->validate([
            'posisi' => [
                'label' => 'posisi',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'nama' => [
                'label' => 'Nama Petugas',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'j_kel' => [
                'label' => 'Jenis Kelamin',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required|max_length[25]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'max_length' => '{field} Maksimal 25 Karakter!'
                ]
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'valid_email' => '{field} Tidak Valid!'
                ]
            ],
            'no_hp' => [
                'label' => 'Nomor Ponsel',
                'rules' => 'required|max_length[12]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'is_unique' => '{field} Telah Digunakan!',
                    'max_length' => '{field} Tidak Valid!'
                ]
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'max_length' => '{field} Maksimal 100 Karakter!'
                ]
            ],
            'ktp' => [
                'label' => 'KTP',
                'rules' => 'max_size[foto,1024]|mime_in[foto,image/png,image/jpg]',
                'errors' => [
                    'max_size' => 'Ukuran File {field} Maksimal 1 MB!',
                    'mime_in'  => 'Format File {field} Harus JPG/PNG!'
                ]
            ],
            'foto' => [
                'label' => 'Foto',
                'rules' => 'max_size[foto,1024]|mime_in[foto,image/png,image/jpg]',
                'errors' => [
                    'max_size' => 'Ukuran File {field} Maksimal 1 MB!',
                    'mime_in'  => 'Format File {field} Harus JPG/PNG!'
                ]
            ],
        ])) {
            $ktp = $this->request->getFile('ktp');
            $foto = $this->request->getFile('foto');
            if ($foto->getError() == 4 && $ktp->getError() == 4) {
                $data = array(
                    'id_petugas' => $id_petugas,
                    'posisi' => $this->request->getPost('posisi'),
                    'nama' => $this->request->getPost('nama'),
                    'j_kel' => $this->request->getPost('j_kel'),
                    'username' => $this->request->getPost('username'),
                    'email' => $this->request->getPost('email'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'alamat' => $this->request->getPost('alamat'),
                );
                $this->ModelPetugas->edit($data);
            } elseif ($foto->getError() == 4 && $ktp->getError() != 4) {
                $petugas = $this->ModelPetugas->detailData($id_petugas);
                if ($petugas['up_ktp'] != "") {
                    unlink('assets/images/ktp/' . $petugas['up_ktp']);
                }
                $nm_file2 = $ktp->getRandomName();
                $data = array(
                    'id_petugas' => $id_petugas,
                    'posisi' => $this->request->getPost('posisi'),
                    'nama' => $this->request->getPost('nama'),
                    'j_kel' => $this->request->getPost('j_kel'),
                    'username' => $this->request->getPost('username'),
                    'email' => $this->request->getPost('email'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'alamat' => $this->request->getPost('alamat'),
                    'up_ktp'   => $nm_file2,
                );
                $ktp->move('assets/images/ktp', $nm_file2);
                $this->ModelPetugas->edit($data);
            } elseif ($foto->getError() != 4 && $ktp->getError() == 4) {
                $petugas = $this->ModelPetugas->detailData($id_petugas);
                if ($petugas['pasfoto'] != "") {
                    unlink('assets/images/pasfoto/' . $petugas['pasfoto']);
                }
                $nm_file = $foto->getRandomName();
                $data = array(
                    'id_petugas' => $id_petugas,
                    'posisi' => $this->request->getPost('posisi'),
                    'nama' => $this->request->getPost('nama'),
                    'j_kel' => $this->request->getPost('j_kel'),
                    'username' => $this->request->getPost('username'),
                    'email' => $this->request->getPost('email'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'alamat' => $this->request->getPost('alamat'),
                    'pasfoto'  => $nm_file
                );
                $foto->move('assets/images/pasfoto/', $nm_file);
                $this->ModelPetugas->edit($data);
            } elseif ($foto->getError() != 4 && $ktp->getError() != 4) {
                $petugas = $this->ModelPetugas->detailData($id_petugas);
                if ($petugas['pasfoto'] != "") {
                    if ($petugas['up_ktp'] != "") {
                        unlink('assets/images/pasfoto/' . $petugas['pasfoto']);
                        unlink('assets/images/ktp/' . $petugas['up_ktp']);
                    }
                }
                $nm_file = $foto->getRandomName();
                $nm_file2 = $ktp->getRandomName();
                $data = array(
                    'id_petugas' => $id_petugas,
                    'posisi' => $this->request->getPost('posisi'),
                    'nama' => $this->request->getPost('nama'),
                    'j_kel' => $this->request->getPost('j_kel'),
                    'username' => $this->request->getPost('username'),
                    'email' => $this->request->getPost('email'),
                    'no_hp' => $this->request->getPost('no_hp'),
                    'alamat' => $this->request->getPost('alamat'),
                    'up_ktp'   => $nm_file2,
                    'pasfoto'  => $nm_file
                );
                $foto->move('assets/images/pasfoto/', $nm_file);
                $ktp->move('assets/images/ktp/', $nm_file2);
                $this->ModelPetugas->edit($data);
            }
            session()->setFlashdata('pesan', 'Data Berhasil Diubah!');
            return redirect()->to(base_url('master/petugas'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('master/petugas'));
        }
    }

    public function delete_petugas($id_petugas)
    {
        $petugas = $this->ModelPetugas->detailData($id_petugas);
        if ($petugas['pasfoto'] != "") {
            unlink('assets/images/pasfoto/' . $petugas['pasfoto']);
            unlink('assets/images/ktp/' . $petugas['up_ktp']);
        }

        $data = [
            'id_petugas' => $id_petugas,
        ];
        $this->ModelPetugas->delete_data($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus!');
        return redirect()->to(base_url('master/petugas'));
    }

    // CONTROLLER OBAT
    public function index_obat()
    {
        $data = [
            'title' => 'Klinik Pratama Medika',
            'sub'   => 'Petugas',
            'isi'   => 'master/v_obat',
            'obat'  => $this->ModelObat->allData()
        ];
        return view('layout/v_wrapper', $data);
    }

    public function add_obat()
    {
        if ($this->validate([
            'pemasok' => [
                'label' => 'Pemasok Obat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'nm_obat' => [
                'label' => 'Nama Obat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'jenis' => [
                'label' => 'Jenis Obat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'kategori' => [
                'label' => 'Kategori Obat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'tgl_kadaluarsa' => [
                'label' => 'Tanggal Kadaluarsa',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'stok' => [
                'label' => 'Stok',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'harga' => [
                'label' => 'Harga',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ]
        ])) {
            $data = [
                'pemasok' => $this->request->getPost('pemasok'),
                'nm_obat' => $this->request->getPost('nm_obat'),
                'jenis' => $this->request->getPost('jenis'),
                'kategori' => $this->request->getPost('kategori'),
                'tgl_kadaluarsa' => $this->request->getPost('tgl_kadaluarsa'),
                'stok' => $this->request->getPost('stok'),
                'harga' => $this->request->getPost('harga'),
            ];
            $this->ModelObat->add($data);
            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');
            return redirect()->to(base_url('master/obat'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('master/obat'));
        }
    }

    public function edit_obat($id_obat)
    {
        if ($this->validate([
            'pemasok' => [
                'label' => 'Pemasok Obat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'nm_obat' => [
                'label' => 'Nama Obat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'jenis' => [
                'label' => 'Jenis Obat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'kategori' => [
                'label' => 'Kategori Obat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'stok' => [
                'label' => 'Stok',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'harga' => [
                'label' => 'Harga',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ]
        ])) {
            $data = [
                'id_obat' => $id_obat,
                'pemasok' => $this->request->getPost('pemasok'),
                'nm_obat' => $this->request->getPost('nm_obat'),
                'jenis' => $this->request->getPost('jenis'),
                'kategori' => $this->request->getPost('kategori'),
                'stok' => $this->request->getPost('stok'),
                'harga' => $this->request->getPost('harga'),
            ];
            $this->ModelObat->edit($data);
            session()->setFlashdata('pesan', 'Data Berhasil Diedit!');
            return redirect()->to(base_url('master/obat'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('master/obat'));
        }
    }

    public function delete_obat($id_obat)
    {
        $data = [
            'id_obat' => $id_obat,
        ];
        $this->ModelObat->delete_data($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus!');
        return redirect()->to(base_url('master/obat'));
    }

    // CONTROLLER LAB
    public function index_lab()
    {
        $data = [
            'title' => 'Klinik Pratama Medika',
            'sub'   => 'Petugas',
            'isi'   => 'master/v_lab',
            'lab'  => $this->ModelLab->allData()
        ];
        return view('layout/v_wrapper', $data);
    }

    public function add_lab()
    {
        if ($this->validate([
            'nm_lab' => [
                'label' => 'Nama Laboratorium',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'no_telp' => [
                'label' => 'Nomor Telepon',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ]
        ])) {
            $data = [
                'nm_lab' => $this->request->getPost('nm_lab'),
                'no_telp' => $this->request->getPost('no_telp'),
                'alamat' => $this->request->getPost('alamat'),
            ];
            $this->ModelLab->add($data);
            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');
            return redirect()->to(base_url('master/lab'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('master/lab'));
        }
    }

    public function edit_lab($id_lab)
    {
        if ($this->validate([
            'nm_lab' => [
                'label' => 'Nama Laboratorium',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'no_telp' => [
                'label' => 'Nomor Telepon',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ]
        ])) {
            $data = [
                'id_lab' => $id_lab,
                'nm_lab' => $this->request->getPost('nm_lab'),
                'no_telp' => $this->request->getPost('no_telp'),
                'alamat' => $this->request->getPost('alamat'),
            ];
            $this->ModelLab->edit($data);
            session()->setFlashdata('pesan', 'Data Berhasil Diedit!');
            return redirect()->to(base_url('master/lab'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('master/lab'));
        }
    }

    public function delete_lab($id_lab)
    {
        $data = [
            'id_lab' => $id_lab,
        ];
        $this->ModelLab->delete_data($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus!');
        return redirect()->to(base_url('master/lab'));
    }

    // CONTROLLER RUMAH SAKIT
    public function index_rs()
    {
        $data = [
            'title' => 'Klinik Medika Pratama',
            'sub'   => 'Petugas',
            'isi'   => 'master/v_rs',
            'rs'    => $this->ModelRs->allData()
        ];
        return view('layout/v_wrapper', $data);
    }

    public function add_rs()
    {
        if ($this->validate([
            'nm_rs' => [
                'label' => 'Nama Rumah Sakit',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'no_telp' => [
                'label' => 'Nomor Telepon',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ]
        ])) {
            $data = [
                'nm_rs' => $this->request->getPost('nm_rs'),
                'no_telp' => $this->request->getPost('no_telp'),
                'alamat' => $this->request->getPost('alamat')
            ];
            $this->ModelRs->add($data);
            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');
            return redirect()->to(base_url('master/rs'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('master/rs'));
        }
    }

    public function edit_rs($id_rs)
    {
        if ($this->validate([
            'nm_rs' => [
                'label' => 'Nama Rumah Sakit',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'no_telp' => [
                'label' => 'Nomor Telepon',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ]
        ])) {
            $data = [
                'id_rs' => $id_rs,
                'nm_rs' => $this->request->getPost('nm_rs'),
                'no_telp' => $this->request->getPost('no_telp'),
                'alamat' => $this->request->getPost('alamat')
            ];
            $this->ModelRs->edit($data);
            session()->setFlashdata('pesan', 'Data Berhasil Diedit!');
            return redirect()->to(base_url('master/rs'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('master/rs'));
        }
    }

    public function delete_rs($id_rs)
    {
        $data = [
            'id_rs' => $id_rs,
        ];
        $this->ModelRs->delete_data($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus!');
        return redirect()->to(base_url('master/rs'));
    }

    // CONTROLLER POLI
    public function index_poli()
    {
        $data = [
            'title' => 'Klinik Medika Pratama',
            'sub'   => 'Petugas',
            'isi'   => 'master/v_poli',
            'poli'    => $this->ModelPoli->allData()
        ];
        return view('layout/v_wrapper', $data);
    }

    public function add_poli()
    {
        if ($this->validate([
            'nm_poli' => [
                'label' => 'Nama Poli',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi!'
                ]
            ]
        ])) {
            $data = [
                'nm_poli' => $this->request->getPost('nm_poli'),
            ];
            $this->ModelPoli->add($data);
            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!');
            return redirect()->to(base_url('master/poli'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('master/poli'));
        }
    }

    public function edit_poli($id_poli)
    {
        if ($this->validate([
            'nm_poli' => [
                'label' => 'Nama Poli',
                'rules' => 'required|is_unique[tb_poli_rs.nm_poli]',
                'errors' => [
                    'required' => '{field} Wajib Diisi!',
                    'is_unique' => '{field} Telah Tersedia!'
                ]
            ]
        ])) {
            $data = [
                'id_poli' => $id_poli,
                'nm_poli' => $this->request->getPost('nm_poli'),
            ];
            $this->ModelPoli->edit($data);
            session()->setFlashdata('pesan', 'Data Berhasil Diedit!');
            return redirect()->to(base_url('master/poli'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('master/poli'));
        }
    }

    public function delete_poli($id_poli)
    {
        $data = [
            'id_poli' => $id_poli,
        ];
        $this->ModelPoli->delete_data($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus!');
        return redirect()->to(base_url('master/poli'));
    }
}
