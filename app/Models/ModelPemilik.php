<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPemilik extends Model
{
    protected $table = "tb_pemilik";
    protected $primaryKey = "id_pemilik";
    protected $returnType = "object";
    protected $allowedFields = ['nama', 'j_kel', 'email', 'no_hp', 'alamat', 'password', 'up_ktp', 'pasfoto'];

    public function allData()
    {
        return $this->db->table('tb_pemilik')
            ->orderBy('nama', 'ASC')
            ->get()->getResultArray();
    }

    public function detailData($id_pemilik)
    {
        return $this->db->table('tb_pemilik')
            ->where('id_pemilik', $id_pemilik)
            ->get()->getRowArray();
    }

    public function add($data)
    {
        $this->db->table('tb_pemilik')->insert($data);
    }

    public function edit($data)
    {
        $this->db->table('tb_pemilik')
            ->where('id_pemilik', $data['id_pemilik'])
            ->update($data);
    }

    public function delete_data($data)
    {
        $this->db->table('tb_pemilik')
            ->where('id_pemilik', $data['id_pemilik'])
            ->delete($data);
    }
}
