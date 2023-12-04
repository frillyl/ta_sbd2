<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelNakes extends Model
{
    protected $table = "tb_nakes";
    protected $primaryKey = "id_nakes";
    protected $returnType = "object";
    protected $allowedFields = ['no_str', 'nama', 'j_kel', 'username', 'email', 'no_hp', 'alamat', 'password', 'up_ktp', 'pasfoto', 'posisi'];

    public function allData()
    {
        return $this->db->table('tb_nakes')
            ->orderBy('nama', 'ASC')
            ->get()->getResultArray();
    }

    public function detailData($id_nakes)
    {
        return $this->db->table('tb_nakes')
            ->where('id_nakes', $id_nakes)
            ->get()->getRowArray();
    }

    public function add($data)
    {
        $this->db->table('tb_nakes')->insert($data);
    }

    public function edit($data)
    {
        $this->db->table('tb_nakes')
            ->where('id_nakes', $data['id_nakes'])
            ->update($data);
    }

    public function delete_data($data)
    {
        $this->db->table('tb_nakes')
            ->where('id_nakes', $data['id_nakes'])
            ->delete($data);
    }
}
