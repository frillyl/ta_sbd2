<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPetugas extends Model
{
    protected $table = "tb_petugas";
    protected $primaryKey = "id_petugas";
    protected $returnType = "object";
    protected $allowedFields = ['nama', 'j_kel', 'username', 'email', 'no_hp', 'alamat', 'password', 'up_ktp', 'pasfoto', 'posisi'];

    public function allData()
    {
        return $this->db->table('tb_petugas')
            ->orderBy('nama', 'ASC')
            ->get()->getResultArray();
    }

    public function detailData($id_petugas)
    {
        return $this->db->table('tb_petugas')
            ->where('id_petugas', $id_petugas)
            ->get()->getRowArray();
    }

    public function add($data)
    {
        $this->db->table('tb_petugas')->insert($data);
    }

    public function edit($data)
    {
        $this->db->table('tb_petugas')
            ->where('id_petugas', $data['id_petugas'])
            ->update($data);
    }

    public function delete_data($data)
    {
        $this->db->table('tb_petugas')
            ->where('id_petugas', $data['id_petugas'])
            ->delete($data);
    }
}
