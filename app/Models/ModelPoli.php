<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPoli extends Model
{
    protected $table = "tb_poli_rs";
    protected $primaryKey = "id_poli";
    protected $returnType = "object";
    protected $allowedFields = ['nm_poli'];

    public function allData()
    {
        return $this->db->table('tb_poli_rs')
            ->orderBy('nm_poli', 'ASC')
            ->get()->getResultArray();
    }

    public function detailData($id_poli)
    {
        return $this->db->table('tb_poli_rs')
            ->where('id_poli', $id_poli)
            ->get()->getRowArray();
    }

    public function add($data)
    {
        $this->db->table('tb_poli_rs')->insert($data);
    }

    public function edit($data)
    {
        $this->db->table('tb_poli_rs')
            ->where('id_poli', $data['id_poli'])
            ->update($data);
    }

    public function delete_data($data)
    {
        $this->db->table('tb_poli_rs')
            ->where('id_poli', $data['id_poli'])
            ->delete($data);
    }
}
